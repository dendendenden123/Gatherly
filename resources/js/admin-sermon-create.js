$(document).ready(() => {
    const $form = $("#sermon-form");
    const $videoInput = $("#video_file");
    const $videoName = $("#video_file_name");
    const $videoUrl = $("#video_url");
    const $browseBtn = $("#browse-video");

    let uploadInProgress = false;

    // Setup CSRF for AJAX
    const csrf = $('meta[name="csrf-token"]').attr("content");
    $.ajaxSetup({
        headers: { "X-CSRF-TOKEN": csrf },
    });

    // Browse button triggers hidden file input
    $browseBtn.on("click", () => $videoInput.trigger("click"));

    // When a file is selected, upload asynchronously
    $videoInput.on("change", function () {
        const file = this.files && this.files[0] ? this.files[0] : null;
        if (!file) return;

        $videoName.val(file.name);
        const uploadUrl = $('meta[name="sermon-upload-url"]').attr("content");
        if (!uploadUrl) {
            Swal.fire("Error", "Upload URL not configured.", "error");
            return;
        }

        const formData = new FormData();
        formData.append("video_file", file);

        uploadInProgress = true;
        Swal.fire({
            title: "Uploading video...",
            html: '<div id="upload-progress" class="w-full bg-gray-200 rounded"><div id="upload-bar" class="bg-blue-600 text-xs leading-none py-1 text-center text-white rounded" style="width:0%">0%</div></div>',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        $.ajax({
            url: uploadUrl,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            xhr: function () {
                const xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener(
                        "progress",
                        function (e) {
                            if (e.lengthComputable) {
                                const percent = Math.round(
                                    (e.loaded / e.total) * 100
                                );
                                $("#upload-bar")
                                    .css("width", percent + "%")
                                    .text(percent + "%");
                            }
                        },
                        false
                    );
                }
                return xhr;
            },
        })
            .done((res) => {
                if (res && res.success && res.url) {
                    $videoUrl.val(res.url);
                    Swal.fire(
                        "Success",
                        "Video uploaded successfully. The Video URL has been filled.",
                        "success"
                    );
                } else {
                    Swal.fire(
                        "Error",
                        res && res.message ? res.message : "Upload failed.",
                        "error"
                    );
                }
            })
            .fail((xhr) => {
                const msg =
                    xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : "Upload failed.";
                Swal.fire("Error", msg, "error");
            })
            .always(() => {
                uploadInProgress = false;
                // Clear the file input so accidental resubmission doesn't re-upload
                $videoInput.val("");
            });
    });

    // Form submission
    $form.on("submit", function (e) {
        // Prevent submit if an upload is currently in progress
        if (uploadInProgress) {
            e.preventDefault();
            Swal.fire(
                "Please wait",
                "Video is still uploading. Submit after it completes.",
                "info"
            );
            return false;
        }

        // Require either a video URL present (from manual input or async upload) or nothing if not applicable
        if (!$videoUrl.val() && !$videoInput.val()) {
            // If neither URL is present, block submit
            e.preventDefault();
            Swal.fire(
                "Missing video",
                "Please provide a Video URL or upload a video file.",
                "warning"
            );
            return false;
        }
        // Allow normal submit to backend store route
        return true;
    });
});
