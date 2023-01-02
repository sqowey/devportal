<?php

function checkLogin(bool $redirect_to_login = true, string $redirect_back_url = ""){
    // Check session state
    if(!isset($_SESSION["user_id"]) || !isset($_SESSION["user_email"]) || !isset($_SESSION["user_username"]) || !isset($_SESSION["user_displayname"])) {
        if(!$redirect_to_login) return false;
        if($redirect_back_url != "") header("Location: https://account.sqowey.de/login/?redirect=".urlencode($redirect_back_url));
        else if($redirect_back_url == "") header("Location: https://account.sqowey.de/login/?redirect=");
    }
    else return true;
}

?>