<?php
// index.php - Главная страница в стиле ВТТКР
require_once 'config.php';
require_once 'functions.php';

$articles = getAllArticles(9); // Получаем 9 последних статей
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новости - Телеканал ВТТКР</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="karti/logo.ico">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Топбар -->
        <div class="topbar">
            <div class="topbar-left">
                <a href="index.php" class="nav-btn">Главная</a>
                <a href="about.php" class="nav-btn">О проекте</a>
            </div>
            
            <div class="topbar-center">
                <a href="index.php">
                    <img src="karti/111.png" alt="Логотип ВТТКР" class="logo">
                </a>
            </div>
            
            <div class="topbar-right">
                <a href="admin/" class="nav-btn">Админ-панель</a>
                <a href="staff.php" class="nav-btn">Сотрудники</a>
            </div>
        </div>
        
        <!-- Заголовок -->
        <div class="main-title">
            <div class="section-title">Новости ВТТКР</div>
            <div class="section-subtitle">Последние новости о ро-бизнесе и транспорте</div>
        </div>
        
        <!-- Сетка новостей -->
        <div class="container" style="background: none; box-shadow: none; margin: 0; padding: 30px;">
            <?php if ($articles): ?>
                <div class="articles-grid">
                    <?php foreach ($articles as $article): ?>
                        <div class="article-card" style="animation-delay: <?php echo $i * 0.1 + 0.5; ?>s;">
                            <?php if (!empty($article['image'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($article['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($article['title']); ?>" 
                                     class="article-image">
                            <?php else: ?>
                                <div style="background: rgba(255,255,255,0.1); height: 200px; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.5);">
                                    <span>Новость ВТТКР</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="article-content">
                                <div class="category-badge"><?php echo htmlspecialchars($article['category']); ?></div>
                                <h3 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h3>
                                
                                <div class="article-meta">
                                    <span>Автор: <?php echo htmlspecialchars($article['author']); ?></span>
                                    <span><?php echo date('d.m.Y', strtotime($article['created_at'])); ?></span>
                                </div>
                                
                                <?php if (!empty($article['excerpt'])): ?>
                                    <p class="article-excerpt"><?php echo htmlspecialchars($article['excerpt']); ?></p>
                                <?php endif; ?>
                                
                                <a href="article.php?id=<?php echo $article['id']; ?>" class="read-more">Читать далее</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 60px 20px; color: rgba(255,255,255,0.7);">
                    <h3 style="margin-bottom: 20px;">Новостей пока нет</h3>
                    <p>Скоро здесь появятся свежие новости о ро-бизнесе и транспорте!</p>
                </div>
            <?php endif; ?>
        </div>
        
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