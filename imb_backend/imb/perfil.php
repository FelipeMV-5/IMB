<?php
session_start();
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] == FALSE) {
    header("Location: index.php");
    exit();
}

include "functions.php";

if (isset($_GET['username'])) {

    require "conexion.php";

    $sqlA = $mysqli->query("SELECT * FROM users WHERE username = '" . $_GET['username'] . "'");
    $rowA = $sqlA->fetch_array();

    // Obtener publicaciones
    $sqlB = $mysqli->query("SELECT * FROM publicaciones WHERE user = '" . $rowA['id'] . "' ORDER BY id DESC");
    $totalp = $sqlB->num_rows;

    // Obtener seguidores y seguidos
    $sqlC = $mysqli->query("SELECT * FROM seguidores WHERE seguido = '" . $rowA['id'] . "' AND aprobada = 1");
    $totalS = $sqlC->num_rows;

    $sqlD = $mysqli->query("SELECT * FROM seguidores WHERE seguidor = '" . $rowA['id'] . "' AND aprobada = 1");
    $totalSe = $sqlD->num_rows;

    // Comprobar si ya está siguiendo al usuario
    $yaEnviaste = $mysqli->query("SELECT * FROM seguidores WHERE seguidor = '" . $_SESSION['id'] . "' AND seguido = '" . $rowA['id'] . "'");
    $yaEnviaste = $yaEnviaste->num_rows;

    // Comprobar si la solicitud de seguimiento fue aprobada
    $tAprobo = $mysqli->query("SELECT * FROM seguidores WHERE seguidor = '" . $_SESSION['id'] . "' AND seguido = '" . $rowA['id'] . "' AND aprobada = 1");
    $tAprobo = $tAprobo->num_rows;

    // Acción para seguir o dejar de seguir
    if (isset($_GET['seguir'])) {
        if ($yaEnviaste > 0) {
            // Si ya está siguiendo, eliminar la relación de seguimiento
            $mysqli->query("DELETE FROM seguidores WHERE seguidor = '" . $_SESSION['id'] . "' AND seguido = '" . $rowA['id'] . "'");
            header("Location: perfil.php?username=" . $_GET['username']);
        } else {
            
            $aprobado = ($rowA['private_profile'] == 1) ? 0 : 1;
            $mysqli->query("INSERT INTO seguidores (seguidor, seguido, aprobada, fecha) VALUES ('" . $_SESSION['id'] . "', '" . $rowA['id'] . "', '$aprobado', NOW())");
            header("Location: perfil.php?username=" . $_GET['username']);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="title" content="Photogram">
    <meta name="description" content="Photogram">
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <title>Perfil de <?php echo $rowA['username']; ?></title>
</head>
<body>

<?php include "header.php"; ?>

<div class="h-content">
    <div class="p-top">
        <div class="p-foto">
            <img src="images/<?php echo (!empty($rowA['avatar']) ? $rowA['avatar'] : 'avatar.png'); ?>" width="180" height="180">
        </div>
        <div class="p-name">
            <div class="p-user"><?php echo $rowA['username']; ?></div>
            <?php if ($rowA['verified'] == 1) { ?>
                <div class="p-user"><img src="images/verificado.png"></div>
            <?php } ?>
            <?php if ($rowA['id'] == $_SESSION['id']) { ?>
                <div class="p-editar"><a href="editar_perfil.php"><button class="button_white">Editar perfil</button></a></div>
            <?php } else { ?>
                <!-- Mostrar botón para seguir o dejar de seguir -->
                <?php if ($tAprobo == 0) { ?>
                    <?php if ($yaEnviaste > 0) { ?>
                        <div class="p-editar"><button class="button_blue">Solicitud enviada</button></div>
                    <?php } else { ?>
                        <a href="?seguir=seguir&username=<?php echo $_GET['username']; ?>">
                            <div class="p-editar"><button class="button_blue">Seguir</button></div>
                        </a>
                    <?php } ?>
                <?php } else { ?>
                    <a href="?seguir=seguir&username=<?php echo $_GET['username']; ?>">
                        <div class="p-editar"><button class="button_blue">Dejar de seguir</button></div>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="p-info">
            <div class="p-infor"><b><?php echo $totalp; ?></b> publicaciones</div>
			<a href="seguidores_usuario.php?username=<?php echo $rowA['username']; ?>">
       		<div class="p-infor"><b><?php echo $totalS; ?></b> seguidores</div>
			</a>
			<a href="seguido.php?username=<?php echo $rowA['username']; ?>">
            <div class="p-infor"><b><?php echo $totalSe; ?></b> seguidos</div>
			</a>
        </div>
        <div class="p-nombre"><?php echo $rowA['name']; ?></div>
        <div class="p-description"><?php echo $rowA['bio']; ?></div>
    </div>

    <div class="p-mid">
        <?php
        if ($rowA['private_profile'] == 1 && $rowA['id'] != $_SESSION['id'] && $tAprobo == 0) {
            echo "Si deseas ver sus fotos o videos, sigue a este usuario.";
        } else {
            while ($rowC = $sqlB->fetch_array()) {
                $sqlD = $mysqli->query("SELECT * FROM archivos WHERE publicacion = '" . $rowC['id'] . "'");
                $rowD = $sqlD->fetch_array();
                ?>
                <div class="p-pub <?php echo $rowD['filtro']; ?>" style="background-image: url('archivos/<?php echo $rowD['ruta']; ?>');"></div>
            <?php }
        }
        ?>
    </div>
</div>

</body>
</html>
