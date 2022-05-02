let item;
let saveTacheInput = document.getElementById('saveTacheInput');
let idCatInput = document.getElementById('idCatInput');
let setUpdateTache = document.getElementById('setUpdateTache');

/**met à jour les données dans les champs cachés
 * concernant les "tâches" qui se déplacent
 */
function updateTache() {
    let tacheId = item.getAttribute('id');
    saveTacheInput.setAttribute('value', tacheId);
    let catId = item.parentNode.getAttribute('id');
    idCatInput.setAttribute('value', catId);
}

document.addEventListener('dragstart', (e) => {
    item = e.target;
});

document.addEventListener('dragover', (e) => {
    e.preventDefault();
});

document.addEventListener('drop', (e) => {
    if (e.target.getAttribute('data-draggable') == 'target') {
        e.preventDefault();
        e.target.appendChild(item);
        updateTache();
        setUpdateTache.submit();
    }
});

document.addEventListener('dragend', () => item = null);

