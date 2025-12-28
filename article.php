<?php
// article.php - Страница статьи в стиле ВТТКР
require_once 'config.php';
require_once 'functions.php';

$article = null;

if (isset($_GET['id'])) {
    $article = getArticle($_GET['id']);
}

if (!$article) {
    header('HTTP/1.0 404 Not Found');
    $error = "Статья не найдена";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $article ? htmlspecialchars($article['title']) : 'Статья не найдена'; ?> - ВТТКР</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="karti/logo.ico">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Топбар -->
        <div class="topbar">
            <div class="topbar-left">
                <a href="index.php" class="nav-btn">← Назад к новостям</a>
                <a href="about.php" class="nav-btn">О проекте</a>
            </div>
            
            <div class="topbar-center">
                <a href="index.php">
                    <img src="karti/111.png" alt="Логотип ВТТКР" class="logo">
                </a>
            </div>
            
            <div class="topbar-right">
                <a href="admin/" class="nav-btn">Админ-панель</a>
            </div>
        </div>
        
        <?php if ($article): ?>
            <div class="article-container">
                <div class="article-header">
                    <div class="category-badge" style="margin-bottom: 15px;"><?php echo $article['category']; ?></div>
                    <h1 class="article-full-title"><?php echo htmlspecialchars($article['title']); ?></h1>
                    
                    <div class="article-full-meta">
                        <span>Автор: <?php echo $article['author']; ?></span>
                        <span>Опубликовано: <?php echo date('d.m.Y H:i', strtotime($article['created_at'])); ?></span>
                        <?php if ($article['updated_at'] != $article['created_at']): ?>
                            <span>Обновлено: <?php echo date('d.m.Y H:i', strtotime($article['updated_at'])); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if (!empty($article['image'])): ?>
                    <img src="uploads/<?php echo $article['image']; ?>" 
                         alt="<?php echo htmlspecialchars($article['title']); ?>" 
                         class="article-full-image">
                <?php endif; ?>
                
                <div class="article-full-content">
                    <?php echo nl2br(htmlspecialchars($article['content'])); ?>
                </div>
                
                <a href="index.php" class="back-link">← Вернуться ко всем новостям</a>
            </div>
        <?php else: ?>
            <div class="main-title">
                <div class="section-title">404</div>
                <div class="section-subtitle">Статья не найдена</div>
            </div>
            
            <div style="text-align: center; padding: 40px 30px;">
                <p style="color: rgba(255,255,255,0.7); margin-bottom: 30px;">Запрошенная статья не найдена или была удалена.</p>
                <a href="index.php" class="nav-btn">Вернуться на главную</a>
            </div>
        <?php endif; ?>
        
        <!-- Футер -->
        <div class="footer">
            <p>© 2025 Телеканал "ВТТКР 1". Все права защищены.</p>
            <div class="social-links">
                <a href="https://t.me/vttkr" target="_blank" class="social-btn">
                    <img src="karti/telegram.png" alt="Telegram">
                </a>
                <a href="https://www.youtube.com/@vttkr" target="_blank" class="social-btn">
                    <img src="karti/youtube.png" alt="YouTube">
                </a>
                <a href="https://vk.com/gtrk_vttkr" target="_blank" class="social-btn">
                    <img src="karti/vk.png" alt="ВКонтакте">
                </a>
            </div>
        </div>
    </div>
</body>
</html>