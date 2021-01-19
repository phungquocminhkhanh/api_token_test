<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Events\sendMessage;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'testTokenController@login');
    Route::post('logout', 'testTokenController@logout');
    Route::post('refresh', 'testTokenController@refresh');
    Route::post('me', 'testTokenController@me');
    Route::post('loadpage', 'testTokenController@load_page');



});
Route::post('getdata_sudungtoken', 'testTokenController2@getdata_sudung_token');


