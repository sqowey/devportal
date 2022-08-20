<?php 
	// Start the session, to get the data
	session_start();
	// If the user is logged in redirect to the app page
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        header('Location: ./portal/');
        exit;
    } else {
        header('Location: ./login/');
        exit;
    }
?>