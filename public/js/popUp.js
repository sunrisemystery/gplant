let popUpWindow = document.getElementById("popup");
let contactButton = document.getElementById("contact");
let contactButtonMobile = document.getElementById("contact-mobile");
let closePopUp = document.getElementsByClassName("close")[0];
if(contactButton!=null) {
    contactButton.onclick = function () {
        popUpWindow.style.display = "block";

    }
}
if (contactButtonMobile != null) {
    contactButtonMobile.onclick = function () {
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