<?php
declare(strict_types=1);
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "test";
require 'routes.php';

exit();

// require 'Views/view.php';

?>
