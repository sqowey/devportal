<?php

// Module import
require("./res/php/session.php");
require("./res/php/checkLogin.php");
require_once("../config.php");

// Pre-start
start_session();
checkLogin(true, "https://dev.sqowey.de/");

// Check display state
$display_mode = "cell";
if(isset($_COOKIE["devportal_display"])) $display_mode = $_COOKIE["devportal_display"];
if(!isset($_GET["display"])) {
    header("Location: .?display=".$display_mode);
}
setcookie("devportal_display", $_GET["display"], time() + 606024 * 365, "/",
    implode(".",array_slice(explode(".",$_SERVER["HTTP_HOST"]), -2, 2)), false, false);

// DB connection (Dev DB)
$con = mysqli_connect($config_dev_db_server, $config_dev_db_user, $config_dev_db_password, $config_dev_db_name);
if($con->connect_error) die("Connection failed: " . $con->connect_error);
// Load apps
$applist = array();
if($stmt = $con->prepare("SELECT app_id, app_level, tokens, app_name FROM ".$config_dev_db_application_table." WHERE owner = ?")) {
    $stmt->bind_param("s", $_SESSION["user_id"]);
    $stmt->execute();
    $stmt->bind_result($app_id, $app_level, $app_tokens, $app_name);
    while ($stmt->fetch()) {
        $applist[] = array(
            "app_id" => $app_id,
            "app_level" => $app_level,
            "tokens" => $app_tokens,
            "app_name" => $app_name
        );
    }
    $stmt->close();
}
$con->close();

// DB connection 2 (Account DB)
$con = mysqli_connect($config_account_db_server, $config_account_db_user, $config_account_db_password, $config_account_db_name);
if($con->connect_error) die("Connection failed: " . $con->connect_error);
// Load user info
if($stmt = $con->prepare("SELECT dev_level FROM ".$config_account_db_userinfo_table." WHERE user_id = ?")){
    $stmt->bind_param("s", $_SESSION["user_id"]);
    $stmt->execute();
    $stmt->bind_result($dev_level);
    $stmt->fetch();
    if(!isset($dev_level)) die("Error, please Contact support!");
    $stmt->close();
}
$con->close();

// Dev level to max app count
$max_app_num = "?";
switch ($dev_level) {
    case 1:
        $max_app_num = 5;
        break;
    case 2:
        $max_app_num = 20;
        break;
    case 3:
        $max_app_num = 50;
        break;
    case 4:
        $max_app_num = 100;
        break;
    case 5:
        $max_app_num = 1000;
        break;
    case 6:
        $max_app_num = 5000;
        break;
    case 9:
        $max_app_num = 10000;
        break;
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sqowey - Devportal</title>
    <link rel="icon" type="image/x-icon" href="/res/img/favicon.ico" />
    <link rel="apple-touch-icon" href="/res/img/favicon.ico" />
    <link rel="stylesheet" href="/res/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/res/fontawesome/css/solid.min.css">
    <link rel="stylesheet" href="/res/css/fonts.css">
    <link rel="stylesheet" href="/res/css/main.css">
    <link rel="stylesheet" href="/res/css/index.css">
</head>
<body>
    <div class="main_nav">
        <div class="nav_header">Sqowey - Developer Portal</div>
            <!-- <div>App <i class="fa-solid fa-external-link-square"></i></div> -->
            <div id="docs_link" onclick="window.open('https:\/\/docs.sqowey.de', '_blank');">Docs <i class="fa-solid fa-external-link-square"></i></div>
            <div id="docs_link" onclick="window.open('https:\/\/docs.sqowey.de/devportal/info', '_blank');"><i class="fa-solid fa-info-circle"></i></div>
            <div id="docs_link" onclick="window.open('https:\/\/docs.sqowey.de/changelogs', '_blank');"><i class="fa-solid fa-check-to-slot"></i></div>
        </div>
    <div class="applist_nav">
        <div class="view_mode">
            <div class="mode_switch" data-show_mode="<?=$_GET["display"]?>">
                <i id="list_mode" onclick="location.assign('.?display=cell');" class="fa-solid fa-align-justify"></i>
                <i id="cell_mode" onclick="location.assign('.?display=list');" class="fa-solid fa-table-cells-large"></i>
            </div>
        </div>
        <div class="applist_title">
            Apps (<?=count($applist)?>/<?=$max_app_num?>)
        </div>
        <div class="app_add">
            <i class="fa-solid fa-plus"></i>
        </div>
    </div>
    <div class="applist" data-show_mode="<?=$_GET["display"]?>"></div>
    <script src="/res/js/jquery/jquery-3.6.1.min.js"></script>
</body>

</html>