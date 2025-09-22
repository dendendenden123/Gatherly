$(document).ready(function () {
    alert("es tos loade");

    // Set the default active tab
    let activeTab = "upcoming";

    // Function to switch tabs
    function switchTab(tabName) {
        // Hide all tab contents
        $(".tab-content").addClass("hidden");

        // Remove active styles from all tabs
        $(".tab-link")
            .removeClass("border-primary text-primary")
            .addClass("border-transparent text-gray-500");

        // Show the selected tab content
        $("#" + tabName + "-tab").removeClass("hidden");

        // Add active styles to the selected tab
        $(`[data-tab="${tabName}"]`)
            .removeClass("border-transparent text-gray-500")
            .addClass("border-primary text-primary");

        // Update the active tab
        activeTab = tabName;

        // Store the active tab in sessionStorage to persist across reloads
        sessionStorage.setItem("activeEventTab", tabName);
    }

    // Check if there's a previously active tab in sessionStorage
    const savedTab = sessionStorage.getItem("activeEventTab");
    if (savedTab) {
        activeTab = savedTab;
    }

    // Initialize the tabs
    switchTab(activeTab);

    // Add click event listeners to the tabs
    $(".tab-link").on("click", function (e) {
        e.preventDefault();
        const tabName = $(this).data("tab");
        switchTab(tabName);
    });
});
