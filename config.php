<?php
// Root configuration file for Telegram Bot CC Checker
// Created automatically — replace placeholders with real values

// =======================================================
// CONFIGURACIÓN DE BASE DE DATOS
// =======================================================
define('DB_HOST', 'YOUR_DATABASE_HOST');
define('DB_USERNAME', 'YOUR_DATABASE_USERNAME');
define('DB_PASSWORD', 'YOUR_DATABASE_PASSWORD');
define('DB_NAME', 'YOUR_DATABASE_NAME');

// =======================================================
// CONFIGURACIÓN DEL BOT DE TELEGRAM
// =======================================================
$botToken = "YOUR_BOT_TOKEN_HERE";                 // Token de tu bot de Telegram (@BotFather)
$Mi_Id = "YOUR_TELEGRAM_USER_ID";                  // Tu ID de usuario de Telegram
$website = "https://api.telegram.org/bot" . $botToken;

// =======================================================
// CONFIGURACIÓN DE APIs EXTERNAS
// =======================================================
$google_translate_api = "YOUR_GOOGLE_TRANSLATE_API_KEY";  // API Key de Google Cloud Translate

// =======================================================
// CONFIGURACIÓN DE PROXIES/VPNS
// =======================================================
$proxy_config = [
    'server' => 'YOUR_PROXY_SERVER',
    'auth' => 'YOUR_PROXY_USERNAME:YOUR_PROXY_PASSWORD',
    'type' => 'SOCKS5'
];

// =======================================================
// CONFIGURACIÓN DE SEGURIDAD
// =======================================================
$authorized_chats = [
    // 'YOUR_TELEGRAM_USER_ID',
    // '-1001234567890',
];

$allowed_domains = [
    'api.telegram.org',
    'translation.googleapis.com',
];

define('typing', 'typing');

$log_config = [
    'enable_logs' => true,
    'log_file' => __DIR__ . '/logs/bot.log',
    'error_log' => __DIR__ . '/logs/error.log'
];

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

?>
