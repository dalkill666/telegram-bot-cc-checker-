<?php
include __DIR__ . '/../Encryptions/Encryptions_Adyen.php';

$encryption = new Encryptions();
$encryption->setData([
    "adyenkey" => "10001|ABC",
    "card" => '4381086433445236',
    "month" => '11',
    "year" => '2025',
    "cvv" => '322',
]);
$encryption->setAdyenVersion('v2');
$encryption->execute();

$ref = new ReflectionClass($encryption);
$prop = $ref->getProperty('response');
$prop->setAccessible(true);
$raw = $prop->getValue($encryption);

echo "RAW RESPONSE:\n";
echo $raw . "\n";
echo "JSON ERR: ".json_last_error_msg()."\n";
$decoded = json_decode($raw, true);
var_dump($decoded);
