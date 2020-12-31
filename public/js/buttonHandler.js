let signButton = document.getElementById('signButton');
if (signButton != null) {
    signButton.addEventListener('click', function () {
        document.location.href = 'login';
    });
}

let signButtonMobile = document.getElementById('signButtonMobile');
if (signButtonMobile != null) {
    signButtonMobile.addEventListener('click', function () {
        document.location.href = 'login';
    });
}


let discover = document.getElementById('discover');
if (discover != null) {
    discover.addEventListener('click', function () {
        document.location.href = 'discover';
    });
}
let discoverMobile = document.getElementById('discoverMobile');
if (discoverMobile != null) {
    discoverMobile.addEventListener('click', function () {
        document.location.href = 'discover';
    });
}

let home = document.getElementById('home');
if (home != null) {
    home.addEventListener('click', function () {
        document.location.href = '/';
    });
}

let addPlant = document.getElementById('addPlant');
if (addPlant != null) {
    addPlant.addEventListener('click', function () {
        document.location.href = 'addPlant';
    });
}

let addNewPlant = document.getElementById('addNewPlant');
if (addNewPlant != null) {
    addNewPlant.addEventListener('click', function () {
        document.location.href = 'addPlant';
    });
}

let myPlants = document.getElementById('myPlants');
if (myPlants != null) {
    myPlants.addEventListener('click', function () {
        document.location.href = 'myPlants';
    });
}

let myPlantsMobile = document.getElementById('myPlantsMobile');
if (myPlantsMobile != null) {
    myPlantsMobile.addEventListener('click', function () {
        document.location.href = 'myPlants';
    });
}
let userSettings = document.getElementById('settings');
if (userSettings != null) {
    userSettings.addEventListener('click', function () {
        document.location.href = 'updateProfile';
    });
}

function deleteConfirm(id) {
    let bool = confirm('Are you sure you want delete this plant? You cant undo this operation.');
    let val = document.getElementById('deleteButton');
    if (bool) {

        val.setAttribute("value", id);

    } else {
        val.setAttribute("value", "-1");

    }

}

let mobileBack = document.getElementById('mobileBack');
if (mobileBack != null) {
    mobileBack.addEventListener('click', function () {
        document.location.href = 'discover';
    });
}

