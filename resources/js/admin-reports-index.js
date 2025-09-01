$(document).ready(function () {
    let ajaxRequest = null;
    let debounceTimer = null;

    $("#filterForm").on("input change", () => {
        requestData();
    });

    // Debounced AJAX request
    function requestData() {
        const filterForm = $("#filterForm").serialize();
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            if (ajaxRequest) {
                ajaxRequest.abort();
            }

            ajaxRequest = $.ajax({
                url: $("#filterForm").attr("action"),
                type: "GET",
                data: filterForm,
                success: function (data) {
                    updateChartContainerWithResponse(data);
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                },
            });
        }, 300);
    }

    //================================================
    //=== Handles updating the chart container with new chart HTML and executes any embedded scripts.
    //=== The AJAX response containing the chart HTML.
    //================================================
    function updateChartContainerWithResponse(data) {
        $(".chart-container").empty();
        const tempDiv = document.createElement("div");
        tempDiv.innerHTML = data.chart;
        $(".chart-container").append(tempDiv.innerHTML);

        // Find and execute any <script> tags in the returned HTML
        const scripts = tempDiv.querySelectorAll("script");
        scripts.forEach(function (script) {
            if (script.textContent.trim()) {
                try {
                    const newScript = document.createElement("script");
                    newScript.textContent = script.textContent;
                    document.head.appendChild(newScript);
                    document.head.removeChild(newScript);
                } catch (error) {
                    console.error("Error executing chart script:", error);
                }
            }
        });
    }
});
