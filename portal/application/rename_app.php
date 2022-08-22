<?php 

    // Get post value
    $app_name = $_POST["app_name"];
    $app_id = $_POST["app_id"];

    // Start the session
    session_start();

    // Get the dev id
    $dev_id = $_SESSION["id"];

    // Db config
    $db_config = require('../../config.php');

    // Conect to database
    $con = mysqli_connect($db_host, $db_user, $db_pass, 'sqowey_devportal');
    if (mysqli_connect_errno()) {
        exit("Database error! Please try again later!");
    }

    // Check if app id matches owner
    if($stmt = $con->prepare("SELECT dev_id, app_name FROM apps WHERE app_id = ?")){
        $stmt->bind_param("s", $app_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 0) {
            exit("Warning! No app found!");
        }
        $stmt->bind_result($dev_id_from_db, $old_app_name);
        $stmt->fetch();
        $stmt->close();
    }
    if($dev_id != $dev_id_from_db){
        exit("Owner doesn't match, please re-log-in!");
    }

    // Check if old app name matches the new one
    if($old_app_name == $app_name){
        header("Location: ./?app_id=$app_id");
    }

    // Check if new name matches requirements (0-9, a-z, A-Z, _, -)
    if(!preg_match("/^[A-Za-z0-9_-]+$/", $app_name)){
        exit("New name doesn't match the rules: Length: 3-12 | Characters: a-z AND A-Z AND _ AND -");
    }
    
    // Rename
    if($stmt = $con->prepare("UPDATE apps SET app_name = ? WHERE app_id = ?")){
        $stmt->bind_param("ss", $app_name, $app_id);
        $stmt->execute();
        if($stmt->affected_rows == 0){
            exit("Database ERROR! Try again");
        }
    }

    // Redirect
    header("Location: ./?app_id=$app_id");

?>