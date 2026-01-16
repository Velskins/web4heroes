<?php

use App\Controllers\{AuthController, CategoryController, IncidentController, ProductController};
use App\Controllers\HomeController;
use App\Core\Router;

return function (Router $router) {
    $router->get('/', [HomeController::class, 'index']);

    $router->get('/login', [AuthController::class, 'showLogin']);
    $router->post('/login', [AuthController::class, 'login']);
    $router->post('/logout', [AuthController::class, 'logout']);

    $router->get('/incident', [IncidentController::class, 'index']);
    $router->get('/incident/show', [IncidentController::class, 'show']);
    $router->get('/incident/create', [IncidentController::class, 'create']);
    $router->post('/incident/store', [IncidentController::class, 'store']);
    $router->get('/incident/edit', [IncidentController::class, 'edit']);
    $router->post('/incident/update', [IncidentController::class, 'update']);
    $router->post('/incident/delete', [IncidentController::class, 'delete']);




    /* EXEMPLE
    $router->get('/products', [ProductController::class, 'index']);
    $router->get('/products/show', [ProductController::class, 'show']);
    $router->get('/products/create', [ProductController::class, 'create']);
    $router->post('/products/store', [ProductController::class, 'store']);
    $router->get('/products/edit', [ProductController::class, 'edit']);
    $router->post('/products/update', [ProductController::class, 'update']);
    $router->post('/products/delete', [ProductController::class, 'delete']);
    $router->get('/products/category', [ProductController::class, 'findByCategory']);

    $router->get('/categories', [CategoryController::class, 'index']);
    $router->get('/categories/create', [CategoryController::class, 'create']);
    $router->post('/categories/store', [CategoryController::class, 'store']);
    $router->get('/categories/edit', [CategoryController::class, 'edit']);
    $router->post('/categories/update', [CategoryController::class, 'update']);
    $router->post('/categories/delete', [CategoryController::class, 'delete']);
    */
};
