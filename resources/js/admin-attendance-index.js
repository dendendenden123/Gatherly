$(document).ready(function () {
    let ajaxRequest = null;
    let debounceTimer = null;

    //request data
    function requestData() {
        const filterForm = $(".filter-form").serialize();
        const filterName = $(".filter-name").serialize();
        const combinedForm = filterForm + "&" + filterName;
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            if (ajaxRequest) {
                ajaxRequest.abort();
            }
            ajaxRequest = $.ajax({
                url: "/admin/attendance",
                type: "GET",
                data: combinedForm,
                success: function (data) {
                    $(".index-attendance-list").html(data.list);
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                },
            });
        }, 300);
    }

    //clear the search box
    const clearSearchBox = (e) => {
        e.preventDefault();
        $(".search-box").val("");
        requestData();
    };

    //calling the functions
    $(document).on(
        "input change",
        ".search-box, .filter-name, .filter-form",
        requestData
    );
    $(".clear-search").on("click", clearSearchBox);
});
