document.addEventListener("DOMContentLoaded", function () {
    const btnMas = document.getElementById("btn-mas");
    const sidebarConfig = document.getElementById("configuracion");
    const btnAyuda = document.getElementById("btn-ayuda");
    const submenuAyuda = document.getElementById("submenu-ayuda");

    btnMas.addEventListener("click", function () {
        sidebarConfig.classList.toggle("visible");
    });

    btnAyuda.addEventListener("click", function () {
        submenuAyuda.classList.toggle("visible");
    });
});

  const burgerBtn = document.getElementById("hamburger-btn");
  const burgerMenu = document.getElementById("hamburger-menu");

  burgerBtn.addEventListener("click", () => {
    burgerMenu.style.display = burgerMenu.style.display === "flex" ? "none" : "flex";
  });

  // Cierra el menú si haces clic fuera
  document.addEventListener("click", (e) => {
    if (!burgerMenu.contains(e.target) && !burgerBtn.contains(e.target)) {
      burgerMenu.style.display = "none";
    }
  });
