const search = document.querySelector('input[placeholder="SEARCH"]');
const usersContainer = document.querySelector(".discover-list");

search.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        const data = {search: this.value};
        fetch("/searchUser", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (users) {
            usersContainer.innerHTML = "";
            loadUsers(users);
        });
    }
});

function loadUsers(users) {
    users.forEach(user => {
        createUser(user);
    });
}

function createUser(user) {
    const template = document.querySelector("#user-template");

    const clone = template.content.cloneNode(true);

    const buttonValue = clone.querySelector(".delete-user");
    buttonValue.id = user.id;
    buttonValue.onclick = function () {
        deleteUserConfirm(user.id);
    }
    const type = clone.querySelector("strong");
    type.innerHTML = user.login;
    const email = clone.querySelector(".p-email");
    email.innerHTML = user.email;
    const name = clone.querySelector(".p-name");
    name.innerHTML = `Name: ${user.name}`;
    usersContainer.appendChild(clone);


}