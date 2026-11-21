<?php
declare(strict_types=1);

use App\Controllers\API\BlogApiController;


$router->get('/api/blog-categories', [BlogApiController::class, 'categories']);
$router->get('/api/blogs',           [BlogApiController::class, 'index']);
$router->get('/api/blogs/{id}',      [BlogApiController::class, 'show']);