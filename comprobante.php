<?php
include 'config.php';
session_start();
if (empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$user_id = intval($_GET['id']);
$stmt = $mysqli->prepare("SELECT nombres, apellidos, email, curso_id, monto, registrado_en FROM usuarios WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($nom, $ape, $email, $cid, $mto, $fecha);
$stmt->fetch();
$stmt->close();
$curso = $mysqli->query("SELECT nombre FROM cursos WHERE id = $cid")->fetch_object();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Comprobante de Registro</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header><a href="index.php">← Regresar</a></header>
  <div class="container">
    <h2>Comprobante de Registro</h2>
    <p>Estimado/a <?php echo htmlspecialchars("$nom $ape"); ?>, su registro fue exitoso.</p>
    <ul>
      <li>Correo: <?php echo htmlspecialchars($email); ?></li>
      <li>Curso: <?php echo htmlspecialchars($curso->nombre); ?></li>
      <li>Monto: $<?php echo number_format($mto, 2); ?></li>
      <li>Fecha: <?php echo $fecha; ?></li>
    </ul>
    <button onclick="window.print()">Imprimir</button>
  </div>
</body>
</html>
