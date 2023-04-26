<?php

use App\Http\Controllers\CatalogoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Auth\RolController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\PermissionController;
use App\Http\Controllers\Auth\TrazaController;

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

    return redirect('/login');

});

Route::controller(LoginController::class)->group(function(){

    Route::get('login','index')->name('showlogin');

    Route::post('login','login')->name('login');
});


Route::get('perfil/edit/{message}',[LoginController::class,'edit_perfil'])->name('perfil.edit');

Route::resource('users',UserController::class)->except('show')->middleware('auth');

Route::controller(UserController::class)->middleware('auth')->group(function(){

    Route::get('usuarios/users','usuarios');

    Route::get('usuarios/clientes','clientes');

    Route::get('usuarios/mostrar_clientes','index_cliente')->name('users.index_cliente');

    Route::get('usuarios/mostrar_libros/{user}','libros_cliente')->name('mostrar.libros');
    
    Route::get('perfil/edit','edit_perfil')->name('perfil.edit');

    Route::put('perfil/update{user}','update_perfil')->name('perfil.update');

});

Route::get('login/registrar_cliente',[UserController::class, 'Mostrar_Registro_Cliente'])->name('resgistro.cliente');

Route::post('login/salvar_cliente',[UserController::class, 'Store_Cliente'])->name('salvar.cliente');


Route::controller(PermissionController::class)->middleware(['auth','can:rol.admin'])->group(function(){
    
    Route::get('permisos/perm','permisos')->name('permisos.show');

    Route::get('permisos','index')->name('permiso.index');

    Route::get('permisos/{role}','set_Rol')->name('permiso.setrol');

    Route::post('permisos','asignacion_permiso')->name('asigna.perm');

});

Route::get('libros/libro',[LibroController::class,'libros'])->middleware(['auth','can:rol.trab']);

Route::resource('libros',LibroController::class)->except('show')->middleware(['auth','can:rol.trab']);


Route::controller(CatalogoController::class)->group(function(){

    Route::get('catalogo','index')->name('catalogo.index');

    Route::get('catalogo/lib','libros_catalogo');

    Route::get('catalogo/{id}','add_solicitud_orden')->name('catalogo.select'); 
});

Route::controller(TrazaController::class)->group(function(){

    Route::get('trazas/tra','trazas')->name('datatable.traza');

    Route::get('trazas','index')->name('traza.index');
});

Route::controller(ReservaController::class)->middleware(['auth','can:rol.cli'])->group(function(){    

    Route::get('reserva','index')->name('reserva.index');

    Route::get('reserva/res','reservas_user');

    Route::get('reserva/devolver/{libro}','devolver_libro')->name('reserva.devolver');

});

Route::resource('roles',RolController::class)->except('show')->middleware('auth');

Route::get('role/rol',[RolController::class,'roles'])->middleware('auth');



//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

