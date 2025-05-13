<?php

function datos_usuario($id,$value) {

	require "conexion.php";

	$id = $mysqli->real_escape_string($id);
	$value = $mysqli->real_escape_string($value);

	$datosZ = $mysqli->query("SELECT * FROM users WHERE id = $id");
	$rowZ = $datosZ->fetch_array();

	echo $rowZ[$value];

}
function agregarNotificacion($mysqli, $usuario_id, $mensaje, $url = "#") {
    $stmt = $mysqli->prepare("INSERT INTO notificaciones (user_id, mensaje, url, fecha, leido) VALUES (?, ?, ?, NOW(), 0)");
    $stmt->bind_param("iss", $usuario_id, $mensaje, $url);
    $stmt->execute();
    $stmt->close();
}


?>