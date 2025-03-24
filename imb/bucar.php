<?php
session_start();
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] == FALSE) {
    header("Location: index.php");
    exit();
}

require("conexion.php");

$query = isset($_GET['query']) ? $mysqli->real_escape_string($_GET['query']) : "";
$resultado = $mysqli->query("SELECT * FROM users WHERE username LIKE '%$query%' OR name LIKE '%$query%'");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Buscar Usuarios</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="logo">
<a href="home.php"> <img class="logo" src="images/logo.png" alt="logo"></a>
</div>
<h2>Resultados de la búsqueda</h2>

<?php if ($resultado->num_rows > 0) { ?>
    <ul>
        <?php while ($user = $resultado->fetch_assoc()) { ?>
            <li>
                <a href="perfil.php?username=<?php echo $user['username']; ?>">
                    <img src="images/<?php echo $user['avatar']; ?>" width="40">
                    <?php echo $user['name']; ?> (@<?php echo $user['username']; ?>)
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } else { ?>
    <p>No se encontraron usuarios.</p>
<?php } ?>

</body>
</html>
<style>
    /* Reset básico */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

/* Contenedor principal */
body {
    background-color: #f4f4f4;
    text-align: center;
    padding: 20px;
}
.logo{
    width: 90px;
}

/* Título de búsqueda */
h2 {
    color: #333;
    margin-bottom: 20px;
}

/* Contenedor de resultados */
ul {
    list-style: none;
    width: 50%;
    max-width: 600px;
    margin: 0 auto;
    background: #fff;
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Estilos para cada usuario en la lista */
li {
    padding: 10px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #ddd;
    transition: background 0.3s;
}

li:last-child {
    border-bottom: none;
}

li:hover {
    background: #f1f1f1;
}

/* Imagen de perfil */
li img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 15px;
}

/* Enlace a perfil */
li a {
    text-decoration: none;
    color: #333;
    font-size: 16px;
    font-weight: bold;
    display: flex;
    align-items: center;
    width: 100%;
}

li a:hover {
    color: #007bff;
}

/* Mensaje cuando no hay resultados */
p {
    color: #777;
    font-size: 16px;
    margin-top: 20px;
}

</style>
