<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'auth'], function () use ($router){
    $router->post('/register','AuthController@register');
    $router->post('/login','AuthController@login');
});

$router->group(['middleware' => ['auth']], function () use ($router) {
    $router->get('posts', 'PostsController@index');
    $router->post('posts','PostsController@store');
    $router->get('posts/{id}', 'PostsController@show');
    $router->put('posts/{id}','PostsController@update');
    $router->delete('posts/{id}','PostsController@destroy');
    $router->get('posts/image/{imageName}', 'PostController@image');
    $router->get('posts/video/{videoName}', 'PostController@video');

    $router->post('profiles','ProfilesController@store');
});
//images/profiles
$router->get('/profiles/{userId}', 'ProfilesController@show');
$router->get('/profiles/image/{imageName}', 'ProfilesController@image');

$router->get('/public/posts','PublicController\PostsController@index');
$router->get('/public/posts/{id}','PublicController\PostsController@show');

//Student 
$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('student', 'StudentController@index');
    $router->post('student','StudentController@store');
    $router->get('student/{id}', 'StudentController@show');
    $router->put('student/{id}','StudentController@update');
    $router->delete('student/{id}','StudentController@destroy');
});