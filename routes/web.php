<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\JiriController;

/** @var Core\Router $router */
$router->get('/', [JiriController::class, 'index']);

$router->get('/jiris', [JiriController::class, 'index'])->only('auth');

$router->get('/jiri', [JiriController::class, 'show']);

$router->get('/jiri/create', [JiriController::class, 'create']);
$router->post('/jiri', [JiriController::class, 'store'])->csrf();

$router->get('/jiri/edit', [JiriController::class, 'edit']);
$router->patch('/jiri', [JiriController::class, 'update'])->csrf();


$router->delete('/jiri', [JiriController::class, 'destroy'])->csrf();

//Contact

$router->get('/contacts', [ContactController::class, 'index'])->only('auth');

$router->get('/contact', [ContactController::class, 'show']);

$router->get('/contact/create', [ContactController::class, 'create']);
$router->post('/contact', [ContactController::class, 'store'])->csrf();

$router->get('/contact/edit', [ContactController::class, 'edit']);
$router->patch('/contact', [ContactController::class, 'update'])->csrf();


$router->delete('/contact', [ContactController::class, 'destroy'])->csrf();

require __DIR__.'/auth.php';

