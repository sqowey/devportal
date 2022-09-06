<?php 
	// Start the session, to get the data
	session_start();
	// If the user is logged in redirect to the app page
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        header('Location: ../invite/');
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sqowey - Login</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="style.css" rel="stylesheet" type="text/css">
    <!-- Set tab icon -->
    <link rel="icon" href="../../contents/icon.svg">
</head>

<body>

    <!-- Theme button -->
    <div id="themeButton">
        <button id="themeToggleButton" onclick="toggleTheme()">Darkmode/Lightmode</button>
    </div>

    <!-- The Container in which the Error output is pasted -->
    <div id="errorOutputContainer">
    </div>

    <!-- A container that centers the form -->
    <div id="centering_container">

        <!-- The main login section -->
        <div id="login">

            <!-- Header -->
            <h1>Anmelden</h1>

            <!-- The form -->
            <form action="login.php?app_id=<?=$_GET["app_id"]?>" method="post">

                <!-- Username field -->
                <input type="text" name="username" placeholder="Nutzername" id="username" required>

                <!-- Password field -->
                <input type="password" name="password" placeholder="Passwort" id="password" required>

                <!-- Login-knopf -->
                <input type="submit" value="Anmelden">
            </form>
        </div>
    </div>

    <!-- Load all needed scripts -->
    <script src="formular_themes.js"></script>
    <script src="message_script.js"></script>
</body>

</html>