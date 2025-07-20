<?php 
include '../config.php';
session_start();

// Verificar si es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') { 
    header('Location: ../index.php'); 
    exit; 
}

// Mostrar errores (solo en desarrollo, no en producción)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Procesar búsqueda
$search = '';
$where = "WHERE u.rol = 'estudiante'";

if (!empty($_GET['search'])) {
    $search = $mysqli->real_escape_string($_GET['search']);
    $where .= " AND (
        u.nombres LIKE '%$search%' OR
        u.apellidos LIKE '%$search%' OR
        u.cedula LIKE '%$search%' OR
        u.email LIKE '%$search%'
    )";
}

// Consulta de estudiantes y curso
$query = "
    SELECT u.*, c.nombre AS nombre_curso, c.valor 
    FROM usuarios u
    LEFT JOIN cursos c ON u.curso_id = c.id
    $where
    ORDER BY u.id DESC
";

$estudiantes = $mysqli->query($query);

if (!$estudiantes) {
    die("Error en la consulta: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Estudiantes</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
    <h1>Administración de Estudiantes</h1>
    <nav>
        <a href="panel_admin.php">← Volver al Panel</a>
    </nav>
</header>

<div class="container">
    <div class="search-box">
        <form method="get">
            <input 
                type="text" 
                name="search" 
                placeholder="Buscar por nombre, cédula o email" 
                value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
            >
            <button type="submit">Buscar</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Cédula</th>
                <th>Teléfono</th>
                <th>Email</th>
                <!-- Se recomienda no mostrar contraseñas -->
                <th>Curso</th>
                <th>Valor</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($estudiantes->num_rows > 0): ?>
                <?php while($estudiante = $estudiantes->fetch_assoc()): ?>
                <tr>
                    <td><?= $estudiante['id'] ?></td>
                    <td><?= htmlspecialchars($estudiante['nombres']) ?></td>
                    <td><?= htmlspecialchars($estudiante['apellidos']) ?></td>
                    <td><?= htmlspecialchars($estudiante['cedula']) ?></td>
                    <td><?= htmlspecialchars($estudiante['telefono']) ?></td>
                    <td><?= htmlspecialchars($estudiante['email']) ?></td>
                    <td><?= htmlspecialchars($estudiante['nombre_curso'] ?? 'Sin asignar') ?></td>
                    <td>$<?= number_format($estudiante['valor'] ?? 0, 2) ?></td>
                    <td><?= $estudiante['activo'] ? 'Activo' : 'Inactivo' ?></td>
                    <td class="action-btns">
                        <a href="editar_estudiante.php?id=<?= $estudiante['id'] ?>" class="btn btn-edit">Editar</a>
                        <a href="eliminar_estudiante.php?id=<?= $estudiante['id'] ?>" class="btn btn-delete" onclick="return confirm('¿Estás seguro de eliminar este estudiante?')">Eliminar</a>
                        <a href="reset_password.php?id=<?= $estudiante['id'] ?>" class="btn btn-reset">Reset Pass</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="10">No se encontraron estudiantes.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
