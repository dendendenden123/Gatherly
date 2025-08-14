//===Set Up===
let ajaxRequest = null;
let debounceTimer = null;

//===Event Handler===
$("#member-search").on("change input", (e) => {
    sendRequest(e);
});
$("#autocomplete-results").on("click", (event) => {
    handleSelectionClick(event);
});

$(document).on("click", (event) => {
    closeDropDown(event);
});

//===Functions===
function showResults(searchTerm) {
    const resultsContainer = document.getElementById("autocomplete-results");

    if (searchTerm.length > 0) {
        resultsContainer.classList.remove("hidden");
    } else {
        resultsContainer.classList.add("hidden");
    }
}

function closeDropDown(event) {
    const searchContainer = document.querySelector(".relative");
    if (!searchContainer.contains(event.target)) {
        document.getElementById("autocomplete-results").classList.add("hidden");
    }
}

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

function sendRequest(e) {
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

                showResults($("#member-search").val());
            },
            error: function (xhr, status, error) {
                if (status !== "abort") {
                    console.error("Pagination error:", error);
                }
            },
        });
    }, 100); // debounce delay in ms
}

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
