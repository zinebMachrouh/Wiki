function opencatPopup() {
    document.getElementById('catPopup').style.display = 'flex';
}

function closecatPopup() {
    document.getElementById('catPopup').style.display = 'none';
}

function openmodCat(id, title, description) {
    document.getElementById('id').value = id;
    document.getElementById('modTitle').value = title;
    document.getElementById('modDescription').value = description;
    document.getElementById('modCatPopup').style.display = 'flex';
}

function closemodCat() {
    document.getElementById('modCatPopup').style.display = 'none';
}

