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
// CONFIGURACIÓN DEL BOT DE TELEGRAM
// =======================================================
$botToken = "8091801617:AAGJMm-X6qf4DJ0GBHYD01vdbiwbPt2H2pc";                 // Token de tu bot de Telegram (@BotFather)
$Mi_Id = "7476130153";                  // Tu ID de usuario de Telegram
$website = "https://api.telegram.org/bot" . $botToken;

// =======================================================
// CONFIGURACIÓN DE APIs EXTERNAS
// =======================================================
$google_translate_api = "";  // leave empty — using LibreTranslate by default (free)

// Translation provider: 'libretranslate' (free/no-key) or 'google' (key required)
$translate_provider = 'libretranslate';
$libretranslate_url = 'https://libretranslate.de/translate';

// =======================================================
// CONFIGURACIÓN DE PROXIES/VPNS
// =======================================================
$proxy_config = [
    'server' => '',
    'auth' => '',
    'type' => ''
];

// Public/free proxy list (may be unreliable). Code can pick one from this list.
$proxy_list = [
    'http://51.15.227.220:3128',
    'http://195.123.212.38:3128',
    'http://185.3.185.224:8080'
];

function getProxyList() {
    global $proxy_list;
    return $proxy_list;
}

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

function getTranslateProvider() {
    global $translate_provider;
    return $translate_provider;
}

function getLibreTranslateUrl() {
    global $libretranslate_url;
    return $libretranslate_url;
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
