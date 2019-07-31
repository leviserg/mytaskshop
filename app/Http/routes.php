<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/','MainController@index');
Route::post('/new','MainController@insert');
Route::get('/new','MainController@newrec');
Route::get('/{id}','MainController@getsingle');
Route::get('/buf/{id}','MainController@getParams');
Route::post('/{id}','MainController@store');
Route::get('/main/getdata', 'MainController@getdata')->name('main.getdata');
