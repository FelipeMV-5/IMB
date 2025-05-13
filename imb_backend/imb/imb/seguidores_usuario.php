<?php
session_start();
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] == FALSE) {
    header("Location: index.php");
    exit();
}

include "functions.php";

if (isset($_GET['username'])) {
    require "conexion.php";

    // Obtener datos del usuario cuyo perfil estás viendo
    $sqlA = $mysqli->query("SELECT * FROM users WHERE username = '" . $_GET['username'] . "'");
    $rowA = $sqlA->fetch_array();

    // Obtener los seguidores de este usuario
    $sqlSeguidores = $mysqli->query("SELECT u.username, u.avatar FROM seguidores s 
                                      JOIN users u ON s.seguidor = u.id 
                                      WHERE s.seguido = '" . $rowA['id'] . "' AND s.aprobada = 1");

    // Verificar si el usuario tiene seguidores
    $totalSeguidores = $sqlSeguidores->num_rows;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="title" content="Seguidores de <?php echo $rowA['username']; ?>">
    <meta name="description" content="Ver los seguidores del usuario <?php echo $rowA['username']; ?>">
    <link href="css/seguidore.css" rel="stylesheet" type="text/css"/>
    <title>Seguidores de <?php echo $rowA['username']; ?></title>
</head>
<body>

<?php include "header.php"; ?>

<div class="seguidores-container">
    <h2>Seguidores de <?php echo $rowA['username']; ?></h2>

    <?php if ($totalSeguidores > 0) { ?>
        <ul class="seguidores-list">
            <?php while ($row = $sqlSeguidores->fetch_assoc()) { ?>
                <li class="usuario">
                    <a href="perfil.php?username=<?php echo $row['username']; ?>">
                        <img src="images/<?php echo (!empty($row['avatar']) ? $row['avatar'] : 'default.png'); ?>" width="80" height="80">
                        <span><?php echo $row['username']; ?></span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>Este usuario no tiene seguidores.</p>
    <?php } ?>
</div>

</body>
</html>

