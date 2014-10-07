<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'ProductController@home'); // Home
Route::get('/q','ProductController@query');	// Query page


// testing 
Route::get('/test', 'ProductController@home'); 
Route::get('/data', 'ProductController@data'); // get the data for visualization




// BECOME ROUTES
Route::get('/become', 'ProductController@home'); // Home
Route::get('/become/q','ProductController@query');	// Query page

// DECIDO ROUTES
Route::get('/decido', 'DecidoController@home');
Route::get('/decido/q', 'DecidoController@query');
Route::get('/decido/data', 'DecidoController@data');

Route::get('/become/query', function(){
	echo URL::current();
});