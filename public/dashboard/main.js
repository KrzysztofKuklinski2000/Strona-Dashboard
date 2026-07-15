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
}

const cardsContainer = document.querySelector('[data-cards-container]');
const cardTemplate = document.querySelector('[data-card-template]');
const addCardButton = document.querySelector('[data-add-card]');

function getCards() {
    return cardsContainer ? [...cardsContainer.querySelectorAll('[data-card]')] : [];
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
}

if (cardsContainer && cardTemplate && addCardButton) {
    addCardButton.addEventListener('click', () => {
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

if (postTypeSelect) {
    syncPostTypeForms();
    postTypeSelect.addEventListener('change', syncPostTypeForms);
}
