
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nombre'], $_POST['email'], $_POST['mensaje'])) {

        $nombre = htmlspecialchars(trim($_POST['nombre']));
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $mensaje = htmlspecialchars(trim($_POST['mensaje']));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('El correo no es válido.'); window.history.back();</script>";
            exit;
        }

        // Dirección de destino
        $destinatario = "servicioayudaimb@gmail.com"; 
        $asunto = "Mensaje desde el formulario de Verix";

        $contenido = "Has recibido un nuevo mensaje desde Verix:\n\n";
        $contenido .= "Nombre: $nombre\n";
        $contenido .= "Correo: $email\n\n";
        $contenido .= "Mensaje:\n$mensaje";

        // Cabeceras del correo
        $headers = "From: $email";

        // Enviar el correo
        if (mail($destinatario, $asunto, $contenido, $headers)) {
            echo "<script>alert('Mensaje enviado correctamente.'); window.location.href = 'servicios.html';</script>";
        } else {
            echo "<script>alert('Error al enviar el mensaje.'); window.history.back();</script>";
        }

    } else {
        echo "<script>alert('Faltan datos del formulario.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Acceso no válido.'); window.location.href = 'servicios.html';</script>";
}

