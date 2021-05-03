<?php

$app->get('/', 'HomeController:index')->setName('home');

$app->group('/admin', function ($app) {
    $app->get('/main', 'PageAdminController:index')->setName('admin.main');
    $app->get('/users', 'PageAdminController:users')->setName('admin.users');
    $app->map(['GET', 'POST'], '/create', 'PageAdminController:create')->setName('admin.create');
    $app->get('/edit/{id}', 'PageAdminController:edit')->setName('admin.edit');
    $app->post('/edit/{id}', 'PageAdminController:update');
    $app->get('/delete', 'PageAdminController:delete');

});


$app->group('/auth', function ($app) {
    $app->map(['GET', 'POST'],'/login', 'AuthController:login')->setName('auth.login');
    $app->map(['GET', 'POST'], '/forgot', 'AuthController:forgot')->setName('auth.forgot');
});
















/*$app->group('/usuario', function ($app) {
    $app->map(['GET', 'POST'], '/avatar', 'UserController:avatar')->setName('user.avatar');
});


$app->group('/postagem', function ($app) {
    $app->map(['GET', 'POST'], '/criar', 'PostController:create')->setName('post.create');

    $app->get('/deletar', 'PostController:delete')->setName('post.delete');

    $app->get('/edit/{id}', 'PostController:edit')->setName('post.edit');
    $app->post('/edit/{id}', 'PostController:update');
})->add(new AuthMiddleware($container));


$app->group('/auth', function($app) {
    $app->map(['GET', 'POST'], '/login', 'AuthController:login')->setName('auth.login');
    $app->map(['GET', 'POST'], '/registrar', 'AuthController:register')->setName('auth.register');
    $app->get('/confirmacao', 'AuthController:confirmation');
    $app->get('/reenviar', 'AuthController:resend')->setName('auth.resend');
    $app->get('/logout', 'AuthController:logout')->setName('auth.logout');
});*/
