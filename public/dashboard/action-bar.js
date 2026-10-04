(() => {
    const content = document.querySelector('.content-container');
    const heading = content?.querySelector(':scope > .dashboard-action-header');
    const form = content?.querySelector([
        'form.dashboard-editor-form',
        'form.homepage-post-form',
        'form.gallery-editor-form',
        'form.dashboard-status-form',
        'form.dashboard-delete-form',
    ].join(', '));

    if (!content || !heading || !form || content.classList.contains('has-action-bar')) {
        return;
    }

    const buttons = [...form.querySelectorAll('button[type="submit"], input[type="submit"]')]
        .filter((button) => button.form === form);

    if (buttons.length === 0) {
        return;
    }

    if (!form.id) {
        let suffix = 1;
        while (document.getElementById(`dashboard-action-form-${suffix}`)) {
            suffix++;
        }
        form.id = `dashboard-action-form-${suffix}`;
    }

    const bar = document.createElement('div');
    bar.className = 'dashboard-action-bar';
    bar.setAttribute('role', 'group');
    bar.setAttribute('aria-label', 'Akcje formularza');

    const title = document.createElement('h3');
    title.className = 'dashboard-action-bar__title';
    title.textContent = heading.textContent;

    const actions = document.createElement('div');
    actions.className = 'dashboard-action-bar__buttons';
    const originalContainers = new Set();

    buttons.forEach((button) => {
        const container = button.closest('.dashboard-form-actions, .homepage-post-form__actions');
        if (container) {
            originalContainers.add(container);
        }
        button.setAttribute('form', form.id);
        if (form.classList.contains('dashboard-delete-form')) {
            button.classList.add('dashboard-action-bar__delete');
        }
        actions.append(button);
    });

    originalContainers.forEach((container) => {
        if (container.textContent.trim() === '' && container.childElementCount === 0) {
            container.remove();
        } else {
            container.classList.add('dashboard-form-actions--note');
        }
    });

    bar.append(title, actions);
    content.insertBefore(bar, heading);
    content.classList.add('has-action-bar');
    document.documentElement.classList.add('has-dashboard-action-bar');

    const updateHeight = () => {
        document.documentElement.style.setProperty(
            '--dashboard-action-bar-height',
            `${Math.ceil(bar.getBoundingClientRect().height)}px`,
        );
    };
    updateHeight();

    if (typeof ResizeObserver !== 'undefined') {
        const observer = new ResizeObserver(updateHeight);
        observer.observe(bar);
    } else {
        window.addEventListener('resize', updateHeight);
    }
})();
