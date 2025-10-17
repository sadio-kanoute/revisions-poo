<?php
// Lightweight autoload shim for local development (when composer isn't run)
spl_autoload_register(function ($class) {
    // only handle App\ namespace
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../Job-15/src/';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $path = $base_dir . str_replace('\\', '/', $relative) . '.php';
    if (file_exists($path)) {
        require $path;
    }
});
