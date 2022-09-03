<?php 

    // Check if app id is a parameter
    if(!isset($_GET["app_id"])){
        exit("UNKNOWN APP ID");
    }
	
    // Start the session, to get login data
	session_start();

    // Variables
    $db_config = require('../../../config.php');

    // Conect to database
    $con = mysqli_connect($db_host, $db_user, $db_pass, 'sqowey_devportal');
    if (mysqli_connect_errno()) {
        header("Location: index.html?c=98");
    }

    // Check if app exists
    if($stmt = $con->prepare("SELECT app_name, dev_id, app_created FROM apps WHERE app_id = ?")){
        $stmt->bind_param("s",$_GET["app_id"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($app_name, $app_owner, $app_creation);
        $stmt->fetch();
        $stmt->close();
        if(!isset($app_name) || !isset($app_owner)){
            exit("UNKNOWN APP ID");
        }
    }

	// If the user is logged in redirect to the app page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
        header('Location: ../login/?app_id='.$_GET["app_id"]);
    }

    // Add the permit
    if($stmt = $con->prepare("INSERT INTO permissions_users (user_id, app_id) VALUES (?, ?)")){
        $stmt->bind_param("ss", $_SESSION["id"], $_GET["app_id"]);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect to finish
    header("Location: ./finished.html");

?>