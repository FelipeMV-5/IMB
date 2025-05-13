<?php
session_start();
if(!isset($_SESSION['logueado']) || $_SESSION['logueado'] == FALSE) {
    header("Location: index.php");
    exit();
}
require "conexion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicar Frase</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 40px;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
        }
        textarea {
            width: 90%;
            max-width: 600px;
            height: 100px;
            padding: 10px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ccc;
            resize: none;
        }
        .contador {
            margin-top: 5px;
            font-size: 14px;
            color: #666;
        }
        .btn-publicar {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #1da1f2;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-publicar:hover {
            background-color: #0d8ddb;
        }
    </style>
    <script>
        function contarCaracteres() {
            const textarea = document.getElementById("descripcion");
            const contador = document.getElementById("contador");
            const max = 280;
            const longitud = textarea.value.length;
            contador.textContent = longitud + " / " + max;
            contador.style.color = (longitud > max) ? "red" : "#666";
        }
    </script>
</head>
<body>

<h2>¿Qué estás pensando?</h2>

<form action="" method="post">
    <textarea id="descripcion" name="descripcion" placeholder="Escribe algo..." maxlength="280" oninput="contarCaracteres()" required></textarea>
    <div class="contador" id="contador">0 / 280</div>
    <br>
    <button class="btn-publicar" type="submit" name="submit">Publicar</button>
</form>

<?php
if (isset($_POST['submit'])) {
    $descripcion = trim($_POST['descripcion']);
    if ($descripcion === '') {
        echo "<script>alert('No puedes publicar una frase vacía.');</script>";
    } else {
        $descripcion = $mysqli->real_escape_string($descripcion);
        $userId = $_SESSION['id'];

        $query = "INSERT INTO publicaciones (user, descripcion, fecha) VALUES ('$userId', '$descripcion', NOW())";
        if ($mysqli->query($query)) {
            echo "<script>alert('¡Frase publicada con éxito!'); window.location='home.php';</script>";
        } else {
            echo "<script>alert('Error al guardar la publicación.');</script>";
        }
    }
}
?>

</body>
</html>
