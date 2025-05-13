<?php
session_start();
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] == FALSE) {
    header("Location: index.php");
    exit();
}

include "functions.php";

if (isset($_GET['username'])) {
    require "conexion.php";

    // Obtener datos del usuario
    $sqlA = $mysqli->query("SELECT * FROM users WHERE username = '" . $_GET['username'] . "'");
    $rowA = $sqlA->fetch_array();

    // Obtener los usuarios que sigue el usuario
    $sqlSeguidos = $mysqli->query("SELECT u.username, u.avatar FROM seguidores s 
                                   JOIN users u ON s.seguido = u.id 
                                   WHERE s.seguidor = '" . $rowA['id'] . "' AND s.aprobada = 1");

    // Número total de seguidos
    $totalSeguidos = $sqlSeguidos->num_rows;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="title" content="Seguidos de <?php echo $rowA['username']; ?>">
    <meta name="description" content="Ver los usuarios que sigue <?php echo $rowA['username']; ?>">
    <link href="css/seguidore.css" rel="stylesheet" type="text/css"/>
    <title>Seguidos de <?php echo $rowA['username']; ?></title>
</head>
<body>

<?php include "header.php"; ?>

<div class="seguidores-container">
    <h2>Seguidos por <?php echo $rowA['username']; ?></h2>

    <?php if ($totalSeguidos > 0) { ?>
        <ul class="seguidores-list">
            <?php while ($row = $sqlSeguidos->fetch_assoc()) { ?>
                <li class="usuario">
                    <a href="perfil.php?username=<?php echo $row['username']; ?>">
                        <img src="images/<?php echo (!empty($row['avatar']) ? $row['avatar'] : 'default.png'); ?>" width="80" height="80">
                        <span><?php echo $row['username']; ?></span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>Este usuario no sigue a nadie.</p>
    <?php } ?>
</div>

</body>
</html>

