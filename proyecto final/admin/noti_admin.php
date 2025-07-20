<?php 
include '../config.php'; 
session_start();

// Verificar si el usuario es admin
if ($_SESSION['rol'] !== 'admin') { 
    header('Location: ../index.php'); 
    exit; 
}

// Obtener las quejas
$res = $mysqli->query("SELECT q.id, u.nombres, q.queja, q.respuesta FROM quejas q JOIN usuarios u ON q.usuario_id=u.id");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Quejas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <a href="panel_admin.php">← Regresar</a>
    </header>
    <div class="container">
        <h2>Quejas y Reclamaciones</h2>
        <?php while ($q = $res->fetch_assoc()): ?>
            <div>
                <h4>De: <?= htmlspecialchars($q['nombres']) ?></h4>
                <p><?= htmlspecialchars($q['queja']) ?></p>
                <form method="post" action="noti_admin.php">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($q['id']) ?>">
                    <textarea name="respuesta" placeholder="Escribe respuesta..."><?= htmlspecialchars($q['respuesta']) ?></textarea>
                    <button>Enviar Respuesta</button>
                </form>
            </div>
            <hr>
        <?php endwhile; ?>
    </div>
</body>
</html>
