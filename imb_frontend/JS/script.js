document.addEventListener("DOMContentLoaded", function () {
    const btnMas = document.getElementById("btn-mas");
    const sidebarConfig = document.getElementById("configuracion");
    const btnCerrarConfig = document.getElementById("btn-cerrar-config");
    const btnAyuda = document.getElementById("btn-ayuda");
    const submenuAyuda = document.getElementById("submenu-ayuda");

    // Alternar visibilidad de la configuración
    btnMas.addEventListener("click", function () {
        sidebarConfig.classList.toggle("visible");
    });

    // Mostrar/Ocultar el submenú de ayuda
    btnAyuda.addEventListener("click", function () {
        submenuAyuda.classList.toggle("visible");
    });
});
