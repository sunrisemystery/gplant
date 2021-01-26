let input = document.getElementById('file-input');
let infoArea = document.getElementById('choose');

input.addEventListener('change', showFileName);

function showFileName(event) {
    let input = event.target;
    let fileName = input.files[0].name;
    infoArea.textContent = '' + fileName;
}