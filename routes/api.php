<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('files/upload', 'Controller@upload', [
    'as' => 'files.upload',
    'middleware' => ['auth:sanctum'],
]);
Route::group(['prefix' => 'use'], function ($router) {
    $router->get('wechat', 'AppController@wechat');

    $router->post('openid', 'AppController@openid');
    $router->post('bind', 'AppController@bind');
});
Route::group(['middleware' => ['auth:sanctum']], function ($router) {
    $router->resource('test', 'TestController');
    $router->post('use/unbind', 'AppController@unbind');

    $router->get('setting_get/{key}', 'AppController@settingGet');
    $router->post('setting_set', 'AppController@settingSet');
    $router->delete('setting_del/{key}', 'AppController@settingDel');

    $router->get('category/tree', 'CategoryController@tree');
    $router->resources([
        'category' => 'CategoryController',
        'article' => 'ArticleController',
        'slider_group' => 'SliderGroupController',
        'slider' => 'SliderController',
    ]);

});
