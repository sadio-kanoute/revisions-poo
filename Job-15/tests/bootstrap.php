<?php
// try composer autoload first
$autoload = __DIR__ . '/../../vendor/autoload.php';
if (file_exists($autoload)) {
    require $autoload;
} else {
    // fallback: require legacy files used by stubs
    require_once __DIR__ . '/../../Job-01/Product.php';
    require_once __DIR__ . '/../../Job-02/Category.php';
    require_once __DIR__ . '/../../Job-11/Clothing.php';
    require_once __DIR__ . '/../../Job-11/Electronic.php';
}
