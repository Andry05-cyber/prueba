<?php
include 'config.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $mysqli->prepare("SELECT id, password, rol FROM usuarios WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $db_password, $rol);
        $stmt->fetch();

        // COMPARAR contraseñas en texto plano (sin hash)
        if ($password === $db_password) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['rol'] = $rol;

            if ($rol === 'admin') {
                header("Location: admin/panel_admin.php");
            } else {
                header("Location: estudiante/panel_estudiante.php");
            }
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="login">

<header class="login-header">
  <a href="index.php" class="logo"><img src="logo.png" alt="Logo"></a>
  <h1 class="project-title">Nombre del proyecto</h1>
  <a href="index.php" class="btn-back">Regresar al inicio</a>
</header>

<div class="login-bg">
  <div class="login-container">

    <div class="login-image">
      <img src="login-image.png" alt="Imagen de bienvenida">
    </div>

    <div class="login-form">
      <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
      <?php endif; ?>

      <form method="post" action="iniciar_sesion.php">
        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Ingresar</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
