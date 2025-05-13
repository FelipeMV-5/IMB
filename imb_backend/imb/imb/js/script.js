document.addEventListener("DOMContentLoaded", function () { 
    const btnMas = document.getElementById("btn-mas");
    const settingsSidebar = document.getElementById("configuracion");
    const btnCerrarConfig = document.getElementById("btn-cerrar-config");
    const btnAyuda = document.getElementById("btn-ayuda");
    const submenuAyuda = document.getElementById("submenu-ayuda");

    btnMas.addEventListener("click", function () {
        settingsSidebar.classList.add("active");
    });

    btnCerrarConfig.addEventListener("click", function () {
        settingsSidebar.classList.remove("active");
    });

    btnAyuda.addEventListener("click", function () {
        submenuAyuda.classList.toggle("active");
    });
});