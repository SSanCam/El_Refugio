//resources/js/editProfile.js

document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.querySelector('[data-profile-edit-toggle]');
    const editContainer = document.querySelector('[data-profile-edit-container]');

    if (!toggleBtn || !editContainer) return;

    const labelOpen = toggleBtn.dataset.labelOpen || 'Editar mis datos';
    const labelClose = toggleBtn.dataset.labelClose || 'Cerrar edición';

    function openEdit() {
        editContainer.hidden = false;
        editContainer.classList.add('is-visible');
        toggleBtn.textContent = labelClose;
        toggleBtn.setAttribute('aria-expanded', 'true');
    }

    function closeEdit() {
        editContainer.hidden = true;
        editContainer.classList.remove('is-visible');
        toggleBtn.textContent = labelOpen;
        toggleBtn.setAttribute('aria-expanded', 'false');
    }

    closeEdit();

    toggleBtn.addEventListener('click', () => {
        const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
        if(isExpanded) {
            closeEdit();
        } else {
            openEdit();
        }
    });
});