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


// Show ALL users
$router->get('/users', 'AuthController@index');

// Show each user by ID
$router->get('/users/{id}', 'AuthController@show');

// Store users
$router->post('/users/create', 'AuthController@store');

// Update users by ID
$router->post('/users/update/{id}', 'AuthController@update');

// Delete users by ID
$router->delete('/users/delete/{id}', 'AuthController@destroy');

// User authentication 
$router->post('/users/login', 'AuthController@login');



// Show ALL categories
$router->get('/categories', 'CategoriesController@index');

// Show each category by ID
$router->get('/categories/{id}', 'CategoriesController@show');

// Store categories
$router->post('/categories/create', 'CategoriesController@store');

// Update categories 
$router->put('/categories/update/{id}', 'CategoriesController@update');

// Delete categories
$router->delete('/categories/delete/{id}', 'CategoriesController@destroy');



// Show ALL books
$router->get('/books', 'BooksController@index');

// Show each book by ID
$router->get('/books/{id}', 'BooksController@show');

// Store books
$router->post('/books/create', 'BooksController@store');

// Update books
$router->post('/books/update/{id}', 'BooksController@update');

// Delete books
$router->delete('/books/delete/{id}', 'BooksController@destroy');

// Upload file 
$router->post('/upload', 'FileController@upload');

$router->get('/', function () use ($router) {
    return 'hi';
});


// <?php

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

