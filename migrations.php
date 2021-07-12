<?php


use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\Application;

require_once __DIR__ . '/vendor/autoload.php';
$config = ['userClass' => ''];


$app = new Application(__DIR__, $config);



$app->db->applyMigrations();
