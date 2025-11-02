(function () {
    const dateFilter = document.getElementById("date-filter");
    const searchInput = document.getElementById("search-input");
    const listContainer = document.querySelector(".sermon-list");
    let searchTimeout;

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

    // On change of date filter, fetch
    dateFilter.addEventListener("change", function () {
        fetchList({ date: this.value, search: searchInput.value, page: 1 });
    });

    // On search input with debounce
    searchInput.addEventListener("input", function () {
        clearTimeout(searchTimeout);
        const searchValue = this.value;
        searchTimeout = setTimeout(() => {
            fetchList({ search: searchValue, date: dateFilter.value, page: 1 });
        }, 500);
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
            fetchList({ date: dateFilter.value, search: searchInput.value, page });
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
        if (searchInput) {
            searchInput.value = params.search || "";
        }
        fetchList({ date: params.date || "", search: params.search || "", page: params.page || 1 }, false);
    });
})();
