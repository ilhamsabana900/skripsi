<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CrudController::class, 'dashboard']);

Route::get('/dashboard', [CrudController::class, 'dashboard'])->name('dashboard');
Route::resource('siswa', SiswaController::class);
Route::resource('guru', GuruController::class);

