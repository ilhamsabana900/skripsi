<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\AuthController;

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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [CrudController::class, 'dashboard']);
    Route::get('/dashboard', [CrudController::class, 'dashboard'])->name('dashboard');
    Route::resource('siswa', SiswaController::class);
    Route::post('siswa/import', [SiswaController::class, 'importExcel'])->name('siswa.import');
    Route::get('/siswa/download-template', [SiswaController::class, 'downloadTemplateSiswa'])->name('siswa.downloadTemplate');
    Route::resource('guru', GuruController::class);
    Route::resource('kelas', KelasController::class);
    Route::get('nilai/massal', [NilaiController::class, 'massal'])->name('nilai.massal');
    Route::post('nilai/massal-store', [NilaiController::class, 'storeMassal'])->name('nilai.massal.store');
    Route::get('nilai/rekap', [NilaiController::class, 'rekap'])->name('nilai.rekap');
    Route::resource('nilai', NilaiController::class);

    // Mapel web CRUD
    Route::get('mapel', [CrudController::class, 'indexMapelWeb'])->name('mapel.index');
    Route::get('mapel/create', [CrudController::class, 'createMapel'])->name('mapel.create');
    Route::post('mapel', [CrudController::class, 'storeMapelWeb'])->name('mapel.store');
    Route::get('mapel/{id}/edit', [CrudController::class, 'editMapel'])->name('mapel.edit');
    Route::put('mapel/{id}', [CrudController::class, 'updateMapelWeb'])->name('mapel.update');
    Route::delete('mapel/{id}', [CrudController::class, 'destroyMapelWeb'])->name('mapel.destroy');
    Route::post('admin/guru/{id}/reset-password', [GuruController::class, 'resetPassword']);
    Route::post('siswa/multi-delete', [SiswaController::class, 'multiDelete'])->name('siswa.multiDelete');
});

