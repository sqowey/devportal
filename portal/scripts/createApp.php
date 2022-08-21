<?php 
    // Variables
    $db_config = require('../../config.php');

    // Conect to database
    $con = mysqli_connect($db_host, $db_user, $db_pass, 'sqowey_devportal');
    if (mysqli_connect_errno()) {exit("ERROR_Database");} 

    // Session
    session_start();

    // Get number of allowed apps
    if($stmt = $con->prepare("SELECT dev_level, verified_mail FROM developers WHERE user_id = ?")){
        $stmt->bind_param('s', $_SESSION['id']);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 0) {
            exit("ERROR_NoDevAccountFound");
        }
        $stmt->bind_result($dev_level, $verified_mail);
        $stmt->fetch();
        $stmt->close();
        switch ($dev_level) {
            case 1:
                $apps_allowed = 5;
                break;
            case 2:
                $apps_allowed = 20;
                break;
            case 3:
                $apps_allowed = 50;
                break;
            case 4:
                $apps_allowed = 100;
                break;
            case 5:
                $apps_allowed = 1000;
                break;
            case 6:
                $apps_allowed = 5000;
                break;
            case 9:
                $apps_allowed = 10000;
                break;
        }
    }

    // Get number of already used apps
    if($stmt = $con->prepare("SELECT app_level FROM apps WHERE dev_id = ?")){
        $stmt->bind_param('s', $_SESSION['id']);
        $stmt->execute();
        $stmt->store_result();
        $apps_used = $stmt->num_rows;
        $stmt->close();
    }

    // Check if too many apps are in use
    if ($apps_used >= $apps_allowed) {
        exit("ERROR_TooManyApps");
    }

    // Get a free app id
    $searchingForAppId = true;
    while ($searchingForAppId) {
        $generated = "";
        for ($i=0; $i < 12; $i++) { 
            $new_char = substr("1234567890abcdef", mt_rand(0, 15),1);
            $generated .= $new_char;
        }
        if ($stmt = $con->prepare("SELECT * FROM apps WHERE app_id = ?")) {
            $stmt->bind_param('s', $generated);
            $stmt->execute();
            if ($stmt->num_rows == 0) {
                $searchingForAppId = false;
            }
            $stmt->close();
        }
    }

    // Get the app_level and number of tokens
    if ($verified_mail){
        $app_level = "B2";
        $start_tokens = 75000;
    } else {
        $app_level = "B1";
        $start_tokens = 25000;
    }

    // Create the app name
    $app_name = "APP ". ($apps_used + 1);

    // Create the App
    if($stmt = $con->prepare("INSERT INTO apps (dev_id, app_id, app_level, tokens, app_name) VALUES (?, ?, ?, ?, ?);")){
        $stmt->bind_param('sssis', $_SESSION['id'], $generated, $app_level, $start_tokens, $app_name);
        $stmt->execute();
        $stmt->close();
        exit("SUCCESS_APP_ID_".$generated);
    }
?>