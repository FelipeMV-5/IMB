<?php
require("conexion.php");

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $sql = $mysqli->query("SELECT * FROM users WHERE code = '$code' AND confirmed = '0'");

    if ($sql->num_rows == 1) {
        $mysqli->query("UPDATE users SET confirmed = '1' WHERE code = '$code'");
        echo "✅ Cuenta verificada correctamente. Ya puedes iniciar sesión.";
    } else {
        echo "❌ Código inválido o ya fue usado.";
    }
} else {
    echo "No se proporcionó ningún código de verificación.";
}
?>
