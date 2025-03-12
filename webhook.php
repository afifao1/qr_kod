<?php
declare(strict_types=1);

require 'vendor/autoload.php';

$dotenv=Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo (new \Controllers\Bot($_ENV['TOKEN']))->setWebhook($argv[1]);