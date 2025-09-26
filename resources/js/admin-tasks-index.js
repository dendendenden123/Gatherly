document.addEventListener("DOMContentLoaded", () => {
    let controller = null;
    let debounceTimer = null;

    // Event delegation for pagination links
    document.addEventListener("click", (e) => {
        const link = e.target.closest(".pagination a");
        if (!link) return; // not a pagination link
        e.preventDefault();

        const url = link.getAttribute("href");

        // Clear debounce if user clicks again quickly
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(async () => {
            // Abort previous request if still active
            if (controller) controller.abort();
            controller = new AbortController();

            try {
                const formData = new FormData(document.querySelector("form"));
                const queryString = new URLSearchParams(formData).toString();
                const fullUrl = `${url}${
                    url.includes("?") ? "&" : "?"
                }${queryString}`;

                const response = await fetch(fullUrl, {
                    method: "GET",
                    signal: controller.signal,
                });

                if (!response.ok)
                    throw new Error("Network response was not ok");

                const data = await response.json(); // expecting JSON response
                console.log(data.list);

                document.querySelector(`.${containerClass}`).innerHTML =
                    data.list;
            } catch (err) {
                if (err.name !== "AbortError") {
                    console.error("Pagination error:", err);
                }
            }
        }, 300); // debounce delay
    });
});
