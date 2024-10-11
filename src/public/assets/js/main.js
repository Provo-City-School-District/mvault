function toggleNav() {
  var x = document.getElementById("myTopnav");
  var icon = document.querySelector(".topnav .icon");
  if (x.className === "topnav") {
    x.className += " responsive";
    icon.innerHTML = "&#10005;"; // Unicode for 'X'
  } else {
    x.className = "topnav";
    icon.innerHTML = "&#9776;"; // Unicode for hamburger
  }
}
