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
    <div style="display:flex; justify-content: center; align-items: center; height: 100%; width: 100%;">
        <div>
            <h1 style="text-align: center;"><i id="server_icon" style="font-size: 3rem; transition: 1.25s;" class="fa-solid fa-server"></i></h1>
            <h1 style="font-size: xxx-large;text-align: center;">Please wait a moment</h1>
            <p style="text-align: center;">We are currently creating your application</p>
            <p style="text-align: center;">You will get redirected soon</p>
        </div>
    </div>

    <script>
        const server_icon = document.getElementById("server_icon");
        var turn = 0;
        window.setInterval(() => {
            turn = turn + 360;
            server_icon.style.transform = "rotate("+turn+"deg)";
        }, 1.5 * 1000);
    </script>

    <!-- Load all needed scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="message_script.js"></script>
    <script src="themes.js"></script>
    <script >
        // Run the php script to create the app
        $.ajax({
            url: './scripts/createApp.php',
            type: 'POST',
            data: {},
            success: function(data) {
                console.log(data);
                if(data == "ERROR_Database"){
                    location.replace("./index.php?c=98");
                }
                if(data == "ERROR_NoDevAccountFound"){
                    location.replace("./index.php?c=10");
                }
                if(data == "ERROR_TooManyApps"){
                    location.replace("./index.php?c=11");
                }
                if(data.startsWith("SUCCESS_APP_ID_")){
                    location.replace("./application/?app="+data.replace("SUCCESS_APP_ID_", ""));
                }
            }
        });
    </script>
</body>

</html>