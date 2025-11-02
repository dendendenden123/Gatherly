(function () {
    const modal = document.getElementById("absenceReasonModal");
    const form = document.getElementById("absenceReasonForm");
    const attendanceIdInput = document.getElementById("attendanceId");
    const eventNameSpan = document.getElementById("eventName");
    const absenceReasonTextarea = document.getElementById("absenceReason");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const cancelModalBtn = document.getElementById("cancelModalBtn");
    const addReasonBtns = document.querySelectorAll(".add-reason-btn");

    // Open modal when "Add Reason" button is clicked
    addReasonBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
            const attendanceId = this.dataset.attendanceId;
            const eventName = this.dataset.eventName;

            attendanceIdInput.value = attendanceId;
            eventNameSpan.textContent = eventName;
            absenceReasonTextarea.value = "";

            modal.classList.remove("hidden");
            document.body.style.overflow = "hidden";
        });
    });

    // Close modal function
    function closeModal() {
        modal.classList.add("hidden");
        document.body.style.overflow = "auto";
        form.reset();
    }

    // Close modal on button clicks
    closeModalBtn.addEventListener("click", closeModal);
    cancelModalBtn.addEventListener("click", closeModal);

    // Close modal when clicking outside
    modal.addEventListener("click", function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && !modal.classList.contains("hidden")) {
            closeModal();
        }
    });

    // Handle form submission
    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const attendanceId = attendanceIdInput.value;
        const notes = absenceReasonTextarea.value.trim();
        const formData = new FormData(form);

        if (!notes) {
            alert("Please provide a reason for your absence.");
            return;
        }

        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        
        if (!csrfToken) {
            console.error('CSRF token not found');
            alert('Session expired. Please refresh the page and try again.');
            return;
        }

        // Add CSRF token to form data
        formData.append('_token', csrfToken);

        try {
            const response = await fetch(
                `/member/attendance/${attendanceId}/add-reason`,
                {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData,
                }
            );

            const data = await response.json();

            if (response.ok) {
                // Success - reload the page to show updated data
                closeModal();

                // Show success message
                const successDiv = document.createElement("div");
                successDiv.className =
                    "fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in";
                successDiv.innerHTML =
                    '<i class="bi bi-check-circle-fill mr-2"></i>Reason added successfully!';
                document.body.appendChild(successDiv);

                setTimeout(() => {
                    successDiv.remove();
                    location.reload();
                }, 2000);
            } else {
                throw new Error(data.message || "Failed to add reason");
            }
        } catch (error) {
            console.error("Error:", error);
            alert("Failed to add reason. Please try again.");
        }
    });
})();
