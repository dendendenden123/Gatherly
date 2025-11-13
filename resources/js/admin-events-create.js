$(document).ready(() => {
    //===SET UP====
    const timeModal = $("#myModal");
    const eventData = $("#calendar").data("events");

    //===EVENT LISTENER===
    showCalendarEvent();
    $("#isRecurring").on("change", () => toggleRecurringOption());
    $(".closeModal").on("click", (e) => hideTimeModal(e));
    $(".confirmModal").on("click", (e) => {
        e.preventDefault();
        hideTimeModal();
    });
    $(".closeViewEventModal").on("click", () => closeViewEventModal());

    //===FUNCTIONS===
    function closeViewEventModal() {
        $("#viewEvent").addClass("hidden");
    }

    function showTimeModal() {
        console.log("Showing time modal");
        timeModal.removeClass("hidden");
    }

    function hideTimeModal(e) {
        if (e) {
            e.preventDefault();
        }
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

        if (!calendarEl) {
            console.error("Calendar element not found");
            return;
        }

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            selectable: true,
            timeZone: "Asia/Manila",
            events: getEvent(),
            eventClick: function (info) {
                viewEvent(info);
                $("#viewEvent").removeClass("hidden");
            },
            select: function (info) {
                console.log("Date selected:", info.startStr, "to", info.endStr);
                //set the value for start and end Date
                $("#startDate").val(info.startStr);
                // FullCalendar's endStr is exclusive (day after), so subtract one day
                var endDate = new Date(info.endStr);
                endDate.setDate(endDate.getDate() - 1);
                var endDateStr = endDate.toISOString().split("T")[0];
                $("#endDate").val(endDateStr);

                showTimeModal();
            },
        });
        calendar.render();
    }

    function getEvent() {
        if (!eventData || !Array.isArray(eventData)) {
            console.warn("No event data available");
            return [];
        }

        return eventData.flatMap((item) =>
            item.event_occurrences.map((occurrence) => {
                // Create a clean occurrence object without time properties that might confuse FullCalendar
                const { start_time, end_time, ...cleanOccurrence } = occurrence;

                // Get CSS class based on event type
                const eventTypeClass = getEventTypeClass(item.event_type);
                const statusClass = `status-${item.status}`;

                // Parse the occurrence date properly without timezone conversion
                const occurrenceDate = occurrence.occurrence_date.split("T")[0];

                return {
                    title: item.event_name,
                    start: occurrenceDate + "T" + start_time,
                    end: occurrenceDate + "T" + end_time,
                    allDay: false,
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
                    className: `${eventTypeClass} ${statusClass}`,
                    ...cleanOccurrence,
                };
            })
        );
    }

    function getEventTypeClass(eventType) {
        const typeMap = {
            Baptism: "event-baptism",
            "Charity Event": "event-charity",
            "Christian Family Organization (CFO) activity": "event-cfo",
            "Evangelical Mission": "event-mission",
            "Inauguration of New Chapels/ Structure": "event-inauguration",
            Meeting: "event-meeting",
            Panata: "event-panata",
            Weddings: "event-wedding",
            "Worship Service": "event-worship",
        };

        return typeMap[eventType] || "event-default";
    }

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

        const timeParts = timeStr.split(":");
        const hour = parseInt(timeParts[0], 10);
        const minute = timeParts[1] || "00"; // Default to "00" if minute is undefined
        const suffix = hour >= 12 ? "PM" : "AM";
        const hour12 = hour % 12 === 0 ? 12 : hour % 12;

        return `${hour12}:${minute.padStart(2, "0")} ${suffix}`;
    }
});
