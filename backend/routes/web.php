<?php
declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\BlogCategoryController;
use App\Controllers\BlogController;
use App\Controllers\ServiceCategoryController;
use App\Controllers\ServiceController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$router->get('/', fn() => redirect('/admin'));

$router->get('/admin/login', [AuthController::class, 'showLogin'], [GuestMiddleware::class]);
$router->post('/admin/login', [AuthController::class, 'login'], [GuestMiddleware::class]);
$router->post('/admin/logout', [AuthController::class, 'logout'], [AuthMiddleware::class]);

$router->get('/admin', [DashboardController::class, 'index'], [AuthMiddleware::class]);

$auth = [AuthMiddleware::class];

$router->get('/admin/blog-category',               [BlogCategoryController::class, 'index'], $auth);
$router->get('/admin/blog-category/data',          [BlogCategoryController::class, 'data'], $auth);
$router->get('/admin/blog-category/add',           [BlogCategoryController::class, 'create'], $auth);
$router->post('/admin/blog-category/add',          [BlogCategoryController::class, 'store'], $auth);
$router->get('/admin/blog-category/edit/{id}',     [BlogCategoryController::class, 'edit'], $auth);
$router->post('/admin/blog-category/edit/{id}',    [BlogCategoryController::class, 'update'], $auth);
$router->post('/admin/blog-category/status',       [BlogCategoryController::class, 'updateStatus'], $auth);
$router->post('/admin/blog-category/delete/{id}',  [BlogCategoryController::class, 'destroy'], $auth);

$router->get('/admin/blog',               [BlogController::class, 'index'], $auth);
$router->get('/admin/blog/data',          [BlogController::class, 'data'], $auth);
$router->get('/admin/blog/add',           [BlogController::class, 'create'], $auth);
$router->post('/admin/blog/add',          [BlogController::class, 'store'], $auth);
$router->get('/admin/blog/edit/{id}',     [BlogController::class, 'edit'], $auth);
$router->post('/admin/blog/edit/{id}',    [BlogController::class, 'update'], $auth);
$router->post('/admin/blog/status',       [BlogController::class, 'updateStatus'], $auth);
$router->post('/admin/blog/delete/{id}',  [BlogController::class, 'destroy'], $auth);

$router->get('/admin/service-category',               [ServiceCategoryController::class, 'index'], $auth);
$router->get('/admin/service-category/data',          [ServiceCategoryController::class, 'data'], $auth);
$router->get('/admin/service-category/add',           [ServiceCategoryController::class, 'create'], $auth);
$router->post('/admin/service-category/add',          [ServiceCategoryController::class, 'store'], $auth);
$router->get('/admin/service-category/edit/{id}',     [ServiceCategoryController::class, 'edit'], $auth);
$router->post('/admin/service-category/edit/{id}',    [ServiceCategoryController::class, 'update'], $auth);
$router->post('/admin/service-category/status',       [ServiceCategoryController::class, 'updateStatus'], $auth);
$router->post('/admin/service-category/delete/{id}',  [ServiceCategoryController::class, 'destroy'], $auth);

$router->get('/admin/service',               [ServiceController::class, 'index'], $auth);
$router->get('/admin/service/data',          [ServiceController::class, 'data'], $auth);
$router->get('/admin/service/add',           [ServiceController::class, 'create'], $auth);
$router->post('/admin/service/add',          [ServiceController::class, 'store'], $auth);
$router->get('/admin/service/edit/{id}',     [ServiceController::class, 'edit'], $auth);
$router->post('/admin/service/edit/{id}',    [ServiceController::class, 'update'], $auth);
$router->post('/admin/service/status',       [ServiceController::class, 'updateStatus'], $auth);
$router->post('/admin/service/delete/{id}',  [ServiceController::class, 'destroy'], $auth);