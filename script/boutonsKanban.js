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

/**
 * fonction qui met à jour la position des categories
 * @param {string} element 
 * @param {string} sens 
 */
function updateCategoriePosition(element, sens){
    let container = element.parentNode.parentNode; 
    let sibling;
    if(sens === 'monter'){
        sibling = container.nextSibling.nextSibling;
    } else if( sens === 'descendre'){
        sibling = container.previousSibling.previousSibling;
    }

    let containerOrder = container.style.order;
    let siblingContainerOrder = sibling.style.order;

    let idCatContainer = container.getAttribute('data-id'); 
    let idCatSibling = sibling.getAttribute('data-id');

    updatePosition.setAttribute('value', siblingContainerOrder);
    catIdPosition.setAttribute('value', idCatContainer);

    UpdateSiblingPosition.setAttribute('value', containerOrder);
    idCatUpdateSiblingPosition.setAttribute('value', idCatSibling);
}

// on assigne des evenement à tous nos boutonsMoins
boutonMoins.forEach(bouton => bouton.addEventListener('click', (e) => {
    updateCategoriePosition(e.target, 'descendre');
    setUpdatePosition.submit();
}))

// on assigne des evenement à tous nos boutonsPlus
boutonPlus.forEach(bouton => bouton.addEventListener('click', (e) => {
    updateCategoriePosition(e.target, 'monter');
    setUpdatePosition.submit();
}))