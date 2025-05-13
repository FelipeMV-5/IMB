<?php

$mysqli = new mysqli("localhost", "root", "", "imb");

if($mysqli->connect_error) {
	echo "Falló la conexion a la base de datos";
}

return $mysqli;

?>
