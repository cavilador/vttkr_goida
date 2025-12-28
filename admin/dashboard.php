<?php
// admin/dashboard.php - Панель управления в стиле ВТТКР
require_once '../config.php';
require_once '../functions.php';

if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

$articles = getAllArticles();
$totalArticles = count($articles);
$monthAgo = strtotime('-1 month');
$monthCount = 0;

foreach ($articles as $article) {
    if (strtotime($article['created_at']) > $monthAgo) {
        $monthCount++;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления - ВТТКР</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../karti/logo.ico">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <!-- Топбар -->
        <div class="topbar">
            <div class="topbar-left">
                <a href="../index.php" class="nav-btn">На сайт</a>
            </div>
            <div class="topbar-center">
                <a href="../index.php">
                    <img src="../karti/111.png" alt="Логотип ВТТКР" class="logo">
                </a>
            </div>
            <div class="topbar-right">
                <a href="logout.php" class="nav-btn" style="background-color: rgba(231, 76, 60, 0.8);">Выйти</a>
            </div>
        </div>
        
        <div class="main-title">
            <div class="section-title">Панель управления</div>
            <div class="section-subtitle">Телеканал ВТТКР - Управление контентом</div>
        </div>
        
        <div class="admin-nav">
            <a href="dashboard.php">Главная</a>
            <a href="create_article.php">Создать статью</a>
            <a href="articles_list.php">Все статьи</a>
        </div>
        
        <div class="admin-container">
            <!-- Статистика -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $totalArticles; ?></div>
                    <div class="stat-label">Всего статей</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $monthCount; ?></div>
                    <div class="stat-label">За месяц</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo count($articles) > 0 ? date('d.m.Y', strtotime($articles[0]['created_at'])) : 'Нет'; ?></div>
                    <div class="stat-label">Последняя статья</div>
                </div>
            </div>
            
            <!-- Быстрые действия -->
            <div style="text-align: center; margin: 40px 0;">
                <a href="create_article.php" class="btn-login" style="display: inline-block; width: auto; padding: 12px 40px; margin-right: 20px;">
                    + Создать статью
                </a>
                <a href="articles_list.php" class="nav-btn" style="padding: 12px 40px;">
                    Управление статьями
                </a>
            </div>
            
            <!-- Последние статьи -->
            <h2 style="color: #fff; margin-bottom: 20px; font-size: 24px;">Последние статьи</h2>
            <?php if ($articles): ?>
                <div style="background: rgba(255,255,255,0.05); border-radius: 12px; padding: 20px;">
                    <?php foreach (array_slice($articles, 0, 5) as $article): ?>
                        <div style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="color: #fff; font-weight: 500; margin-bottom: 5px;"><?php echo htmlspecialchars($article['title']); ?></div>
                                <div style="font-size: 12px; color: rgba(255,255,255,0.6);">
                                    <?php echo htmlspecialchars($article['author']); ?> • <?php echo date('d.m.Y', strtotime($article['created_at'])); ?>
                                </div>
                            </div>
                            <div>
                                <a href="../article.php?id=<?php echo $article['id']; ?>" target="_blank" style="color: #3498db; margin-right: 10px;">Просмотр</a>
                                <a href="create_article.php?edit=<?php echo $article['id']; ?>" style="color: #2ecc71; margin-right: 10px;">Редактировать</a>
                                <a href="delete_article.php?id=<?php echo $article['id']; ?>" onclick="return confirm('Удалить статью?')" style="color: #e74c3c;">Удалить</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; color: rgba(255,255,255,0.6);">
                    <p>Статей пока нет. Создайте первую!</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="footer">
            <p>© 2025 Телеканал "ВТТКР 1". Панель управления</p>
        </div>
    </div>
</body>
</html>