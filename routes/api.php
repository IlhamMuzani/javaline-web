<?php

use App\Http\Controllers\Api\PengambilandoController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\KendaraanController;
use App\Models\Pengambilan_do;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Driver\Driver;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('driver/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('driver/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::get('driver-detail/{id}', [\App\Http\Controllers\Api\AuthController::class, 'detail']);

Route::get('list-kendaraanall', [\App\Http\Controllers\Api\KendaraanController::class, 'listAll']);
Route::get('list-kendaraan/{id}', [\App\Http\Controllers\Api\KendaraanController::class, 'list']);
Route::post('kendaraan-search', [KendaraanController::class, 'kendaraan_search']);
Route::get('kendaraan-detail/{id}', [KendaraanController::class, 'detail']);
Route::post('kendaraan-update/{id}', [KendaraanController::class, 'update']);
Route::get('kendaraan-detailken/{id}', [\App\Http\Controllers\Api\DriverController::class, 'kendaraan_detail']);
Route::get('karyawan-detailkaryawan/{id}', [\App\Http\Controllers\Api\DriverController::class, 'karyawan_detail']);
Route::post('karyawan-u_profile/{id}', [\App\Http\Controllers\Api\DriverController::class, 'update_profile']);
Route::post('karyawan-u_password/{id}', [\App\Http\Controllers\Api\DriverController::class, 'update_password']);

Route::post('kendaraan-tunggumuat/{id}', [\App\Http\Controllers\Api\DriverController::class, 'tunggu_muat']);
Route::post('kendaraan-loadingmuat/{id}', [\App\Http\Controllers\Api\DriverController::class, 'loading_muat']);
Route::post('kendaraan-perjalananisi/{id}', [\App\Http\Controllers\Api\DriverController::class, 'perjalanan_isi']);
Route::post('kendaraan-tunggubongkar/{id}', [\App\Http\Controllers\Api\DriverController::class, 'tunggu_bongkar']);
Route::post('kendaraan-loadingbongkar/{id}', [\App\Http\Controllers\Api\DriverController::class, 'loading_bongkar']);
Route::post('kendaraan-perjalanankosong/{id}', [\App\Http\Controllers\Api\DriverController::class, 'perjalanan_kosong']);
Route::post('kendaraan-kosong/{id}', [\App\Http\Controllers\Api\DriverController::class, 'kosong']);
Route::post('kendaraan-perbaikandijalan/{id}', [\App\Http\Controllers\Api\DriverController::class, 'perbaikan_dijalan']);
Route::post('kendaraan-perbaikandigarasi/{id}', [\App\Http\Controllers\Api\DriverController::class, 'perbaikan_digarasi']);
Route::get('list-pelanggan', [\App\Http\Controllers\Api\DriverController::class, 'pelangganlist']);
Route::get('list-tujuan', [\App\Http\Controllers\Api\DriverController::class, 'kotalist']);
Route::get('list-pengambilan_do/{id}', [\App\Http\Controllers\Api\PengambilandoController::class, 'list']);
Route::get('pengambilan_do-detailpengambilan/{id}', [\App\Http\Controllers\Api\PengambilandoController::class, 'pengambilando_detail']);
Route::post('pengambilan_do-konfirmasi/{id}', [\App\Http\Controllers\Api\PengambilandoController::class, 'konfirmasi']);
Route::post('pengambilan_do-batal_pengambilan/{id}', [\App\Http\Controllers\Api\PengambilandoController::class, 'batal_pengambilan']);
// Route::post('pengambilan_do-bukti_foto/{id}', [\App\Http\Controllers\Api\PengambilandoController::class, 'bukti_foto']);
Route::post('pengambilan_do-bukti_foto/{id}', [PengambilandoController::class, 'bukti_foto']);
Route::post('pengambilan_do-bukti_fotoselesai/{id}', [PengambilandoController::class, 'bukti_fotoselesai']);
Route::post('pengambilan_do-bukti_fotoperbarui/{id}', [PengambilandoController::class, 'bukti_fotoperbarui']);
Route::post('pengambilan_do-bukti_fotoselesaiperbarui/{id}', [PengambilandoController::class, 'bukti_fotoselesaiperbarui']);
Route::post('pengambilan_do-konfirmasi_selesai/{id}', [\App\Http\Controllers\Api\PengambilandoController::class, 'konfirmasi_selesai']);

// Route::apiResource('kendaraan', [KendaraanController::class, 'kendaraan_search'])->except('index');