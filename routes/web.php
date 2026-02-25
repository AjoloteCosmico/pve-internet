<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuestrasController;

use App\Http\Controllers\Enc20Controller;
use App\Http\Controllers\PosgradoController;
use App\Http\Controllers\CorreosController;
use App\Http\Controllers\EncuestasController;
use App\Http\Controllers\Enc16Controller;
use App\Http\Controllers\EncContinuaController;
use App\Http\Controllers\EncContinuaEspecialidad;
use App\Http\Controllers\EncVerdeController;
use App\Http\Controllers\RedirectionController;
use App\Http\Controllers\TrackingController;
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
    Route::post('/verify_cuenta/{type}',  'verify')->name('enc20.verify');
    Route::get('/encuesta_seguimiento/section/{id}/{section}',  'section')->name('enc20.section');
    Route::post('/update_personal_data/{id}', 'update_personal_data')->name('enc20.update_personal_data');
    Route::post('/update_section/{id}','update')->name('enc20.update');
});
Route::controller(PosgradoController::class)->group(function(){
    Route::get('/encuesta_posgrado', 'inicio')->name('enc_posgrado.inicio');
    Route::post('/verify_cuenta_posgrado',  'verify')->name('enc_posgrado.verify');
    Route::get('/encuesta_posgrado/section/{id}/{section}',  'section')->name('enc_posgrado.section');
    Route::post('/update_personal_data_posgrado/{id}', 'update_personal_data')->name('enc_posgrado.update_personal_data');
    Route::post('/update_section_posgrado/{id}','update')->name('enc_posgrado.update');
});

Route::controller(Enc16Controller::class)->group(function(){
    Route::get('/encuesta_actualizacion/{type}', 'inicio')->name('enc16.inicio');
    Route::post('/verify_cuenta_2016', 'verify')->name('enc16.verify');
    Route::get('/encuesta_act/section/{id}/{section}', 'section')->name('enc16.section');
    Route::post('/update_personal_data_actualizacion/{id}', 'update_personal_data')->name('enc16.update_personal_data');
    Route::post('/update_section_actualizacion/{id}','update')->name('enc16.update');
});

Route::controller(EncContinuaController::class)->group(function(){
    Route::get('/encuesta_continua/{hash?}', 'inicio')->name('enc_continua.inicio');
    Route::post('/verify_cuenta_continua', 'verify')->name('enc_continua.verify');
    Route::get('/encuesta_continua/section/{id}/{section}', 'section')->name('enc_continua.section');
    Route::post('/update_personal_data_continua/{id}', 'update_personal_data')->name('enc_continua.update_personal_data');
    Route::post('/update_section_continua/{id}','update')->name('enc_continua.update');
});

Route::controller(EncContinuaEspecialidad::class)->group(function(){
    Route::get('/encuesta_especialidad/{hash?}', 'inicio')->name('enc_esp.inicio');
    Route::post('/verify_cuenta_esp', 'verify')->name('enc_esp.verify');
    Route::get('/encuesta_especialidad/section/{id}/{section}', 'section')->name('enc_esp.section');
    Route::post('/update_personal_data_esp/{id}', 'update_personal_data')->name('enc_esp.update_personal_data');
    Route::post('/update_section_esp/{id}','update')->name('enc_esp.update');
});

//Encuesta Egresados destacados
Route::get('/encuesta_destacados', [App\Http\Controllers\EncDestacadosController::class, 'index'])->name('enc_destacados.index');
Route::post('/encuesta_destacados_save', [App\Http\Controllers\EncDestacadosController::class, 'save'])->name('enc_destacados.save');

//Encuesta Cosas verdes de la DGOSE

Route::controller(EncVerdeController::class)->group(function(){
    Route::get('/encuesta_verde/inicio', 'inicio')->name('enc_verde.inicio');
    Route::post('/verify_cuenta_verde', 'verify')->name('enc_verde.verify');
    Route::get('/encuesta_verde/{section}/{id}', 'section')->name('enc_verde.section');
    Route::post('/update_personal_data_verde/{id}', 'update_personal_data')->name('enc_verde.update_personal_data');
    Route::post('/update_section_verde/{id}','update')->name('enc_verde.update');
});
//Rutas para redireccionar y contar
Route::controller(RedirectionController::class)->group(function(){
    Route::get('/pveaju/credencial', 'credencial')->name('redirect_to.credential');
});
//rutas para tracking
// routes/web.php

Route::get('/track/{emailUuid}', [TrackingController::class, 'track'])
    ->name('email.track')
    ->middleware('throttle:60,1'); // Limitar peticiones por seguridad

Route::get('/', function () {
    return redirect(route('enc.inicio',[2022]));
});

Auth::routes();
Route::group(['middleware' => ['auth']], function()
{   
});
