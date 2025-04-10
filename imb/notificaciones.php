<?php
session_start();
require("conexion.php"); // Conexión a la base de datos

// Verificar si hay sesión de usuario activa
if (!isset($_SESSION['id'])) {
    die("Error: No hay sesión de usuario activa.");
}

$usuario_id = $_SESSION['id']; // ID del usuario que verá las notificaciones

// Obtener las notificaciones del usuario
$stmt = $mysqli->prepare("SELECT * FROM notificaciones WHERE user_id = ? ORDER BY fecha DESC");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$notificaciones = $stmt->get_result();

// Verificar si hay errores en la consulta
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

    <?php
    // Si hay notificaciones, se muestran en una lista
    if ($notificaciones->num_rows > 0) { ?>
        <ul>
            <?php while ($noti = $notificaciones->fetch_assoc()) { ?>
                <li class="<?php echo ($noti['leido'] == '1') ? 'leida' : 'nueva'; ?>">
                    <a href="<?php echo isset($noti['url']) ? htmlspecialchars($noti['url']) : '#'; ?>">
                        <?php echo htmlspecialchars($noti['mensaje']); ?>
                    </a>
                    <span class="fecha"><?php echo date("d/m/Y H:i", strtotime($noti['fecha'])); ?></span>
                    <?php if ($noti['leido'] != '1') { ?>
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
// Si se ha recibido un parámetro para marcar una notificación como leída
if (isset($_GET['marcar_leida'])) {
    $notificacion_id = $_GET['marcar_leida'];

    // Verificar que el ID de la notificación sea válido
    if (!is_numeric($notificacion_id)) {
        die("Error: ID de notificación no válido.");
    }

    // Marcar la notificación como leída
    $stmt = $mysqli->prepare("UPDATE notificaciones SET leido = '1' WHERE id = ?");
    $stmt->bind_param("i", $notificacion_id);
    $stmt->execute();

    // Verificar si la actualización fue exitosa
    if ($stmt->error) {
        die("Error al marcar la notificación como leída: " . $stmt->error);
    }

    $stmt->close();

    // Redirigir a la página de notificaciones después de marcar como leída
    header("Location: notificaciones.php");
    exit();
}
?>

