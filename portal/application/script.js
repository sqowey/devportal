// Get the pixel width of the browser window
var width = window.innerWidth;

// Check if 15% of the window width is less than 330px
if (width / 100 * 15 < 330) {

    // Get how many percent of the window is 330px
    var left_side = 330 / width * 100;
    var right_side = 100 - left_side;

    // Set the left and right side of the grid from .container
    document.getElementsByClassName('container')[0].style.gridTemplateColumns = left_side + '% ' + right_side + '%';

}

// Sensitive data copy
const sensitive_elements = document.getElementsByClassName("sensitive_data");
for (let i = 0; i < sensitive_elements.length; i++) {
    const element = sensitive_elements[i];
    element.onclick = () => {
        navigator.clipboard.writeText(element.innerHTML);
        element.style.transition = "0.1s";
        element.style.backgroundColor = "#00ff00";
        window.setTimeout(() => {
            element.style.backgroundColor = "#383e42";
        }, 250);
    };
}

// Value change form submit
const startvalue = document.getElementById("app_name_input").value;
window.setInterval(() => {
    if (document.getElementById("app_name_input").value != startvalue) {
        document.getElementById("app_name_input_submit").classList.remove("button_inactive");
        document.getElementById("app_name_input_submit").classList.add("button_active");
        document.getElementById("app_name_input_submit").disabled = false;
    }
}, 100);