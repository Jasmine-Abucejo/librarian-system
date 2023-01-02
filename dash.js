// function updateClock() {
//   let currentTime = new Date();
//   let currentHours = currentTime.getHours();
//   let currentMinutes = currentTime.getMinutes();
//   let currentSeconds = currentTime.getSeconds();

//   // Pad the minutes and seconds with leading zeros, if required
//   currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
//   currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;

//   // Choose either "AM" or "PM" as appropriate
//   let timeOfDay = currentHours < 12 ? "AM" : "PM";

//   // Convert the hours component to 12-hour format if needed
//   currentHours = currentHours > 12 ? currentHours - 12 : currentHours;

//   // Convert an hours component of "0" to "12"
//   currentHours = currentHours == 0 ? 12 : currentHours;

//   let currentDay = currentTime.getDay();
//   let currentDayName = weekdays[currentDay];

//   // Compose the string for display
//   let currentTimeString =
//     currentHours +
//     ":" +
//     currentMinutes +
//     ":" +
//     currentSeconds +
//     " " +
//     timeOfDay +
//     "," +
//     currentDayName;

//   // Update the time display
//   document.getElementById("date").innerText = currentTimeString;
// }

// Update the clock every 1 second
//setInterval(updateClock, 1000);
setInterval(() => {
  let currentDate = new Date();
  let dateString = currentDate.toLocaleString();
  let dateElement = document.getElementById("date");
  dateElement.innerText = dateString;
}, 1000);

let addButton = document.getElementById("addBtn");
addButton.addEventListener("click", function () {
  let modal = document.getElementById("myPopUp");
  modal.style.display = "block";
});

let close = document.getElementById("closeBtn");
close.addEventListener("click", function () {
  let modalClose = document.getElementById("myPopUp");
  modalClose.style.display = "none";
});
