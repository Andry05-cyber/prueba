<?php 
include '../config.php'; 
session_start();

// Verificar si el usuario es admin
if ($_SESSION['rol'] !== 'admin') { 
    header('Location: ../index.php'); 
    exit; 
}

// Obtener la lista de cursos
$res = $mysqli->query("SELECT * FROM cursos");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cursos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <a href="panel_admin.php">← Regresar</a>
    </header>
    <div class="container">
        <h2>Gestión de Cursos</h2>
        <a href="#" onclick="document.getElementById('nuevo').style.display='block'">+ Nuevo Curso</a>
        <div id="nuevo" style="display:none;">
            <form method="post" action="cursos_admin.php">
                <input name="nombre" placeholder="Nombre del curso" required>
                <input type="number" name="horas" placeholder="Horas" required>
                <input type="number" step="0.01" name="valor" placeholder="Valor" required>
                <button>Crear</button>
            </form>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Curso</th>
                <th>Horas</th>
                <th>Valor</th>
                <th>Acciones</th>
            </tr>
            <?php while ($c = $res->fetch_assoc()): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= $c['nombre'] ?></td>
                <td><?= $c['horas'] ?></td>
                <td>$<?= $c['valor'] ?></td>
                <td><a href="#">Editar</a> | <a href="#">Eliminar</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
