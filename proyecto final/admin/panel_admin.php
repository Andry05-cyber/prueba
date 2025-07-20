<?php 
include '../config.php'; 
session_start();

// Verificar si el usuario es admin
if ($_SESSION['rol'] !== 'admin') { 
    header('Location: ../index.php'); 
    exit; 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="logo">
            LOGO
        </div>
        <h2>Nombre del proyecto</h2>
        <nav>
            <div class="admin-user">
                <div class="user-button">👤 Usuario</div>
                <div class="admin-role">Modo administrador</div>
                <div class="dropdown-menu" style="display:block; margin-top:8px;">
                    <a href="editar_usuario.php">✏️ Editar perfil</a><br>
                    <a href="../index.php">🚪 Cerrar sesión</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container">
        <h2>Panel de Administración</h2>

        <div class="main-buttons" style="flex-direction: column; gap: 15px; max-width: 400px; margin: 0 auto;">
            <a href="estudiantes_admin.php" class="btn-main">Estudiantes</a>
            <a href="cursos_admin.php" class="btn-main">Cursos</a>
            <a href="noti_admin.php" class="btn-main">Notificaciones sobre problemas</a>
        </div>
    </main>

    <footer class="container" style="text-align:center; margin-top: 40px; color:#00ffd5;">
        Panel_admin.PHP
    </footer>
</body>
</html>
