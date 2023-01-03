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
            Apps (25/1500)
        </div>
        <div class="app_add">
            <i class="fa-solid fa-plus"></i>
        </div>
    </div>
    <div class="applist"></div>
    <script src="/res/js/jquery/jquery-3.6.1.min.js"></script>
</body>

</html>