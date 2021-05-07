<?php

$app->group('/site', function ($app) {
    $app->get('/home', 'HomeController:home')->setName('site.home');
    $app->get('/category', 'HomeController:getCategoryProducts')->setName('site.category');
    $app->get('/product_detail', 'HomeController:getProductDetail')->setName('site.product-detail');
});


$app->group('/admin', function ($app) {
    $app->get('/main', 'PageAdminController:index')->setName('admin.main');

    $app->get('/users', 'PageAdminController:getUsers')->setName('admin.users');
    $app->map(['GET', 'POST'], '/create', 'PageAdminController:createUser')->setName('admin.user-create');
    $app->map(['GET', 'POST'], '/user/update/{id}', 'PageAdminController:updateUser')->setName('admin.user-update');
    $app->get('/user/delete', 'PageAdminController:deleteUser');
});


$app->group('/admin', function ($app) {
    $app->get('/categories', 'CategoryController:getCategories')->setName('admin.categories');
    $app->map(['GET', 'POST'], '/category/create', 'CategoryController:createCategory')->setName('admin.category-create');
    $app->map(['GET', 'POST'], '/category/update/{id}', 'CategoryController:updateCategory')->setName('admin.category-update');
    $app->get('/category/delete', 'CategoryController:deleteCategory');

    $app->get('/categories/products/{id}', 'CategoryController:getProductCategory')->setName('admin.categories-products');
});


$app->group('/admin', function ($app) {
    $app->get('/products', 'ProductController:getProducts')->setName('admin.products');
    $app->map(['GET', 'POST'], '/product/create', 'ProductController:createProduct')->setName('admin.product-create');
    $app->map(['GET', 'POST'], '/product/update/{id}', 'ProductController:updateProduct')->setName('admin.product-update');
    $app->get('/product/delete', 'ProductController:deleteProduct');

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
