//themes.js von CuzImBisonratte
//https://github.com/CuzImBisonratte/themes.js

// Hier kannst du die Farbcodes umstellen
ThemeColorBackLight = "#f1f1f1";
ThemeColorBackDark = "#282C36";
ThemeColorNavBackDark = "#384250";
ThemeColorNavBackLight = "#d1d1d1";
ThemeColorTextLight = "#282C36";
ThemeColorTextDark = "#818181";
ThemeButtonNameLight = "Hell";
ThemeButtonNameDark = "Dunkel";



// Funktion, die die Farbänderungen auführt
function changeToTheme(backgroundColor, textColor, navBackgroundColor, themeName) {
    document.body.style.backgroundColor = backgroundColor;
    document.body.style.color = textColor;
    document.getElementById("navbar").style.backgroundColor = navBackgroundColor;
    document.getElementById("themeToggleButton").innerHTML = themeName;
}



// Die funktion, die beim aufrufen der Website automatisch gestartet wird
function initializeTheme() {

    // Aktuelles Theme abrufen
    theme = localStorage.getItem("theme");

    //Theme auf gespeichertes Theme setzen
    if (theme == "light") {

        // Theme ändern
        changeToTheme(ThemeColorBackLight, ThemeColorTextLight, ThemeColorNavBackLight, ThemeButtonNameLight);
    } else {

        // Theme ändern
        changeToTheme(ThemeColorBackDark, ThemeColorTextDark, ThemeColorNavBackDark, ThemeButtonNameDark);
    }
}

// Funktion einmal zum Start ausführen
initializeTheme();



// Funktion, die bei Knopfdruck ausgeführt wird
function toggleTheme() {

    // Aktuelles Theme abrufen
    theme = localStorage.getItem("theme");

    // Theme basierend auf Aktuellem theme ändern
    if (theme == "dark") {

        // Theme ändern
        changeToTheme(ThemeColorBackLight, ThemeColorTextLight, ThemeColorNavBackLight, ThemeButtonNameLight);

        // Theme-Speicher auf "Hell" setzen
        localStorage.setItem("theme", "light");
    } else {

        // Theme ändern
        changeToTheme(ThemeColorBackDark, ThemeColorTextDark, ThemeColorNavBackDark, ThemeButtonNameDark);

        // Theme-Speicher auf "Dunkel" setzen
        localStorage.setItem("theme", "dark");
    }
}