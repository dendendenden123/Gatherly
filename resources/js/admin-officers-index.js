//===========================SET UP=================b=============
const addOfficerModal = document.getElementById("addOfficerModal");
let autocompleteNames = $("#autoCompleteNames").data("user");
let ajaxRequest = null;
let debounceTimer = null;

//===========================EVENT HANDLERS==============================

$("#addOfficerBtn").on("click", () => showAddOfficerForm());

$("#closeAddOfficerModalBtn, #cancelAddOfficer").on("click", () =>
    hideAddOfficerForm()
);

$("#officerRole").on("change", function () {
    showCustomRoleField(this);
});

$("#submitAddOfficerForm").on("click", function (e) {
    submitAddOfficerForm(e);
});

$("#officerName").on("click input change", function () {
    filterOfficerNames(this);
});

$(document).on("click", ".autocomplete-item", function () {
    handleAutoCompleteSelection(this);
});

//===========================FUNCTIONS==============================

//=================================
//==Displays the "Add Officer" modal form
//=================================
function showAddOfficerForm() {
    addOfficerModal.style.display = "flex";
}

//=================================
//==Hides the "Add Officer" modal form
//=================================
function hideAddOfficerForm() {
    addOfficerModal.style.display = "none";
}

//=================================
//==Showsthe custom role input if custom is selected
//=================================
function showCustomRoleField(officerRole) {
    const customRoleGroup = document.getElementById("customRoleGroup");
    customRoleGroup.style.display =
        officerRole.value === "other" ? "block" : "none";
}

//=================================
//==Filters the officer list autoComplete by input value and updates the autocomplete dropdown
//=================================
function filterOfficerNames(officerInput) {
    let memberName = $(officerInput).val();
    if (memberName.length > 0) {
        $("#autoCompleteNames").removeClass("hidden");
    } else {
        $("#autoCompleteNames").addClass("hidden");
    }

    let filteredName = autocompleteNames.filter((element) => {
        let full_name = element.first_name + " " + element.last_name;
        return (
            element.first_name
                .toLowerCase()
                .includes(memberName.toLowerCase()) ||
            element.last_name
                .toLowerCase()
                .includes(memberName.toLowerCase()) ||
            full_name.toLowerCase().includes(memberName.toLowerCase())
        );
    });

    $("#autoCompleteNames ul").html(
        filteredName.map((item) => {
            return `<li id="${item.id}" class="autocomplete-item px-4 py-2 hover:bg-gray-100 cursor-pointer">${item.first_name} ${item.last_name}</li>`;
        })
    );
}

//=================================
//==Updates the officer input and hidden user ID field when an autocomplete suggestion is selected.
//=================================
function handleAutoCompleteSelection(item) {
    $("#officerName").val($(item).text());
    $("#selectedUserId").val($(item).attr("id"));
    $("#autoCompleteNames").addClass("hidden");
}

function submitAddOfficerForm(e) {
    e.preventDefault();
    alert("submit not allowed");
}

// Form Submission
// document.getElementById("officerForm").addEventListener("submit", function (e) {
//     e.preventDefault();

//     // Get form values
//     const name = document.getElementById("officerName").value;
//     const email = document.getElementById("officerEmail").value;
//     const role = document.getElementById("officerRole").value;
//     const customRole = document.getElementById("customRole").value;
//     const termStart = document.getElementById("termStart").value;
//     const termEnd = document.getElementById("termEnd").value;

//     // In a real app, this would send data to your backend
//     console.log("Adding officer:", {
//         name,
//         email,
//         role: role === "other" ? customRole : role,
//         termStart,
//         termEnd,
//     });

//     alert(`Officer ${name} added successfully!`);
//     addOfficerModal.style.display = "none";
//     this.reset();
// });

// Remove buttons
document.querySelectorAll(".remove-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
        const officerName =
            this.closest("tr").querySelector(".officer-name").textContent;
        if (
            confirm(
                `Are you sure you want to remove ${officerName} as an officer?`
            )
        ) {
            alert(`${officerName} has been removed from officer position.`);
            // In a real app, this would make an API call to update the database
        }
    });
});

function openModal() {
    document.getElementById("modalBackdrop").classList.remove("hidden");
    document.getElementById("roleModal").classList.remove("hidden");
    document.body.classList.add("overflow-hidden");
}

function closeModal() {
    $("#modalBackdrop").addClass("hidden");
    $("#roleModal").addClass("hidden");
    document.body.classList.remove("overflow-hidden");
}

function saveRoles() {
    const selectedRoles = Array.from(
        document.querySelectorAll('input[name="roles"]:checked')
    ).map((checkbox) => checkbox.value);

    // Here you would typically send the data to your Laravel backend
    console.log("Selected roles:", selectedRoles);

    // Close the modal after saving
    closeModal();

    // Show success message (you can replace this with a toast notification)
    alert("Roles updated successfully!");
}

// Close modal when clicking outside
document.getElementById("modalBackdrop").addEventListener("click", closeModal);

// Prevent modal content click from closing the modal
document.getElementById("roleModal").addEventListener("click", function (e) {
    e.stopPropagation();
});

// Close modal with Escape key
document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
        closeModal();
    }
});
