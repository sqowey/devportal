<?php 
    // Variables
    $db_config = require('../../config.php');

    // Conect to database
    $con = mysqli_connect($db_host, $db_user, $db_pass, 'sqowey_devportal');
    if (mysqli_connect_errno()) {
        echo"<script>status_notify('Database error!\nPlease try again later!', 'negative');</script>";
    } 

    // Session
    session_start();
    
    // Save app id
    $_SESSION["app_id"] = $_GET["app_id"];

    // Get app informations
    if ($stmt = $con->prepare("SELECT dev_id, app_level, tokens, app_name, last_used, app_secret FROM apps WHERE app_id = ?")) {
        $stmt->bind_param("s", $_GET["app_id"]);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 0) {
            echo"<script>status_notify('Warning!\nNo app found!', 'negative');</script>";
            exit();
        }
        $stmt->bind_result($dev_id, $app_level, $tokens, $app_name, $last_used, $app_secret);
        $stmt->fetch();
        $stmt->close();
    }

    // Check if current-logged-in-id is matching the application-owner
    if($dev_id != $_SESSION['id']){
        echo"<script>status_notify('Account error!\nPlease re-log-in!', 'negative');</script>";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sqowey - Devportal</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.2/css/all.css">
</head>

<body>

    <!-- Close icon -->
    <div class="close-icon" onclick="location.replace('../')">
        <i class="fa-solid fa-square-xmark"></i>
    </div>

    <!-- Container for status messages -->
    <div class="status_container status"></div>

    <div class="container">
        <div class="tabs">
            <ul>
                <a href="#security">
                    <li>
                        <i class="fa-solid fa-shield-halved"></i> Security
                    </li>
                </a>
                <a href="#help">
                    <li>
                        <i class="fa-solid fa-question-circle"></i> Help
                    </li>
                </a>
                <a href="#infos">
                    <li>
                        <i class="fa-solid fa-info-circle"></i> More Information
                    </li>
                </a>
            </ul>

        </div>
        <div class="portal">
            <div id="security">
                <h1>Application Security</h1>
                <div class="details">
                    <h3>App-Name</h3>
                    <form action="./rename_app.php" method="POST">
                        <input type="text" maxlength="12" minlength="3" name="app_name" id="app_name_input" value="<?=$app_name?>">
                        <input type="text" name="app_id" id="app_id_input" hidden="" value="<?=$_GET["app_id"]?>">
                        <input class="button_inactive" type="submit" value="Submit" id="app_name_input_submit" disabled="">
                    </form>
                    <h3>App-ID</h3>
                    <p><?=$_GET["app_id"]?></p>
                    <h3>App-Secret</h3>
                    <p class="sensitive_data"><?=$app_secret?></p>
                    <button class="button_warning" id="app_name_input_submit" onclick="location.assign('./reset_secret.php');">Reset APP-Secret</button>
                    <h3>Owner</h3>
                    <p><?=$dev_id?></p>
                </div>
            </div>
            <div id="help">
                <h1>Help</h1>
                <div class="details">
                    <h3>Feedback</h3>
                    <p>
                        You can submit feedback <a onclick="alert('Soon!')">here</a>!
                    </p>
                    <h3>Documentation</h3>
                    <p>
                        You can find the Developer Documentation <a onclick="alert('Coming soon!')">here</a>!
                    </p>
                </div>
            </div>
            <div id="infos">
                <h1>More Information</h1>
                <div class="details">
                    <h3>API-Version used</h3>
                    <p>
                        Beta 0.1.0
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Get the statusbox library -->
    <script src="https://cdn.jsdelivr.net/gh/cuzimbisonratte/status_box@v1.0.0/statusbox.js">
    </script>

    <!-- Get the ajax library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Get all other scripts -->
    <script src="./script.js"></script>
</body>

</html>