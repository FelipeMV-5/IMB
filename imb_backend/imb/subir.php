<?php
ob_start();
session_start();
if(!isset($_SESSION['logueado']) || $_SESSION['logueado'] == FALSE) {
  header("Location: index.php");
  exit();
}
error_reporting(E_ALL);
include "functions.php";
require "conexion.php";
?>

<!DOCTYPE html>
<html lang="es">  
<head>    
    <title>Subir IMB</title>    
    <meta charset="UTF-8">
    <meta name="title" content="IMB">
    <meta name="description" content="IMB">    
    <link href="css/subir.css" rel="stylesheet" type="text/css"/>   
    <link href="css/instagram.css" rel="stylesheet" type="text/css"/>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
    <script type="text/javascript">
        $(document).ready(function(){
            $('#file-input').change(function(e) {
                var file = e.target.files[0];
                if (!file.type.match(/image.*/)) {
                    alert("Solo puedes subir imágenes.");
                    return;
                }
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imgSalida').attr("src", e.target.result);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
</head>
<body>
<?php include "header.php"; ?>
<form action="" method="post" enctype="multipart/form-data">  
    <div class="hl-icon" style="text-align:center;">
        <label for="file-input">
            <img src="images/icons/mas.png" width="50" title="Sube una foto o video">
        </label>
        <input id="file-input" type="file" name="file" hidden />
    </div>
    
    <div style="text-align:center; margin-top:20px;">
        <img id="imgSalida" width="600" style="display:none;" />
    </div>
    
    <div style="text-align:center; margin-top:20px;">
        <textarea rows="4" cols="50" name="descripcion" placeholder="Descripción de tu publicación"></textarea>
    </div>
    
    <div style="text-align:center; margin-top:20px;">
        <input name="submit" type="submit" class="myButton" value="Compartir">   
    </div>
</form>  

<?php  
if (isset($_POST['submit'])) {  
    if (!isset($_FILES['file']) || $_FILES['file']['error'] != 0) {
        echo "<script>alert('Error al subir la imagen.');</script>";
    } else {
        $imagen = $_FILES['file']['tmp_name'];   
        $imagen_tipo = exif_imagetype($imagen);

        if (!in_array($imagen_tipo, [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_BMP])) {
            echo "<script>alert('Solo puedes subir imágenes JPG, PNG o BMP.');</script>";
        } else {
            $descripcion = $mysqli->real_escape_string($_POST['descripcion']);
            $resultado = $mysqli->query("SHOW TABLE STATUS WHERE Name='archivos'");
            $data = $resultado->fetch_assoc();
            $next_id = $data['Auto_increment'];
            
            $ext = ".jpg";
            $namefinal = 'ID-' . $next_id . '-' . substr(md5(microtime()), 0, 6) . $ext;
            
            if (move_uploaded_file($imagen, "archivos/$namefinal")) {
                $queryp = $mysqli->query("INSERT INTO publicaciones (user, descripcion, fecha) VALUES ('" . $_SESSION['id'] . "', '$descripcion', NOW())");
                
                if ($queryp) {
                    $ultpub = $mysqli->query("SELECT id FROM publicaciones WHERE user = '" . $_SESSION['id'] . "' ORDER BY id DESC LIMIT 1");
                    $ultp = $ultpub->fetch_array();
                    
                    $query = "INSERT INTO archivos (user, ruta, tipo, size, publicacion, fecha) VALUES (" .
                        "'" . $_SESSION['id'] . "', '$namefinal', '" . $_FILES['file']['type'] . "', '" . $_FILES['file']['size'] . "', '" . $ultp['id'] . "', NOW())";
                    
                    if ($mysqli->query($query)) {
                        header("Location: home.php");
                        exit();
                    } else {
                        echo "<script>alert('Error al guardar la imagen en la base de datos.');</script>";
                    }
                }
            } else {
                echo "<script>alert('Error al mover la imagen al servidor.');</script>";
            }
        }
    }
}
?>
</body>
</html>