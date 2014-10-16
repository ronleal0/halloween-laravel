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
Route::get('/', 'ProductController@jsonHome'); 
Route::get('/become/data', 'ProductController@data'); // get the data for visualization




// BECOME ROUTES
Route::get('/become', 'ProductController@home'); // Home
Route::get('/become/q','ProductController@query');	// Query page

// DECIDO ROUTES
Route::get('/decido', 'DecidoController@home');
Route::get('/decido/q', 'DecidoController@query');
Route::get('/decido/data', 'DecidoController@data');

Route::get('/become/static', function(){
	$gclid = (Input::get('gclid')) ? Input::get('gclid') : false;
	$merchant = (Input::get('mer')) ? Input::get('mer') : '';
	$json = (Input::get('cat')) ? Input::get('cat') : '';
	return View::make('angular')->with('json',$json)
	->with('merchant', $merchant)
	->with('gclid', $gclid);
});


Route::get('/ron', function(){
	$query = 'bag';
	$results = Toolbox::getResultingJSON($query,3);
	$filter = $results['resultFilterModule']['resultFilter'][0]['filterDimension'][0]['dimensionClass'];
	$products = $results['productResultsModule']['productResults']['product'];
	$popular = $results['popularProductsModule']['popularProducts']['product'];
	return $popular;
});