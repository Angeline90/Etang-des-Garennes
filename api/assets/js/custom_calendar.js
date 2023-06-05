// console.log(userId)
// const events = [
//   {
//     summary: "JS Conference",
//     start: {
//       date: Calendar.dayjs().format("DD/MM/YYYY"),
//     },
//     end: {
//       date: Calendar.dayjs().format("DD/MM/YYYY"),
//     },
//     color: {
//       background: "#cfe0fc",
//       foreground: "#0a47a9",
//     },
//   },
//   {
//     summary: "Vue Meetup",
//     start: {
//       date: Calendar.dayjs().add(25, "day").format("DD/MM/YYYY"),
//     },
//     end: {
//       date: Calendar.dayjs().add(29, "day").format("DD/MM/YYYY"),
//     },
//     color: {
//       background: "#ebcdfe",
//       foreground: "#6e02b1",
//     },
//   },
//   {
//     summary: "Angular Meetup",
//     description:
//       "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nullapariatur",
//     start: {
//       date: Calendar.dayjs().subtract(3, "day").format("DD/MM/YYYY"),
//       dateTime:
//         Calendar.dayjs().subtract(3, "day").format("DD/MM/YYYY") + " 10:00",
//     },
//     end: {
//       date: Calendar.dayjs().add(3, "day").format("DD/MM/YYYY"),
//       dateTime: Calendar.dayjs().add(3, "day").format("DD/MM/YYYY") + " 14:00",
//     },
//     color: {
//       background: "#c7f5d9",
//       foreground: "#0b4121",
//     },
//   },
//   {
//     summary: "React Meetup",
//     start: {
//       date: Calendar.dayjs().add(5, "day").format("DD/MM/YYYY"),
//     },
//     end: {
//       date: Calendar.dayjs().add(8, "day").format("DD/MM/YYYY"),
//     },
//     color: {
//       background: "#fdd8de",
//       foreground: "#790619",
//     },
//   },
//   {
//     summary: "Meeting",
//     start: {
//       date: Calendar.dayjs().add(1, "day").format("DD/MM/YYYY"),
//       dateTime: Calendar.dayjs().add(1, "day").format("DD/MM/YYYY") + " 8:00",
//     },
//     end: {
//       date: Calendar.dayjs().add(1, "day").format("DD/MM/YYYY"),
//       dateTime: Calendar.dayjs().add(1, "day").format("DD/MM/YYYY") + " 12:00",
//     },
//     color: {
//       background: "#cfe0fc",
//       foreground: "#0a47a9",
//     },
//   },
//   {
//     summary: "Call",
//     start: {
//       date: Calendar.dayjs().add(2, "day").format("DD/MM/YYYY"),
//       dateTime: Calendar.dayjs().add(2, "day").format("DD/MM/YYYY") + " 11:00",
//     },
//     end: {
//       date: Calendar.dayjs().add(2, "day").format("DD/MM/YYYY"),
//       dateTime: Calendar.dayjs().add(2, "day").format("DD/MM/YYYY") + " 14:00",
//     },
//     color: {
//       background: "#292929",
//       foreground: "#f5f5f5",
//     },
//   },
// ];

const events = [
    {
        summary: userId,
        start: {
            date: Calendar.dayjs().format('DD/MM/YYYY'),
        },
        end: {
            date: Calendar.dayjs().format('DD/MM/YYYY'),
        },
        color: {
            background: '#f0f',
        },
    },
           {
        summary: 'reservation CAROLE',
        start: {
            date: Calendar.dayjs().format('DD/MM/YYYY'),
        },
        end: {
            date: Calendar.dayjs().format('DD/MM/YYYY'),
        },
        color: {
            background: '#f0f',
        },
    },
];

const calendarElement = document.getElementById("calendar");
calendarElement.classList.add("calendar");
const calendarInstance = new Calendar(calendarElement, {
  events: events,
  timepickerOptions: {
    clearLabel: "Example Clear",
  },
  datepickerOptions: {
    okBtnText: "Example Ok",
  },
});

calendarElement.addEventListener("addEvent.mdb.calendar", async (e) => {
  const arrivalDate = new Date(
    e.event.start.date.split("/").reverse().join("-")
  ).toISOString();
  console.log(arrivalDate)
  const departureDate = new Date(
    e.event.end.date.split("/").reverse().join("-")
  ).toISOString();

  const data = {
    clients: ["/users/" + userId],
    arrivalDate: arrivalDate,
    departureDate: departureDate,
    bookingState: "/booking_states/1",
    cottage: "/cottages/" + cottageId,
    createdAt: new Date().toJSON(),
    updatedAt: new Date().toJSON(),
  };
  const rawResponse = await fetch("https://localhost/bookings", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });
  console.log(data);

  //  const content = await rawResponse.json();
  const fetchBooking = async () => {
    const jsonResponse = await fetch("https://localhost/bookings", {
      method: "GET",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
    });
    console.log(jsonResponse);
  };
});

// const calendarInstance = Calendar.getInstance(calendarElement);
// calendarInstance.addEvents(events)
