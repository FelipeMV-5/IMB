<?php
session_start();
require "conexion.php";

$postid = $_POST['id'];
$user = $_SESSION['id'];

// Activar errores (opcional, para depurar)
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$countLikes = $mysqli->query("SELECT * FROM likes WHERE usuario = '$user' AND post = '$postid'");
$cLike = $countLikes->num_rows;

if ($cLike == 0) {
    $insertLike = $mysqli->query("INSERT INTO likes (usuario, post, fecha) VALUES ('$user', '$postid', now())");
    $updatePub = $mysqli->query("UPDATE publicaciones SET likes = likes+1 WHERE id = '$postid'");

    // Obtener el autor de la publicación
    $stmt = $mysqli->prepare("SELECT usuario FROM publicaciones WHERE id = ?");
    $stmt->bind_param("i", $postid);
    $stmt->execute();
    $stmt->bind_result($autor_post);
    $stmt->fetch();
    $stmt->close();

    // No notificar si el usuario se da like a sí mismo
    if ($autor_post != $user) {
        $mensaje = "A alguien le gustó tu publicación.";
        $tipo = "like";
        $prioridad = "normal";
        $estado = "nueva";
        $url = "publicacion.php?id=" . $postid; // Cambia esto a la URL correcta de la publicación

        $stmt = $mysqli->prepare("INSERT INTO notificaciones (usuario_id, mensaje, tipo, prioridad, estado, url, fecha) VALUES (?, ?, ?, ?, ?, ?, now())");
        $stmt->bind_param("isssss", $autor_post, $mensaje, $tipo, $prioridad, $estado, $url);
        $stmt->execute();
        $stmt->close();
    }

} else {
    $insertLike = $mysqli->query("DELETE FROM likes WHERE usuario = '$user' AND post = '$postid'");
    $updatePub = $mysqli->query("UPDATE publicaciones SET likes = likes-1 WHERE id = '$postid'");
}

if ($cLike == 0) {
    $megusta = "<img src='images/icons/cora2.png'>";
} else {
    $megusta = "<img src='images/icons/cora.png'>";
}

$return = array("img" => $megusta);
echo json_encode($return);
?>
