$(document).ready(() => {
    let eventData = $("#calendar").data("events");

    console.log(
        eventData.map((arr) => {
            return {
                title: arr.event_name,
                start: arr.start_date,
                end: arr.end_date,
            };
        })
    );

    //===SET UP====
    let ajaxRequest = null;
    let debounceTimer = null;
    const timeModal = $("#myModal");

    //===EVENT LISTENER===
    showCalendarEvent();
    $("#isRecurring").on("change", toggleRecurringOption);
    $(".closeModal").on("click", hideTimeModal);

    //===FUNCTIONS===
    function showTimeModal() {
        timeModal.removeClass("hidden");
    }

    function hideTimeModal(e) {
        e.preventDefault();
        timeModal.addClass("hidden");
    }

    function toggleRecurringOption() {
        const recurringOptions = $("#recurringOptions");
        if (this.checked) {
            recurringOptions.show();
        } else {
            recurringOptions.hide();
        }
    }

    function showCalendarEvent() {
        var calendarEl = document.getElementById("calendar");
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            selectable: true,
            events: eventData.map((arr) => {
                return {
                    title: arr.event_name,
                    start: arr.start_date,
                    end: arr.end_date,
                };
            }),

            // events: getEvent(),
            select: function (info) {
                showTimeModal();
                $("#submitForm").on("click", storeEvent(info));
            },
        });
        calendar.render();
    }

    function getEvent() {
        return [
            {
                id: 1,
                title: "Evengilical MIssion <br> hello",
                start: "2025-08-07",
                end: "2025-08-10",
            },
            {
                id: 2,
                title: "Evengilical MIssion <br> hello",
                start: "2025-08-07",
                end: "2025-08-10",
            },
        ];
    }

    console.log(getEvent());

    function storeEvent(info) {
        const eventForm = $("#eventForm").serializeArray();

        eventForm.push(
            { name: "start_date", value: info.startStr },
            { name: "end_date", value: info.endStr }
        );

        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            if (ajaxRequest) {
                ajaxRequest.abort();
            }

            ajaxRequest = $.ajax({
                url: "/admin/events/store",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                type: "POST",
                data: eventForm,
                success: function (data) {
                    // Swal.fire({
                    //     icon: "success",
                    //     title: "Success!",
                    //     text: data.success,
                    //     confirmButtonColor: "#3085d6",
                    // });
                    // location.reload();

                    console.log(data);
                },
                error: function (xhr) {
                    console.error1("Error:", xhr.responseText);
                },
            });
        }, 300);
    }
});
