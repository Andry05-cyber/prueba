<?php 
include '../config.php'; 
session_start();

// Verificar si el usuario es estudiante
if ($_SESSION['rol'] !== 'estudiante') { 
    header('Location: ../index.php'); 
    exit; 
}

// Obtener calificaciones del estudiante
$res = $mysqli->query("SELECT * FROM calificaciones WHERE usuario_id=" . $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calificaciones</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Estilos específicos para la página de calificaciones */
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            color: #333;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
        }

        header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <header>
        <a href="panel_estudiante.php">← Regresar</a>
    </header>
    <div class="container">
        <h2>Mis Calificaciones</h2>
        <table>
            <tr>
                <th>Clase</th>
                <th>Act1</th>
                <th>Act2</th>
                <th>Act3</th>
                <th>Act4</th>
                <th>Prueba</th>
                <th>Final</th>
                <th>Nota Final</th>
            </tr>
            <?php while ($c = $res->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($c['clase']) ?></td>
                <td><?= htmlspecialchars($c['act1']) ?></td>
                <td><?= htmlspecialchars($c['act2']) ?></td>
                <td><?= htmlspecialchars($c['act3']) ?></td>
                <td><?= htmlspecialchars($c['act4']) ?></td>
                <td><?= htmlspecialchars($c['prueba']) ?></td>
                <td><?= htmlspecialchars($c['prueba_final']) ?></td>
                <td><?= htmlspecialchars($c['nota_final']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
