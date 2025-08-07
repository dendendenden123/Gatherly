$(document).ready(() => {
    //===SET UP====
    const timeModal = $("#myModal");
    const eventData = $("#calendar").data("events");

    //===EVENT LISTENER===
    showCalendarEvent();
    $("#isRecurring").on("change", toggleRecurringOption);
    $(".closeModal").on("click", hideTimeModal);
    $(".closeViewEventModal").on("click", closeViewEventModal);

    //===FUNCTIONS===
    function closeViewEventModal() {
        $("#viewEvent").addClass("hidden");
    }

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
                viewEvent(info);
                $("#viewEvent").removeClass("hidden");
            },
            select: function (info) {
                //set the value for start and end Date
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
                eventDescription: item.event_description,
                eventType: item.event_type,
                eventLocation: item.location ?? "No specified location",
                eventStartDate: dateFormatter(item.start_date),
                eventEndDate:
                    item.repeat != "once"
                        ? dateFormatter(item.end_date)
                        : dateFormatter(item.start_date),
                eventStartTime: formatTo12Hour(item.start_time),
                eventEndTime: formatTo12Hour(item.end_time),
                eventRepeat: item.repeat,
                eventStatus: item.status,
                ...occurrence,
            }))
        );
    }

    console.log("eventData", eventData);
    console.log("getEvent: ", getEvent());

    function viewEvent(info) {
        const event = info.event;
        $("#viewEventName").html(event.title);
        $("#viewEventDescription").html(event.extendedProps.eventDescription);
        $("#viewEventStatus").html(event.extendedProps.eventStatus);
        $("#viewEventType").html(event.extendedProps.eventType);
        $("#viewEventLocation").html(event.extendedProps.eventLocation);
        $("#viewEventDate").html(dateFormatter(event.start));
        $("#viewEventStartTime").html(event.extendedProps.eventStartTime);
        $("#viewEventEndTime").html(event.extendedProps.eventEndTime);
        $("#viewEventStartDate").html(event.extendedProps.eventStartDate);
        $("#viewEventEndDate").html(event.extendedProps.eventEndDate);
        $("#viewEventRepeat").html(event.extendedProps.eventRepeat);
    }
});

function dateFormatter(rawDate) {
    return new Date(rawDate).toLocaleDateString("en-US", {
        month: "short",
        day: "numeric",
        year: "numeric",
    });
}

function formatTo12Hour(timeStr) {
    if (!timeStr) {
        return "No specified time";
    }

    const [hour, minute] = timeStr.split(":");
    const h = parseInt(hour);
    const suffix = h >= 12 ? "PM" : "AM";
    const hour12 = h % 12 === 0 ? 12 : h % 12;
    return `${hour12}:${minute} ${suffix}`;
}
