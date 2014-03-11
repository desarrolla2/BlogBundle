<?php

if (!is_file($autoloadFile = __DIR__ . '/../vendor/autoload.php')) {
    throw new \LogicException('Could not find autoload.php in vendor/. Did you run "composer install --dev"?');
}

$loader = require $autoloadFile;

// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__ . '/../vendor/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';
}

return $loader;
