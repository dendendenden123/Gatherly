$(document).ready(() => {
    //SET UP
    let ajaxRequest = null;
    let debounceTimer = null;

    //EVENT LISTENER
    $("#member-search, #filterForm").on("click input change", () => {
        console.log("click");
        fetchFilteredList();
    });
    $(".delete-btn").on("click", (e) => confirmDeleteEvent(e));

    //FUNCTIONS
    //============================================
    //===Debounced AJAX request to fetch and update filtered member list
    //===========================================
    function fetchFilteredList() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            if (ajaxRequest) {
                ajaxRequest.abort();
            }

            ajaxRequest = $.ajax({
                url: $("#filterForm").attr("action"),
                type: "GET",
                data: $("#filterForm").serialize(),
                success: function (data) {
                    $(".index-list").html(data.list);
                },
                error: function (xhr, status, error) {
                    if (status !== "abort") {
                        console.error(error);
                        console.log(xhr.responseText);
                    }
                },
            });
        }, 100);
    }

    //==================================================
    //====Shows confirmation dialog before submitting event delete form
    //=================================================
    function confirmDeleteEvent(e) {
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
    }
});
