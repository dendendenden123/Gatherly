$(document).ready(() => {
    //===SET UP====
    let ajaxRequest = null;
    let debounceTimer = null;
    const timeModal = $("#myModal");
    const eventData = $("#calendar").data("events");

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
            events: getEvent(),
            select: function (info) {
                $("#startDate").val(info.startStr);
                $("#endDate").val(info.endStr);

                showTimeModal();
            },
        });
        calendar.render();
    }

    function getEvent() {
        return eventData.flatMap((item) =>
            item.event_occurrences.map((occurrence) => ({
                title: item.event_name,
                start: occurrence.occurrence_date,
                end: occurrence.occurrence_date,
                ...occurrence,
            }))
        );
    }

    async function storeEvent(start_date, end_date) {
        const eventForm = $("#eventForm").serializeArray();

        eventForm.push(
            { name: "start_date", value: start_date },
            { name: "end_date", value: end_date }
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
                    console.log("events created successfully");
                },
                error: function (xhr) {
                    console.error1("Error:", xhr.responseText);
                },
            });
        }, 300);
    }
});
