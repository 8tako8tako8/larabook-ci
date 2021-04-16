<?php
use App\Book;
use Illuminate\Http\Request; 

//Auth
Auth::routes();

//本登録・ダッシュボード表示
Route::get('/', 'BookController@index')->name('books.index');

//本検索処理
Route::post('/books/search','BookController@search')->name('books.search');

//登録処理
Route::post('/books','BookController@store')->name('books.store');

//更新画面
Route::post('/booksedit/{books}','BookController@edit')->name('books.edit');

//更新処理
Route::post('/books/update','BookController@update')->name('books.update');

//本を削除
Route::delete('/book/{book}','BookController@destroy')->name('books.destroy');

Route::get('/home', 'BookController@index')->name('home'); 

//新着リスト表示
Route::get('/newlist', 'NewListController@index')->name('newlist.index');