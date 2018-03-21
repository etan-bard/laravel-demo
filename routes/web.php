<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* According to the below link, this file more or less replaces routes.php which the guide mentions.
* https://stackoverflow.com/a/39313633
*/
Route::get('new_ticket', 'TicketsController@create');

Route::post('new_ticket', 'TicketsController@store');

Route::get('my_tickets', 'TicketsController@userTickets');

Route::get('tickets/{ticket_id}', 'TicketsController@show');

Route::post('comment', 'CommentsController@postComment');

// This will specify to use our AdminMiddleware before proceeding with the routing. */
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    Route::get('tickets', 'TicketsController@index');
    Route::post('close_ticket/{ticket_id}', 'TicketsController@close');
});