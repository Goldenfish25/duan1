<?php

use App\Core\Session;
use App\Core\View;
use App\Database\Connection;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$root = dirname(__DIR__);

if (file_exists($root . '/env.example') && !file_exists($root . '/.env')) {
    copy($root . '/env.example', $root . '/.env');
}

if (file_exists($root . '/.env')) {
    $dotenv = Dotenv::createImmutable($root);
    $dotenv->safeLoad();
}

date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'Asia/Ho_Chi_Minh');

Session::start();
View::setBasePath($root . '/src/Views');
Connection::boot([
    'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
    'port' => (int) ($_ENV['DB_PORT'] ?? 3306),
    'database' => $_ENV['DB_DATABASE'] ?? 'foodly',
    'username' => $_ENV['DB_USERNAME'] ?? 'root',
    'password' => $_ENV['DB_PASSWORD'] ?? '',
    'charset' => 'utf8mb4',
]);

