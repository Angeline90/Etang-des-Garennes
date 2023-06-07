// console.log(userId)

const calendarElement = document.getElementById("calendar");
if (calendarElement){
  

calendarElement.classList.add("calendar");
const jsonResponse = await fetch(
  `https://localhost/cottages/${cottageId}/bookings?bookingState=/booking_states/7`,
  {
    method: "GET",
  }
);
const bookings = await jsonResponse.json();
console.log("BOOKING>>>", bookings);
const convertedEvents = bookings["hydra:member"].map((booking) => {
  const formattedArrivalDate = Calendar.dayjs(booking.arrivalDate).format(
    "DD/MM/YYYY"
  );
  const formattedDepartureDate = Calendar.dayjs(booking.departureDate).format(
    "DD/MM/YYYY"
  );

  return {
    summary: userName,
    start: {
      date: formattedArrivalDate,
    },
    end: {
      date: formattedDepartureDate,
    },
    color: {
      foreground: formattedArrivalDate && formattedDepartureDate ? "#f0f" : "#008000",
    },
    disabled : true,
    readonly : true,
  };
});

console.log(convertedEvents);

const calendarInstance = new Calendar(calendarElement, {
  events: convertedEvents,
  timepickerOptions: {
    clearLabel: "Example Clear",
  },
  datepickerOptions: {
    okBtnText: "Example Ok",
  },
});

calendarElement.addEventListener("addEvent.mdb.calendar", async (e) => {
  console.log(e);
  const arrivalDate = new Date(
    e.event.start.date.split("/").reverse().join("-")
  ).toISOString();
  //   console.log("dateArrivee>>", arrivalDate);
  const departureDate = new Date(
    e.event.end.date.split("/").reverse().join("-")
  ).toISOString();

  const data = {
    clients: ["/users/" + userId],
    arrivalDate: arrivalDate,
    departureDate: departureDate,
    cottage: "/cottages/" + cottageId,
  };
  const rawResponse = await fetch("https://localhost/bookings", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });
  // console.log(rawResponse, await rawResponse.json());
  if (rawResponse.status != 201){
    console.log('Une erreur est survenue')
  }
  else {
    window.location = `http://localhost/app/booking/${(await rawResponse.json()).id}/payment`;

  }
});
}
