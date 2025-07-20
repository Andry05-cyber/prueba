<?php
include 'config.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres          = trim($_POST['nombres']);
    $apellidos        = trim($_POST['apellidos']);
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $cedula           = trim($_POST['cedula']);
    $telefono         = trim($_POST['telefono']);
    $email            = trim($_POST['email']);
    $password         = $_POST['password']; // SIN cifrar
    $curso_id         = intval($_POST['curso']);

    // Obtener el valor del curso
    $stmt_curso = $mysqli->prepare("SELECT valor FROM cursos WHERE id = ?");
    $stmt_curso->bind_param("i", $curso_id);
    $stmt_curso->execute();
    $stmt_curso->bind_result($valor);
    $stmt_curso->fetch();
    $stmt_curso->close();

    if (!isset($valor)) {
        $mensaje = "Curso inválido.";
    } else {
        // Insertar estudiante con contraseña sin cifrar
        $stmt = $mysqli->prepare("INSERT INTO usuarios 
            (nombres, apellidos, fecha_nacimiento, cedula, telefono, email, password, curso_id, monto, pagado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
        $stmt->bind_param(
            'sssssssii',
            $nombres,
            $apellidos,
            $fecha_nacimiento,
            $cedula,
            $telefono,
            $email,
            $password,  // <-- aquí va sin hash
            $curso_id,
            $valor
        );

        if ($stmt->execute()) {
            header('Location: comprobante.php');
            exit;
        } else {
            $mensaje = "Error al registrar: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registro</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<header class="login-header">
  <a href="index.php" class="logo"><img src="logo.png" alt="Logo" /></a>
  <h1 class="project-title">Nombre del proyecto</h1>
  <a href="index.php" class="btn-back">Regresar al inicio</a>
</header>

<div class="container">
  <h2>Registrarse como Estudiante</h2>
  <?php if ($mensaje): ?>
    <p style="color:red;"><?php echo htmlspecialchars($mensaje); ?></p>
  <?php endif; ?>

  <form method="post" action="registrar.php">
    <input name="nombres" placeholder="Nombres" required />
    <input name="apellidos" placeholder="Apellidos" required />
    <label>Fecha de nacimiento:</label>
    <input type="date" name="fecha_nacimiento" required />
    <input name="cedula" placeholder="Cédula" required />
    <input name="telefono" placeholder="Teléfono" required />
    <input type="email" name="email" placeholder="Correo" required />
    <input type="password" name="password" placeholder="Contraseña" required />

    <label>Selecciona un curso:</label>
    <select name="curso" required>
      <option value="">-- Selecciona --</option>
      <?php
      $result = $mysqli->query("SELECT id, nombre, valor FROM cursos");
      while ($curso = $result->fetch_assoc()) {
          echo "<option value='" . intval($curso['id']) . "'>" . htmlspecialchars($curso['nombre']) . " - $" . htmlspecialchars($curso['valor']) . "</option>";
      }
      ?>
    </select>

    <button type="submit">Registrarse e imprimir comprobante</button>
  </form>
</div>
</body>
</html>
