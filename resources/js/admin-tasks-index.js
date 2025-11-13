document.addEventListener("DOMContentLoaded", () => {
    let controller;
    const taskListContainer = document.querySelector(".task-list");
    const filterForm = document.querySelector("#filter-form");
    const taskStatus = document.querySelector("#task-status");
    const taskPriority = document.querySelector("#task-priority");
    const taskCategory = document.querySelector("#task-category");

    filterForm.addEventListener("change", async (e) => {
        e.preventDefault();
        await sendFilterForm();
    });

    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("delete-btn")) {
            e.preventDefault();
            submitDeleteBtnConfirmation(e.target.id);
        }

        // Handle update task button click
        if (e.target.classList.contains("update-task-btn")) {
            openUpdateTaskModal(e.target);
        }
    });

    const sendFilterForm = async () => {
        controller?.abort();
        controller = new AbortController();

        let baseUrl = filterForm.getAttribute("action");
        let params = new URLSearchParams({
            status: taskStatus.value,
            priority: taskPriority.value,
            category: taskCategory.value,
        }).toString();

        const res = await fetch(`${baseUrl}?${params}`, {
            method: "GET",
            headers: { Accept: "Application/json" },
            signal: controller.signal,
        });

        if (!res.ok) throw new Error(`HTTP ${res.status}`);

        const data = await res.json();
        taskListContainer.innerHTML = data.taskList;
    };

    const submitDeleteBtnConfirmation = (buttonId) => {
        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(`#${buttonId}`).closest("form").submit();
            }
        });
    };

    // Update Task Modal Functions
    const openUpdateTaskModal = (button) => {
        const taskId = button.dataset.taskId;
        const taskTitle = button.dataset.taskTitle;
        const taskStatus = button.dataset.taskStatus;
        const taskComment = button.dataset.taskComment;

        const modal = document.getElementById("updateTaskModal");
        const form = document.getElementById("updateTaskForm");
        const modalTitle = document.getElementById("modal-title");
        const statusSelect = document.getElementById("task_status");
        const commentTextarea = document.getElementById("task_comment");

        // Set form action URL
        form.action = `/member/tasks/${taskId}/update-status`;
        
        // Set modal title
        modalTitle.textContent = `Update Task: ${taskTitle}`;
        
        // Set current values
        statusSelect.value = taskStatus;
        commentTextarea.value = taskComment;

        // Show modal
        modal.classList.remove("hidden");
    };

    // Close modal handlers
    const modal = document.getElementById("updateTaskModal");
    const closeModalBtn = document.getElementById("closeModal");

    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", () => {
            modal.classList.add("hidden");
        });
    }

    // Close modal when clicking outside
    if (modal) {
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.classList.add("hidden");
            }
        });
    }

    // Handle form submission
    const updateTaskForm = document.getElementById("updateTaskForm");
    if (updateTaskForm) {
        updateTaskForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(updateTaskForm);
            const url = updateTaskForm.action;

            try {
                const response = await fetch(url, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json",
                        "X-HTTP-Method-Override": "PUT"
                    },
                    body: formData,
                });

                const data = await response.json();

                if (response.ok) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: data.message || "Task updated successfully!",
                        confirmButtonColor: "#3085d6",
                    }).then(() => {
                        modal.classList.add("hidden");
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: data.message || "Failed to update task",
                        confirmButtonColor: "#d33",
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "An error occurred while updating the task",
                    confirmButtonColor: "#d33",
                });
            }
        });
    }
});
