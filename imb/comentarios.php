<?php
session_start();
if (!isset($_SESSION['logueado']) && $_SESSION['logueado'] == FALSE) {
  header("Location: index.php");
}

require("conexion.php");

if (isset($_POST['comentar'])) {
  $post_id = $_POST['post_id'];
  $usuario_id = $_SESSION['id'];
  $comentario = $mysqli->real_escape_string($_POST['comentario']);

  $mysqli->query("INSERT INTO comentarios (post_id, usuario_id, comentario) VALUES ('$post_id', '$usuario_id', '$comentario')");
}

$post_id = $_GET['post_id'];
$resultado = $mysqli->query("SELECT * FROM comentarios WHERE post_id = '$post_id' ORDER BY fecha DESC");

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <title>Comentarios</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="logo">
<a href="home.php"> <img class="logo" src="images/logo.png" alt="logo"></a>
</div>
<h2>Comentarios</h2>

<form method="POST">
  <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
  <textarea name="comentario" required></textarea>
  <button type="submit" name="comentar">Comentar</button>
</form>

<?php while ($row = $resultado->fetch_assoc()) { ?>
  <p><strong><?php echo $row['usuario_id']; ?></strong>: <?php echo $row['comentario']; ?></p>
<?php } ?>

</body>
</html>
<style>
  body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 20px;
  text-align: center;
}
.logo{
    width: 90px;
}

h2 {
  color: #333;
}

form {
  background: white;
  padding: 20px;
  max-width: 400px;
  margin: 20px auto;
  border-radius: 8px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

textarea {
  width: 100%;
  height: 100px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  resize: none;
  font-size: 14px;
}

button {
  background-color:rgb(121, 121, 121);
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 10px;
}

button:hover {
  background-color:rgb(82, 82, 82);
}

p {
  background: white;
  padding: 10px;
  max-width: 400px;
  margin: 10px auto;
  border-radius: 5px;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  text-align: left;
}

p strong {
  color: #007bff;
}

</style>
