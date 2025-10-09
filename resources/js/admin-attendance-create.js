//===Set Up===
let ajaxRequest = null;
let debounceTimer = null;

//===Event Handler===
$("#member-search").on("keyup", (e) => {
    getAutoCompleteNameSuggestion(e);
});
$("#autocomplete-results").on("click", (event) => {
    handleSelectionClick(event);
});

$(document).on("click", (event) => {
    closeDropDown(event);
});

$("#present-attendnace-btn").on("click", () => {
    recordMemberAttendance("present");
});

$("#absent-attendnace-btn").on("click", () => {
    recordMemberAttendance("absent");
});

$("#event-done-btn").on("click", () => markEventAsDone());

$("#locale-select").on("input change", () =>
    filterNameSuggestionByLocaleCongregation()
);

$("#email").on("input change", function (e) {
    e.preventDefault();
    isEmailValidForEnrollment(this);
});

//===Functions===

function isEmailValidForEnrollment(form) {
    let emailurl = $(form).data("email-verify-url");
    let emailInput = $(form).val();

    console.log(emailurl, emailInput);

    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        // Abort previous request if still active
        if (ajaxRequest) {
            ajaxRequest.abort();
        }

        ajaxRequest = $.ajax({
            url: emailurl,
            type: "GET",
            data: { email: emailInput },
            success: function (data) {
                if (data.status == "404") {
                    $(".emailVerifyFeedback").html(
                        `<span class="text-red-500"> ${data.message} </span>`
                    );
                    $("#emailVerifyBtn").prop("disabled", true);
                } else if (data.status == "409") {
                    $(".emailVerifyFeedback").html(
                        `<span class="text-blue-500"> ${data.message} </span>`
                    );
                    $("#emailVerifyBtn").prop("disabled", true);
                } else if (data.status == "200") {
                    $(".emailVerifyFeedback").html(
                        `<span class="text-green-500"> ${data.message} </span>`
                    );

                    $("#emailVerifyBtn").prop("disabled", false);
                }
            },
            error: function (xhr, status, error) {
                if (status !== "abort") {
                    console.error("Pagination error:", error);
                }
            },
        });
    }, 50);
}

//====================================
//===Show members name suggestions
//===================================
function showResults(searchTerm) {
    const resultsContainer = document.getElementById("autocomplete-results");

    if (searchTerm.length > 0) {
        resultsContainer.classList.remove("hidden");
    } else {
        resultsContainer.classList.add("hidden");
    }
}

//====================================
//===Close down Drop down for member name suggestions
//===================================
function closeDropDown(event) {
    const searchContainer = document.querySelector(".relative");
    if (!searchContainer.contains(event.target)) {
        document.getElementById("autocomplete-results").classList.add("hidden");
    }
}

//====================================
//===Handle click event when names suggestion is clicked
//===================================
function handleSelectionClick(event) {
    const selectedItem = $(event.target).closest(".nameList");
    const memberData = selectedItem.data("member-data");
    const fullName = selectedItem
        .find(".full_name")
        .text()
        .trim()
        .replace(/\s+/g, " ");
    if (selectedItem.length) {
        $("#member-search").val(fullName);
        showInfoSelectedMember(memberData);
        $("#autocomplete-results").addClass("hidden");
    }
}

//====================================
//===Get the name suggestion when user search for member name
//===================================
function getAutoCompleteNameSuggestion(e) {
    e.preventDefault();
    const url = $("#manual-form").attr("action");
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        // Abort previous request if still active
        if (ajaxRequest) {
            ajaxRequest.abort();
        }

        ajaxRequest = $.ajax({
            url: url,
            type: "GET",
            data: $("#manual-form").serialize(),
            success: function (data) {
                let arrList = data.autoCorrctNameList || [];
                $("#autocomplete-results").empty();
                if (arrList.length == 0) {
                    $("#autocomplete-results").append(`
                            <div class=" px-4 py-2 hover:bg-light-gray cursor-pointer border-b border-gray-100 flex justify-between" data-member-data=''>
                                <span class='full_name text-red-500'>Member not found
                                </span>
                                <span class="text-red-500 font-mono">
                                    NA
                                </span>
                            </div>
                `);
                } else {
                    arrList.forEach((item) => {
                        $("#autocomplete-results").append(`
                            <div class="nameList px-4 py-2 hover:bg-light-gray cursor-pointer border-b border-gray-100 flex justify-between" data-member-data='
                                 ${JSON.stringify(item)}
                            '>
                                <span class='full_name'>
                                    ${item.first_name}
                                    ${item.middle_name}
                                    ${item.last_name}
                                </span>
                                <span class="text-gray-500 font-mono">
                                    ${item.id}
                                </span>
                            </div>
                `);
                    });
                }

                showResults($("#member-search").val());
            },
            error: function (xhr, status, error) {
                if (status !== "abort") {
                    console.error("Pagination error:", error);
                }
            },
        });
    }, 100);
}

//====================================
//===Show info from selected member
//===================================
function showInfoSelectedMember(memberData) {
    const data = JSON.parse(memberData);
    const fullName = `${data.first_name} ${data.middle_name} ${data.last_name}`;
    const dateObj = new Date(data.birthdate);
    const birthdateFormatted = dateObj.toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });

    $("#name-selected").text(fullName);
    $("#id-selected").text(data.id);
    $("#birthdate-selected").text(birthdateFormatted);
    $("#phone-selected").text(data.phone);
    $("#email-selected").text(data.email);
}

//====================================
//===Record attendance of selected member as Present or Absent
//===================================
async function recordMemberAttendance(status) {
    const userId = $("#id-selected").text();
    const event_occurence_id = $("#manualEventNameSelection").val();

    console.log(
        "checking",
        "user id: " + userId,
        "event id: " + event_occurence_id
    );

    if (
        (!userId ||
            userId == "0" ||
            !event_occurence_id ||
            event_occurence_id.length == 0) &&
        status != "eventDone"
    ) {
        $("#responeMessage").html(`
            <span class="text-red-500">
                Please select both a user and an event.
            </span>
        `);
        return;
    }

    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        if (ajaxRequest) {
            ajaxRequest.abort();
        }

        ajaxRequest = $.ajax({
            url: $("#present-attendnace-btn").attr("action"),
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                "Content-Type": "application/json",
            },
            type: "POST",
            data: JSON.stringify({
                user_id: userId,
                event_occurrence_id: event_occurence_id,
                status: status,
            }),
            success: function (data) {
                if (data.error) {
                    $("#responeMessage").html(
                        `<span class="text-red-500">${data.error}</span>`
                    );
                } else {
                    $("#responeMessage").html(
                        `<span class="text-green-500">${data.message}</span>`
                    );

                    setTimeout(() => {
                        $("#responeMessage").html("");
                        $("#member-search").val("");
                    }, 2000);
                }

                $(".create-recent-attendance-list").html(data.list);
            },
            error: function (xhr, status, error) {
                if (status !== "abort") {
                    console.error("Attendance error:", error);
                    console.log("Response text:", xhr.responseText);
                }

                $("#responeMessage").html(
                    `<span class="text-red-500">${data.error}</span>`
                );
            },
        });
    }, 100);
}

//====================================
//===Mark event as done. Create record for absent members
//===================================
async function markEventAsDone() {
    const event_occurence_id = $("#manualEventNameSelection").val();
    console.log(event_occurence_id);
    if (!event_occurence_id || event_occurence_id.length == 0) {
        return $("#responeMessage").html(`
            <span class="text-red-500">
                Please select an event.
            </span>
        `);
    }

    const result = await Swal.fire({
        title: "Are you sure?",
        text: "This will mark the event as done and record attendance.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "rgb(46 204 113)",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, continue",
    });

    if (result.isConfirmed) {
        await recordMemberAttendance("eventDone"); // wait here
        await Swal.fire(
            "Recorded!",
            "The attendance has been saved.",
            "success"
        );
        location.reload();
    }
}

function filterNameSuggestionByLocaleCongregation() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        if (ajaxRequest) {
            ajaxRequest.abort();
        }

        ajaxRequest = $.ajax({
            url: $("#locale-select").attr("action"),
            type: "GET",
            data: {
                locale: $("#locale-select").val(),
            },
            success: function (data, e) {
                getAutoCompleteNameSuggestion(e);
            },
            error: function (xhr, status, error) {
                if (status !== "abort") {
                    console.error("Attendance error:", error);
                    console.log("Response text:", xhr.responseText);
                }

                $("#responeMessage").html(
                    `<span class="text-red-500">${data.error}</span>`
                );
            },
        });
    }, 100);
}

// AI GENERATED CODE BELOW
// Tab switching logic
document.addEventListener("DOMContentLoaded", function () {
    const tabButtons = document.querySelectorAll(".tab-button");
    const tabContents = document.querySelectorAll(".tab-content");

    tabButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const tabId = this.getAttribute("data-tab");

            // Update active tab button
            tabButtons.forEach((btn) => btn.classList.remove("active"));
            this.classList.add("active");

            // Show active tab content
            tabContents.forEach((content) =>
                content.classList.remove("active")
            );
            document.getElementById(tabId).classList.add("active");
        });
    });
});

// Camera modal logic
let cameraStream = null;
const cameraModal = document.getElementById("cameraModal");
const openCameraBtn = document.getElementById("openCameraBtn");
const closeCameraModal = document.getElementById("closeCameraModal");
const cameraPreview = document.getElementById("cameraPreview");
const cameraCanvas = document.getElementById("cameraCanvas");
const capturePhotoBtn = document.getElementById("capturePhotoBtn");
let scanPhotoDataUrl = null;
const cameraError = document.getElementById("cameraError");

if (openCameraBtn) {
    openCameraBtn.addEventListener("click", async function () {
        cameraError.classList.add("hidden");
        cameraError.textContent = "";
        cameraModal.classList.remove("hidden");
        try {
            cameraStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    width: { ideal: 1280 },
                    height: { ideal: 720 },
                },
            });
            cameraPreview.srcObject = cameraStream;
        } catch (err) {
            cameraError.textContent = "Unable to access camera: " + err.message;
            cameraError.classList.remove("hidden");
        }
    });
}

if (closeCameraModal) {
    closeCameraModal.addEventListener("click", function () {
        cameraModal.classList.add("hidden");
        if (cameraStream) {
            cameraStream.getTracks().forEach((track) => track.stop());
            cameraPreview.srcObject = null;
        }
    });
}

if (capturePhotoBtn) {
    capturePhotoBtn.addEventListener("click", function () {
        if (!cameraStream) return;
        const width = cameraPreview.videoWidth;
        const height = cameraPreview.videoHeight;
        cameraCanvas.width = width;
        cameraCanvas.height = height;
        cameraCanvas
            .getContext("2d")
            .drawImage(cameraPreview, 0, 0, width, height);
        scanPhotoDataUrl = cameraCanvas.toDataURL("image/jpeg");
        // Hide modal and stop camera
        cameraModal.classList.add("hidden");
        cameraStream.getTracks().forEach((track) => track.stop());
        cameraPreview.srcObject = null;
        Swal.fire({
            icon: "success",
            title: "Photo Captured",
            text: "Photo ready for submission.",
            timer: 1500,
            showConfirmButton: false,
        });
    });
}

// AJAX submit for forms to show pop-up without reload
$(function () {
    $("#enrollForm").on("submit", function (e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        var action = $(form).attr("action");
        $.ajax({
            url: action,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.message || "Member enrolled successfully!",
                    timer: 2000,
                    showConfirmButton: false,
                });
                form.reset();
            },
            error: function (xhr) {
                let msg = "An error occurred.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: msg,
                    timer: 3000,
                    showConfirmButton: false,
                });
            },
        });
    });

    $("#scanForm").on("submit", function (e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData();
        var action = $(form).attr("action");
        // If no photo, show error
        if (!scanPhotoDataUrl) {
            Swal.fire({
                icon: "error",
                title: "No Photo",
                text: "Please scan and capture a photo first.",
                timer: 2000,
                showConfirmButton: false,
            });
            return;
        }
        // Convert base64 to Blob and append as file
        function dataURLtoFile(dataurl, filename) {
            var arr = dataurl.split(","),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);
            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new File([u8arr], filename, { type: mime });
        }
        var photoFile = dataURLtoFile(scanPhotoDataUrl, "photo.jpg");
        formData.append("photo", photoFile);
        // Add CSRF token
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
        var eventId = $('#scanForm select[name="event_occurrence_id"]').val();
        formData.append("event_occurrence_id", eventId || "");
        $.ajax({
            url: action,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text:
                        response.message || "Attendance scanned successfully!",

                    showConfirmButton: true,
                });
                form.reset();
                scanPhotoDataUrl = null;
            },
            error: function (xhr) {
                let msg = "An error occurred.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: msg,
                    timer: 3000,
                    showConfirmButton: false,
                });
            },
        });
    });
});

// File upload preview
document
    .getElementById("photo-upload")
    .addEventListener("change", function (e) {
        const fileName = e.target.files[0]
            ? e.target.files[0].name
            : "No file chosen";
        document.querySelector('label[for="photo-upload"] p').textContent =
            fileName;
    });
