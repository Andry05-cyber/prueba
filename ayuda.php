<?php
include 'config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y sanitizar
    $nombres = $mysqli->real_escape_string(trim($_POST['nombres']));
    $apellidos = $mysqli->real_escape_string(trim($_POST['apellidos']));
    $cedula = $mysqli->real_escape_string(trim($_POST['cedula']));
    $telefono = $mysqli->real_escape_string(trim($_POST['telefono']));
    $email = filter_var(trim($_POST['correo']), FILTER_VALIDATE_EMAIL);
    $curso_id = intval($_POST['curso']);
    $queja = $mysqli->real_escape_string(trim($_POST['queja']));
    if ($email && $queja) {
        $stmt = $mysqli->prepare("INSERT INTO quejas (usuario_id, queja) VALUES (?, ?)");
        // crear usuario temporal
        $stmtUser = $mysqli->prepare("INSERT IGNORE INTO usuarios (nombres,apellidos,cedula,telefono,email,rol) VALUES (?, ?, ?, ?, ?, 'estudiante')");
        $stmtUser->bind_param('sssss', $nombres, $apellidos, $cedula, $telefono, $email);
        $stmtUser->execute();
        $user_id = $mysqli->insert_id ? $mysqli->insert_id : $mysqli->query("SELECT id FROM usuarios WHERE email='$email'")->fetch_object()->id;
        $stmtUser->close();
        $stmt->bind_param('is', $user_id, $queja);
        $stmt->execute();
        $stmt->close();
        $mensaje = 'Queja enviada correctamente.';
    } else {
        $error = 'Datos inválidos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario de Quejas</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="login-header">
  <a href="index.php" class="logo"><img src="logo.png" alt="Logo"></a>
  <h1 class="project-title">Nombre del proyecto</h1>
  <a href="index.php" class="btn-back">Regresar al inicio</a>
</header>

  <div class="form-container">
    <?php if (!empty($mensaje)): ?><p class="success"><?php echo $mensaje; ?></p><?php endif; ?>
    <?php if (!empty($error)): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
    <form action="ayuda.php" method="post">
      <input type="text" name="nombres" placeholder="Nombres completos" required>
      <input type="text" name="apellidos" placeholder="Apellidos completos" required>
      <input type="text" name="cedula" placeholder="Cédula" required>
      <input type="tel" name="telefono" placeholder="Teléfono" required>
      <input type="email" name="correo" placeholder="Correo electrónico" required>
      <select name="curso" required>
        <option value="">Seleccione su curso...</option>
        <?php
        $cursos = $mysqli->query("SELECT id, nombre FROM cursos");
        while ($c = $cursos->fetch_assoc()) {
            echo "<option value='{$c['id']}'>".htmlspecialchars($c['nombre'])."</option>";
        }
        ?>
      </select>
      <textarea name="queja" placeholder="Describa su queja..." required></textarea>
      <button type="submit">Enviar Queja</button>
    </form>
  </div>
</body>
</html>