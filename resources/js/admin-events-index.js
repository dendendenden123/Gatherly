$(document).ready(function () {
    $.get("/admin/events", (data) => {
        console.log(data);
    });

    let ajaxRequest = null;
    let debounceTimer = null;
    let filterForm = $(".filter-form");

    // Filtering
    filterForm.on("click input change", () => {
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            if (ajaxRequest) {
                ajaxRequest.abort();
            }

            ajaxRequest = $.ajax({
                url: filterForm.attr("action"),
                type: "GET",
                data: filterForm.serialize(),
                success: function (data) {
                    $(".index-events-list").html(data.list);
                    console.log(data.list);
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                },
            });
        }, 300);
    });

    function bindDeleteButtons() {
        $(".delete-btn")
            .off("click")
            .on("click", function () {
                const id = $(this).data("id");
                const url = $(this).data("url");

                if (confirm("Are you sure you want to delete this item?")) {
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function (data) {
                            alert("success");
                            $("#event-" + id).remove();
                            // Optionally, reload current page if needed
                            fetchData(window.location.href);
                        },
                        error: function () {
                            alert("Error deleting item.");
                        },
                    });
                }
            });
    }

    // Function to handle pagination clicks using AJAX
    function fetchData(url) {
        $.get(url, function (data) {
            $(".index-events-list").html(
                $(data).find(".index-events-list").html()
            );
            $("#pagination").html($(data).find("#pagination").html());
            bindDeleteButtons(); // Rebind events
        });
    }

    // Handle pagination link clicks
    $(document).on("click", "#pagination a", function (e) {
        e.preventDefault();
        let url = $(this).attr("href");
        fetchData(url);
    });

    bindDeleteButtons(); // Initial bind
});
