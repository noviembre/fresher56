<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


#==============     REGISTER    =====================
Route::post('/register', 'RegisterController@register');

Route::group(['prefix' => 'topics'], function () {

    #======== topic index: cualquiera pueve ver
    Route::get('/', 'TopicController@index');

    #======== topic store: protegido
    Route::post('/', 'TopicController@store')->middleware('auth:api');


});
