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
}

if (postTypeSelect) {
    syncPostTypeForms();
    postTypeSelect.addEventListener('change', syncPostTypeForms);
}
