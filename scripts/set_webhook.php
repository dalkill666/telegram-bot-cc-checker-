<?php
// Read tunnel output and set Telegram webhook
$cfg = __DIR__ . '/../config.local.php';
if (!file_exists($cfg)) {
    echo "config.local.php not found\n";
    exit(1);
}
include $cfg;

$out = @file_get_contents('/tmp/lt.out');
if (!preg_match('/https:\/\/[^
\s]+loca.lt/', $out, $m)) {
    echo "No tunnel URL found in /tmp/lt.out\n";
    exit(2);
}
$url = $m[0] . '/index.php';
if (empty($botToken)) {
    echo "Bot token missing in config.local.php\n";
    exit(3);
}
$api = "https://api.telegram.org/bot{$botToken}/setWebhook?url=" . urlencode($url);
echo "Setting webhook to: $url\n";
$res = @file_get_contents($api);
echo "Response: " . ($res===false?"(no response)":$res) . "\n";
// Also print getWebhookInfo
$info = @file_get_contents("https://api.telegram.org/bot{$botToken}/getWebhookInfo");
echo "getWebhookInfo: " . ($info===false?"(no response)":$info) . "\n";
