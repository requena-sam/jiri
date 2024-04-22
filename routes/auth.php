<?php

/** @var Core\Router $router */

use App\Http\Controllers\Auth\AuthenticatedSessionController;

$router->get('/login', [AuthenticatedSessionController::class, 'create'])->only('guest');
$router->post('/login', [AuthenticatedSessionController::class, 'store'])->only('guest')->csrf();

$router->delete('/logout', [AuthenticatedSessionController::class, 'destroy'])->csrf();
