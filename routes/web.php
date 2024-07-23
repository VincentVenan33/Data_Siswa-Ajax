<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', function () {
    $data = array();
    $data['title'] = "Login";
    return view('auth/login', $data);
})->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout');

/**
 * route resource siswa
 */
Route::resource('/home', App\Http\Controllers\HomeController::class)->middleware('auth');
Route::get('/filter-data', [App\Http\Controllers\HomeController::class, 'filterData'])->name('filterData');
Route::get('/alldata', [App\Http\Controllers\HomeController::class, 'alldata'])->name('alldata');
Route::resource('/siswa', App\Http\Controllers\SiswaController::class)->middleware('auth');
Route::resource('/guru', App\Http\Controllers\GuruController::class)->middleware('auth');
Route::resource('/kelas', App\Http\Controllers\KelasController::class)->middleware('auth');
Route::get('/carikelas', [App\Http\Controllers\KelasController::class, 'carikelas'])->middleware('auth');