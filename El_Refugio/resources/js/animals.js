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
