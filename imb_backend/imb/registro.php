<?php
ob_start();
session_start();

if (isset($_SESSION['logueado']) && $_SESSION['logueado'] == TRUE) {
    header("Location: home.php");
}

if (isset($_POST['registro'])) {
    require("conexion.php");

    $email = $mysqli->real_escape_string($_POST['mail']);
    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $usuario = $mysqli->real_escape_string($_POST['usuario']);
    $password = md5($_POST['password']);
    $ip = $_SERVER['REMOTE_ADDR'];

    // Validar que el correo tenga el dominio correcto
    if (!preg_match('/@institutmvm\.cat$/', $email)) {
        echo "Solo se permiten registros con correos de institutmvm.cat";
    } else {
        $consultausuario = "SELECT username FROM users WHERE username = '$usuario'";
        $consultaemail = "SELECT email FROM users WHERE email = '$email'";

        $resultadousuario = $mysqli->query($consultausuario);
        $numerousuario = $resultadousuario->num_rows;

        $resultadoemail = $mysqli->query($consultaemail);
        $numeroemail = $resultadoemail->num_rows;

        if ($numeroemail > 0) {
            echo "Este correo ya está registrado, intenta con otro.";
        } elseif ($numerousuario > 0) {
            echo "Este usuario ya existe.";
        } else {
            $aleatorio = uniqid();
            $query = "INSERT INTO users (email, name, username, password, signup_date, last_ip, code) 
                      VALUES ('$email', '$nombre', '$usuario', '$password', NOW(), '$ip', '$aleatorio')";

            if ($mysqli->query($query)) {
                require("fuctions.php");
                header("Refresh: 2; URL=index.php");
                echo "Felicidades $usuario, te has registrado correctamente. Hemos enviado un correo de confirmación.";

                // Envío de correo de confirmación
                $email_to = $email;
                $email_subject = "Confirma tu email en IMB";
                $email_from = "reply@tusitioweb.com";

                $email_message = "Hola $usuario,\n\n";
                $email_message .= "Para disfrutar de nuestro sitio web, confirma tu email con el siguiente código:\n\n";
                $email_message .= "Código: $aleatorio\n";

                $headers = "From: $email_from\r\n" .
                           "Reply-To: $email_from\r\n" .
                           "X-Mailer: PHP/" . phpversion();
                @mail($email_to, $email_subject, $email_message, $headers);
            } else {
                echo "Ha ocurrido un error en el registro, inténtelo de nuevo.";
                header("Refresh: 2; URL=registro.php");
            }
        }
    }
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>IMB - Registro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>

<div id="wrapper">
    <div class="main-content">
        <div class="header">
            <img src="images/logo.png" />
        </div>
        <form action="" method="post">
            <div class="l-part">
                <input type="email" placeholder="Correo electrónico" class="input" name="mail" required />
                <div class="overlap-text">
                    <input type="text" placeholder="Nombre completo" class="input" name="nombre" required />
                </div>
                <div class="overlap-text">
                    <input type="text" placeholder="Usuario" class="input" name="usuario" required />
                </div>
                <div class="overlap-text">
                    <input type="password" placeholder="Contraseña" class="input" name="password" required />
                </div>
                <input type="submit" value="Registrarte" class="btn" name="registro" />
            </div>
        </form>
    </div>
    <div class="sub-content">
        <div class="s-part">
            ¿Tienes una cuenta? <a href="index.php">Entrar</a>
            <div class="terminos">
                <h4><strong>Términos y Condiciones</strong></h4>
                <p>Para iniciar sesión, es obligatorio verificar el correo con el dominio del centro educativo.</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<?php
ob_end_flush();
?>
