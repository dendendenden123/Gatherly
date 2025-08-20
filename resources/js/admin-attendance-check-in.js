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

//===Functions===

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
    const url = $("form").attr("action");
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        // Abort previous request if still active
        if (ajaxRequest) {
            ajaxRequest.abort();
        }

        ajaxRequest = $.ajax({
            url: url,
            type: "GET",
            data: $("form").serialize(),
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
    const event_occurence_id = $("#eventNameSelection").val();

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

                $(".check-in-recent-attendance-list").html(data.list);
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
    const event_occurence_id = $("#eventNameSelection").val();
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
