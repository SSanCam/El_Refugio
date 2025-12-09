document.addEventListener("DOMContentLoaded", () => {
    const body = document.body;
    const toggle = document.getElementById("themeToggle");

    if (!toggle) return; // seguridad por si alguna vista no tiene el botón

    // Leer preferencia guardada
    if (localStorage.getItem("theme") === "dark") {
        body.classList.add("theme-dark");
    }

    // Alternar tema
    toggle.addEventListener("click", () => {
        body.classList.toggle("theme-dark");

        if (body.classList.contains("theme-dark")) {
            localStorage.setItem("theme", "dark");
        } else {
            localStorage.setItem("theme", "light");
        }
    });
});
