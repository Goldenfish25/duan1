<?php

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\CartController;
use App\Controllers\FoodController;
use App\Controllers\HomeController;
use App\Controllers\OrderController;
use App\Controllers\PasswordController;
use App\Core\Router;

/** @var Router $router */

$router->get('/', [HomeController::class, 'index']);
$router->get('/menu', [FoodController::class, 'index']);
$router->get('/foods/{id}', [FoodController::class, 'show']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/forgot-password', [PasswordController::class, 'showForgot']);
$router->post('/forgot-password', [PasswordController::class, 'sendLink']);
$router->get('/reset-password', [PasswordController::class, 'showReset']);
$router->post('/reset-password', [PasswordController::class, 'reset']);

$router->get('/cart', [CartController::class, 'index']);
$router->post('/cart/add', [CartController::class, 'add']);
$router->post('/cart/update', [CartController::class, 'update']);
$router->post('/cart/remove', [CartController::class, 'remove']);

$router->get('/checkout', [OrderController::class, 'checkout']);
$router->post('/checkout', [OrderController::class, 'placeOrder']);
$router->get('/orders', [OrderController::class, 'index']);
$router->get('/orders/{id}', [OrderController::class, 'show']);

$router->group('/admin', function (Router $router) {
    $router->get('', [AdminController::class, 'dashboard']);

    $router->get('/foods', [AdminController::class, 'foods']);
    $router->get('/foods/create', [AdminController::class, 'createFood']);
    $router->post('/foods', [AdminController::class, 'storeFood']);
    $router->get('/foods/{id}/edit', [AdminController::class, 'editFood']);
    $router->post('/foods/{id}', [AdminController::class, 'updateFood']);
    $router->post('/foods/{id}/delete', [AdminController::class, 'deleteFood']);

    $router->get('/orders', [AdminController::class, 'orders']);
    $router->post('/orders/{id}/status', [AdminController::class, 'updateOrderStatus']);
});

