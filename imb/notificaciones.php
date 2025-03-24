<?php
session_start();
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] == FALSE) {
    header("Location: index.php");
    exit();
}

require("conexion.php");

// Obtener notificaciones del usuario
$usuario_id = $_SESSION['id'];
$notificaciones = $mysqli->query("SELECT * FROM notificaciones WHERE usuario_id = '$usuario_id' ORDER BY fecha DESC");

// Marcar notificaciones como leídas
$mysqli->query("UPDATE notificaciones SET leida = 1 WHERE usuario_id = '$usuario_id'");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificaciones</title>
    <link rel="stylesheet" href="css/notificaciones.css">
</head>
<body>

<?php include "header.php"; ?>

<div class="notificaciones-container">
    <h2>Notificaciones</h2>

    <?php if ($notificaciones->num_rows > 0) { ?>
        <ul>
            <?php while ($noti = $notificaciones->fetch_assoc()) { ?>
                <li class="<?php echo $noti['leida'] ? 'leida' : 'nueva'; ?>">
                    <a href="<?php echo $noti['url']; ?>">
                        <?php echo $noti['mensaje']; ?>
                    </a>
                    <span class="fecha"><?php echo date("d/m/Y H:i", strtotime($noti['fecha'])); ?></span>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>No tienes nuevas notificaciones.</p>
    <?php } ?>
</div>

</body>
</html>
