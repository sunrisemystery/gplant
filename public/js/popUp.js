const popUpWindow = document.getElementById("popup");
const infoButton = document.getElementById("contact");
const infoButtonMobile = document.getElementById("contact-mobile");
const closePopUp = document.getElementsByClassName("close")[0];
if (infoButton != null) {
    infoButton.onclick = function () {
        popUpWindow.style.display = "block";
    }
}
if (infoButtonMobile != null) {
    infoButtonMobile.onclick = function () {
        popUpWindow.style.display = "block";
    }
}
closePopUp.onclick = function () {
    popUpWindow.style.display = "none";
}

window.onclick = function (event) {
    if (event.target === popUpWindow) {
        popUpWindow.style.display = "none";
    }
}