<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\NilaiController;

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
Route::post('siswa/import', [SiswaController::class, 'importExcel'])->name('siswa.import');
Route::resource('guru', GuruController::class);
Route::resource('kelas', KelasController::class);
Route::get('nilai/massal', [NilaiController::class, 'massal'])->name('nilai.massal');
Route::post('nilai/massal-store', [NilaiController::class, 'storeMassal'])->name('nilai.massal.store');
Route::get('nilai/rekap', [NilaiController::class, 'rekap'])->name('nilai.rekap');
Route::resource('nilai', NilaiController::class);

