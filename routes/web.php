<?php


use App\Libro;
use Illuminate\Http\Request;

//本ダッシュボード表示
Route::get('/','LibrosController@index');

//登録処理
Route::post('/libros','LibrosController@store');

//更新画面
Route::post('/librosedit/{libros}','LibrosController@edit');

//更新処理
Route::post('/libros/update','LibrosController@update');

//本を削除
Route::delete('/libro/{libro}','LibrosController@destroy');

//Auth
Auth::routes();

Route::get('/home', 'LibrosController@index')->name('home');
