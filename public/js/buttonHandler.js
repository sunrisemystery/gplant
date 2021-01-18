const signButton = document.getElementById('signButton');
if (signButton != null) {
    signButton.addEventListener('click', function () {
        document.location.href = 'login';
    });
}

const signButtonMobile = document.getElementById('signButtonMobile');
if (signButtonMobile != null) {
    signButtonMobile.addEventListener('click', function () {
        document.location.href = 'login';
    });
}

const discover = document.getElementById('discover');
if (discover != null) {
    discover.addEventListener('click', function () {
        document.location.href = 'discover';
    });
}
const discoverMobile = document.getElementById('discoverMobile');
if (discoverMobile != null) {
    discoverMobile.addEventListener('click', function () {
        document.location.href = 'discover';
    });
}

const home = document.getElementById('home');
if (home != null) {
    home.addEventListener('click', function () {
        document.location.href = '/';
    });
}

const addPlant = document.getElementById('addPlant');
if (addPlant != null) {
    addPlant.addEventListener('click', function () {
        document.location.href = 'addPlant';
    });
}

const addNewPlant = document.getElementById('addNewPlant');
if (addNewPlant != null) {
    addNewPlant.addEventListener('click', function () {
        document.location.href = 'addPlant';
    });
}

const myPlants = document.getElementById('myPlants');
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
const userSettings = document.getElementById('settings');
if (userSettings != null) {
    userSettings.addEventListener('click', function () {
        document.location.href = 'updateProfile';
    });
}

const userSettingsMobile = document.getElementById('settingsMobile');
if (userSettingsMobile != null) {
    userSettingsMobile.addEventListener('click', function () {
        document.location.href = 'updateProfile';
    });
}

const cancel = document.getElementById('cancel');
if (cancel != null) {
    cancel.addEventListener('click', function () {
        window.history.back();
    });
}
const mobileBack = document.getElementById('mobileBack');
if (mobileBack != null) {
    mobileBack.addEventListener('click', function () {
        window.history.back();
    });
}

const mobileBackPlants = document.getElementById('myplantsBack');
if (mobileBackPlants != null) {
    mobileBackPlants.addEventListener('click', function () {
        document.location.href = 'myPlants';
    });
}
const adminPanel = document.getElementById('adminPanel');
if (adminPanel != null) {
    adminPanel.addEventListener('click', function () {
        document.location.href = 'adminView';
    });
}
const adminPanelMobile = document.getElementById('adminPanelMobile');
if (adminPanelMobile != null) {
    adminPanelMobile.addEventListener('click', function () {
        document.location.href = 'adminView';
    });
}

function deleteConfirm(id) {
    let bool = confirm('Are you sure you want delete this plant? You cant undo this operation.');
    const val = document.getElementById('deleteButton');
    if (bool) {

        val.setAttribute("value", id);

    } else {
        val.setAttribute("value", "-1");

    }
}

function deleteUserConfirm(id) {
    let bool = confirm('Are you sure you want delete this plant? You cant undo this operation.');
    const val = document.getElementById(id);
    if (bool) {

        val.setAttribute("value", id);

    } else {
        val.setAttribute("value", "-1");

    }
}
