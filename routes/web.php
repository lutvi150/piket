<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AbsenGuruController;
use App\Http\Controllers\AbsenSiswaController;
use App\Http\Controllers\Api\AbsenSiswaController as ApiAbsenSiswaController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CheckAbsensiController;
use App\Http\Controllers\ControllerNotif;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PiketController;
use App\Http\Controllers\RekapPiketController;
use App\Http\Controllers\ReportPdf;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    $session = session()->get('data.role');
    // return response()->json($session);
    // if(is_array($session) && in_array('admin',$session)){
    if (is_array($session)) {
        return redirect()->to('admin');
    } else {
        return view('login');
    }
    // if (session()->get('data.role') == 'admin') {
    //     return redirect()->to('admin');
    // } elseif (session()->get('data.role') == 'guru') {
    //     return redirect()->to('guru');
    // } else {
    //     return view('login');
    // }
});
Route::view('template', 'layout.template');
// use for testing
// admin route
// Route::middleware(['auth', CheckRole::class . ':admin'])->prefix('admin')->group(function () {
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    // use for classroom
    // Route::get('kelas/data', [KelasController::class, 'index'])->name('kelas');
    Route::post('kelas/kelas-add', [KelasController::class, 'store'])->name('kelas-add');
    Route::get('kelas/{kelasModel}/edit', [KelasController::class, 'edit'])->name('kelas-edit');
    Route::get('kelas/kelas-delete/{id}', [KelasController::class, 'destroy'])->name('kelas-delete');

    // attendance
    // Route::post('absensi/buat-absensi', [GuruController::class, 'storeAttendance'])->name('admin-absensi-add');
    // Route::get('absensi/check-absensi/{id_kelas}/{id_absen}', [CheckAbsensiController::class, 'index'])->name('guru-check-absensi');
    // Route::delete('absensi/{absenModel}', [AbsenController::class, 'destroy'])->name('absen.destroy');
    // report
    // Route::get('absensi/laporan-bulanan/{bulan}/{tahun}/{id_kelas}', [ReportPdf::class, 'reportAbsen'])->name('guru-report-absensi');
    // Route::get('absensi/laporan-bulanan', [ReportPdf::class, 'reportAbsen'])->name('admin-absensi');
    // Route::get('absensi', [GuruController::class, 'absensi'])->name('admin-absensi');
});
// guru route
// Route::prefix('guru')->group(function () {
//     // Route::get('/', [AdminController::class, 'index'])->name('guru-dashboard');
//     Route::get('absensi', [GuruController::class, 'absensi'])->name('guru-absensi');
//     // make attendance
//     Route::get('absensi/buat-absensi/{id}', [GuruController::class, 'makeAttendance'])->name('guru-absensiweb');
//     Route::post('absensi/buat-absensi', [GuruController::class, 'storeAttendance'])->name('guru-absensi-add');
//     Route::get('absensi/check-absensi/{id_kelas}/{id_absen}', [CheckAbsensiController::class, 'index'])->name('guru-check-absensi');
//     Route::post('absensi/check-absensi', [CheckAbsensiController::class, 'store'])->name('guru-check-absensi-add');
//     // all attendance
//     Route::post('absensi/check-absensi-semua', [CheckAbsensiController::class, 'storeAll'])->name('guru-check-absensi-add-all');
//     // report
//     Route::get('absensi/laporan-bulanan/{bulan}/{tahun}/{id_kelas}', [ReportPdf::class, 'reportAbsen'])->name('guru-report-absensi');
// });
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('login', [LoginController::class, 'login'])->name('login');
// use for chart data
Route::get('count-data-chart', [AdminController::class, 'countDataChart'])->name('count-data-chart');
// costume for chart data
Route::get('chart-data', [ReportPdf::class, 'chartData'])->name('chart-data');
// post data chart
Route::post('chart-data-post', [ReportPdf::class, 'chartDataPost'])->name('chart-data-post');
// zenziva
Route::get('whatsapp/{phonenumber}', [ControllerNotif::class, 'sendMessageFonte'])->name('whatsapp');
Route::get('check-balance', [ControllerNotif::class, 'checkBalance'])->name('check-balance');
Route::post('send-message', [ControllerNotif::class, 'sendMessage'])->name('send-message');
// check barcode
Route::post('check-barcode/{bulan}/{tahun}', [ReportPdf::class, 'reportAbsen'])->name('check-barcode');
//  next route
Route::prefix('piket')->group(function () {
    Route::get('/', [PiketController::class, 'index'])->name('piket');
    Route::get('rekap-piket', [RekapPiketController::class, 'index'])->name('rekap-piket');
});
Route::prefix('guru')->group(function () {
    // use for teacher
    Route::get('/', [GuruController::class, 'index'])->name('guru');
    // Route::post('guru-add', [GuruController::class, 'store'])->name('guru-add');
    Route::get('guru-edit/{id}', [GuruController::class, 'edit'])->name('guru-edit');
    Route::get('guru-delete/{id}', [GuruController::class, 'destroy'])->name('guru-delete');
    // // teacher ajac
    // Route::get('api/guru/data', [GuruController::class, 'getGuru'])->name('get-guru');
    // Route::post('api/password/edit', [LoginController::class, 'changePassword'])->name('ubah-password');
});
Route::prefix('siswa')->group(function () {
    Route::get('/', [SiswaController::class, 'index'])->name('siswa');
    Route::post('siswa-add', [SiswaController::class, 'store'])->name('siswa-add');
    Route::get('siswa-edit/{id}', [SiswaController::class, 'edit'])->name('siswa-edit');
    Route::delete('siswa/{siswaModel}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
});
Route::prefix('mapel')->group(function () {
    Route::get('/', [MapelController::class, 'index'])->name('mapel');
    Route::post('mapel-add', [MapelController::class, 'store'])->name('mapel-add');
    Route::get('mapel-edit/{id}', [MapelController::class, 'edit'])->name('mapel-edit');
    Route::delete('mapel/{mapelModel}', [MapelController::class, 'destroy'])->name('mapel.destroy');
    Route::view('mapel-detail', 'mapel.jadwal_pelajaran')->name('mapel-detail');
});
Route::prefix('jadwal-piket')->group(function () {
    Route::get('/', [PiketController::class, 'index'])->name('jadwal-piket');
    Route::get('/{bulan}/{tahun}', [PiketController::class, 'piketDetail'])->name('piket.show');
    Route::get('add-jadwal-tahunan', [PiketController::class, 'addJadwalTahunan'])->name('piket.add-jadwal-tahunan');
});
Route::prefix('kelas')->group(function () {
    Route::get('/', [KelasController::class, 'index'])->name('kelas');
});
Route::prefix('pelanggaran')->group(function () {
    Route::get('/', [PelanggaranController::class, 'index'])->name('pelanggaran');
});
Route::prefix('absensi-siswa')->group(function () {
    Route::get('/', [AbsenSiswaController::class, 'index'])->name('absensi-siswa');
    Route::get('/start-absen/{id_absen}',[AbsenSiswaController::class, 'startAbsen']);
    Route::post('/', [AbsenSiswaController::class, 'store']);
});
Route::prefix('absensi-siswa-api')->group(function () {
    Route::get('/', [ApiAbsenSiswaController::class, 'index'])->name('absensi-siswa-api');
});
Route::prefix('absensi-guru')->group(function () {
    Route::get('/', [AbsenGuruController::class, 'index'])->name('absensi-guru');

});
