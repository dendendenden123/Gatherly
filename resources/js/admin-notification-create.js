$(document).ready(function () {
    // Mobile menu toggle
    $("#menuToggle").on("click", function () {
        $("#sidebar").toggleClass("active");
    });

    // Recipient Type Selection
    $("#recipientType").on("change", function () {
        if (this.value == "specific_member") {
            $("#specificMemberInput").removeClass("hidden");
        } else {
            $("#specificMemberInput").addClass("hidden");
        }
    });

    // Preview Button
    $("#previewBtn").on("click", function () {
        const subject = $("#notificationSubject").val() || "Sample Subject";
        const message =
            $("#notificationMessage").val() ||
            "This is a preview of how your notification will appear to recipients.";

        $("#previewSubject").text(subject);
        $("#previewMessage").text(message);
        $("#sender").text("From: " + $(this).data("loggeduser"));

        $("#previewSection").show();

        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
    });

    // Close Preview
    $("#closePreview").on("click", function () {
        $("#previewSection").hide();
    });
});
