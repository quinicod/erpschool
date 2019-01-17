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
    return view('auth/login');
});

Auth::routes();

Route::group(['middleware' => 'authVerify'], function(){

Route::get('/home', 'HomeController@index')->name('home');

//Empresas
Route::resource('companies', 'CompanyController');
//Estudiantes
Route::resource('students', 'StudentController');
//Ciclos
Route::resource('grades', 'GradeController');
Route::post('grades/addStudent/{id_g}', 'GradeController@addStudent')->name('addStudent');
Route::get('borrarAlumnoCurso/{id_c}/{id_a}', 'GradeController@borrarAlumnoCurso')->name('borrarAlumnoCurso');
//Solicitudes
Route::resource('petitions', 'PetitionController');
Route::post('petitions/f', 'PetitionController@filtroPetitions')->name('filtroPetitions');
Route::post('petitions/listadoPdf', 'PetitionController@listadoPdf')->name('listadoPdf');


});
