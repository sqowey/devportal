<?php 
	// Start the session, to get the data
	session_start();
	// If the user is logged in redirect to the app page
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    } else {
        header('Location: ../login/');
    }

    // Variables
    $db_config = require('../config.php');

    // Conect to database
    $con = mysqli_connect($db_host, $db_user, $db_pass, 'sqowey_devportal');
    if (mysqli_connect_errno()) {
        header("Location: index.html?c=98");
    }

    // Get all apps
    $applist = array();
    $query=$con->query("SELECT app_id, app_level, tokens, app_name, app_icon FROM apps WHERE dev_id = \"".$_SESSION['id']."\"");
    if($query){
        while($row = mysqli_fetch_array($query)){
            array_push($applist, json_encode(array("app_id" => $row["app_id"], "app_level" => $row["app_level"], "tokens" => $row["tokens"], "app_name" => $row["app_name"], "app_icon" => $row["app_icon"])));
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sqowey - Devportal</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>

    <!-- Navigation bar -->
    <div class="navbar" id="navbar">
        <div class="navbar_title">
            <div class="navbar_title_inner"> Sqowey Developer Portal</div>
        </div>
        <div class="themeSwitcher" onclick="toggleTheme();">
            <i id="themeSwitcherButton" class="fas fa-adjust"></i>
        </div>
    </div>

    <!-- Applications -->
    <div class="applications_list">
        <div class="application_item">
            <div class="container">
                <img src="https://via.placeholder.com/1000C/ffffff" alt="ALT" class="application_logo">
                <div class="application_name">MMMMMMMMMMMM</div>
                <div class="application_status">Tokens left: 1000</div>
            </div>
        </div>
    </div>

    <!-- The Container in which the Error output is pasted -->
    <div id="errorOutputContainer">
    </div>

    <!-- Load all needed scripts -->
    <script src="themes.js"></script>
    <script src="message_script.js"></script>
</body>

</html>