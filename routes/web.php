<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// upload de archivos
Route::post('/upload', [App\Http\Controllers\User\FilesController::class, 'store'])->name('user.files.store');

// opcion "Mis archivos"
Route::get('/files', [App\Http\Controllers\User\FilesController::class, 'index'])->name('user.files.index');

// mostrar 1 archivo en especifico
Route::get('/file/{file}', [App\Http\Controllers\User\FilesController::class, 'show'])->name('user.files.show');

// eliminar un archivo
Route::delete('/delete-file/{file}', [App\Http\Controllers\User\FilesController::class, 'destroy'])->name('user.files.destroy');