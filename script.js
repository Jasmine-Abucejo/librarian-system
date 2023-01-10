let userAccs = document.getElementById("userAccs");
userAccs.addEventListener("click", function () {
  console.log("div");
  $(".subdivs").css("display", "block");
});

let addAcc = document.getElementById("addAcc");
addAcc.addEventListener("click", function () {
  let modal = document.getElementById("myPopUp");
  modal.style.display = "block";
});

let close = document.getElementById("closeBtn");
close.addEventListener("click", function () {
  let modalClose = document.getElementById("myPopUp");
  modalClose.style.display = "none";
});
