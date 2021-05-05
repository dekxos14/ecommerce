<?php

$app->group('/site', function ($app) {
    $app->get('/home', 'HomeController:home')->setName('site.home');
    $app->get('/category', 'HomeController:getCategory')->setName('site.category.');
});


$app->group('/admin', function ($app) {
    $app->get('/main', 'PageAdminController:index')->setName('admin.main');

    $app->get('/users', 'PageAdminController:getUsers')->setName('admin.users');
    $app->map(['GET', 'POST'], '/create', 'PageAdminController:createUser')->setName('admin.user-create');
    $app->map(['GET', 'POST'], '/user/update/{id}', 'PageAdminController:updateUser')->setName('admin.user-update');
    $app->get('/user/delete', 'PageAdminController:deleteUser');

    $app->get('/categories', 'PageAdminController:getCategories')->setName('admin.categories');
    $app->map(['GET', 'POST'], '/category/create', 'PageAdminController:createCategory')->setName('admin.category-create');
    $app->map(['GET', 'POST'], '/category/update/{id}', 'PageAdminController:updateCategory')->setName('admin.category-update');
    $app->get('/category/delete', 'PageAdminController:deleteCategory');


});


$app->group('/admin', function ($app) {
    $app->get('/products', 'ProductController:getProducts')->setName('admin.products');
    $app->map(['GET', 'POST'], '/products/create', 'ProductController:createProduct')->setName('admin.product-create');
    $app->map(['GET', 'POST'], '/products/update/{id}', 'ProductController:updateProduct')->setName('admin.product-update');

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
