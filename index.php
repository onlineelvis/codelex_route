<?php

require_once __DIR__ . '/vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $router) {
    $router->addRoute('GET', '/users', 'UsersController@index');
    $router->addRoute('GET', '/users/{id:\d+}', 'UsersController@show');

    $router->addRoute('GET', '/posts', 'PostController@index');
    $router->addRoute('GET', '/posts/{id:\d+}', 'PostController@show');

});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

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
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = explode('@', $handler);

        $controllerPath = '\App\Controller\\'.$controller;

            echo (new $controllerPath)->{$method}($vars);

        break;
}