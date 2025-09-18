// Single notification mark as read via AJAX
$(document).ready(function () {
    $(document).on("click", ".single-markread-btn", function () {
        const btn = $(this);
        const url = btn.data("url");
        const token = $("input[name='_token']").first().val();
        if (!url || !token) {
            alert("Mark Read URL or CSRF token not found.");
            return;
        }
        $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: token,
            },
            success: function () {
                window.location.reload();
            },
            error: function () {
                Swal.fire(
                    "Error",
                    "Failed to mark notification as read.",
                    "error"
                );
            },
        });
    });
});
// Single notification delete via AJAX
$(document).ready(function () {
    $(document).on("click", ".single-delete-btn", function () {
        const btn = $(this);
        const url = btn.data("url");
        const token = $("input[name='_token']").first().val();
        if (!url || !token) {
            alert("Delete URL or CSRF token not found.");
            return;
        }
        Swal.fire({
            title: "Are you sure?",
            text: "This notification will be deleted.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _method: "DELETE",
                        _token: token,
                    },
                    success: function () {
                        Swal.fire({
                            title: "Deleted!",
                            text: "The selected notifications have been deleted successfully.",
                            icon: "success",
                            confirmButtonText: "OK",
                        }).then(() => {
                            // Reload after user clicks OK
                            window.location.reload();
                        });
                    },
                    error: function () {
                        Swal.fire(
                            "Error",
                            "Failed to delete notification.",
                            "error"
                        );
                    },
                });
            }
        });
    });
});

$(document).ready(function () {
    // Bulk delete confirmation with SweetAlert2
    $("#bulkForm").on("submit", function (e) {
        e.preventDefault(); // stop normal form submission first

        Swal.fire({
            title: "Are you sure?",
            text: "Do you really want to delete the selected notifications?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete them!",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                e.target.submit();
            }
        });
    });

    $("#bulkDeleteBtn").on("click", () => {
        $("#bulkForm").submit();
    });
});
