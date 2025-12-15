<?php
// Root configuration file for Telegram Bot CC Checker
// Created automatically — replace placeholders with real values

// =======================================================
// CONFIGURACIÓN DE BASE DE DATOS
// =======================================================
// Database (filled from repository config)
define('DB_HOST', 'mysql-arturo.alwaysdata.net');
define('DB_USERNAME', 'arturo');
define('DB_PASSWORD', '15112003Aa!');
define('DB_NAME', 'arturo_dior');

// =======================================================
<?php
// Configuration loader. Keep secrets in `config.local.php` (ignored).

// If a local config exists, load it. Otherwise default to placeholders.
if (file_exists(__DIR__ . '/config.local.php')) {
    require __DIR__ . '/config.local.php';
}

// Default placeholders (used when not provided by config.local.php)
if (!defined('DB_HOST')) define('DB_HOST', 'YOUR_DATABASE_HOST');
if (!defined('DB_USERNAME')) define('DB_USERNAME', 'YOUR_DATABASE_USERNAME');
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', 'YOUR_DATABASE_PASSWORD');
if (!defined('DB_NAME')) define('DB_NAME', 'YOUR_DATABASE_NAME');

if (!isset($botToken)) $botToken = 'YOUR_BOT_TOKEN_HERE';
if (!isset($Mi_Id)) $Mi_Id = 'YOUR_TELEGRAM_USER_ID';
if (!isset($google_translate_api)) $google_translate_api = '';
if (!isset($translate_provider)) $translate_provider = 'libretranslate';
if (!isset($libretranslate_url)) $libretranslate_url = 'https://libretranslate.de/translate';
if (!isset($proxy_config)) $proxy_config = ['server' => '', 'auth' => '', 'type' => ''];
if (!isset($proxy_list)) $proxy_list = [];

if (!isset($authorized_chats)) $authorized_chats = [];
if (!isset($allowed_domains)) $allowed_domains = ['api.telegram.org', 'translation.googleapis.com'];

define('typing', 'typing');

if (!isset($log_config)) {
    $log_config = [
        'enable_logs' => true,
        'log_file' => __DIR__ . '/logs/bot.log',
        'error_log' => __DIR__ . '/logs/error.log'
    ];
}

function getDbConfig() {
    return [
        'host' => DB_HOST,
        'username' => DB_USERNAME,
        'password' => DB_PASSWORD,
        'database' => DB_NAME
    ];
}

function getProxyConfig() {
    global $proxy_config;
    return $proxy_config;
}

function getProxyList() {
    global $proxy_list;
    return $proxy_list;
}

function getGoogleTranslateApiKey() {
    global $google_translate_api;
    return $google_translate_api;
}

function isChatAuthorized($chat_id) {
    global $authorized_chats, $Mi_Id;
    return in_array($chat_id, $authorized_chats) || $chat_id == $Mi_Id;
}

function getBotToken() {
    global $botToken;
    return $botToken;
}

function getOwnerId() {
    global $Mi_Id;
    return $Mi_Id;
}

function getTranslateProvider() {
    global $translate_provider;
    return $translate_provider;
}

function getLibreTranslateUrl() {
    global $libretranslate_url;
    return $libretranslate_url;
}

?>

