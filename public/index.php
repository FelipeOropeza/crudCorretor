<?php

use Slim\Factory\AppFactory;

session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = AppFactory::create();

(require __DIR__ . '/../app/Routes/CorretorRoute.php')($app);


$app->run();