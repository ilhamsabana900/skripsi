<?php

use App\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Admin
Route::get('admin', [CrudController::class, 'indexAdmin']);
Route::get('admin/{id}', [CrudController::class, 'showAdmin']);
Route::post('admin', [CrudController::class, 'storeAdmin']);
Route::put('admin/{id}', [CrudController::class, 'updateAdmin']);
Route::delete('admin/{id}', [CrudController::class, 'destroyAdmin']);

// Guru
Route::get('guru', [CrudController::class, 'indexGuru']);
Route::get('guru/{id}', [CrudController::class, 'showGuru']);
Route::post('guru', [CrudController::class, 'storeGuru']);
Route::put('guru/{id}', [CrudController::class, 'updateGuru']);
Route::delete('guru/{id}', [CrudController::class, 'destroyGuru']);

// Kelas
Route::get('kelas', [CrudController::class, 'indexKelas']);
Route::get('kelas/{id}', [CrudController::class, 'showKelas']);
Route::post('kelas', [CrudController::class, 'storeKelas']);
Route::put('kelas/{id}', [CrudController::class, 'updateKelas']);
Route::delete('kelas/{id}', [CrudController::class, 'destroyKelas']);

// Mapel
Route::get('mapel', [CrudController::class, 'indexMapel']);
Route::get('mapel/{id}', [CrudController::class, 'showMapel']);
Route::post('mapel', [CrudController::class, 'storeMapel']);
Route::put('mapel/{id}', [CrudController::class, 'updateMapel']);
Route::delete('mapel/{id}', [CrudController::class, 'destroyMapel']);

// Nilai
Route::get('nilai', [CrudController::class, 'indexNilai']);
Route::get('nilai/{id}', [CrudController::class, 'showNilai']);
Route::post('nilai', [CrudController::class, 'storeNilai']);
Route::put('nilai/{id}', [CrudController::class, 'updateNilai']);
Route::delete('nilai/{id}', [CrudController::class, 'destroyNilai']);

// Siswa
Route::get('siswa', [CrudController::class, 'indexSiswa']);
Route::get('siswa/{id}', [CrudController::class, 'showSiswa']);
Route::post('siswa', [CrudController::class, 'storeSiswa']);
Route::put('siswa/{id}', [CrudController::class, 'updateSiswa']);
Route::delete('siswa/{id}', [CrudController::class, 'destroySiswa']);

// User
Route::get('user', [CrudController::class, 'indexUser']);
Route::get('user/{id}', [CrudController::class, 'showUser']);
Route::post('user', [CrudController::class, 'storeUser']);
Route::put('user/{id}', [CrudController::class, 'updateUser']);
Route::delete('user/{id}', [CrudController::class, 'destroyUser']);

// Login
Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
