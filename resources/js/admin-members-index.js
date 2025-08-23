$(document).ready(() => {
    //SET UP
    let ajaxRequest = null;
    let debounceTimer = null;

    //EVENT HANDLER
    $("#member-search, #filterForm").on("click input change", () => {
        console.log("click");
        filter();
    });

    //FUNCTIONS

    function filter() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            if (ajaxRequest) {
                ajaxRequest.abort();
            }

            ajaxRequest = $.ajax({
                url: $("#filterForm").attr("action"),
                type: "GET",
                data: $("#filterForm").serialize(),
                success: function (data) {
                    $(".index-list").html(data.list);
                },
                error: function (xhr, status, error) {
                    if (status !== "abort") {
                        console.error(error);
                        console.log(xhr.responseText);
                    }
                },
            });
        }, 100);
    }
});
