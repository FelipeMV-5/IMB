<?php
session_start();
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] == FALSE) {
    header("Location: index.php");
    exit();
}

include "functions.php";
require "conexion.php";

// Obtener datos del usuario actual
$sqlA = $mysqli->query("SELECT * FROM users WHERE id = '" . $_SESSION['id'] . "'");
$rowA = $sqlA->fetch_array();

if (isset($_POST['editar'])) {
    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $username = $mysqli->real_escape_string($_POST['username']);
    $bio = $mysqli->real_escape_string($_POST['bio']);
    $email = $mysqli->real_escape_string($_POST['email']);

    // Verificar si el username y el email ya están en uso
    $sqlB = $mysqli->query("SELECT * FROM users WHERE username = '$username' AND id != '" . $_SESSION['id'] . "'");
    $totalusuarios = $sqlB->num_rows;

    $sqlC = $mysqli->query("SELECT * FROM users WHERE email = '$email' AND id != '" . $_SESSION['id'] . "'");
    $totalemail = $sqlC->num_rows;

    if ($totalusuarios > 0) {
        $existe = "Ya hay un usuario con este nombre";
    } elseif ($totalemail > 0) {
        $existe2 = "Ya hay un email registrado";
    } else {
        // Manejo de la imagen de perfil
        if (!empty($_FILES['avatar']['name'])) {
            $avatar = $_FILES['avatar']['name'];
            $avatar_tmp = $_FILES['avatar']['tmp_name'];
            $ext = strtolower(pathinfo($avatar, PATHINFO_EXTENSION));
            $avatar_new = uniqid() . "." . $ext;
            $target = "images/" . $avatar_new;

            // Validar extensión de imagen
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($ext, $allowed_exts)) {
                if (move_uploaded_file($avatar_tmp, $target)) {
                    // Eliminar la imagen anterior si existe
                    if (!empty($rowA['avatar']) && file_exists("images/" . $rowA['avatar'])) {
                        unlink("images/" . $rowA['avatar']);
                    }

                    // Actualizar base de datos con la nueva imagen
                    $mysqli->query("UPDATE users SET avatar = '$avatar_new' WHERE id = '" . $_SESSION['id'] . "'");
                } else {
                    echo "<script>alert('Error al subir la imagen');</script>";
                }
            } else {
                echo "<script>alert('Formato de imagen no permitido');</script>";
            }
        }

        // Actualizar otros datos del usuario
        $sqlE = $mysqli->query("UPDATE users SET name = '$nombre', username = '$username', bio = '$bio', email = '$email' WHERE id = '" . $_SESSION['id'] . "'");

        if ($sqlE) {
            echo "<script>alert('Perfil actualizado correctamente'); window.location.href='editar_perfil.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar el perfil');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>imb - Editar Perfil</title>
    <meta charset="UTF-8">
    <meta name="description" content="Editar perfil de usuario en imb">
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<?php include "header.php"; ?>

<div class="h-content">
    <div class="e-mid">
        <div class="e-left">
            <a href="editar_perfil.php"><button class="button_edit_on">Editar perfil</button></a>
            <a href="editar_pass.php"><button class="button_edit">Cambiar contraseña</button></a>
            <a href="editar_privacidad.php"><button class="button_edit">Privacidad y seguridad</button></a>
            <a href="#"> <button class="button_edit"> Ayuda</button></a>
        </div>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="e-right">
                <div class="e-contenido">
                    <label for="avatar" class="upload-btn">Cambiar foto de perfil</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" style="display: none;">
                    <input type="submit" name="editar" value="Subir" class="button_blue">
                </div>

                <div class="e-contenido">
                    <div class="e-title">Nombre</div>
                    <div class="e-input">
                        <input type="text" name="nombre" value="<?php echo $rowA['name']; ?>" autocomplete="off">
                    </div>
                </div>

                <div class="e-contenido">
                    <div class="e-title">Nombre de usuario</div>
                    <div class="e-input">
                        <input type="text" name="username" value="<?php echo $rowA['username']; ?>" autocomplete="off">
                        <br>
                        <div style="color:red; font-size: 12px;">
                            <?php if (isset($existe)) { echo $existe; } ?>
                        </div>
                    </div>
                </div>

                <div class="e-contenido">
                    <div class="e-title">Biografía</div>
                    <div class="e-input">
                        <input type="text" name="bio" value="<?php echo $rowA['bio']; ?>" autocomplete="off">
                    </div>
                </div>

                <div class="e-contenido">
                    <div class="e-title">Correo electrónico</div>
                    <div class="e-input">
                        <input type="text" name="email" value="<?php echo $rowA['email']; ?>" autocomplete="off">
                        <br>
                        <div style="color:red; font-size: 12px;">
                            <?php if (isset($existe2)) { echo $existe2; } ?>
                        </div>
                    </div>
                </div>

                <div class="e-contenido">
                    <div class="e-title">Sexo</div>
                    <div class="e-input">
                        <select disabled>
                            <option value="">Sin especificar</option>
                            <option value="0">Hombre</option>
                            <option value="1">Mujer</option>
                        </select>
                    </div>
                </div>

                <div class="e-contenido">
                    <div class="e-title"></div>
                    <div class="e-but">
                        <input type="submit" value="Editar" name="editar" class="button_blue"
                               style="margin-left: 110px; margin-bottom: 30px; color: white; font-size: 16px; padding:6px 9px;font-weight: 600;">
                               
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>
