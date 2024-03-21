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
Route::get('/encuesta_generacion2020', [App\Http\Controllers\Enc20Controller::class, 'inicio'])->name('enc20.inicio');
Route::post('/verify_cuenta_2020', [App\Http\Controllers\Enc20Controller::class, 'verify'])->name('enc20.verify');
Route::get('/encuesta2020/section/{id}/{section}', [App\Http\Controllers\Enc20Controller::class, 'section'])->name('enc20.section');
Route::post('/update_personal_data/{id}', [App\Http\Controllers\Enc20Controller::class, 'update_personal_data'])->name('enc20.update_personal_data');
Route::post('/update_section/{id}', [App\Http\Controllers\Enc20Controller::class, 'update'])->name('enc20.update');

Route::get('/', function () {
    return redirect(route('login'));
});
Auth::routes();
Route::group(['middleware' => ['auth']], function()
{   

});