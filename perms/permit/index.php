<?php 

    // Check if app id is a parameter
    if(!isset($_GET["app_id"])){
        exit("UNKNOWN APP ID");
    }
	
    // Start the session, to get login data
	session_start();

    // Variables
    $db_config = require('../../config.php');

    // Conect to database
    $con = mysqli_connect($db_host, $db_user, $db_pass, 'sqowey_devportal');
    if (mysqli_connect_errno()) {
        header("Location: index.html?c=98");
    }

    // Check if app exists
    if($stmt = $con->prepare("SELECT app_name, dev_id FROM apps WHERE app_id = ?")){
        $stmt->bind_param("s",$_GET["app_id"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($app_name, $app_owner);
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

?>

<!DOCTYPE html>
<html style="height: fit-content;">

<head>
    <meta charset="utf-8">
    <title>Sqowey - Devportal</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.2/css/all.css">
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body style="height: fit-content;">

    <!-- Navigation bar -->
    <div class="navbar" id="navbar">
        <div class="navbar_title">
            <div class="navbar_title_inner"> Sqowey Developer Portal</div>
        </div>
        <div class="themeSwitcher" onclick="toggleTheme();">
            <i id="themeSwitcherButton" class="fas fa-adjust"></i>
        </div>
    </div>

    <div class="app_permit_container">
        <div class="app_permit_container_inner">
            <div>
                <p>
                    The external Application<br>
                    <span id="app_name"><?=$app_name?></span><br>
                    wants the following Permissions
                </p>
            </div>
            <hr>
            <div>

            </div>
            <hr>
            <div>

            </div>
        </div>
    </div>

    <!-- Get the statusbox library -->
    <div class="status_container status"></div>
    <script src="./statusbox.js"></script>

    <!-- Get the jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Load all needed scripts -->
    <script src="themes.js"></script>
</body>

</html>