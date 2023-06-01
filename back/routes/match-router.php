<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProductTypeTaxRateController;

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('POST', '/login', AuthController::class . '/login');
    $r->addRoute('GET', '/auth', AuthController::class . '/auth');
    $r->addRoute('GET', '/refresh', AuthController::class . '/refreshToken');
    $r->addRoute('GET', '/products', ProductController::class . '/index');
    $r->addRoute('POST', '/products', ProductController::class . '/store');
    $r->addRoute('GET', '/product-types', ProductTypeController::class . '/index');
    $r->addRoute('POST', '/product-types', ProductTypeController::class . '/store');
    $r->addRoute('GET', '/product-type-tax-rates', ProductTypeTaxRateController::class . '/index');
    $r->addRoute('POST', '/product-type-tax-rates', ProductTypeTaxRateController::class . '/store');
    $r->addRoute('GET', '/sales', SaleController::class . '/index');
    $r->addRoute('POST', '/sales', SaleController::class . '/store');

    // {id} must be a number (\d+)
    //$r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
    // The /{title} suffix is optional
    //$r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri        = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo 'here2';
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        list($class, $method) = explode("/", $handler, 2);
        echo call_user_func_array(array(new $class, $method), $vars);
        break;
}