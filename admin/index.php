<?php
// admin/index.php - Вход в админку в стиле ВТТКР
require_once '../config.php';
require_once '../functions.php';

if (isAdmin()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Неверное имя пользователя или пароль';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в админ-панель - ВТТКР</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../karti/logo.ico">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <div class="topbar">
            <div class="topbar-left">
                <a href="../index.php" class="nav-btn">На главную</a>
            </div>
            <div class="topbar-center">
                <a href="../index.php">
                    <img src="../karti/111.png" alt="Логотип ВТТКР" class="logo">
                </a>
            </div>
            <div class="topbar-right"></div>
        </div>
        
        <div class="main-title">
            <div class="section-title">Админ-панель</div>
            <div class="section-subtitle">Телеканал ВТТКР - Панель управления</div>
        </div>
        
        <div class="admin-login-container">
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Имя пользователя:</label>
                    <input type="text" name="username" required>
                </div>
                
                <div class="form-group">
                    <label>Пароль:</label>
                    <input type="password" name="password" required>
                </div>
                
                <button type="submit" class="btn-login">Войти</button>
            </form>
            
            <p style="text-align: center; margin-top: 20px; color: rgba(255,255,255,0.6);">
                Данные для входа: admin / admin123
            </p>
        </div>
        
        <div class="footer">
            <p>© 2025 Телеканал "ВТТКР 1". Все права защищены.</p>
        </div>
    </div>
</body>
</html>