<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'MoviesController@index')->name('movies.index');
Route::get('/movie/{movie}', 'MoviesController@show')->name('movies.show');


Route::get('/tv/', function(){
	echo 'TV';
})->name('tv.index');;

Route::get('/actor/{id}', function(){
	echo 'Actor';
})->name('actors.show');
Route::get('/actor', function(){
	echo 'Actor';
})->name('actors.index');
