<?php
include 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio - Proyecto Final</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <a href="index.php" class="logo"><img src="logo.png" alt="Logo"></a>
  <a href="iniciar_sesion.php" class="btn-login">INICIAR SESIÓN</a>
  <h1 class="course-title">TÍTULO DEL CURSO</h1>
  <div class="main-buttons">
    <a href="registrar.php" class="btn-main btn-register">REGISTRARSE</a>
    <a href="informacion_cursos.php" class="btn-main btn-info">INFORMACIÓN DE LOS CURSOS</a>
  </div>
  <a href="ayuda.php" class="btn-help">Ayuda</a>
</body>
</html>