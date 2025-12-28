<?php
// functions.php
require_once 'config.php';

// Функция для проверки авторизации
function isAdmin() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Функция для сохранения статьи
function saveArticle($data) {
    $id = uniqid('article_', true);
    $filename = ARTICLES_DIR . $id . '.json';
    
    $article = [
        'id' => $id,
        'title' => htmlspecialchars($data['title']),
        'content' => $data['content'],
        'excerpt' => htmlspecialchars($data['excerpt'] ?? ''),
        'author' => htmlspecialchars($data['author'] ?? 'Администратор'),
        'category' => htmlspecialchars($data['category'] ?? 'Общее'),
        'image' => $data['image'] ?? '',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'published' => true
    ];
    
    file_put_contents($filename, json_encode($article, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    return $id;
}

// Функция для получения всех статей
function getAllArticles($limit = null) {
    $articles = [];
    $files = glob(ARTICLES_DIR . '*.json');
    
    // Сортируем по дате создания (новые первые)
    usort($files, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });
    
    if ($limit) {
        $files = array_slice($files, 0, $limit);
    }
    
    foreach ($files as $file) {
        $content = file_get_contents($file);
        $article = json_decode($content, true);
        if ($article && ($article['published'] ?? true)) {
            $articles[] = $article;
        }
    }
    
    return $articles;
}

// Функция для получения одной статьи
function getArticle($id) {
    $filename = ARTICLES_DIR . $id . '.json';
    if (file_exists($filename)) {
        $content = file_get_contents($filename);
        return json_decode($content, true);
    }
    return null;
}

// Функция для удаления статьи
function deleteArticle($id) {
    $filename = ARTICLES_DIR . $id . '.json';
    if (file_exists($filename)) {
        // Удаляем связанное изображение
        $article = getArticle($id);
        if ($article && !empty($article['image'])) {
            $imagePath = UPLOADS_DIR . basename($article['image']);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        return unlink($filename);
    }
    return false;
}

// Функция для загрузки изображения
function uploadImage($file) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'Ошибка загрузки файла'];
    }
    
    if (!in_array($file['type'], $allowedTypes)) {
        return ['error' => 'Недопустимый тип файла'];
    }
    
    if ($file['size'] > $maxSize) {
        return ['error' => 'Файл слишком большой'];
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('img_', true) . '.' . $extension;
    $destination = UPLOADS_DIR . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => true, 'filename' => $filename];
    }
    
    return ['error' => 'Не удалось сохранить файл'];
}