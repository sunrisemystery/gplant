const waterNow = document.getElementsByClassName("button-plant");

function waterPlant() {
    const button = this;
    const id = button.getAttribute("value");
    const input = '/waterNow/'.concat(btoa(id));
    const attr = document.getElementById(id);
    fetch(input).then(function () {
        attr.innerHTML = ' today';
    });
}

waterNow.item(0).addEventListener("click", waterPlant);

function deleteConfirm(id) {
    let bool = confirm('Are you sure you want delete this plant? You cant undo this operation.');
    const val = document.getElementById('deleteButton');
    if (bool) {
        val.setAttribute("value", id);
    } else {
        val.setAttribute("value", "-1");
    }
}

