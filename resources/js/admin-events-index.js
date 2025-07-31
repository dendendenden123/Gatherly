$(document).ready(function () {
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

    //delete button
    $(".delete-btn")
        .off("click")
        .on("click", (e) => {
            e.preventDefault();
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
        });
});
