<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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
    return view('shortened');
});

 
Route::get('/login', function () {
    return view('login_view');
})->name('login');

Route::get('/register',                         'UserController@register');

Route::get('/logout',                                   'UserController@logout');


Route::get('/view_shortenedURLs',           'AdminController@view_shortenedURLs');
Route::post('/load_view_shortenedURLs',        'AdminController@load_view_shortenedURLs', function(Request $request){}); 
Route::post('/delete_shortenedURLs',        'AdminController@delete_shortenedURLs', function(Request $request){}); 
 
Route::post('ajax_login', 'UserController@ajax_login', function(Request $request){});

Route::post('/ajax_save_register',              'UserController@ajax_save_register', function(Request $request){});
Route::post('/check_duplicate',                 'UserController@check_duplicate', function(Request $request){});
 
Route::get('/shortened',                    'URLController@shortened');
Route::post('/create_shortened_url',        'URLController@create_shortened_url', function(Request $request){}); 
Route::get('/{code}',                       'URLController@redirectURL');



