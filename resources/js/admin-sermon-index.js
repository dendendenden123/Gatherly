(function () {
    const dateFilter = document.getElementById("date-filter");
    const listContainer = document.querySelector(".sermon-list");

    function buildUrl(baseUrl, params) {
        const url = new URL(baseUrl, window.location.origin);
        Object.keys(params).forEach((key) => {
            if (
                params[key] !== undefined &&
                params[key] !== null &&
                params[key] !== ""
            ) {
                url.searchParams.set(key, params[key]);
            } else {
                url.searchParams.delete(key);
            }
        });
        return url.toString();
    }

    async function fetchList(params, pushState = true) {
        const url = buildUrl(
            window.location.pathname,
            Object.assign(
                {},
                Object.fromEntries(new URLSearchParams(window.location.search)),
                params
            )
        );
        try {
            const resp = await fetch(url, {
                headers: { "X-Requested-With": "XMLHttpRequest" },
            });
            const data = await resp.json();
            if (data.list) {
                listContainer.innerHTML = data.list;
                if (pushState) {
                    window.history.pushState({}, "", url);
                }
            }
        } catch (e) {
            console.error("Failed to fetch sermons:", e);
        }
    }

    // On change of filter, fetch
    dateFilter.addEventListener("change", function () {
        fetchList({ date: this.value, page: 1 });
    });

    // Delegate pagination clicks to fetch via AJAX and preserve filter
    document.addEventListener("click", function (e) {
        const a = e.target.closest(
            ".sermon-list .pagination a, .sermon-list nav a"
        );
        if (a) {
            e.preventDefault();
            const url = new URL(a.href, window.location.origin);
            const page = url.searchParams.get("page") || 1;
            fetchList({ date: dateFilter.value, page });
        }
    });

    // Handle back/forward
    window.addEventListener("popstate", function () {
        const params = Object.fromEntries(
            new URLSearchParams(window.location.search)
        );
        if (dateFilter) {
            dateFilter.value = params.date || "";
        }
        fetchList({ date: params.date || "", page: params.page || 1 }, false);
    });
})();
