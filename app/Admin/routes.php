<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');


    $router->resource('users', 'UsersController', ['only' => ['index']]);

    $router->resource('productCategories', 'ProductCategoriesController', ['only' => ['index', 'create', 'edit', 'store', 'update', 'destroy']]);
    $router->resource('products', 'ProductsController', ['only' => ['index', 'create', 'edit', 'store', 'update', 'destroy']]);
    $router->resource('productCompanies', 'ProductCompaniesController', ['only' => ['index', 'create', 'edit', 'store', 'update', 'destroy']]);
    $router->get('productCategories/api/companies', 'ProductCategoriesController@apiGetCompanies')->name('productCategories.api.companies');

    $router->resource('feedback', 'FeedbackController', ['only' => ['index', 'show', 'destroy']]);

    $router->resource('articleCategories', 'ArticleCategoriesController', ['only' => ['index', 'create', 'edit', 'store', 'update', 'destroy']]);
    $router->resource('articles', 'ArticlesController', ['only' => ['index', 'create', 'edit', 'store', 'update', 'destroy']]);
});
