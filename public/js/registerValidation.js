const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const confirmPasswordInput = form.querySelector('input[name = "password-confirm"]');

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function arePasswordsSame(password, confirmedPassword) {
    return password === confirmedPassword;
}

function validateEmail() {
    setTimeout(function () {
            markValidation(emailInput, isEmail(emailInput.value));
        }
        , 1000);
}

function validatePassword() {
    setTimeout(function () {
            const condition = arePasswordsSame(
                confirmPasswordInput.previousElementSibling.value,
                confirmPasswordInput.value
            )
            markValidation(confirmPasswordInput, condition);
        }
        , 1000);
}

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

if (emailInput != null) {
    emailInput.addEventListener('keyup', validateEmail);
}

if (confirmPasswordInput != null) {
    confirmPasswordInput.addEventListener('keyup', validatePassword);
}




