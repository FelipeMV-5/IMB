document.addEventListener("DOMContentLoaded", function () {
    const btnMas = document.getElementById("btn-mas");
    const sidebarConfig = document.getElementById("configuracion");
    const btnCerrarConfig = document.getElementById("btn-cerrar-config");
    const btnAyuda = document.getElementById("btn-ayuda");
    const submenuAyuda = document.getElementById("submenu-ayuda");

    btnMas.addEventListener("click", function () {
        sidebarConfig.classList.toggle("visible");
    });

    btnAyuda.addEventListener("click", function () {
        submenuAyuda.classList.toggle("visible");
    });
});
