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


Route::group(['prefix' => 'auth'], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('create','UserController@create');
});


Route::group(['prefix' => 'payment_BSA','namespace'=>'payment_BSA'], function ($router) {
    
    Route::get('products','productController@index')->name('products.all.show');
    Route::post('basket/products/{product}','BasketController@add')->name('basket.add.product');
    Route::get('basket','couponController@index')->name('basket.index');
    Route::post('coupon','couponController@store')->name('basket.store');
    Route::get('coupons','couponController@show')->name('basket.show');
    Route::delete('session/coupons','couponController@clear')->name('clear.session.coupon');
    Route::post('basket/coupon','couponController@add')->name('basket.add');
    Route::patch('basket/products/{product}/quantities/{quantity}','BasketController@update')->name('basket.product.update');
    Route::delete('basket/products/{product}','BasketController@remove')->name('basket.prosuct.remove');
    Route::delete('basket','BasketController@clear')->name('basket.prosuct.clear.all');
    Route::post('basket/checkout','BasketController@checkout')->name('basket.checkout');
    Route::post('payment/{gateway}/callback','PaymentController@verify')->name('payment.verify');
    Route::post('orders','OrdersController@index')->name('orders.index');
    Route::get('invoice/orders/{order}','InvoicesController@show')->name('invoice.orders.show');

});

