<?php
//Recibir datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$mensaje = $_POST['mensaje'];

//Configurar el correo
$destinatario = "servicioayudaimb@gmail.com"; 
$asunto = "Mensaje de contacto desde la web";

//Crear el mensaje
$contenido = "Nombre: $nombre\n";
$contenido .= "Email: $email\n\n";
$contenido .= "Mensaje:\n$mensaje";

//Cabeceras
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";

//Enviar el correo
$envio = mail($destinatario, $asunto, $contenido, $headers);

//resultado
if ($envio) {
    echo "<script>
        alert('Mensaje enviado con éxito');
        window.location.href = 'servicios.html';
    </script>";
} else {
    echo "<script>
        alert('Error al enviar. Intenta nuevamente.');
        window.history.back();
    </script>";
}
?>