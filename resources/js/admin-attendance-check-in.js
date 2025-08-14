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
    const $selectedItem = $(event.target).closest(
        'div[class*="hover:bg-light-gray"]'
    );

    if ($selectedItem.length) {
        const memberName = $selectedItem.find("span:first-child").text();
        const memberId = $selectedItem.find("span:last-child").text();

        $("#member-search").val(memberName);
        $("#autocomplete-results").addClass("hidden");

        console.log("member data", $selectedItem.data("member-data"));

        // In a real app, you would now load the member details
        console.log(`Selected: ${memberName} (${memberId})`);
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
                let arrList = data.data || []; // declare the variable safely
                $("#autocomplete-results").empty(); // no arguments needed
                arrList.forEach((item) => {
                    $("#autocomplete-results").append(`
                <div class="px-4 py-2 hover:bg-light-gray cursor-pointer border-b border-gray-100 flex justify-between">
                    <span data-member-data='${item}' >${item.first_name} ${item.middle_name} ${item.last_name}</span>
                    <span class="text-gray-500 font-mono">${item.id}</span>
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
