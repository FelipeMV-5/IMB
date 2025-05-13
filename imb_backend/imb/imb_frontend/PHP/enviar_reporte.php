<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Capturar datos del formulario
    $tipo = htmlspecialchars($_POST["tipo"]);
    $descripcion = htmlspecialchars($_POST["descripcion"]);

    //Dirección de correo de soporte
    $para = "soporte@verix.com";
    $asunto = "Nuevo reporte de problema: $tipo";
    $mensaje = "Tipo de problema: $tipo\n\nDescripción:\n$descripcion";
    $cabeceras = "From: no-reply@verix.com\r\nReply-To: no-reply@verix.com\r\nContent-Type: text/plain; charset=UTF-8";

    // Enviar correo y responder al AJAX
    if (mail($para, $asunto, $mensaje, $cabeceras)) {
        echo "Éxito"; //Respuesta para el Java
    } else {
        echo "Error"; //Si el correo no se envía
    }
}
?>
