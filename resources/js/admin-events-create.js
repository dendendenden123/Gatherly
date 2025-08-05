$(document).ready(() => {
    //===SET UP====
    const timeModal = $("#myModal");
    const eventData = $("#calendar").data("events");
    console.log(eventData);

    //===EVENT LISTENER===
    showCalendarEvent();
    $("#isRecurring").on("change", toggleRecurringOption);
    $(".closeModal").on("click", hideTimeModal);
    $(".closeViewEventModal").on("click", closeViewEventModal);

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
            eventClick: function (info) {
                console.log(viewEvent(info));
                $("#viewEvent").removeClass("hidden");
            },
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
                description: item.event_description,
                type: item.event_type,
                location: item.location,
                start: occurrence.occurrence_date,
                end: occurrence.occurrence_date,
                ...occurrence,
            }))
        );
    }

    function viewEvent(info) {
        return info.event;
    }

    function closeViewEventModal() {
        $("#viewEvent").addClass("hidden");
    }
});
