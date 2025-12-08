document.addEventListener('DOMContentLoaded', () => {

    // Selecciona TODOS los toggles del sitio
    const toggles = document.querySelectorAll('[data-toggle]');

    toggles.forEach(toggle => {
        const targetName = toggle.dataset.toggle;
        const target = document.querySelector(`[data-target="${targetName}"]`);

        if (!target) return;

        const labelOpen = toggle.dataset.labelOpen || toggle.textContent.trim();
        const labelClose = toggle.dataset.labelClose || 'Cerrar';

        // Estado inicial
        target.hidden = true;
        toggle.setAttribute('aria-expanded', 'false');

        // Lógica de abrir / cerrar
        const open = () => {
            target.hidden = false;
            toggle.textContent = labelClose;
            toggle.setAttribute('aria-expanded', 'true');
        };

        const close = () => {
            target.hidden = true;
            toggle.textContent = labelOpen;
            toggle.setAttribute('aria-expanded', 'false');
        };

        toggle.addEventListener('click', () => {
            const expanded = toggle.getAttribute('aria-expanded') === 'true';
            expanded ? close() : open();
        });
    });

});
