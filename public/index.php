<?php

define('APP_DIR', dirname(__DIR__));

require_once APP_DIR . '/vendor/autoload.php';

session_start();


use App\Router;
use App\Controllers\LoginController;
use App\Controllers\ChatController;

$router = new Router();

$router->get('/login', [LoginController::class, 'showLogin']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);
$router->get('/', [ChatController::class, 'showChat']);
$router->get('/api/messages', [ChatController::class, 'getMessages']);
$router->post('/api/messages', [ChatController::class, 'sendMessage']);
$router->delete('/api/messages/(\d+)', [ChatController::class, 'deleteMessage']);

$router->dispatch();