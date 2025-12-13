import './bootstrap';

import Alpine from 'alpinejs';


window.Alpine = Alpine;

Alpine.start();

import './globals';
import './adminDashboard';
import './animals';
import '../js/theme.js';


/*--------------------------------
Carrusel de imágenes en detalle de animal
--------------------------------*/
document.addEventListener('DOMContentLoaded', () => {
    const mainImg = document.getElementById('animal-main-image');
    if (!mainImg) return;

    const thumbButtons = document.querySelectorAll('.animal-detail-card__thumb-btn');
    const prev = document.querySelector('.animal-detail-card__nav--prev');
    const next = document.querySelector('.animal-detail-card__nav--next');

    if (!thumbButtons.length) return;

    let current = 0;

    function update(index) {
        const total = thumbButtons.length;
        current = (index + total) % total;

        thumbButtons.forEach((btn, i) => {
            const img = btn.querySelector('img');
            const isActive = i === current;

            btn.classList.toggle('is-active', isActive);

            if (isActive && img) {
                mainImg.src = img.src;
                mainImg.alt = img.alt || '';
            }
        });
    }

    thumbButtons.forEach((btn, i) => {
        btn.addEventListener('click', () => update(i));
    });

    if (prev) prev.addEventListener('click', () => update(current - 1));
    if (next) next.addEventListener('click', () => update(current + 1));

    update(0);
});

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

document.addEventListener("DOMContentLoaded", () => {
    const body = document.body;
    const themeButtons = document.querySelectorAll("[data-theme-toggle]");

    if (!themeButtons.length) return;

    // Cargar preferencia guardada
    if (localStorage.getItem("theme") === "light") {
        body.classList.add("theme-light");
    }

    themeButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            body.classList.toggle("theme-dark");

            localStorage.setItem("theme",
                body.classList.contains("theme-dark") ? "dark" : "light"
            );
        });
    });
});
