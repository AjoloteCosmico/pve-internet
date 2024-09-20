<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuestrasController;

use App\Http\Controllers\Enc20Controller;
use App\Http\Controllers\CorreosController;
use App\Http\Controllers\EncuestasController;
/*
|--------------------------------------------------------------------------|
| Web Routes                                                               |
|--------------------------------------------------------------------------|
|                                                                          |
| Here is where you can register web routes for your application. These    |
| routes are loaded by the RouteServiceProvider and all of them will       |
| be assigned to the "web" middleware group. Make something great!         |
|__________________________________________________________________________|
*/

Route::controller(Enc20Controller::class)->group(function(){
    Route::get('/encuesta_generacion/{type}', 'inicio')->name('enc.inicio');
    Route::post('/verify_cuenta_2020',  'verify')->name('enc20.verify');
    Route::get('/encuesta2020/section/{id}/{section}',  'section')->name('enc20.section');
    Route::post('/update_personal_data/{id}', 'update_personal_data')->name('enc20.update_personal_data');
    Route::post('/update_section/{id}','update')->name('enc20.update');
});


Route::get('/', function () {
    return redirect(route('enc.inicio',[2020]));
});


Auth::routes();
Route::group(['middleware' => ['auth']], function()
{   
});