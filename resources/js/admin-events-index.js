$(document).ready(function () {
    let ajaxRequest = null;
    let debounceTimer = null;
    let filterForm = $(".filter-form");
    let deleteButton = $(".delete-btn");

    //request data
    function requestDataList(data, endpoint, Hmtlcontainer) {
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            if (ajaxRequest) {
                ajaxRequest.abort();
            }
            ajaxRequest = $.ajax({
                url: endpoint,
                type: "GET",
                data: data,
                success: function (data) {
                    $("." + Hmtlcontainer).html(data.list);
                    console.log(data.list);
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                },
            });
        }, 300);
    }

    deleteButton.on("click", () => {
        let event_id = deleteButton.attr("id");
        console.log(event_id);
    });

    filterForm.on("click input change", () => {
        requestDataList(
            filterForm.serialize(),
            filterForm.attr("action"),
            "index-events-list"
        );
    });
});
