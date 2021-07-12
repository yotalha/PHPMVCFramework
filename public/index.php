<?php

use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\Application;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'userClass' => \app\models\User::class
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'contact']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/registerStudent', [AuthController::class, 'registerStudent']);
$app->router->post('/registerStudent', [AuthController::class, 'registerStudent']);
$app->router->get('/registerTeacher', [AuthController::class, 'registerTeacher']);
$app->router->post('/registerTeacher', [AuthController::class, 'registerTeacher']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->get('/profile', [AuthController::class, 'profile']);

$app->run();
