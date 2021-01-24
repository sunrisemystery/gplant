const userSettingsMobile = document.getElementById('settingsMobile');
addClickListener(userSettingsMobile, 'updateProfile');

const mobileBack = document.getElementById('mobileBack');
goBack(mobileBack);

const mobileBackPlants = document.getElementById('myplantsBack');
goBack(mobileBackPlants);

function goBack(name) {
    if (name != null) {
        name.addEventListener('click', function () {
            window.history.back();
        });
    }
}

function addClickListener(element, name) {
    if (element != null) {
        element.addEventListener('click', () => openPage(name));
    }
}

function openPage(name) {
    document.location.href = name;
}
