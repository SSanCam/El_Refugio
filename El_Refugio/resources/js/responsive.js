document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.getElementById("menuToggle");
    const nav = document.getElementById("mainNav");
    const overlay = document.getElementById("menuOverlay");

    if (!toggleBtn || !nav || !overlay) return;

    toggleBtn.addEventListener("click", (e) => {
        e.stopPropagation();

        const isOpen = nav.classList.toggle("show");

        toggleBtn.classList.toggle("menu-open", isOpen);
        overlay.classList.toggle("show", isOpen);
    });

    overlay.addEventListener("click", () => {
        nav.classList.remove("show");
        toggleBtn.classList.remove("menu-open");
        overlay.classList.remove("show");
    });
});
