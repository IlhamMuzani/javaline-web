<?php

use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\KendaraanController;
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

Route::get('list-kendaraan/{id}', [\App\Http\Controllers\Api\KendaraanController::class, 'list']);
Route::post('kendaraan-search', [KendaraanController::class, 'kendaraan_search']);
Route::get('kendaraan-detail/{id}', [KendaraanController::class,'detail']);
Route::post('kendaraan-update/{id}', [KendaraanController::class, 'update']);
Route::get('kendaraan-detailken/{id}', [\App\Http\Controllers\Api\DriverController::class, 'kendaraan_detail']);
Route::post('kendaraan-tunggumuat/{id}',[\App\Http\Controllers\Api\DriverController::class, 'tunggu_muat']);
Route::post('kendaraan-loadingmuat/{id}', [\App\Http\Controllers\Api\DriverController::class, 'loading_muat']);
Route::post('kendaraan-perjalananisi/{id}', [\App\Http\Controllers\Api\DriverController::class, 'perjalanan_isi']);
Route::post('kendaraan-tunggubongkar/{id}', [\App\Http\Controllers\Api\DriverController::class, 'tunggu_bongkar']);
Route::post('kendaraan-loadingbongkar/{id}', [\App\Http\Controllers\Api\DriverController::class, 'loading_bongkar']);
Route::post('kendaraan-perjalanankosong/{id}', [\App\Http\Controllers\Api\DriverController::class, 'perjalanan_kosong']);
Route::post('kendaraan-perbaikandijalan/{id}', [\App\Http\Controllers\Api\DriverController::class, 'perbaikan_dijalan']);
Route::post('kendaraan-perbaikandigarasi/{id}', [\App\Http\Controllers\Api\DriverController::class, 'perbaikan_digarasi']);
Route::get('list-pelanggan', [\App\Http\Controllers\Api\DriverController::class, 'pelangganlist']);
Route::get('list-tujuan', [\App\Http\Controllers\Api\DriverController::class, 'kotalist']);

// Route::apiResource('kendaraan', [KendaraanController::class, 'kendaraan_search'])->except('index');