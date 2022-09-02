<?php

    // Start the PHP_session
    session_start();

    // Variables
    $db_config = require('../../config.php');

    // Get input
    $username = strtolower($_POST['username']);
    $displayname = $_POST['username'];
    $password = $_POST['password'];

    // Conect to database
    $con = mysqli_connect($db_host, $db_user, $db_pass, 'accounts');
    if (mysqli_connect_errno()) {
        header("Location: ./?c=98");
        exit;
    }

    // Check if account exists
    $stmt = $con->prepare("SELECT id FROM accounts WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) {
        header("Location: ./?c=14");
        exit;
    }

    // Get id, salt and password hash from database
    if ($stmt = $con->prepare("SELECT id, salt, password, email, account_version FROM accounts WHERE username = ?")) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $salt, $password_hash, $email, $account_version);
        $stmt->fetch();
    }

    // Add salt and password and check if right
    if ($account_version < 2) {
        $pw_with_hash = $password;
    } else {
        $pw_with_hash = $salt . $password;
    }

    // Check if password is right
    if (!password_verify($pw_with_hash, $password_hash)) {
        header("Location: ./?c=14");
        exit;
    } 

    // Open the devportal connection
    $con->close();
    $con = mysqli_connect($db_host, $db_user, $db_pass, 'sqowey_devportal');
    if (mysqli_connect_errno()) {
        header("Location: ./?c=98");
        exit;
    }

    // Set session variables
    $_SESSION['id'] = $id;
    $_SESSION['username'] = $username;
    $_SESSION['displayname'] = $displayname;
    $_SESSION['email'] = $email;
    $_SESSION['loggedin'] = true;

    // Redirect to app
    if(isset($_GET["app_id"])){
        header("Location: ../permit/?app_id=".$_GET["app_id"]);
    } else {
        header("Location: ../permit/");
    }
?>