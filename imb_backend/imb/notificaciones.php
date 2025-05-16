<?php
session_start();
require("conexion.php"); // Conexión a la base de datos

if (!isset($_SESSION['id'])) {
    die("Error: No hay sesión de usuario activa.");
}

$usuario_id = $_SESSION['id'];

// Cambiado a "fecha"
$stmt = $mysqli->prepare("SELECT * FROM notificaciones WHERE usuario_id = ? ORDER BY fecha DESC");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$notificaciones = $stmt->get_result();

if ($stmt->error) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}
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
                <li class="<?php echo ($noti['estado'] == 'leída') ? 'leida' : 'nueva'; ?>">
                    <a href="<?php echo isset($noti['url']) ? htmlspecialchars($noti['url']) : '#'; ?>">
                        <?php echo htmlspecialchars($noti['mensaje']); ?>
                    </a>
                    <span class="fecha"><?php echo date("d/m/Y H:i", strtotime($noti['fecha'])); ?></span>
                    <?php if ($noti['estado'] != 'leída') { ?>
                        <a href="?marcar_leida=<?php echo $noti['id']; ?>" class="marcar-leida">✔ Marcar como leída</a>
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>No tienes nuevas notificaciones.</p>
    <?php } ?>
</div>

</body>
</html>

<?php
if (isset($_GET['marcar_leida'])) {
    $notificacion_id = $_GET['marcar_leida'];

    if (!is_numeric($notificacion_id)) {
        die("Error: ID de notificación no válido.");
    }

    $stmt = $mysqli->prepare("UPDATE notificaciones SET estado = 'leída' WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("ii", $notificacion_id, $usuario_id);
    $stmt->execute();

    if ($stmt->error) {
        die("Error al marcar la notificación como leída: " . $stmt->error);
    }

    $stmt->close();

    header("Location: notificaciones.php");
    exit();
}
?>
