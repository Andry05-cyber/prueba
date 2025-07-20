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
  <title>Panel Estudiante</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
  <h2>Panel del Estudiante</h2>
  <nav>
    <a href="clase1.php">Clase 1</a>
    <a href="clase2.php">Clase 2</a>
    <a href="clase3.php">Clase 3</a>
    <a href="clase4.php">Clase 4</a>
    <a href="calificaciones.php">Calificaciones</a>
    <a href="../index.php">Salir</a>
  </nav>
</header>
<div class="container">
  <p>Bienvenido a tus clases.</p>
</div>
</body>
</html>
