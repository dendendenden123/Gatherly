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
                    $(".chart-container").html(data.chart);
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                },
            });
        }, 300);
    }
});
