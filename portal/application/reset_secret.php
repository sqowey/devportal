<?php

    // Start the session
    session_start();

    // Get the dev id and app id
    $dev_id = $_SESSION["id"];
    $app_id = $_SESSION["app_id"];

    // Db config
    $db_config = require('../../config.php');

    // Conect to database
    $con = mysqli_connect($db_host, $db_user, $db_pass, 'sqowey_devportal');
    if (mysqli_connect_errno()) {
        exit("Database error! Please try again later!");
    }
    
    // Check if app id matches owner
    if($stmt = $con->prepare("SELECT dev_id FROM apps WHERE app_id = ?")){
        $stmt->bind_param("s", $app_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 0) {
            exit("Warning! No app found!");
        }
        $stmt->bind_result($dev_id_from_db);
        $stmt->fetch();
        $stmt->close();
    }
    if($dev_id != $dev_id_from_db){
        exit("Owner doesn't match, please re-log-in!");
    }

    // Generate new secret
    $generated = "";
    for ($i=0; $i < 64; $i++) { 
        $new_char = substr("1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 61),1);
        $generated .= $new_char;
    }

    // Set new app secret
    if($stmt = $con->prepare("UPDATE apps SET app_secret = ? WHERE app_id = ?")){
        $stmt->bind_param("ss", $generated, $app_id);
        $stmt->execute();
        if($stmt->affected_rows == 0){
            exit("Database ERROR! Try again");
        }
    }

    // Redirect
    header("Location: ./?app_id=$app_id");

?>