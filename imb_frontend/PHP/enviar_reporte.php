<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //datos del formulario
    $tipo = htmlspecialchars($_POST["tipo"]);
    $descripcion = htmlspecialchars($_POST["descripcion"]);

   
    $para = "soporteimb@gmail.com";
    $asunto = "Nuevo reporte de problema: $tipo";
    $mensaje = "Tipo de problema: $tipo\n\nDescripción:\n$descripcion";
    $cabeceras = "From: no-reply@verix.com\r\nReply-To: no-reply@verix.com\r\nContent-Type: text/plain; charset=UTF-8";

    if (mail($para, $asunto, $mensaje, $cabeceras)) {
        echo "Éxito"; 
    } else {
        echo "Error"; 
    }
}
?>
