$(document).ready(function () {
    // === SET UP ===
    let ajaxRequest = null;
    let debounceTimer = null;
    const filterForm = $(".filter-form");
    const bulkDeleteCheckBox = $(".bulk-delete-checkbox");

    // === EVENT LISTENERS ===
    $(".bulk-delete-submit-btn").on("click", () => confirmBulkDelete());
    filterForm.on("click input change", () => fetchFilteredEvents());
    $(".delete-btn")
        .off("click")
        .on("click", (e) => confirmDeleteEvent(e));
    $("#select-all-button")
        .off("click")
        .on("click", () => toggleSelectAll());

    //=== FUNCTION ===
    //==================================================
    //====Debounced AJAX request to fetch and update the filtered events list
    //=================================================
    function fetchFilteredEvents() {
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

    //==================================================
    //====Shows confirmation dialog before submitting event delete form
    //=================================================
    function confirmDeleteEvent(e) {
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
    }

    //==================================================
    //====Toggles select/deselect all checkboxes and updates button text
    //=================================================
    function toggleSelectAll() {
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
    }

    //==================================================
    //==== Confirms and triggers bulk deletion of selected items
    //=================================================
    function confirmBulkDelete() {
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

            bulkDeleteEvents(selectedIds);
        });
    }

    //==================================================
    //====Sends debounced AJAX request to bulk delete selected events
    //=================================================
    function bulkDeleteEvents(selectedIds) {
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
    }
});
