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

    // Count number of uses for the app
    if($stmt = $con->prepare("select * FROM permissions_users WHERE app_id = ?")){
        $stmt->bind_param("s",$_GET["app_id"]);
        $stmt->execute();
        $stmt->store_result();
        $num_of_apps = strval($stmt->num_rows());
        $stmt->close();
    }


	// If the user is logged in redirect to the app page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
        header('Location: ../login/?app_id='.$_GET["app_id"]);
    }

    // Open the db connection to the account db
    $con->close();
    $con = mysqli_connect($db_host, $db_user, $db_pass, 'accounts');
    if (mysqli_connect_errno()) {
        exit("DB ERROR");
    }

    // Get the app owners name
    if($stmt = $con->prepare("SELECT displayname FROM accounts WHERE id = ?")){
        $stmt->bind_param("s",$app_owner);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($displayname);
        $stmt->fetch();
        $stmt->close();
        if(!isset($app_name) || !isset($app_owner)){
            exit("UNKNOWN APP ID");
        }
    }

    // Get the creation date
    $date = date_create($app_creation);
    $creation_formatted = date_format($date,"Y/m/d");
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
                    <span class="emphasize"><?=$app_name?></span><br>
                    wants to get onto one of your servers
                </p>
            </div>
            <hr>
            <div>
            </div>
            <hr>
            <div id="info_container">
                <table>
                    <tr>
                        <td><i class="fa-solid fa-code"></i></td>
                        <td>
                            The Application is being maintained by <span class="emphasize"><?=$displayname?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fa-solid fa-clock"></i></td>
                        <td>
                            The Application exists since <span class="emphasize"><?=$creation_formatted?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fa-solid fa-users"></i></td>
                        <td>
                            The Application is trusted by users <span class="emphasize"><?=$num_of_apps?>x Times</span>
                        </td>
                    </tr>
                </table>
            </div>
            <hr>
            <div id="buttons_container">
                <button id="back_button" onclick='location.replace("./denied/");'>Back</button>
                <button id="permit_button" onclick='location.replace("./permit/?app_id=<?=$_GET["app_id"]?>");'>Permit App</button>
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