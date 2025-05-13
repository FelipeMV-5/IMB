<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['mensaje'])) {
        echo "<script>alert('Todos los campos son obligatorios.'); window.history.back();</script>";
        exit;
    }

    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Por favor ingresa un correo electrónico válido.'); window.history.back();</script>";
        exit;
    }

    $destinatario = "servicioayudaimb@gmail.com";
    $asunto = "Mensaje desde el formulario de Verix - " . date('d/m/Y H:i:s');

    
    $contenido = "Has recibido un nuevo mensaje:\n\n";
    $contenido .= "Nombre: $nombre\n";
    $contenido .= "Email: $email\n\n";
    $contenido .= "Mensaje:\n$mensaje\n\n";
    $contenido .= "Enviado el: " . date('d/m/Y H:i:s');


    $headers = "From: $nombre <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    try {
        $envio = mail($destinatario, $asunto, $contenido, $headers);
        
        if ($envio) {
            echo "<script>alert('¡Mensaje enviado con éxito!'); window.location.href = 'servicios.html';</script>";
        } else {
            throw new Exception('Error en el servidor al enviar el correo');
        }
    } catch (Exception $e) {
        error_log('Error al enviar correo: ' . $e->getMessage());
        echo "<script>alert('Hubo un error al enviar tu mensaje. Por favor intenta nuevamente.'); window.history.back();</script>";
    }
} else {
    
    header("Location: servicios.html");
    exit;
}
?>