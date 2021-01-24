const cancel = document.getElementById('cancel');
goBack(cancel);

function goBack(name) {
    if (name != null) {
        name.addEventListener('click', function () {
            window.history.back();
        });
    }
}