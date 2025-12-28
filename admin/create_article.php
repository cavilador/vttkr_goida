<?php
// admin/create_article.php - Создание статьи в стиле ВТТКР
require_once '../config.php';
require_once '../functions.php';

if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

$article = null;
$editMode = false;
$message = '';

if (isset($_GET['edit'])) {
    $article = getArticle($_GET['edit']);
    if ($article) {
        $editMode = true;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'excerpt' => $_POST['excerpt'],
        'author' => $_POST['author'],
        'category' => $_POST['category']
    ];
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadImage($_FILES['image']);
        if (isset($uploadResult['filename'])) {
            $data['image'] = $uploadResult['filename'];
        }
    } elseif ($editMode && $article && !empty($article['image'])) {
        $data['image'] = $article['image'];
    }
    
    if ($editMode && $article) {
        $article = array_merge($article, $data);
        $article['updated_at'] = date('Y-m-d H:i:s');
        file_put_contents(ARTICLES_DIR . $article['id'] . '.json', 
            json_encode($article, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        $message = "Статья обновлена успешно!";
    } else {
        $id = saveArticle($data);
        $message = "Статья создана успешно!";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $editMode ? 'Редактировать статью' : 'Создать статью'; ?> - ВТТКР</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../karti/logo.ico">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <!-- Топбар -->
        <div class="topbar">
            <div class="topbar-left">
                <a href="dashboard.php" class="nav-btn">← Назад в панель</a>
            </div>
            <div class="topbar-center">
                <a href="../index.php">
                    <img src="../karti/111.png" alt="Логотип ВТТКР" class="logo">
                </a>
            </div>
            <div class="topbar-right">
                <a href="../index.php" class="nav-btn">На сайт</a>
            </div>
        </div>
        
        <div class="main-title">
            <div class="section-title"><?php echo $editMode ? 'Редактировать статью' : 'Создать новость'; ?></div>
            <div class="section-subtitle">Телеканал ВТТКР - <?php echo $editMode ? 'Редактирование материала' : 'Создание нового материала'; ?></div>
        </div>
        
        <div class="form-container">
            <?php if ($message): ?>
                <div class="success-message"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Заголовок новости *</label>
                    <input type="text" id="title" name="title" required 
                           value="<?php echo htmlspecialchars($article['title'] ?? ''); ?>"
                           placeholder="Введите заголовок новости">
                </div>
                
                <div class="form-group">
                    <label for="content">Текст новости *</label>
                    <textarea id="content" name="content" required rows="10"
                              placeholder="Введите полный текст новости..."><?php echo htmlspecialchars($article['content'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="excerpt">Краткое описание (для анонса)</label>
                    <textarea id="excerpt" name="excerpt" rows="3"
                              placeholder="Краткое описание, которое будет отображаться в списке новостей"><?php echo htmlspecialchars($article['excerpt'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="author">Автор</label>
                        <input type="text" id="author" name="author" 
                               value="<?php echo htmlspecialchars($article['author'] ?? 'Редакция ВТТКР'); ?>"
                               placeholder="Имя автора">
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Категория</label>
                        <select id="category" name="category" style="width: 100%; padding: 12px; background-color: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; color: #fff;">
                            <option value="Новости" <?php echo ($article['category'] ?? '') == 'Новости' ? 'selected' : ''; ?>>Новости</option>
                            <option value="Ро-бизнес" <?php echo ($article['category'] ?? '') == 'Ро-бизнес' ? 'selected' : ''; ?>>Ро-бизнес</option>
                            <option value="Транспорт" <?php echo ($article['category'] ?? '') == 'Транспорт' ? 'selected' : ''; ?>>Транспорт</option>
                            <option value="Аналитика" <?php echo ($article['category'] ?? '') == 'Аналитика' ? 'selected' : ''; ?>>Аналитика</option>
                            <option value="Интервью" <?php echo ($article['category'] ?? '') == 'Интервью' ? 'selected' : ''; ?>>Интервью</option>
                            <option value="Спецпроект" <?php echo ($article['category'] ?? '') == 'Спецпроект' ? 'selected' : ''; ?>>Спецпроект</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="image">Изображение новости</label>
                    <input type="file" id="image" name="image" accept="image/*" style="color: #fff;">
                    
                    <?php if ($editMode && $article && !empty($article['image'])): ?>
                        <div class="image-preview">
                            <p style="color: rgba(255,255,255,0.7); margin-top: 10px;">Текущее изображение:</p>
                            <img src="../uploads/<?php echo $article['image']; ?>" alt="Изображение новости">
                        </div>
                    <?php endif; ?>
                </div>
                
                <div style="display: flex; gap: 20px; margin-top: 30px;">
                    <button type="submit" class="btn-submit">
                        <?php echo $editMode ? 'Обновить новость' : 'Опубликовать новость'; ?>
                    </button>
                    <a href="dashboard.php" class="nav-btn">Отмена</a>
                </div>
            </form>
        </div>
        
        <div class="footer">
            <p>© 2025 Телеканал "ВТТКР 1". Панель управления</p>
        </div>
    </div>
</body>
</html>