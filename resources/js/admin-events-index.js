$(document).ready(function () {
    let ajaxRequest = null;
    let debounceTimer = null;
    let filterForm = $(".filter-form");
    let bulkDeleteCheckBox = $(".bulk-delete-checkbox");

    // Filtering
    filterForm.on("click input change", () => {
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            if (ajaxRequest) {
                ajaxRequest.abort();
            }

            ajaxRequest = $.ajax({
                url: filterForm.attr("action"),
                type: "GET",
                data: filterForm.serialize(),
                success: function (data) {
                    $(".index-events-list").html(data.list);
                    console.log(data.list);
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                },
            });
        }, 300);
    });

    //delete button
    $(".delete-btn")
        .off("click")
        .on("click", (e) => {
            e.preventDefault();
            const form = e.currentTarget.closest("form");

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to undo this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

    //select all delete button
    $("#select-all-button")
        .off("click")
        .on("click", function () {
            let allChecked =
                bulkDeleteCheckBox.length ==
                $(".bulk-delete-checkbox:checked").length;

            if (allChecked) {
                bulkDeleteCheckBox.prop("checked", false);
                $(this).text("Select All");
            } else {
                bulkDeleteCheckBox.prop("checked", true);
                $(this).text("Deselect All");
            }
        });

    $(".bulk-delete-submit-btn").on("click", function () {
        const selectedIds = $(".bulk-delete-checkbox:checked")
            .map(function () {
                return $(this).data("id");
            })
            .get();

        if (!selectedIds.length > 0) {
            return null;
        }

        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            if (ajaxRequest) {
                ajaxRequest.abort();
            }

            ajaxRequest = $.ajax({
                url: "/admin/events/bulkDelete",
                type: "DELETE",
                data: {
                    ids: selectedIds,
                    _token: "{{ csrf_token() }}",
                },
                success: function (data) {
                    $(".index-events-list").html(data.list);
                    console.log(data.list);
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                },
            });
        }, 300);
    });
});
