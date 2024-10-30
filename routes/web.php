<?php
//poner notas
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('template');
});

Route::view('/panel', 'panel.index')->name('panel');

Route::resource('categorias', App\Http\Controllers\categoriaController::class);

Route::resource('productos', App\Http\Controllers\ProductoController::class);

Route::resource('marcas', App\Http\Controllers\marcaController::class);

Route::resource('presentaciones', App\Http\Controllers\presentacioneController::class);

Route::view('/create','categoria.create');

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/401', function () {
    return view('pages.401');
});

Route::get('/404', function () {
    return view('pages.404');
});

Route::get('/500', function () {
    return view('pages.500');
});