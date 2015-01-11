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

Route::get('/', 'TasksController@index');
Route::get('login', 'UsersController@login');
Route::get('tasks/quadrant/{quadrant}', 'TasksController@indexByQuadrant');
Route::resource('tasks', 'TasksController');

/* OAuth */
Route::get('/oauth/google', 'UsersController@googleOAuth');
