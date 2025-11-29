<?php

use App\Core\Router;
use App\Core\Request;

require __DIR__ . '/../bootstrap/app.php';

$router = new Router();

require __DIR__ . '/../routes/web.php';

$request = Request::capture();
$router->dispatch($request);

