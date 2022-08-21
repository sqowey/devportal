<?php 
	// Start the session, to get the data
	session_start();
	// If the user is logged in redirect to the app page
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    } else {
        header('Location: ../login/');
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sqowey - Devportal</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.2/css/all.css">
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
    <div id="applications_list">
        <div class="application_item">
            <div class="container">
                <div class="application_new_plus application_logo">
                    <i class=" fa-solid fa-plus"></i>
                </div>
                <div class="application_new_title">Create a new app</div>
                <div class="application_new_subtitle">Tokens left: 1000</div>
            </div>
        </div>
    </div>

    <!-- The Container in which the Error output is pasted -->
    <div id="errorOutputContainer">
    </div>

    <!-- Load all needed scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="message_script.js"></script>
    <script src="./scripts/getApps.js"></script>
    <script src="themes.js"></script>
</body>

</html>