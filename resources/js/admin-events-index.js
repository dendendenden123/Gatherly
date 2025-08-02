$(document).ready(function () {
    // === Setup ===
    let ajaxRequest = null;
    let debounceTimer = null;
    const filterForm = $(".filter-form");
    const bulkDeleteCheckBox = $(".bulk-delete-checkbox");
    const bulkDeletesSubmitBtn = $(".bulk-delete-submit-btn");

    // === Event Listeners ===
    bulkDeletesSubmitBtn.on("click", bulkDelete);
    filterForm.on("click input change", filterList);
    selectAllButton;

    // === Functions ===
    function filterList() {
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
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                },
            });
        }, 300);
    }

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

    function bulkDelete() {
        const selectedIds = $(".bulk-delete-checkbox:checked")
            .map(function () {
                return $(this).data("id");
            })
            .get();

        if (!selectedIds.length > 0) {
            return null;
        }

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to undo this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            clearTimeout(debounceTimer);

            debounceTimer = setTimeout(() => {
                if (ajaxRequest) {
                    ajaxRequest.abort();
                }

                ajaxRequest = $.ajax({
                    url: "/admin/events/bulkDestroy",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                        "Content-Type": "application/json",
                    },
                    type: "DELETE",
                    data: JSON.stringify({
                        ids: selectedIds,
                    }),
                    success: function (data) {
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: data.success,
                            confirmButtonColor: "#3085d6",
                        });
                        location.reload();
                    },
                    error: function (xhr) {
                        console.error("Error:", xhr.responseText);
                    },
                });
            }, 300);
        });
    }
});
