<?php

use App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\PelanggaranController;
use App\Http\Controllers\Api\PiketController;
use App\Http\Controllers\Api\PiketTahunanController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\RekapPiketController;
use App\Http\Controllers\Api\AbsenSiswaController;
use App\Http\Controllers\Api\MapelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('admin')->group(function () {
    // Route::post('login',)
});
Route::prefix('kelas')->group(function () {
    Route::get('/', [KelasController::class, 'index']);
    Route::post('/', [KelasController::class, 'store']);
    Route::get('/{id}', [KelasController::class, 'show']);
    Route::put('/{id}', [KelasController::class, 'update']);
    Route::delete('/{id}', [KelasController::class, 'destroy']);
});
Route::prefix('mapel')->group(function () {
    Route::get('/', [MapelController::class, 'index']);
    Route::post('/', [MapelController::class, 'store']);
    Route::get('/{id}', [MapelController::class, 'show']);
    Route::put('/{id}', [MapelController::class, 'update']);
    Route::delete('/{id}', [MapelController::class, 'destroy']);
});
Route::prefix('siswa')->group(function () {
    Route::get('/', [SiswaController::class, 'index']);
    Route::post('/', [SiswaController::class, 'store']);
    Route::get('/search', [SiswaController::class, 'search']);
    Route::get('/{id}', [SiswaController::class, 'show']);
    Route::put('/{id}', [SiswaController::class, 'update']);
    Route::delete('/{id}', [SiswaController::class, 'destroy']);
});
Route::prefix('guru')->group(function () {
    Route::get('/search', [GuruController::class, 'search']);
    Route::get('/walikelas', [GuruController::class, 'getWaliKelas']);
    Route::get('/', [GuruController::class, 'index']);
    Route::post('/', [GuruController::class, 'store']);
    Route::get('/{id}', [GuruController::class, 'show']);
    Route::put('/{id}', [GuruController::class, 'update']);
    Route::delete('/{id}', [GuruController::class, 'destroy']);
    // role
    Route::post('/{id}/assign-role', [GuruController::class, 'assignRole']);
    Route::get('/{id}/roles', [GuruController::class, 'getRoles']);
});
Route::prefix('piket')->group(function () {
    Route::get('/', [PiketController::class, 'index']);
    Route::post('/', [PiketController::class, 'store'])->name('api-piket-add');
    Route::get('/{id}', [PiketController::class, 'show']);
    Route::put('/{id}', [PiketController::class, 'update']);
    Route::delete('/{id}', [PiketController::class, 'destroy']);
});
Route::prefix('dashboard')->group(function () {
    Route::get('/', [GuruController::class, 'dashboard']);
    Route::get('chart-siswa', [Dashboard::class, 'chartSiswa']);
});
Route::prefix('piket-tahunan')->group(function () {
    Route::get('/', [PiketTahunanController::class, 'index']);
    Route::post('/', [PiketTahunanController::class, 'store'])->name('api-piket-add');
    Route::get('/{id}', [PiketTahunanController::class, 'show']);
    Route::put('/{id}', [PiketTahunanController::class, 'update']);
    Route::delete('/{id}', [PiketTahunanController::class, 'destroy']);
    Route::post('/generate-piket-tahunan', [PiketTahunanController::class, 'generatePiketTahunan'])->name('api-piket-generate');
});
Route::prefix('pelanggaran')->group(function () {
    Route::get('/', [PelanggaranController::class, 'index']);
    Route::post('/', [PelanggaranController::class, 'store']);
    Route::get('/cetak', [PelanggaranController::class, 'cetak'])->name('pelanggaran.cetak');
    Route::get('/{id}', [PelanggaranController::class, 'show']);
    Route::put('/{id}', [PelanggaranController::class, 'update']);
    Route::delete('/{id}', [PelanggaranController::class, 'destroy']);
});
Route::prefix('rekap-piket')->group(function(){
    Route::get('/', [RekapPiketController::class, 'index']);
    Route::get('/print', [RekapPiketController::class, 'printRekap'])->name('rekap-piket.cetak');
    Route::post('/', [RekapPiketController::class, 'store']);
    Route::get('/{id}', [RekapPiketController::class, 'show']);
    Route::put('/{id}', [RekapPiketController::class, 'update']);
    Route::delete('/{id}', [RekapPiketController::class, 'destroy']);
});
Route::prefix('absensi-siswa')->group(function(){
    Route::get('/', [AbsenSiswaController::class, 'index']);
    Route::get('/check-absen/{id}',[AbsenSiswaController::class, 'checkAbsen']); 
    Route::get('/cetak-pdf/{id}',[AbsenSiswaController::class, 'cetakAbsen']);    
    Route::post('/check-absen',[AbsenSiswaController::class, 'storeAbsen']);
    Route::post('/', [AbsenSiswaController::class, 'store']);
    Route::get('/{id}', [AbsenSiswaController::class, 'show']);
    Route::put('/{id}', [AbsenSiswaController::class, 'update']);
    Route::delete('/{id}', [AbsenSiswaController::class, 'destroy']);
});
