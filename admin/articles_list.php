<?php
// admin/articles_list.php
require_once '../config.php';
require_once '../functions.php';

if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

$articles = getAllArticles();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление статьями</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
            font-weight: bold;
            color: #495057;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: top;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 0.9em;
        }
        .view { color: #3498db; }
        .edit { color: #2ecc71; }
        .delete { color: #e74c3c; }
        .article-title {
            font-weight: bold;
            color: #2c3e50;
        }
        .article-excerpt {
            color: #666;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>Управление статьями</h1>
        <a href="dashboard.php">Назад в панель</a>
    </div>
    
    <div class="admin-nav">
        <a href="dashboard.php">Главная</a>
        <a href="create_article.php">Создать статью</a>
        <a href="articles_list.php">Все статьи</a>
        <a href="logout.php" style="color: #e74c3c;">Выйти</a>
    </div>
    
    <div class="admin-container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Все статьи (<?php echo count($articles); ?>)</h2>
            <a href="create_article.php" class="btn">+ Новая статья</a>
        </div>
        
        <?php if ($articles): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 40%;">Статья</th>
                            <th>Автор</th>
                            <th>Дата</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article): ?>
                        <tr>
                            <td>
                                <div class="article-title"><?php echo htmlspecialchars($article['title']); ?></div>
                                <?php if (!empty($article['excerpt'])): ?>
                                    <div class="article-excerpt"><?php echo htmlspecialchars(substr($article['excerpt'], 0, 100)) . '...'; ?></div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($article['author']); ?></td>
                            <td><?php echo date('d.m.Y H:i', strtotime($article['created_at'])); ?></td>
                            <td class="actions">
                                <a href="../article.php?id=<?php echo $article['id']; ?>" target="_blank" class="view">Просмотр</a>
                                <a href="create_article.php?edit=<?php echo $article['id']; ?>" class="edit">Редактировать</a>
                                <a href="delete_article.php?id=<?php echo $article['id']; ?>" onclick="return confirm('Удалить статью?')" class="delete">Удалить</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p style="text-align: center; padding: 40px; color: #666;">Статей пока нет. <a href="create_article.php">Создайте первую!</a></p>
        <?php endif; ?>
    </div>
</body>
</html>