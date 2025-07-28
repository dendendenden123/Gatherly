$(document).ready(function () {
    let ajaxRequest = null;
    let debounceTimer = null;
    let filterForm = $(".filter-form");
    let deleteButton = $(".delete-btn");

    //request data
    function requestDataList(data, endpoint, Hmtlcontainer, type = "GET") {
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            if (ajaxRequest) {
                ajaxRequest.abort();
            }
            ajaxRequest = $.ajax({
                url: endpoint,
                type: type,
                data: data,
                success: function (data) {
                    $("." + Hmtlcontainer).html(data.list);
                    console.log(data.list);

                    return data;
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                },
            });
        }, 300);
    }

    //delete event
    deleteButton.on("click", (e) => {
        let requestDelete = requestDataList(
            $(".delete-form").serialize(),
            $(".delete-form").attr("action"),
            "index-events-list",
            "POST"
        );

        if (!requestDelete) {
            Swal.fire({
                title: "Failed!",
                text: "Deletion is failed.",
                icon: "failed",
                confirmButtonText: "Great",
            });
        }

        e.preventDefault();
        let eventId = e.currentTarget.id;
        $("#" + eventId).remove();
    });

    //filtering
    filterForm.on("click input change", () => {
        requestDataList(
            filterForm.serialize(),
            filterForm.attr("action"),
            "index-events-list"
        );
    });
});
