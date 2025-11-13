
//===========================SET UP================================
const addOfficerModal = $("#addOfficerModal");
const roleCheckBoxes = $(".role-checkbox");
const officerForm = $("#officerForm");
const filterForm = $("#officerFilters");
let userList = $("#autoCompleteNames").data("user");
let ajaxRequest = null;
let debounceTimer = null;

//===========================EVENT HANDLERS==============================

$("#addOfficerBtn").on("click", () => showAddOfficerForm());

$("#closeAddOfficerModalBtn, #cancelAddOfficer").on("click", () =>
    hideAddOfficerForm()
);

$(".edit-btn").on("click", function () {
    showAddOfficerForm(this);
});

$("#officerName").on("click input change", function () {
    updateAutocompleteSuggestions(this);
});

$(document).on("click", ".autocomplete-item", function () {
    handleAutoCompleteSelection(this);
});

$(".delete-btn").on("click", (e) => {
    e.preventDefault();
    confirmDeleteEvent(e);
});

// Filter form submission
filterForm.on('submit', function(e) {
    e.preventDefault();
    applyFilters();
});

// Reset filters
$('#resetFilters').on('click', function() {
    filterForm.trigger('reset');
    applyFilters();
});

// Apply filters with debounce for search input
$('#search').on('input', function() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        applyFilters();
    }, 500);
});

// Apply filters when date, role, or status changes
$('#role, #status, #start_date, #end_date').on('change', function() {
    applyFilters();
});

//===========================FUNCTIONS==============================

//=================================
//==Displays the "Add Officer" modal form
//=================================
function showAddOfficerForm(selectedUser = null) {
    if (selectedUser) {
        handleAutoCompleteSelection(selectedUser);
    }
    addOfficerModal.css("display", "flex");
}

//=================================
//==Hides the "Add Officer" modal form
//=================================
function hideAddOfficerForm() {
    addOfficerModal.css("display", "none");
}

//=================================
//==Filters the officer list autoComplete by input value and updates the autocomplete dropdown
//=================================
function updateAutocompleteSuggestions(officerInput) {
    let memberName = $(officerInput).val();
    $("#autoCompleteNames").toggleClass("hidden", memberName.length === 0);

    let filteredName = userList.filter((element) => {
        return element.full_name
            .toLowerCase()
            .includes(memberName.toLowerCase());
    });

    $("#autoCompleteNames ul").html(
        filteredName.map((item) => {
            return `<li id="${item.id}" data-name='${item.full_name}' class="autocomplete-item px-4 py-2 hover:bg-gray-100 cursor-pointer">${item.full_name}</li>`;
        })
    );
}

//=================================
//==Updates the officer input and hidden user ID field when an autocomplete suggestion is selected.
//=================================
function handleAutoCompleteSelection(item) {
    let selectedUser = $(item).attr("id");
    $("#officerName").val($(item).data("name"));
    $("#selectedUserId").val($(item).attr("id"));
    $("#autoCompleteNames").addClass("hidden");

    applyUserRolesToForm(selectedUser);
}

//=================================
//===Sets the role checkboxes in the form based on the selected user's assigned roles.
//=================================
function applyUserRolesToForm(selectedUser) {
    const user = userList.find((user) => user.id == selectedUser);
    const attainedRoleIds = Array.isArray(user && user.roles)
        ? user.roles.map((item) => `role_${item.role_id}`)
        : [];

    roleCheckBoxes.each(function () {
        const checkboxId = $(this).attr("id");
        const shouldBeChecked = attainedRoleIds.includes(checkboxId);
        $(this).prop("checked", shouldBeChecked);
    });
}

//=================================
//===Applies the current filters and updates the officers list
//=================================
function applyFilters() {
    const formData = filterForm.serialize();
    
    // Show loading state
    const officersList = $('#officersList');
    officersList.addClass('opacity-50 pointer-events-none');
    
    // Cancel any pending request
    if (ajaxRequest) {
        ajaxRequest.abort();
    }
    
    // Make AJAX request
    ajaxRequest = $.ajax({
        url: window.location.pathname,
        type: 'GET',
        data: formData,
        dataType: 'html',
        success: function(response) {
            officersList.html(response);
            updateUrlWithFilters(formData);
        },
        error: function(xhr, status, error) {
            if (status !== 'abort') {
                console.error('Error applying filters:', error);
                alert('An error occurred while applying filters. Please try again.');
            }
        },
        complete: function() {
            officersList.removeClass('opacity-50 pointer-events-none');
            ajaxRequest = null;
        }
    });
}

//=================================
//===Updates the URL with the current filters without page reload
//=================================
function updateUrlWithFilters(params) {
    const url = new URL(window.location);
    const searchParams = new URLSearchParams(params);
    
    // Remove empty params
    for (const [key, value] of searchParams.entries()) {
        if (value) {
            url.searchParams.set(key, value);
        } else {
            url.searchParams.delete(key);
        }
    }
    
    // Update URL without page reload
    window.history.pushState({}, '', url);
}

//==================================================
//====Shows confirmation dialog before submitting event delete form
//=================================================
function confirmDeleteEvent(e) {
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
