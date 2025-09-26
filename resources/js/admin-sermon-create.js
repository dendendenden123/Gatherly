$(document).ready(() => {
    $("#sermon-form").on("submit", function (e) {
        e.preventDefault();
        submitSermonCreateForm(this);
    });

    function submitSermonCreateForm(form) {
        if (!$("#video_url").val() && !$("#video_file").val()) {
            return Swal.fire({
                icon: "Failed",
                title: "Failed",
                text: "Upload a video or paste a link to continue.",
                confirmButtonColor: "#d63030ff",
            });
        }
        form.submit();
    }
});
