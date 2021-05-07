<?php

use Slim\Http\{
    Environment,
    Uri
};
use Twig\Extra\Intl\IntlExtension;

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


$container['upload_directory'] = "C:/xampp/htdocs/hcode-slim-3/public/images";

$container['validator'] = function($container) {
    return new App\Validation\Validator;
};

$container['flash'] = function($container) {
    return new Slim\Flash\Messages;
};

$container['auth'] = function($container) {
    return new App\Auth\Auth($container);
};

$container['mail'] = function($container) {
    return new App\Models\Mail($container);
};

$container['view'] = function($container) {
    $view = new Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
    ]);
    $router = $container->get('router');
    $uri = Uri::createFromEnvironment(new Environment($_SERVER));
    $twig = new IntlExtension();

    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));
    $view->addExtension(new IntlExtension());
    $view->getEnvironment()->addGlobal('flash', $container->flash);

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user' => $container->auth->user()
    ]);

    return $view;
};


$container['AuthController'] = function($container) {
    return new App\Controllers\AuthController($container);
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

$container['ProductController'] = function($container) {
    return new App\Controllers\ProductController($container);
};

$container['CategoryController'] = function($container) {
    return new App\Controllers\CategoryController($container);
};



require __DIR__ . '/commons.php';

getControllers($container, [
    'HomeController',
    'AuthController',
    'PageAdminController',
    'ProductController',
    'CategoryController']);

$app->add(new App\Middleware\DisplayInputErrorsMiddleware($container));

require __DIR__ . '/routes.php';