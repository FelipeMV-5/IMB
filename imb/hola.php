<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración - Verix</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    
    <div class="container">
        <!-- Barra lateral izquierda -->
        <aside class="sidebar">
      <a href="home.php"> <img class="logo" src="images/logo.png" alt="logo"></a>
            <ul>
                <div class="barra">
                    <li><a href="home.php"><i class="fa-solid fa-house"></i> <span>Inicio</span></a></li>
                    <li><i class="fa-solid fa-envelope"></i> <span>Mensajes</span> <span class="notif">99+</span></li>
                    <li><a href="notificaciones.php"><i class="fa-solid fa-bell"></i> <span>Notificaciones</span></a></li>
                    <li><a href="subir.php"><i class="fa-solid fa-plus"></i> <span>Crear</span></a></li>
                <li><a href="perfil.php"><i class="fa-solid fa-user"></i> <span>Perfil</span></a></li>
                    <li id="btn-mas"><i class="fa-solid fa-thumbtack"></i> <span>Más</span></li>
                    <a href="logout.php">Cerrar sesión</a>
                </div>
            </ul>
        </aside>
        <!-- Barra de búsqueda -->

</div>


        <!-- Barra lateral derecha (configuración) -->
        <aside class="settings-sidebar" id="configuracion">
            <button id="btn-cerrar-config"><i class="fa-solid fa-xmark"></i></button>
            <h3>Configuración</h3>
            <ul class="settings-menu">
                <li><a href="editar_perfil.php"><span>Editar perfil</span> <i class="fa-solid fa-pen"></i></a></li>
                <li id="btn-ayuda"><span>Ayuda</span> <i class="fa-solid fa-circle-question"></i></li>
            </ul>

            <!-- Submenú desplegable de Ayuda -->
            <ul class="submenu" id="submenu-ayuda">
                <li><a href="#"><span>Informar de un problema</span> <i class="fa-solid fa-bug"></i></a></li>
                <li><a href="#"><span>Estado de la cuenta</span> <i class="fa-solid fa-chart-line"></i></a></li>
                <li><a href="#"><span>Servicio de ayuda</span> <i class="fa-solid fa-book"></i></a></li>
                <li><a href="#"><span>Privacidad y seguridad</span> <i class="fa-solid fa-lock"></i></a></li>
             
            </ul>
        </aside>
        <script src="js/script.js"></script>
        <nav class="mobile-nav">
        <a href="#"><i class="fa-solid fa-house"></i><span>Inicio</span></a>
        <a href="#"><i class="fa-solid fa-magnifying-glass"></i><span>Buscar</span></a>
        <a href="#"><i class="fa-solid fa-plus-circle"></i><span>Crear</span></a>
        <a href="#"><i class="fa-solid fa-envelope"></i><span>Mensajes</span></a>
        <a href="#"><i class="fa-solid fa-user"></i><span>Perfil</span></a>
    </nav>

</body>
</html>
<style>


body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    height: 100vh;
    background-color: #f5f5f5;
}

.container {
    display: flex;
    width: 100%;
}





/* Barra lateral izquierda */
.sidebar {
    width: 250px;
    background: #fff;
    border-right: 1px solid #ddd;
}

.sidebar h2 {
    margin: 0;
    font-size: 22px;
    font-weight: bold;
}

.sidebar ul {
    list-style: none;
    margin-top: 20px;
    

}
.sidebar a{
    text-decoration: none;
    color: black;
}

.sidebar ul li {
    padding: 12px;
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 16px;
}

.sidebar ul li i {
    margin-right: 10px;
}

.sidebar ul li:hover {
    background: #ddd;
    border-radius: 5px;
}

.notif {
    background: red;
    color: white;
    font-size: 12px;
    padding: 3px 7px;
    border-radius: 50%;
    margin-left: auto;
}


/* Configuración */
.settings-sidebar {
    width: 300px;
    background: white;
    padding: 20px;
    position: fixed;
    top: 0;
    right: -350px;
    height: 100vh;
    border-left: 1px solid #ddd;
    transition: right 0.3s ease;
}

.settings-sidebar.active {
    right: 0;
}

#btn-cerrar-config {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    float: right;
}

/* Menú de configuración */
.settings-menu {
    list-style: none;
    padding: 0;
}

.settings-menu li {
    padding: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.settings-menu li i {
    margin-left: auto;
}
.logo{
    width: 110px;
    display: flex;
    flex-direction:row;
    justify-content: center;
}
/* Submenú de ayuda */
.submenu {
    list-style: none;
    padding: 0;
    display: none;
}

.submenu.active {
    display: block;
}

.submenu li {
    padding: 8px 10px;
    border-left: 3px solid #ccc;
    margin-left: 15px;
}

/* Contenido principal */
.content {
    flex-grow: 1;
    padding: 20px;
    overflow-y: auto;
}

.profile-section {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.profile-section img {
    border-radius: 50%;
    width: 80px;
    height: 80px;
}

.profile-info p {
    margin: 5px 0;
}

.btn {
    padding: 8px 12px;
    border: none;
    background: #007bff;
    color: white;
    cursor: pointer;
    border-radius: 5px;
}

.btn-primary {
    background: #28a745;
}

/* Estilos para el formulario */
form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

textarea {
    width: 100%;
    height: 60px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

select {
    padding: 8px;
    border-radius: 5px;
}

.checkbox-container {
    display: flex;
    align-items: center;
}

.checkbox-container input {
    margin-right: 10px;
}
/* Oculta la barra de navegación inferior en escritorio */
.mobile-nav {
    display: none; /* Por defecto, oculta la barra */
}
/* Ocultar la barra lateral en móvil */
@media (max-width: 768px) {
    .sidebar {
        display: none;
    }

    .mobile-nav {
        display: flex;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: white;
        border-top: 1px solid #ddd;
        justify-content: space-around;
        padding: 10px 0;
    }

    .mobile-nav a {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: black;
        text-decoration: none;
        font-size: 12px;
    }

    .mobile-nav i {
        font-size: 20px;
        margin-bottom: 3px;
    }
}


        </style>
    
