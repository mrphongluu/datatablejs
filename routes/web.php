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
Route::get('/sss',[
 'uses'=>'DataController@product',
    'as'  =>'shop.product.product'
]);
Route::post('/dell',[
    'uses'=>'DataController@deleteUser',
    'as'  =>'shop.product.delete'
]);
Route::post('POstEdit')->uses('DataController@editPostUser')->name('shop.uses.editPost');
Route::post('POstCreate')->uses('DataController@Create')->name('shop.uses.Create');
Route::get('POstCreate/check-email')->uses('DataController@CheckEmail')->name('shop.uses.CheckEmail');


