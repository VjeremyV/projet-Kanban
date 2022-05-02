let boutonMoins = document.querySelectorAll('.boutonMoins');
let boutonPlus = document.querySelectorAll('.boutonPlus');
let categoriesContainer = document.querySelectorAll('.categorieContainer');
let catIdPosition = document.getElementById('idCatInputPosition');
let updatePosition = document.getElementById('UpdatePosition');
let UpdateSiblingPosition = document.getElementById('UpdateSiblingPosition');
let idCatUpdateSiblingPosition = document.getElementById('idCatUpdateSiblingPosition')
let setUpdatePosition = document.getElementById('setUpdatePosition');
let item2;
console.log(setUpdatePosition);

function updateCategoriePosition(element){
    let container = element.parentNode.parentNode; 
    let sibling = container.previousSibling.previousSibling;

    let containerOrder = container.style.order;
    let siblingContainerOrder = sibling.style.order;

    let idCatContainer = container.getAttribute('data-id'); 
    let idCatSibling = sibling.getAttribute('data-id');

    updatePosition.setAttribute('value', siblingContainerOrder);
    catIdPosition.setAttribute('value', idCatContainer);

    UpdateSiblingPosition.setAttribute('value', containerOrder);
    idCatUpdateSiblingPosition.setAttribute('value', idCatSibling);
    

}

boutonMoins.forEach(bouton => bouton.addEventListener('click', (e) => {
    updateCategoriePosition(e.target);
    setUpdatePosition.submit();
}))


// boutonPlus.forEach(bouton => console.log(bouton))