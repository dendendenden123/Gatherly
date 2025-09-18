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
