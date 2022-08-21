<?php 
	// Start the session, to get the data
	session_start();

    // Variables
    $db_config = require('../../config.php');

    // Conect to database
    $con = mysqli_connect($db_host, $db_user, $db_pass, 'sqowey_devportal');
    if (mysqli_connect_errno()) {
        header("Location: index.html?c=98");
    }

    // Get all apps
    $applist = array();
    $query=$con->query("SELECT app_id, app_level, tokens, app_name FROM apps WHERE dev_id = \"".$_SESSION['id']."\"");
    if($query){
        while($row = mysqli_fetch_array($query)){
            array_push($applist, json_encode(array("app_id" => $row["app_id"], "app_level" => $row["app_level"], "tokens" => $row["tokens"], "app_name" => $row["app_name"])));
        }
    }

    // Exit
    exit(json_encode($applist));
?>