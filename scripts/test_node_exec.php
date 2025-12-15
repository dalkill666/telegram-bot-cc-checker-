<?php
$script = __DIR__ . '/../Encryptions/src/middleware/encryptions/adyen.js';
$cmd = "node " . escapeshellarg($script) . " \"arg1\" \"arg2\" \"arg3\" \"arg4\" \"arg5\" \"arg6\" \"arg7\" \"arg8\" 2>&1";
echo "Running: $cmd\n";
$out = shell_exec($cmd);
echo "RAW OUTPUT:\n";
echo $out . "\n";
echo "JSON_DECODE TEST:\n";
$decoded = json_decode($out, true);
var_dump($decoded);
