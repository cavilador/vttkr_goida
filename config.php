<?php
// config.php
session_start();

// Настройки системы
define('SITE_TITLE', 'Новостной портал');
define('ARTICLES_DIR', __DIR__ . '/news/');
define('UPLOADS_DIR', __DIR__ . '/uploads/');
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD_HASH', password_hash('admin123', PASSWORD_DEFAULT));

// Создаем директории, если их нет
if (!file_exists(ARTICLES_DIR)) mkdir(ARTICLES_DIR, 0777, true);
if (!file_exists(UPLOADS_DIR)) mkdir(UPLOADS_DIR, 0777, true);