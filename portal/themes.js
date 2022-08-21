//themes.js von CuzImBisonratte
//https://github.com/CuzImBisonratte/themes.js

// Hier kannst du die Farbcodes umstellen
ThemeColorBackLight = "#f1f1f1";
ThemeColorBackDark = "#282C36";
ThemeColorNavBackDark = "#384250";
ThemeColorNavBackLight = "#d1d1d1";
ThemeColorTextLight = "#282C36";
ThemeColorTextDark = "#818181";
ThemeButtonTurnLight = "270deg";
ThemeButtonTurnDark = "90deg";



// Funktion, die die Farbänderungen auführt
function changeToTheme(backgroundColor, textColor, navBackgroundColor, themeTurn) {
    document.body.style.backgroundColor = backgroundColor;
    document.body.style.color = textColor;
    document.documentElement.style.backgroundColor = backgroundColor;
    document.getElementById("navbar").style.backgroundColor = navBackgroundColor;
    document.getElementById("themeSwitcherButton").style.transform = "rotate(" + themeTurn + ")";
    const app_items = document.getElementsByClassName("application_item");
    for (let i = 0; i < app_items.length; i++) {
        const element = app_items[i];
        element.style.backgroundColor = navBackgroundColor;
    }
    const app_logo_items = document.getElementsByClassName("application_logo");
    for (let i = 0; i < app_logo_items.length; i++) {
        const element = app_logo_items[i];
        element.style.backgroundColor = backgroundColor;
    }
}



// Die funktion, die beim aufrufen der Website automatisch gestartet wird
function initializeTheme() {

    // Aktuelles Theme abrufen
    theme = localStorage.getItem("theme");

    //Theme auf gespeichertes Theme setzen
    if (theme == "light") {

        // Theme ändern
        changeToTheme(ThemeColorBackLight, ThemeColorTextLight, ThemeColorNavBackLight, ThemeButtonTurnLight);
    } else {

        // Theme ändern
        changeToTheme(ThemeColorBackDark, ThemeColorTextDark, ThemeColorNavBackDark, ThemeButtonTurnDark);
    }
}

initializeTheme();



// Funktion, die bei Knopfdruck ausgeführt wird
function toggleTheme() {

    // Aktuelles Theme abrufen
    theme = localStorage.getItem("theme");

    // Theme basierend auf Aktuellem theme ändern
    if (theme == "dark") {

        // Theme ändern
        changeToTheme(ThemeColorBackLight, ThemeColorTextLight, ThemeColorNavBackLight, ThemeButtonTurnLight);

        // Theme-Speicher auf "Hell" setzen
        localStorage.setItem("theme", "light");
    } else {

        // Theme ändern
        changeToTheme(ThemeColorBackDark, ThemeColorTextDark, ThemeColorNavBackDark, ThemeButtonTurnDark);

        // Theme-Speicher auf "Dunkel" setzen
        localStorage.setItem("theme", "dark");
    }
}