<?php

use App\Http\Controllers\Admin\GolonganController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [AuthController::class, 'index']);
Route::get('login', [AuthController::class, 'index']);
Route::get('loginn', [AuthController::class, 'tologin']);
Route::get('register', [AuthController::class, 'toregister']);
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'registeruser']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('check-user', [HomeController::class, 'check_user']);


Route::get('golongan/{kode}', [\App\Http\Controllers\GolonganController::class, 'detail']);
Route::get('nokir/{kode}', [\App\Http\Controllers\NokirController::class, 'detail']);
Route::get('karyawan/{kode}', [\App\Http\Controllers\KaryawanController::class, 'detail']);
Route::get('kendaraan/{kode}', [\App\Http\Controllers\KendaraanController::class, 'detail']);
Route::get('ban/{kode}', [\App\Http\Controllers\BanController::class, 'detail']);
Route::get('supplier/{kode}', [\App\Http\Controllers\SupplierController::class, 'detail']);
Route::get('pelanggan/{kode}', [\App\Http\Controllers\PelangganController::class, 'detail']);
Route::get('stnk/{kode}', [\App\Http\Controllers\StnkController::class, 'detail']);


Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);
    Route::get('user/access/{id}', [\App\Http\Controllers\Admin\UserController::class, 'access']);
    Route::post('user-access/{id}', [\App\Http\Controllers\Admin\UserController::class, 'access_user']);
    Route::post('user-create', [\App\Http\Controllers\Admin\UserController::class, 'update_user']);
    Route::get('user/karyawan/{id}', [\App\Http\Controllers\Admin\UserController::class, 'karyawan']);
    Route::get('nokir/kendaraan/{id}', [\App\Http\Controllers\Admin\NokirController::class, 'kendaraan']);
    Route::get('stnk/kendaraan/{id}', [\App\Http\Controllers\Admin\StnkController::class, 'kendaraan']);
    Route::get('pemasangan_ban/kendaraan/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'kendaraan']);
    Route::get('pelepasan_ban/kendaraan/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'kendaraan']);
    Route::get('km_update/kendaraan/{id}', [\App\Http\Controllers\Admin\KmController::class, 'kendaraan']);
    Route::get('pembelian_ban/supplier/{id}', [\App\Http\Controllers\Admin\PembelianBanController::class, 'supplier']);
    Route::get('pembelian_part/sparepart/{id}', [\App\Http\Controllers\Admin\PembelianpartController::class, 'sparepart']);
    Route::get('akses/access/{id}', [\App\Http\Controllers\Admin\AksesController::class, 'access']);
    Route::post('akses-access/{id}', [\App\Http\Controllers\Admin\AksesController::class, 'access_user']);
    Route::get('pemasangan/{kendaraan_id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'pemasangan']);
    Route::post('pemasangan1/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_1a']);
    Route::post('pemasangan1b/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_1b']);
    Route::post('pemasangan2a/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_2a']);
    Route::post('pemasangan2b/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_2b']);
    Route::post('pemasangan2c/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_2c']);
    Route::post('pemasangan2d/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_2d']);
    Route::post('pemasangan3a/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_3a']);
    Route::post('pemasangan3b/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_3b']);
    Route::post('pemasangan3c/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_3c']);
    Route::post('pemasangan3d/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_3d']);
    Route::post('pemasangan4a/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_4a']);
    Route::post('pemasangan4b/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_4b']);
    Route::post('pemasangan4c/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_4c']);
    Route::post('pemasangan4d/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_4d']);
    Route::post('pemasangan5a/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_5a']);
    Route::post('pemasangan5b/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_5b']);
    Route::post('pemasangan5c/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_5c']);
    Route::post('pemasangan5d/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_5d']);
    Route::post('pemasangan6a/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_6a']);
    Route::post('pemasangan6b/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_6b']);
    Route::post('pemasangan6c/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_6c']);
    Route::post('pemasangan6d/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'update_6d']);
    // Route::post('hapus_pemasangan/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'hapusban']);

    Route::post('pelepasan1/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_1a']);
    Route::post('pelepasan1b/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_1b']);
    Route::post('pelepasan2a/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_2a']);
    Route::post('pelepasan2b/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_2b']);
    Route::post('pelepasan2c/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_2c']);
    Route::post('pelepasan2d/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_2d']);
    Route::post('pelepasan3a/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_3a']);
    Route::post('pelepasan3b/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_3b']);
    Route::post('pelepasan3c/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_3c']);
    Route::post('pelepasan3d/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_3d']);
    Route::post('pelepasan4a/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_4a']);
    Route::post('pelepasan4b/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_4b']);
    Route::post('pelepasan4c/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_4c']);
    Route::post('pelepasan4d/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_4d']);
    Route::post('pelepasan5a/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_5a']);
    Route::post('pelepasan5b/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_5b']);
    Route::post('pelepasan5c/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_5c']);
    Route::post('pelepasan5d/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_5d']);
    Route::post('pelepasan6a/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_6a']);
    Route::post('pelepasan6b/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_6b']);
    Route::post('pelepasan6c/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_6c']);
    Route::post('pelepasan6d/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'updatepelepasan_6d']);
    Route::post('tambah_supplier', [\App\Http\Controllers\Admin\PembelianBanController::class, 'tambah_supplier']);
    Route::post('tambah_supplier', [\App\Http\Controllers\Admin\PembelianpartController::class, 'tambah_supplier']);
    Route::post('tambah_sparepart', [\App\Http\Controllers\Admin\PembelianpartController::class, 'tambah_sparepart']);
    Route::post('km/update/{id}', [\App\Http\Controllers\Admin\KmController::class, 'update'])->name('update-km');
    Route::post('tambah_sparepartin', [\App\Http\Controllers\Admin\InqueryPembelianPartController::class, 'tambah_sparepart']);
    Route::get('status_perjalanan/driver/{id}', [\App\Http\Controllers\Admin\StatusPerjalananController::class, 'driver']);


    Route::post('inquerypemasangan1/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan1']);
    Route::post('inquerypemasangan1b/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan1b']);
    Route::post('inquerypemasangan2a/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan2a']);
    Route::post('inquerypemasangan2b/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan2b']);
    Route::post('inquerypemasangan2c/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan2c']);
    Route::post('inquerypemasangan2d/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan2d']);
    Route::post('inquerypemasangan3a/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan3a']);
    Route::post('inquerypemasangan3b/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan3b']);
    Route::post('inquerypemasangan3c/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan3c']);
    Route::post('inquerypemasangan3d/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan3d']);
    Route::post('inquerypemasangan4a/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan4a']);
    Route::post('inquerypemasangan4b/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan4b']);
    Route::post('inquerypemasangan4c/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan4c']);
    Route::post('inquerypemasangan4d/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan4d']);
    Route::post('inquerypemasangan5a/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan5a']);
    Route::post('inquerypemasangan5b/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan5b']);
    Route::post('inquerypemasangan5c/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan5c']);
    Route::post('inquerypemasangan5d/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan5d']);
    Route::post('inquerypemasangan6a/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan6a']);
    Route::post('inquerypemasangan6b/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan6b']);
    Route::post('inquerypemasangan6c/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan6c']);
    Route::post('inquerypemasangan6d/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'inquerypemasangan6d']);

    Route::post('inquerypelepasan1/{id}', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'inquerypelepasan1']);

    Route::put('admin/update_km/{id}', [\App\Http\Controllers\Admin\KmController::class, 'updateKM'])->name('update_km.update');

    Route::get('inquery_ban', [\App\Http\Controllers\Admin\InqueryPembelianBanController::class, 'index']);
    Route::get('unpostban/{id}', [\App\Http\Controllers\Admin\InqueryPembelianBanController::class, 'unpostban'])->name('unpostban');
    Route::get('postingban/{id}', [\App\Http\Controllers\Admin\InqueryPembelianBanController::class, 'postingban'])->name('postingban');
    Route::get('lihat_faktur/{id}', [\App\Http\Controllers\Admin\InqueryPembelianBanController::class, 'lihat_faktur'])->name('lihat_faktur');
    Route::get('edit_faktur/{id}', [\App\Http\Controllers\Admin\InqueryPembelianBanController::class, 'edit_faktur'])->name('edit_faktur');
    Route::get('laporan_pembelianban', [\App\Http\Controllers\Admin\LaporanPembelianBan::class, 'index']);
    Route::get('print_ban', [\App\Http\Controllers\Admin\LaporanPembelianBan::class, 'print_ban']);
    Route::get('laporan_pemasanganban', [\App\Http\Controllers\Admin\LaporanpemasanganbanController::class, 'index']);
    Route::get('print_pemasanganban', [\App\Http\Controllers\Admin\LaporanpemasanganbanController::class, 'print_pemasanganban']);


    Route::get('laporan_pelepasanban', [\App\Http\Controllers\Admin\LaporanpelepasanbanController::class, 'index']);
    Route::get('print_pelepasanban', [\App\Http\Controllers\Admin\LaporanpelepasanbanController::class, 'print_pelepasanban']);


    Route::get('pemasangan_ban/ban/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class,'ban']);

    Route::delete('pemasangan_ban/delete_ban/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'delete_ban']);
    Route::delete('hapus_part/{id}', [\App\Http\Controllers\Admin\PemasanganpartController::class, 'hapus_part']);

    Route::delete('inquery_pemasanganban/deleteban/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'delete']);
    Route::delete('inquery_pelepasanban/deleteban/{id}', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'delete']);

    Route::get('inquery_part', [\App\Http\Controllers\Admin\InqueryPembelianPartController::class, 'index']);
    Route::get('unpostpart/{id}', [\App\Http\Controllers\Admin\InqueryPembelianPartController::class, 'unpostpart'])->name('unpostpart');
    Route::get('lihat_fakturpart/{id}', [\App\Http\Controllers\Admin\InqueryPembelianPartController::class, 'lihat_fakturpart'])->name('lihat_fakturpart');
    Route::get('edit_fakturpart/{id}', [\App\Http\Controllers\Admin\InqueryPembelianPartController::class, 'edit_fakturpart'])->name('edit_fakturpart');
    Route::get('postingpart/{id}', [\App\Http\Controllers\Admin\InqueryPembelianPartController::class, 'postingpart'])->name('postingpart');
    Route::get('laporan_pembelianpart', [\App\Http\Controllers\Admin\LaporanPembelianPart::class, 'index']);
    Route::get('print_part', [\App\Http\Controllers\Admin\LaporanPembelianPart::class, 'print_part']);

    
    Route::get('inquery_km', [\App\Http\Controllers\Admin\InqueryUpdateKMController::class, 'index']);
    Route::get('unpostkm/{id}', [\App\Http\Controllers\Admin\InqueryUpdateKMController::class, 'unpostkm'])->name('unpostkm');
    Route::get('postingkm/{id}', [\App\Http\Controllers\Admin\InqueryUpdateKMController::class, 'postingkm'])->name('postingkm');
    Route::get('deletekm/{id}', [\App\Http\Controllers\Admin\InqueryUpdateKMController::class, 'deletekm'])->name('deletekm');
    Route::get('laporan_updatekm', [\App\Http\Controllers\Admin\LaporanUpdateKM::class, 'index']);
    Route::get('print_updatekm', [\App\Http\Controllers\Admin\LaporanUpdateKM::class, 'print_updatekm']);
    Route::get('lihat_kendaraan/{id}', [\App\Http\Controllers\Admin\InqueryUpdateKMController::class, 'lihat_kendaraan'])->name('lihat_kendaraan');
    Route::get('edit_kendaraan/{id}', [\App\Http\Controllers\Admin\InqueryUpdateKMController::class, 'edit_kendaraan'])->name('edit_kendaraan');

    Route::get('inquery_pemasanganban', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'index']);
    Route::get('unpostpemasangan/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'unpostpemasangan'])->name('unpostpemasangan');
    Route::get('postingpemasangan/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'postingpemasangan'])->name('postingpemasangan');
    Route::get('lihat_pemasangan/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'lihat_pemasangan'])->name('lihat_pemasangan');
    Route::get('edit_pemasangan/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'edit_pemasangan'])->name('edit_pemasangan');
    Route::get('konfirmasiselesai/{id}', [\App\Http\Controllers\Admin\StatusPerjalananController::class, 'konfirmasiselesai'])->name('konfirmasiselesai');

    Route::get('inquery_pelepasanban', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'index']);
    Route::get('unpostpelepasan/{id}', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'unpostpelepasan'])->name('unpostpelepasan');
    Route::get('postingpelepasan/{id}', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'postingpelepasan'])->name('postingpelepasan');
    Route::get('lihat_pelepasan/{id}', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'lihat_pelepasan'])->name('lihat_pelepasan');
    Route::get('edit_pelepasan/{id}', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'edit_pelepasan'])->name('edit_pelepasan');

    
    Route::get('departemen/cetak-pdf/{id}', [\App\Http\Controllers\Admin\DepartemenController::class, 'cetakpdf']);
    Route::get('golongan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\GolonganController::class, 'cetakpdf']);
    Route::get('karyawan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\KaryawanController::class, 'cetakpdf']);
    Route::get('user/cetak-pdf/{id}', [\App\Http\Controllers\Admin\UserController::class, 'cetakpdf']);
    Route::get('supplier/cetak-pdf/{id}', [\App\Http\Controllers\Admin\SupplierController::class, 'cetakpdf']);
    Route::get('pelanggan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PelangganController::class, 'cetakpdf']);
    Route::get('kendaraan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\KendaraanController::class, 'cetakpdf']);
    Route::get('ban/cetak-pdf/{id}', [\App\Http\Controllers\Admin\BanController::class, 'cetakpdf']);
    Route::get('divisi/cetak-pdf/{id}', [\App\Http\Controllers\Admin\DivisiController::class, 'cetakpdf']);
    Route::get('jenis-kendaraan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\Jenis_kendaraanController::class, 'cetakpdf']);
    Route::get('ukuran-ban/cetak-pdf/{id}', [\App\Http\Controllers\Admin\UkuranbanController::class, 'cetakpdf']);
    Route::get('merek-ban/cetak-pdf/{id}', [\App\Http\Controllers\Admin\MerekController::class, 'cetakpdf']);
    Route::get('nokir/cetak-pdf/{id}', [\App\Http\Controllers\Admin\NokirController::class, 'cetakpdf']);
    Route::get('stnk/cetak-pdf/{id}', [\App\Http\Controllers\Admin\StnkController::class, 'cetakpdf']);
    Route::get('perpanjangan_stnk/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PerpanjanganstnkController::class, 'cetakpdf']);
    Route::get('pemasangan_ban/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'cetakpdf']);
    Route::get('pelepasan_ban/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PelepasanbanController::class, 'cetakpdf']);
    Route::get('pembelian_ban/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PembelianBanController::class, 'cetakpdf']);
    Route::get('pembelian_part/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PembelianpartController::class, 'cetakpdf']);
    Route::get('perpanjangan_stnk/checkpost/{id}', [\App\Http\Controllers\Admin\PerpanjanganstnkController::class, 'checkpost']);
    Route::get('perpanjangan_kir/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PerpanjanganKirController::class, 'cetakpdf']);
    Route::get('perpanjangan_kir/checkpostkir/{id}', [\App\Http\Controllers\Admin\PerpanjanganKirController::class, 'checkpostkir']);
    Route::get('pemasangan_part/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PemasanganpartController::class, 'cetakpdf']);
    Route::get('penggantian_oli/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PenggantianOliController::class, 'cetakpdf']);
    Route::get('penggantian_oli/checkpostoli/{id}', [\App\Http\Controllers\Admin\PenggantianOliController::class, 'checkpostoli']);
    Route::get('nokir/cetak-pdfnokir/{id}', [\App\Http\Controllers\Admin\NokirController::class, 'cetakpdfnokir']);

    // Route::middleware('admin')->prefix('admin')->group(function () {
        Route::delete('inquery_pembelianpart/deletepart/{id}', [\App\Http\Controllers\Admin\InqueryPembelianPartController::class, 'deletepart']);
    
    Route::get('pembelian_part/tabelpart', [\App\Http\Controllers\Admin\PembelianpartController::class, 'tabelpart']);
    Route::get('pembelian_part/tabelpartmesin', [\App\Http\Controllers\Admin\PembelianpartController::class, 'tabelpartmesin']);

    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index']);
    Route::post('profile/update', [\App\Http\Controllers\Admin\ProfileController::class, 'update']);

    Route::get('deleteban/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'deleteban'])->name('deleteban');
    Route::get('ban', [\App\Http\Controllers\Admin\BanController::class, 'index']);
    Route::get('sparepart', [\App\Http\Controllers\Admin\SparepartController::class, 'sparepart']);

    Route::get('inquery_pemasanganpart', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'index']);
    Route::get('unpostpemasanganpart/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'unpostpemasanganpart'])->name('unpostpemasanganpart');
    Route::get('postingpemasanganpart/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'postingpemasanganpart'])->name('postingpemasanganpart');
    Route::get('lihat_pemasanganpart/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'lihat_pemasanganpart'])->name('lihat_pemasanganpart');
    Route::get('edit_pemasanganpart/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'edit_pemasanganpart'])->name('edit_pemasanganpart');
    Route::delete('inquery_pemasanganpart/deletepart/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'delete']);
    Route::delete('inquery_pemasanganpart/deletepartdetail/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'deletepart']);
    
    Route::get('laporan_pemasanganpart', [\App\Http\Controllers\Admin\LaporanpemasanganpartController::class, 'index']);
    Route::get('print_pemasanganpart', [\App\Http\Controllers\Admin\LaporanpemasanganpartController::class, 'print_pemasanganpart']);
    Route::get('print_laporanstatusperjalanan', [\App\Http\Controllers\Admin\LaporanStatusPerjalananController::class, 'print_statusperjalanan']);

    Route::get('inquery_penggantianoli', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'index']);
    Route::get('unpostpenggantianoli/{id}', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'unpostpenggantianoli'])->name('unpostpenggantianoli');
    Route::get('postingpenggantianoli/{id}', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'postingpenggantianoli'])->name('postingpenggantianoli');
    Route::get('lihat_penggantianoli/{id}', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'lihat_penggantianoli'])->name('lihat_penggantianoli');
    Route::get('edit_penggantianoli/{id}', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'edit_penggantianoli'])->name('edit_penggantianoli');
    Route::delete('inquery_penggantianoli/deleteoli/{id}', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'delete']);
    Route::delete('inquery_penggantianoli/deleteolidetail/{id}', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'deleteoli']);
    
    Route::get('laporan_penggantianoli', [\App\Http\Controllers\Admin\LaporanPenggantianoliController::class, 'index']);
    Route::get('print_penggantianoli', [\App\Http\Controllers\Admin\LaporanPenggantianoliController::class, 'print_penggantianoli']);
    Route::get('status_perjalanan', [\App\Http\Controllers\Admin\StatusPerjalananController::class, 'index']);
    Route::get('laporan_statusperjalanan', [\App\Http\Controllers\Admin\LaporanStatusPerjalananController::class, 'index']);


    Route::resource('karyawan', \App\Http\Controllers\Admin\KaryawanController::class);
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('departemen', \App\Http\Controllers\Admin\DepartemenController::class);
    Route::resource('supplier', \App\Http\Controllers\Admin\SupplierController::class);
    Route::resource('pelanggan', \App\Http\Controllers\Admin\PelangganController::class);
    Route::resource('kendaraan', \App\Http\Controllers\Admin\KendaraanController::class);
    Route::resource('ban', \App\Http\Controllers\Admin\BanController::class);
    Route::resource('golongan', \App\Http\Controllers\Admin\GolonganController::class);
    Route::resource('divisi', \App\Http\Controllers\Admin\DivisiController::class);
    Route::resource('jenis_kendaraan', \App\Http\Controllers\Admin\Jenis_kendaraanController::class);
    Route::resource('merek_ban', \App\Http\Controllers\Admin\MerekController::class);
    Route::resource('type_ban', \App\Http\Controllers\Admin\TypebanController::class);
    Route::resource('ukuran_ban', \App\Http\Controllers\Admin\UkuranbanController::class);
    Route::resource('km', \App\Http\Controllers\Admin\KmController::class);
    Route::resource('nokir', \App\Http\Controllers\Admin\NokirController::class);
    Route::resource('akses', \App\Http\Controllers\Admin\AksesController::class);
    Route::resource('stnk', \App\Http\Controllers\Admin\StnkController::class);
    Route::resource('perpanjangan_stnk', \App\Http\Controllers\Admin\PerpanjanganstnkController::class);
    Route::resource('perpanjangan_kir', \App\Http\Controllers\Admin\PerpanjanganKirController::class);
    Route::resource('pemasangan_ban', \App\Http\Controllers\Admin\PemasanganbanController::class);
    Route::resource('pelepasan_ban', \App\Http\Controllers\Admin\PelepasanbanController::class);
    Route::resource('pemasangan_part', \App\Http\Controllers\Admin\PemasanganpartController::class);
    Route::resource('pembelian_ban', \App\Http\Controllers\Admin\PembelianBanController::class);
    Route::resource('pembelian_part', \App\Http\Controllers\Admin\PembelianpartController::class);
    Route::resource('log_updatekm', \App\Http\Controllers\Admin\LogActivityController::class);
    Route::resource('sparepart', \App\Http\Controllers\Admin\SparepartController::class);
    Route::resource('inquery_pembelianban', \App\Http\Controllers\Admin\InqueryPembelianBanController::class);
    Route::resource('inquery_pembelianpart', \App\Http\Controllers\Admin\InqueryPembelianPartController::class);
    Route::resource('inquery_updatekm', \App\Http\Controllers\Admin\InqueryUpdateKMController::class);
    Route::resource('inquery_pemasanganban', \App\Http\Controllers\Admin\InqueryPemasanganbanController::class);
    Route::resource('inquery_pelepasanban', \App\Http\Controllers\Admin\InqueryPelepasanbanController::class);
    Route::resource('updatekm', \App\Http\Controllers\Admin\UpdateKMController::class);
    Route::resource('detail_pemasanganpart', \App\Http\Controllers\Admin\DetailPemasanganpartController::class);
    Route::resource('inquery_pemasanganpart', \App\Http\Controllers\Admin\InqueryPemasanganpartController::class);
    Route::resource('laporan_pemasanganpart', \App\Http\Controllers\Admin\LaporanpemasanganpartController::class);
    Route::resource('penggantian_oli', \App\Http\Controllers\Admin\PenggantianOliController::class);
    Route::resource('inquery_penggantianoli', \App\Http\Controllers\Admin\InqueryPenggantianoliController::class);
    Route::resource('laporan_penggantianoli', \App\Http\Controllers\Admin\LaporanPenggantianoliController::class);
    Route::resource('status_perjalanan', \App\Http\Controllers\Admin\StatusPerjalananController::class);
    Route::resource('laporan_statusperjalanan', \App\Http\Controllers\Admin\LaporanStatusPerjalananController::class);
    Route::resource('kota', \App\Http\Controllers\Admin\KotaController::class);

});