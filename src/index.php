<?php

namespace silverorange\DevTest;

require __DIR__ . '/../vendor/autoload.php';

$config = new Config();
// Initialize database with Config
$database = new Database($config);
$db = $database->getConnection();

$app = new App($db);
return $app->run();
