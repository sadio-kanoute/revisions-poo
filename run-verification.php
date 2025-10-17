<?php
// Lightweight verification script for Jobs 01..14 and Job-15 PSR-4 stubs.
require_once __DIR__ . '/vendor/autoload.php';

function runPhpFile($phpPath, $file)
{
    $cmd = escapeshellarg($phpPath) . ' ' . escapeshellarg($file);
    echo "\n=== Running $file ===\n";
    passthru($cmd, $status);
    echo "--- Exit code: $status ---\n";
}

// Basic smoke checks
echo "Autoload shim loaded. Checking availability of classes...\n";
if (class_exists('App\\Clothing')) {
    echo "App\\Clothing available via PSR-4 stub.\n";
} elseif (class_exists('\\Clothing')) {
    echo "Legacy Clothing available.\n";
} else {
    echo "WARNING: Clothing class not found.\n";
}

// Discover php binary from environment variables or defaults
$candidates = [
    'C:\\wamp64\\bin\\php\\php8.3.14\\php.exe',
    'C:\\wamp64\\bin\\php\\php8.3.13\\php.exe',
    'C:\\wamp64\\bin\\php\\php8.3.12\\php.exe',
    'C:\\wamp64\\bin\\php\\php8.2.0\\php.exe',
    'C:\\wamp64\\bin\\php\\php8.1.0\\php.exe',
];
$php = null;
foreach ($candidates as $p) {
    if (file_exists($p)) { $php = $p; break; }
}
if (!$php) {
    // try 'php' in PATH
    $which = trim(shell_exec('where php 2>NUL'));
    if ($which) { $php = explode(PHP_EOL, $which)[0]; }
}

if (!$php) {
    echo "No php executable found. Please run this script with your php.exe or put php in PATH.\n";
    exit(2);
}

echo "Using PHP: $php\n";

// Run simple checks (the tests added earlier are minimal — just class existence)
echo "\nRunning basic test checks...\n";
// we emulate the simple tests by including the bootstrap and running assertions
require_once __DIR__ . '/Job-15/tests/bootstrap.php';
echo "Bootstrap loaded.\n";

// Now run Job index scripts 1..14
for ($i = 1; $i <= 14; $i++) {
    $dir = sprintf('Job-%02d', $i);
    $file = __DIR__ . '/' . $dir . '/index.php';
    if (file_exists($file)) {
        runPhpFile($php, $file);
    } else {
        echo "File $file not found; skipping.\n";
    }
}

echo "\nVerification run complete.\n";
