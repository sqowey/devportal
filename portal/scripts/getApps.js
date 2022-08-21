const applications_list = document.getElementById("applications_list");

// Run the php script to get apps
$.ajax({
    url: './scripts/getApps.php',
    type: 'POST',
    data: {},
    success: function(data) {
        console.log(data);
        const parsed = JSON.parse(data);
        parsed.forEach(lmnt => {
            const element_parsed = JSON.parse(lmnt);
            // App item container
            const application_item = document.createElement("div");
            application_item.classList.add("application_item");
            // App item inner container
            const container = document.createElement("div");
            container.classList.add("container");
            // App item logo
            const application_logo = document.createElement("img");
            application_logo.classList.add("application_logo");
            application_logo.alt = element_parsed.app_name;
            application_logo.src = element_parsed.app_id + ".png";
            // App item name
            const application_name = document.createElement("div");
            application_name.classList.add("application_name");
            application_name.innerText = element_parsed.app_name;
            // App item token status
            const application_status = document.createElement("div");
            application_status.classList.add("application_status");
            application_status.innerText = "Tokens left: " + element_parsed.tokens;
            // Append them together
            container.appendChild(application_logo);
            container.appendChild(application_name);
            container.appendChild(application_status);
            application_item.appendChild(container);
            // Append the item
            applications_list.prepend(application_item);
        });
    }
});