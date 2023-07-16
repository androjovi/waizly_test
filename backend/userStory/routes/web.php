<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\RegisterController;
//use App\Http\Controllers\LoginController;

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

Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => "logging"], function(){

    //Route::get('/register', [RegisterController::class, 'show']);
    //Route::get('/login', [LoginController::class, 'show']);

    /*
    * Register routes
    *
    */
    Route::get('/register', 'RegisterController@show')->name('register.show');
    Route::post('/register', 'RegisterController@register')->name('register.perform');
    Route::get('/registerVerify/{token}', 'RegisterController@registerVerify')->name('register.verify');

    /*
    * Login routes
    * 
    */

    Route::get('/login', 'LoginController@show')->name('login.show');
    Route::post('/login', 'LoginController@login')->name('login.perform');

    /*
    * Profile routes
    * 
    */
    Route::get('/profile', 'ProfileController@show')->name('profile.show');
    Route::post('/update', 'ProfileController@updatePhotoProfile')->name('profile.updatePhotoProfile');
    Route::post('/updateDetail', 'ProfileController@updateProfileDetail')->name('profile.updateProfileDetail');

    
    Route::get('/logout', 'LoginController@logout')->name('logout');    

    Route::group(['middleware' => ['auth']] , function() {
        /*
        * Logout routes
        *
        */
        Route::group(['middleware' => ['user.access']] , function() {
            Route::get('/product', 'ProductController@show')->name('product.show');
            /*
            * Order routes
            *
            */
            Route::get('/order', 'OrderController@show')->name('order.show');
            Route::get('/orderBuy/{idProduct}', 'OrderController@buyProduct')->name('order.buyProduct');
            Route::post('/orderBuy', 'OrderController@buyPerformProduct')->name('order.buyPerformProduct');
            Route::get('/orderPay/{idOrder}', 'OrderController@payPerformProduct')->name('order.payPerformProduct');
            Route::get('/orderCancel/{idOrder}', 'OrderController@cancelPerformProduct')->name('order.cancelPerformProduct');
            Route::get('/orderExport/{type}', 'OrderController@exportOrder2File')->name('order.exportOrder');
        });

        Route::group(['middleware' => ['admin.access']] , function() {
            /*
            * Product Admin routes
            *
            */
            Route::get('/productCreate', 'ProductController@makeProduct')->name('product.create');
            Route::post('/productCreate', 'ProductController@makePerformProduct')->name('product.makePerformProduct');
            Route::get('/productEdit/{idProduct}', 'ProductController@editProduct')->name('product.editProduct');
            Route::post('/productEdit', 'ProductController@editPerformProduct')->name('product.editPerformProduct');
            Route::get('/productDelete/{idProduct}', 'ProductController@deletePerformProduct')->name('product.deletePerformProduct');
            Route::get('/productList', 'ProductController@showListProduct')->name('product.showListProduct');
        });
        
    });
    

});