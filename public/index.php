<?php
define('SWALLOW_START', microtime(true));

use Config\Application;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/api.php';

$app = Application::getInstance();
$app->run();

