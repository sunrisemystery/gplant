const search = document.querySelector('input[placeholder="SEARCH"]');
const plantsContainer = document.querySelector(".discover-list");

search.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        const data = {search: this.value};
        fetch("/search", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (plants) {
            plantsContainer.innerHTML = "";
            loadPlants(plants);
        });
    }
});

function loadPlants(plants) {
    plants.forEach(plant => {
        createPlant(plant);
    });
}

function createPlant(plant) {
    const template = document.querySelector("#plant-template");

    const clone = template.content.cloneNode(true);
    const image = clone.querySelector("img");
    const href = 'public/img/discover/';

    image.src = href.concat(plant.image);
    image.alt = plant.image;
    const buttonValue = clone.querySelector(".link-button");
    buttonValue.value = plant.id;
    const type = clone.querySelector("strong");
    type.innerHTML = plant.type;
    const description = clone.querySelector("p");
    const str = plant.main_description;
    description.innerHTML = str.substr(0, 100).concat('...');
    plantsContainer.appendChild(clone);


}