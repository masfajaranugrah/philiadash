var start_date = document.getElementById("event-start-date");
var timepicker1 = document.getElementById("timepicker1");
var timepicker2 = document.getElementById("timepicker2");
var date_range = null;
var T_check = null;

document.addEventListener("DOMContentLoaded", function () {
    flatPickrInit();
    var addEvent = new bootstrap.Modal(document.getElementById('event-modal'), {
        keyboard: false
    });
    var modalTitle = document.getElementById('modal-title');
    var formEvent = document.getElementById('form-event');
    var selectedEvent = null;
    var forms = document.getElementsByClassName('needs-validation');

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var Draggable = FullCalendar.Draggable;
    var externalEventContainerEl = document.getElementById('external-events');
    let defaultEvents = [];

    const apiUrl = window.Laravel.apiUrl; // Ambil nilai dari Blade

fetch(`${apiUrl}/events/`)
    .then(response => response.json())
    .then(data => {
        // Transform the data into the format FullCalendar expects
        defaultEvents = data.map(event => {
            const startDate = new Date(event.start);
            let endDate = event.end ? new Date(event.end) : null;

            // Ambil hanya bagian "YYYY-MM-DD" untuk perbandingan
            const startDateOnly = startDate.toISOString().split("T")[0]; // "2025-02-18"
            const endDateOnly = endDate ? endDate.toISOString().split("T")[0] : null;
            console.log(startDateOnly === endDateOnly)
            if (startDateOnly !== endDateOnly) {
                // Jika tanggalnya berbeda, tambahkan 1 hari ke end date
                endDate.setDate(endDate.getDate() + 1);
                return {
                    id: event.id,
                    title: event.title,
                    start: startDate.toISOString(),
                    end: endDate.toISOString(),
                    className: event.className,
                    allDay: Boolean(event.allDay),
                    location: event.location,
                    description: event.description
                };
            } else {
               
                // Jika tanggalnya sama atau end date tidak ada, biarkan end tetap null
                return {
                    id: event.id,
                    title: event.title,
                    start: startDate.toISOString(),
                    end: endDate.toISOString(),
                    className: event.className,
                    allDay: Boolean(event.allDay),
                    location: event.location,
                    description: event.description
                };
            }
       
        })

        console.log(defaultEvents); // Verify if data is correctly loaded
        initializeCalendar(defaultEvents);
    })
    .catch(error => console.error("Error fetching events:", error));


    // Initialize draggable external events
    new Draggable(externalEventContainerEl, {
        itemSelector: '.external-event',
        eventData: function (eventEl) {
            return {
                id: Math.floor(Math.random() * 11000),
                title: eventEl.innerText,
                allDay: true,
                start: new Date(),
                className: eventEl.getAttribute('data-class')
            };
        }
    });

    function initializeCalendar(defaultEvents) {
        var calendarEl = document.getElementById('calendar');

        function addNewEvent(info) {
            formEvent.reset();
            document.getElementById('btn-delete-event').setAttribute('hidden', true);
            addEvent.show();
            formEvent.classList.remove("was-validated");
            selectedEvent = null;
            modalTitle.innerText = 'Add Event';
            // Optionally store info for further processing
            document.getElementById("edit-event-btn").setAttribute("data-id", "new-event");
            document.getElementById('edit-event-btn').click();
            document.getElementById("edit-event-btn").setAttribute("hidden", true);
        }

        function getInitialView() {
            if (window.innerWidth >= 768 && window.innerWidth < 1200) {
                return 'timeGridWeek';
            } else if (window.innerWidth <= 768) {
                return 'listMonth';
            } else {
                return 'dayGridMonth';
            }
        }

        var eventCategoryChoice = new Choices("#event-category", {
            searchEnabled: false
        });

        var calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: 'local',
            editable: false,
            droppable: false,
            selectable: true,
            navLinks: true,
            initialView: getInitialView(),
            themeSystem: 'bootstrap',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            windowResize: function (view) {
                var newView = getInitialView();
                calendar.changeView(newView);
            },
            eventResize: function (info) {
                // Update your local event object as needed
                var index = defaultEvents.findIndex(x => x.id == info.event.id);
                if (index !== -1) {
                    defaultEvents[index].title = info.event.title;
                    defaultEvents[index].start = info.event.start;
                    defaultEvents[index].end = info.event.end || null;
                    defaultEvents[index].allDay = info.event.allDay;
                    defaultEvents[index].className = info.event.classNames[0];
                    defaultEvents[index].description = info.event._def.extendedProps.description || '';
                    defaultEvents[index].location = info.event._def.extendedProps.location || '';
                }
            },
            eventClick: function (info) {
                // Prepare modal for editing
                document.getElementById("edit-event-btn").removeAttribute("hidden");
                document.getElementById('btn-save-event').setAttribute("hidden", true);
                document.getElementById("edit-event-btn").setAttribute("data-id", "edit-event");
                document.getElementById("edit-event-btn").innerHTML = "Edit";
                eventClicked();
                flatPickrInit();
                flatpicekrValueClear();
                addEvent.show();
                formEvent.reset();
                selectedEvent = info.event;

                // Set modal fields with event data
                document.getElementById("modal-title").innerHTML = "";
                document.getElementById("event-location-tag").innerHTML = selectedEvent.extendedProps.location || "No Location";
                document.getElementById("event-description-tag").innerHTML = selectedEvent.extendedProps.description || "No Description";

                document.getElementById("event-title").value = selectedEvent.title;
                document.getElementById("event-location").value = selectedEvent.extendedProps.location || "No Location";
                document.getElementById("event-description").value = selectedEvent.extendedProps.description || "No Description";
                document.getElementById("eventid").value = selectedEvent.id;

                if (selectedEvent.classNames[0]) {
                    eventCategoryChoice.destroy();
                    eventCategoryChoice = new Choices("#event-category", { searchEnabled: false });
                    eventCategoryChoice.setChoiceByValue(selectedEvent.classNames[0]);
                }

                // Convert string dates to Date objects for flatpickr
                var st_date = new Date(selectedEvent.start);
                var ed_date = selectedEvent.end ? new Date(selectedEvent.end) : null;
           

                // Format dates for display
                var formatDate = function (date) {
                    var d = new Date(date),
                        month = '' + (d.getMonth() + 1),
                        day = '' + d.getDate(),
                        year = d.getFullYear();
                    if (month.length < 2) month = '0' + month;
                    if (day.length < 2) day = '0' + day;
                    return [year, month, day].join('-');
                };

                // var displayDate = ed_date ? (str_dt(st_date)) + ' to ' + (str_dt(ed_date)) : (str_dt(st_date));
                var adjustedEndDate = new Date(ed_date);

                // Jika rentang tanggal lebih dari 1 hari, kurangi 1 hari untuk tampilan
                if (st_date !== ed_date) {
                    adjustedEndDate.setDate(adjustedEndDate.getDate() - 1);
                }
                
                var displayDateForPicker = ed_date 
                    ? formatDate(st_date) + ' to ' + formatDate(adjustedEndDate)
                    : formatDate(st_date);

                flatpickr(start_date, {
                    defaultDate: displayDateForPicker,
                    altInput: true,
                    altFormat: "j F Y",
                    dateFormat: "Y-m-d",
                    mode: ed_date !== null ? "range" : "single",
                    onChange: function (selectedDates, dateStr) {
                        var dates = dateStr.split("to");
                        if (dates.length > 1) {
                            document.getElementById('event-time').setAttribute("hidden", true);
                        } else {
                            document.getElementById("timepicker1").parentNode.classList.remove("d-none");
                            document.getElementById("timepicker1").classList.replace("d-none", "d-block");
                            document.getElementById("timepicker2").parentNode.classList.remove("d-none");
                            document.getElementById("timepicker2").classList.replace("d-none", "d-block");
                            document.getElementById('event-time').removeAttribute("hidden");
                        }
                    }
                });
                document.getElementById("event-start-date-tag").innerHTML = str_dt(st_date);
                
                var gt_time = getTime(selectedEvent.start);
                var ed_time = getTime(selectedEvent.end);

                if (gt_time == ed_time) {
                    document.getElementById('event-time').setAttribute("hidden", true);
                    flatpickr(document.getElementById("timepicker1"), { enableTime: true, noCalendar: true, dateFormat: "H:i" });
                    flatpickr(document.getElementById("timepicker2"), { enableTime: true, noCalendar: true, dateFormat: "H:i" });
                } else {
                    document.getElementById('event-time').removeAttribute("hidden");
                    flatpickr(document.getElementById("timepicker1"), {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        defaultDate: gt_time
                    });
                    flatpickr(document.getElementById("timepicker2"), {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        defaultDate: ed_time
                    });
                    document.getElementById("event-timepicker1-tag").innerHTML = tConvert(gt_time);
                    document.getElementById("event-timepicker2-tag").innerHTML = tConvert(ed_time);
                }
                newEventData = null;
                modalTitle.innerText = selectedEvent.title;
                document.getElementById('btn-delete-event').removeAttribute('hidden');

document.getElementById("btn-delete-event").addEventListener("click", function (e) {
    if (selectedEvent) {
        // Kirim permintaan DELETE ke API untuk menghapus event dari backend
        fetch(`${apiUrl}/events/${selectedEvent.id}`, { // Corrected URL with template literals
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        })
        .then(response => {
            if (response.ok) {
                // Jika API mengembalikan response sukses, hapus event dari kalender dan array defaultEvents
                for (var i = 0; i < defaultEvents.length; i++) {
                    if (defaultEvents[i].id == selectedEvent.id) {
                        defaultEvents.splice(i, 1);
                        break;
                    }
                }
                selectedEvent.remove();
                selectedEvent = null;
                addEvent.hide();
            } else {
                console.error("Gagal menghapus event. Response:", response);
            }
        })
        .catch(error => console.error("Error deleting event:", error));
    }
});

            },
            dateClick: function (info) {
                addNewEvent(info);
            },
            events: defaultEvents,
            eventReceive: function (info) {
                var newid = parseInt(info.event.id);
                var newEvent = {
                    id: newid,
                    title: info.event.title,
                    start: info.event.start,
                    allDay: info.event.allDay,
                    className: info.event.classNames[0]
                };
                defaultEvents.push(newEvent);
            },
            eventDrop: function (info) {
                var index = defaultEvents.findIndex(x => x.id == info.event.id);
                if (index !== -1) {
                    defaultEvents[index].title = info.event.title;
                    defaultEvents[index].start = info.event.start;
                    defaultEvents[index].end = info.event.end || null;
                    defaultEvents[index].allDay = info.event.allDay;
                    defaultEvents[index].className = info.event.classNames[0];
                    defaultEvents[index].description = info.event._def.extendedProps.description || '';
                    defaultEvents[index].location = info.event._def.extendedProps.location || '';
                }
            }
        });

        calendar.render();

        /*--- Create/Update Event (Form Submission) ---*/
        formEvent.addEventListener('submit', function (ev) {
            ev.preventDefault();

            // Get values from the form
            var updatedTitle = document.getElementById("event-title").value;
            var updatedCategory = document.getElementById('event-category').value;
            var dateInput = document.getElementById("event-start-date").value.split("to");
            var startValue = dateInput[0].trim();
            var endValue = dateInput[1] ? dateInput[1].trim() : null;

          // Convert string dates into Date objects
var newStart = new Date(startValue);
var newEnd = endValue ? new Date(endValue) : null;

// For time selection (if single date)
var all_day = false;
if (!endValue) {
    var start_time = document.getElementById("timepicker1").value.trim();
    var end_time = document.getElementById("timepicker2").value.trim();
    if (start_time && end_time) {
        newStart = new Date(startValue + "T" + start_time);
        newEnd = new Date(startValue + "T" + end_time);
    } else {
        all_day = true;
    }
} else {
    // For range events, you may adjust end date as needed
    newEnd.setDate(newEnd.getDate()); // Add one day for the end date
    all_day = true;
}
 

            var event_location = document.getElementById("event-location").value;
            var eventDescription = document.getElementById("event-description").value;
            var eventid = document.getElementById("eventid").value;
            
            // Prepare event data object for API
            var eventData = {
                title: updatedTitle,
                start: newStart.toISOString(),
                end: newEnd ? newEnd.toISOString() : null,
                className: updatedCategory,
                allDay: all_day,
                location: event_location,
                description: eventDescription,
                // Optionally include extendedProps if needed
            };
      
            // If editing an existing event
            if (selectedEvent) {
             
                // Make a PUT request to update event in the backend
                fetch(`${apiUrl}/events/` + selectedEvent.id, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json"
                    },
                    body: JSON.stringify(eventData)
                })
                    .then(response => response.json())
                    .then(data => {
                        // Update the event on the calendar
                        selectedEvent.setProp("title", data.title);
                        selectedEvent.setStart(data.start);
                        selectedEvent.setEnd(data.end);
                        selectedEvent.setProp("classNames", [data.className]);
                        selectedEvent.setAllDay(data.allDay);
                        selectedEvent.setExtendedProp("location", data.location);
                        selectedEvent.setExtendedProp("description", data.description);
                        // Update the local defaultEvents array if needed
                        var index = defaultEvents.findIndex(x => x.id == selectedEvent.id);
                        if (index !== -1) {
                            defaultEvents[index] = data;
                        }
                        defaultEvents.push(data);
                        addEvent.hide();
                    
                        // Auto reload halaman setelah sukses
                        setTimeout(() => {
                            location.reload();
                        }, 1); // Delay 500ms aga
                        // addEvent.hide();
                    })
                    .catch(error => console.error("Error updating event:", error));
            } else {
          
               // Create a new event (POST request)
fetch(`${apiUrl}/events/`, {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json"
    },
    body: JSON.stringify(eventData)
})
.then(response => response.json())
.then(data => {
    // Add the new event to the calendar and local array
    calendar.addEvent({
        id: data.id,
        title: data.title,
        start: data.start,
        end: data.end,
        allDay: data.allDay,
        className: data.className,
        extendedProps: {
            location: data.location,
            description: data.description
        }
    });

    defaultEvents.push(data);
    addEvent.hide();

    // Auto reload halaman setelah sukses
    setTimeout(() => {
        location.reload();
    }, 1); // Delay 500ms agar efek lebih halus
})
.catch(error => console.error("Error creating event:", error));

            }
        });
    }
});

    


function flatPickrInit() {
    var config = {
        enableTime: true,
        noCalendar: true,
    };
    var date_range = flatpickr(
        start_date, {
        enableTime: false,
        mode: "range",
        minDate: "today",
        onChange: function (selectedDates, dateStr, instance) {
            var date_range = dateStr;
            var dates = date_range.split("to");
            if (dates.length > 1) {
                document.getElementById('event-time').setAttribute("hidden", true);
            } else {
                document.getElementById("timepicker1").parentNode.classList.remove("d-none");
                document.getElementById("timepicker1").classList.replace("d-none", "d-block");
                document.getElementById("timepicker2").parentNode.classList.remove("d-none");
                document.getElementById("timepicker2").classList.replace("d-none", "d-block");
                document.getElementById('event-time').removeAttribute("hidden");
            }
        },
    });
    flatpickr(timepicker1, config);
    flatpickr(timepicker2, config);
}

function flatpicekrValueClear() {
    if (start_date._flatpickr) start_date._flatpickr.clear();
    if (timepicker1._flatpickr) timepicker1._flatpickr.clear();
    if (timepicker2._flatpickr) timepicker2._flatpickr.clear();
}


function eventClicked() {
    document.getElementById('form-event').classList.add("view-event");
    document.getElementById("event-title").classList.replace("d-block", "d-none");
    document.getElementById("event-category").classList.replace("d-block", "d-none");
    document.getElementById("event-start-date").parentNode.classList.add("d-none");
    document.getElementById("event-start-date").classList.replace("d-block", "d-none");
    document.querySelector("#event-time").hidden = true;
        document.getElementById("timepicker1").parentNode.classList.add("d-none");
    document.getElementById("timepicker1").classList.replace("d-block", "d-none");
    document.getElementById("timepicker2").parentNode.classList.add("d-none");
    document.getElementById("timepicker2").classList.replace("d-block", "d-none");
    document.getElementById("event-location").classList.replace("d-block", "d-none");
    document.getElementById("event-description").classList.replace("d-block", "d-none");
    document.getElementById("event-start-date-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-timepicker1-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-timepicker2-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-location-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-description-tag").classList.replace("d-none", "d-block");
    document.getElementById('btn-save-event').setAttribute("hidden", true);
}

 
function editEvent(data) {
    var data_id = data.getAttribute("data-id");
    if (data_id == 'new-event') {
        document.getElementById('modal-title').innerHTML = "";
        document.getElementById('modal-title').innerHTML = "Add Event";
        document.getElementById("btn-save-event").innerHTML = "Add Event";
        eventTyped();
    } else if (data_id == 'edit-event') {
        data.innerHTML = "Cancel";
        data.setAttribute("data-id", 'cancel-event');
        document.getElementById("btn-save-event").innerHTML = "Update Event";
        data.removeAttribute("hidden");
        eventTyped();
    } else {
        data.innerHTML = "Edit";
        data.setAttribute("data-id", 'edit-event');
        eventClicked();
    }
}

function eventTyped() {
    document.getElementById('form-event').classList.remove("view-event");
    document.getElementById("event-title").classList.replace("d-none", "d-block");
    document.getElementById("event-category").classList.replace("d-none", "d-block");
    document.getElementById("event-start-date").parentNode.classList.remove("d-none");
    document.getElementById("event-start-date").classList.replace("d-none", "d-block");
    document.getElementById("timepicker1").parentNode.classList.remove("d-none");
    document.getElementById("timepicker1").classList.replace("d-none", "d-block");
    document.getElementById("timepicker2").parentNode.classList.remove("d-none");
    document.getElementById("timepicker2").classList.replace("d-none", "d-block");
    document.getElementById("event-location").classList.replace("d-none", "d-block");
    document.getElementById("event-description").classList.replace("d-none", "d-block");
    document.getElementById("event-start-date-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-timepicker1-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-timepicker2-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-location-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-description-tag").classList.replace("d-block", "d-none");
    document.getElementById('btn-save-event').removeAttribute("hidden");
}

function getTime(params) {
    params = new Date(params);
    if (params.getHours() != null) {
        var hour = params.getHours();
        var minute = (params.getMinutes()) ? params.getMinutes() : 0o0;
        return hour + ":" + minute;
    }
}

function tConvert(time) {
    var t = time.split(":");
    var hours = t[0];
    var minutes = t[1];
    var newformat = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    return (hours + ':' + minutes + ' ' + newformat);
}

var str_dt = function formatDate(date) {
    var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var d = new Date(date),
        month = '' + monthNames[(d.getMonth())],
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    return [day + " " + month, year].join(',');
};