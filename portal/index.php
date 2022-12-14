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

    // Get dev level
    if($stmt=$con->prepare("SELECT dev_level, user_id, dev_secret FROM developers WHERE user_id = ?")){
        $stmt->bind_param('s', $_SESSION['id']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($dev_level, $dev_id, $dev_secret);
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
    if($stmt=$con->prepare("SELECT app_level FROM apps WHERE dev_id = ?")){
        $stmt->bind_param('s', $_SESSION['id']);
        $stmt->execute();
        $stmt->store_result();
        $apps_used = $stmt->num_rows;
        $stmt->close();
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
    <!-- Container for status messages -->
    <div class="status_container status"></div>

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
    <div id="applications_list">
        <div class="application_item" onclick="location.assign('./createApp.php');">
            <div class="container">
                <div class="application_new_plus application_logo">
                    <i class=" fa-solid fa-plus"></i>
                </div>
                <div class="application_new_title">Create a new app</div>
                <div class="application_new_subtitle">Apps used: <?=$apps_used?>/<?=$apps_allowed?></div>
            </div>
        </div>
        <div class="account_item">
            <div class="account_container">
                <h3>Developer Secret</h3>
                <p class="account_textfield sensitive_data"><?=$dev_secret?></p>
                <h3>Developer ID</h3>
                <p class="account_textfield"><?=$dev_id?></p>
            </div>
        </div>
    </div>

    <!-- The Container in which the Error output is pasted -->
    <div id="errorOutputContainer">
    </div>

    <!-- Get the statusbox library -->
    <script src="./statusbox.js"></script>

    <!-- Get the jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Load all needed scripts -->
    <script src="./scripts/getApps.js"></script>
    <script src="themes.js"></script>
    <script>
        // Sensitive data copy
        const sensitive_elements = document.getElementsByClassName("sensitive_data");
        for (let i = 0; i < sensitive_elements.length; i++) {
            const element = sensitive_elements[i];
            element.onclick = () => {
                navigator.clipboard.writeText(element.innerHTML);
                element.style.transition = "0.1s";
                element.style.backgroundColor = "#00ff00";
                window.setTimeout(() => {
                    element.style.backgroundColor = "#383e42";
                }, 250);
            };
        }
    </script>
</body>

</html>