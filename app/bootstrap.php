<?php

use Slim\Http\{
    Environment,
    Uri
};

session_start();

date_default_timezone_set('America/Sao_Paulo');

require __DIR__ . '/./../vendor/autoload.php';

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'db_ecommerce',
            'username' => 'root',
            'password' => 'root',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ]
]);

/**
 * Instância o container.
 * Um container no slim é um array.
 */
$container = $app->getContainer();

$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();


/*$c = $app->getContainer();
$c['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $data = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => explode("\n", $exception->getTraceAsString()),
        ];

        return $c->get('response')->withStatus(500)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($data));
    };
};*/

/*$container['validator'] = function($container) {
    return new App\Validation\Validator;
};*/

$container['flash'] = function($container) {
    return new Slim\Flash\Messages;
};

$container['auth'] = function($container) {
    return new App\Auth\Auth($container);
};

$container['view'] = function($container) {
    $view = new Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
    ]);
    $router = $container->get('router');
    $uri = Uri::createFromEnvironment(new Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    $view->getEnvironment()->addGlobal('flash', $container->flash);

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user' => $container->auth->user()
    ]);

    return $view;
};

/**
 * @param $container -> key =  'HomeController', value = function($container)
 */
$container['HomeController'] = function($container) {
    return new App\Controllers\HomeController($container);
};

$container['PageAdminController'] = function($container) {
    return new App\Controllers\PageAdminController($container);
};

$container['AuthController'] = function($container) {
    return new App\Controllers\AuthController($container);
};

require __DIR__ . '/commons.php';

getControllers($container, [
    'HomeController',
    'AuthController',
    'PageAdminController']);

$app->add(new App\Middleware\DisplayInputErrorsMiddleware($container));

require __DIR__ . '/routes.php';