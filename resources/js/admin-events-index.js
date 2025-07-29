$(document).ready(function () {
    let ajaxRequest = null;
    let debounceTimer = null;
    let filterForm = $(".filter-form");

    // Request data
    function requestDataList(attr) {
        const data = attr.data;
        const endpoint = attr.endpoint;
        const dynamicHtmlContainer = attr.container;
        const type = attr.type || "GET";
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
                    if (!dynamicHtmlContainer) {
                        return data;
                    }

                    $("." + dynamicHtmlContainer).html(data.list);
                    console.log(data.list);
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                },
            });
        }, 300);
    }

    // Delete event
    $(".delete-btn").on("click", function (e) {
        e.preventDefault();
        const formDelete = $(this).closest("form");
        alert(formDelete);

        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            deletionRequest = requestDataList({
                data: formDelete.serialize(),
                endpoint: formDelete.attr("action"),
                container: "index-events-list",
                type: "POST",
            });

            Swal.fire("Deleted!", "The event has been deleted.", "success");
        });
    });

    // Filtering
    filterForm.on("click input change", () => {
        requestDataList({
            data: filterForm.serialize(),
            endpoint: filterForm.attr("action"),
            container: "index-events-list",
        });
    });
});
