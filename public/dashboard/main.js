let flash = document.querySelector('.flash');
let flashClose = document.querySelector('.flash-close');

if (flash && flashClose) {
    flashClose.addEventListener('click', ()=> {
        flash.style.display = 'none';
    }, false)
}

const postTypeSelect = document.querySelector('[data-post-type-select]');
const postTypeForms = [...document.querySelectorAll('[data-post-type-form]')];

function syncPostTypeForms() {
    if (!postTypeSelect || postTypeForms.length === 0) {
        return;
    }

    if (postTypeSelect.form) {
        postTypeSelect.form.dataset.activePostType = postTypeSelect.value;
    }

    postTypeForms.forEach((form) => {
        const isActive = form.dataset.postTypeForm === postTypeSelect.value;

        form.hidden = !isActive;
        form.querySelectorAll('input, textarea, select, button').forEach((field) => {
            field.disabled = !isActive;
        });
    });

    syncCardRemoveButtons();
    syncImageTextOptionalSections();
}

const cardsContainer = document.querySelector('[data-cards-container]');
const cardTemplate = document.querySelector('[data-card-template]');
const addCardButton = document.querySelector('[data-add-card]');

function getCards() {
    return cardsContainer ? [...cardsContainer.querySelectorAll('[data-card]')] : [];
}

function getMaxCards() {
    return Number(cardsContainer?.dataset.maxCards) || 12;
}

function reindexCards() {
    getCards().forEach((card, index) => {
        const number = index + 1;

        card.querySelector('[data-card-number]').textContent = number;
        card.querySelector('[data-card-title]').textContent = `Kafelek ${number}`;
        card.querySelector('[data-remove-card]').setAttribute('aria-label', `Usuń kafelek ${number}`);

        card.querySelectorAll('[data-card-field]').forEach((field) => {
            field.name = `payload[cards][${index}][${field.dataset.cardField}]`;
        });
    });

    syncCardRemoveButtons();
}

function syncCardRemoveButtons() {
    const cards = getCards();
    const typeForm = cardsContainer?.closest('[data-post-type-form]');
    const isInactive = Boolean(typeForm?.hidden);

    cards.forEach((card) => {
        card.querySelector('[data-remove-card]').disabled = cards.length <= 1 || isInactive;
    });

    if (addCardButton) {
        addCardButton.disabled = isInactive || cards.length >= getMaxCards();
    }
}

if (cardsContainer && cardTemplate && addCardButton) {
    addCardButton.addEventListener('click', () => {
        if (getCards().length >= getMaxCards()) {
            return;
        }

        const newCard = cardTemplate.content.firstElementChild.cloneNode(true);

        cardsContainer.appendChild(newCard);
        reindexCards();
        newCard.querySelector('input')?.focus();
    });

    cardsContainer.addEventListener('click', (event) => {
        const removeButton = event.target.closest('[data-remove-card]');

        if (!removeButton || getCards().length <= 1) {
            return;
        }

        removeButton.closest('[data-card]').remove();
        reindexCards();
    });

    reindexCards();
}

const listSection = document.querySelector('[data-list-section]');
const listItemsContainer = document.querySelector('[data-list-items]');
const listItemTemplate = document.querySelector('[data-list-item-template]');
const addListButton = document.querySelector('[data-add-list]');
const addListItemButton = document.querySelector('[data-add-list-item]');
const removeListButton = document.querySelector('[data-remove-list]');
const linkSection = document.querySelector('[data-link-section]');
const addLinkButton = document.querySelector('[data-add-link]');
const removeLinkButton = document.querySelector('[data-remove-link]');

function getListItems() {
    return listItemsContainer ? [...listItemsContainer.querySelectorAll('[data-list-item]')] : [];
}

function getMaxListItems() {
    return Number(listItemsContainer?.dataset.maxItems) || 20;
}

function reindexListItems() {
    getListItems().forEach((item, index) => {
        const number = index + 1;
        const input = item.querySelector('[data-list-item-input]');

        item.querySelector('[data-list-item-label]').textContent = `Punkt ${number}`;
        item.querySelector('[data-remove-list-item]').setAttribute('aria-label', `Usuń punkt ${number}`);
        input.name = `payload[items][${index}]`;
    });

    syncImageTextOptionalSections();
}

function addListItem() {
    if (!listItemsContainer || !listItemTemplate || getListItems().length >= getMaxListItems()) {
        return;
    }

    const newItem = listItemTemplate.content.firstElementChild.cloneNode(true);

    listItemsContainer.appendChild(newItem);
    reindexListItems();
    newItem.querySelector('input')?.focus();
}

function setListVisibility(isVisible, clearItems = false) {
    if (!listSection || !addListButton) {
        return;
    }

    if (clearItems && listItemsContainer) {
        listItemsContainer.innerHTML = '';
    }

    listSection.hidden = !isVisible;
    addListButton.hidden = isVisible;

    if (isVisible && getListItems().length === 0) {
        addListItem();
    }

    syncImageTextOptionalSections();
}

function setLinkVisibility(isVisible, clearFields = false) {
    if (!linkSection || !addLinkButton) {
        return;
    }

    if (clearFields) {
        linkSection.querySelectorAll('input').forEach((input) => {
            input.value = '';
        });
    }

    linkSection.hidden = !isVisible;
    addLinkButton.hidden = isVisible;
    syncImageTextOptionalSections();

    if (isVisible) {
        linkSection.querySelector('input')?.focus();
    }
}

function syncImageTextOptionalSections() {
    const typeForm = listSection?.closest('[data-post-type-form]')
        ?? linkSection?.closest('[data-post-type-form]');
    const isInactive = Boolean(typeForm?.hidden);

    [listSection, linkSection].forEach((section) => {
        if (!section) {
            return;
        }

        section.querySelectorAll('input, textarea, button').forEach((field) => {
            field.disabled = section.hidden || isInactive;
        });
    });

    [addListButton, addLinkButton].forEach((button) => {
        if (button) {
            button.disabled = isInactive;
        }
    });

    if (addListItemButton) {
        addListItemButton.disabled = isInactive
            || Boolean(listSection?.hidden)
            || getListItems().length >= getMaxListItems();
    }
}

if (listSection && listItemsContainer && addListButton && addListItemButton && removeListButton) {
    addListButton.addEventListener('click', () => setListVisibility(true));
    addListItemButton.addEventListener('click', addListItem);
    removeListButton.addEventListener('click', () => setListVisibility(false, true));

    listItemsContainer.addEventListener('click', (event) => {
        const removeButton = event.target.closest('[data-remove-list-item]');

        if (!removeButton) {
            return;
        }

        removeButton.closest('[data-list-item]').remove();

        if (getListItems().length === 0) {
            setListVisibility(false);
            return;
        }

        reindexListItems();
    });

    reindexListItems();
}

if (linkSection && addLinkButton && removeLinkButton) {
    addLinkButton.addEventListener('click', () => setLinkVisibility(true));
    removeLinkButton.addEventListener('click', () => setLinkVisibility(false, true));
    syncImageTextOptionalSections();
}

if (postTypeSelect) {
    syncPostTypeForms();
    postTypeSelect.addEventListener('change', syncPostTypeForms);
}
