<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'MoviesController@index')->name('movies.index');

Route::view('/', 'index')->name('movies.index');
Route::view('/movie', 'show')->name('movies.show');

Route::get('/tv/', function(){
	echo 'TV';
})->name('tv.index');;

Route::get('/actor', function(){
	echo 'Actor';
})->name('actors.index');
