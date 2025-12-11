document.addEventListener("DOMContentLoaded", () => {
    const body = document.body;
    const themeButtons = document.querySelectorAll("[data-theme-toggle]");

    if (!themeButtons.length) return;

    // Cargar preferencia guardada
    if (localStorage.getItem("theme") === "light") {
        body.classList.add("theme-ligth");
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
