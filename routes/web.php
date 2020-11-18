<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/question/add','QuestionController@add_question')->name('add_question');
Route::post('/question/add','QuestionController@add_question')->name('add_question_post');
Route::get('/dashboard', 'HomeController@index')->name('home');
Route::resource('/question','QuestionController');
Route::resource('/choice','ChoiceController');
Route::get('/question/sort/{categories}','QuestionController@sort')->name('sort');
Route::get('/choice/create/{id}','ChoiceController@create_choice')->name('create_choice');
