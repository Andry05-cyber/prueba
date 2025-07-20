<?php
include 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Información de los Cursos</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="login-header">
  <a href="index.php" class="logo"><img src="logo.png" alt="Logo"></a>
  <h1 class="project-title">Nombre del proyecto</h1>
  <a href="index.php" class="btn-back">Regresar al inicio</a>
</header>


  <div class="container">
    <h2>Cursos Disponibles</h2>
    <?php
    $res = $mysqli->query("SELECT id, nombre, horas, valor FROM cursos ORDER BY nombre");
    if (!$res) {
        echo "<p class='error'>" . htmlspecialchars($mysqli->error) . "</p>";
    } else {
        while ($r = $res->fetch_assoc()) {
            echo "<div><h3>" . htmlspecialchars($r['nombre']) . "</h3>";
            echo "<p>Horas: " . intval($r['horas']) . "</p>";
            echo "<p>Valor: $" . number_format($r['valor'], 2) . "</p></div><hr>";
        }
    }
    ?>
  </div>
</body>
</html>
