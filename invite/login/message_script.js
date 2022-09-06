// The messages that refer to the codes
code_messages_en = {
    "00": "Success",
    "01": "This email<br>is invalid",
    "02": "This username<br>is invalid",
    "03": "Username length<br>must be between<br>4 and 12 characters",
    "04": "Password is<br>invalid",
    "11": "Username already taken",
    "12": "Email already taken too many times",
    "13": "Account created<br>You can login now",
    "14": "Username or<br>password invalid",
    "21": "Both passwords must match",
    "98": "Database error",
    "99": "ERROR"
};



// Get the message from the url
// Its the string between the ?c= and the &
// If there is no & in the url the message goes to the end of the url

// Get the url
var url = window.location.href;

// Check if there is an ?c= in the url
if (url.indexOf("?c=") > -1) {

    // Split out the code
    var code = url.split('?c=')[1];
    code = code.split('&')[0];

    // Check if there is a message
    if (code_messages_en[code] != undefined) {
        var message = code_messages_en[code];
    } else {
        var message = "Unknown error";
    }

    console.log(message);

    document.getElementById("errorOutputContainer").innerHTML = "<div id='errorOutput'>" + message + "</div>";
}

document.getElementById("errorOutputContainer").addEventListener("click", function() {

    // Remove the error message
    document.getElementById("errorOutputContainer").style.animation = "animation_close_error 0.5s";

    // Remove the error message after the animation is done
    setTimeout(function() {

        // Remove the error message
        document.getElementById("errorOutputContainer").style.display = "none";

    }, 500);

});