const waterNowButtons = document.querySelectorAll(".button")
const waterNow = document.getElementsByClassName("button-plant");
if (waterNowButtons != null) {
    function water() {
        const button = this;
        const id = button.getAttribute("value");
        const attr = document.getElementById(id);
        const attr2 = document.getElementsByClassName(id);
        const input = '/waterNow/'.concat(btoa(id));

        fetch(input).then(function () {
            attr.innerHTML = ' today';
            attr2.item(0).innerHTML = ' today';


        });
    }

    waterNowButtons.forEach(button => button.addEventListener("click", water));
}
if (waterNow.item(0) != null) {
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

}

