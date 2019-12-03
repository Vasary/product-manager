<?php

declare(strict_types=1);

use Slim\App;
use Vasary\ProductManager\Controller\Product\CreateController;
use Vasary\ProductManager\Controller\Product\ListController;
use Vasary\ProductManager\Controller\Product\ReadController;
use Vasary\ProductManager\Controller\Product\RemoveController;
use Vasary\ProductManager\Controller\Product\UpdateController;

/**
 * @param App $app
 */
function routes(App $app): void
{
    $app->get('/products', ListController::class);
    $app->post('/product', CreateController::class);
    $app->get('/product/{id}', ReadController::class);
    $app->delete('/product/{id}', RemoveController::class);
    $app->put('/product/{id}', UpdateController::class);
}
