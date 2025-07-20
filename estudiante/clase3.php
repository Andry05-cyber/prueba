<?php 
include '../config.php'; 
session_start();

if ($_SESSION['rol'] !== 'estudiante') {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Clase 3</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
  <a href="panel_estudiante.php">← Regresar</a>
</header>
<div class="container">
  <h2>Clase 3: Título de la clase</h2>
  <p>Contenido de la clase, videos, recursos, etc.</p>
</div>
</body>
</html>
