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
});
