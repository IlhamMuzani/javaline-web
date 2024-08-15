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
    Route::get('akses/accessdetail/{id}', [\App\Http\Controllers\Admin\AksesController::class, 'accessdetail']);
    Route::post('akses-accessdetail/{id}', [\App\Http\Controllers\Admin\AksesController::class, 'access_userdetail']);
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
    Route::post('tambah_barang', [\App\Http\Controllers\Admin\ReturnekspedisiController::class, 'tambah_barang']);

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
    Route::get('bukti_potongpajak/cetak-pdf/{id}', [\App\Http\Controllers\Admin\BuktipotongpajakController::class, 'cetakpdf']);
    Route::get('bukti_potongpajak/get_item/{id}', [\App\Http\Controllers\Admin\BuktipotongpajakController::class, 'get_item']);
    Route::get('print_buktipotongpajak', [\App\Http\Controllers\Admin\LaporanBuktipotongpajakController::class, 'print_buktipotongpajak']);
    Route::get('print_buktipotongpajakglobal', [\App\Http\Controllers\Admin\LaporanBuktipotongpajakglobalController::class, 'print_buktipotongpajakglobal']);

    Route::get('ban', [\App\Http\Controllers\Admin\InqueryPembelianBanController::class, 'index']);
    Route::get('unpostban/{id}', [\App\Http\Controllers\Admin\InqueryPembelianBanController::class, 'unpostban'])->name('unpostban');
    Route::get('postingban/{id}', [\App\Http\Controllers\Admin\InqueryPembelianBanController::class, 'postingban'])->name('postingban');
    Route::get('hapusban/{id}', [\App\Http\Controllers\Admin\InqueryPembelianBanController::class, 'hapusban'])->name('hapusban');
    Route::get('lihat_faktur/{id}', [\App\Http\Controllers\Admin\InqueryPembelianBanController::class, 'lihat_faktur'])->name('lihat_faktur');
    Route::get('lihat_klaim/{id}', [\App\Http\Controllers\Admin\BanController::class, 'lihat_klaim'])->name('lihat_klaim');

    Route::get('edit_faktur/{id}', [\App\Http\Controllers\Admin\InqueryPembelianBanController::class, 'edit_faktur'])->name('edit_faktur');
    Route::get('laporan_pembelianban', [\App\Http\Controllers\Admin\LaporanPembelianBan::class, 'index']);
    Route::get('print_ban', [\App\Http\Controllers\Admin\LaporanPembelianBan::class, 'print_ban']);
    Route::get('laporan_pemasanganban', [\App\Http\Controllers\Admin\LaporanpemasanganbanController::class, 'index']);
    Route::get('print_pemasanganban', [\App\Http\Controllers\Admin\LaporanpemasanganbanController::class, 'print_pemasanganban']);
    Route::get('cetak_pdffilter', [\App\Http\Controllers\Admin\BanController::class, 'cetak_pdffilter']);

    Route::get('print_sopir', [\App\Http\Controllers\Admin\DriverController::class, 'print_sopir']);
    Route::get('driver/rekapexport', [\App\Http\Controllers\Admin\DriverController::class, 'rekapexport']);

    Route::get('laporan_mobillogistikglobal/rekapexportlaporanlogistik', [\App\Http\Controllers\Admin\LaporanMobillogistikglobalController::class, 'rekapexportlaporanlogistik']);
    Route::get('inquery_memoperjalanan/rekapexportmemoperjalanan', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'rekapexportmemoperjalanan']);

    Route::get('laporan_pelepasanban', [\App\Http\Controllers\Admin\LaporanpelepasanbanController::class, 'index']);
    Route::get('print_pelepasanban', [\App\Http\Controllers\Admin\LaporanpelepasanbanController::class, 'print_pelepasanban']);


    Route::get('pemasangan_ban/ban/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'ban']);

    Route::delete('pemasangan_ban/delete_ban/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'delete_ban']);
    Route::delete('hapus_part/{id}', [\App\Http\Controllers\Admin\PemasanganpartController::class, 'hapus_part']);

    Route::delete('inquery_pemasanganban/deleteban/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'deleteban']);
    Route::delete('inquery_pelepasanban/deleteban/{id}', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'delete']);
    Route::get('deletebans/{id}', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'deletebans'])->name('deletebans');

    Route::get('inquery_part', [\App\Http\Controllers\Admin\InqueryPembelianPartController::class, 'index']);
    Route::get('unpostpart/{id}', [\App\Http\Controllers\Admin\InqueryPembelianPartController::class, 'unpostpart'])->name('unpostpart');
    Route::get('lihat_fakturpart/{id}', [\App\Http\Controllers\Admin\InqueryPembelianPartController::class, 'lihat_fakturpart'])->name('lihat_fakturpart');
    Route::get('edit_fakturpart/{id}', [\App\Http\Controllers\Admin\InqueryPembelianPartController::class, 'edit_fakturpart'])->name('edit_fakturpart');
    Route::get('postingpart/{id}', [\App\Http\Controllers\Admin\InqueryPembelianPartController::class, 'postingpart'])->name('postingpart');
    Route::get('hapuspart/{id}', [\App\Http\Controllers\Admin\InqueryPembelianPartController::class, 'hapuspart'])->name('hapuspart');
    Route::get('laporan_pembelianpart', [\App\Http\Controllers\Admin\LaporanPembelianPart::class, 'index']);
    Route::get('print_part', [\App\Http\Controllers\Admin\LaporanPembelianPart::class, 'print_part']);


    Route::get('inquery_km', [\App\Http\Controllers\Admin\InqueryUpdateKMController::class, 'index']);
    Route::get('inquery_updatekm/unpostkm/{id}', [\App\Http\Controllers\Admin\InqueryUpdateKMController::class, 'unpostkm']);
    Route::get('inquery_updatekm/postingkm/{id}', [\App\Http\Controllers\Admin\InqueryUpdateKMController::class, 'postingkm']);
    Route::get('hapuskm/{id}', [\App\Http\Controllers\Admin\InqueryUpdateKMController::class, 'hapuskm'])->name('hapuskm');
    Route::get('deletekm/{id}', [\App\Http\Controllers\Admin\InqueryUpdateKMController::class, 'deletekm'])->name('deletekm');
    Route::get('laporan_updatekm', [\App\Http\Controllers\Admin\LaporanUpdateKM::class, 'index']);
    Route::get('print_updatekm', [\App\Http\Controllers\Admin\LaporanUpdateKM::class, 'print_updatekm']);
    Route::get('lihat_kendaraan/{id}', [\App\Http\Controllers\Admin\InqueryUpdateKMController::class, 'lihat_kendaraan'])->name('lihat_kendaraan');
    Route::get('edit_kendaraan/{id}', [\App\Http\Controllers\Admin\InqueryUpdateKMController::class, 'edit_kendaraan'])->name('edit_kendaraan');

    Route::get('inquery_pemasanganban', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'index']);
    Route::get('unpostpemasangan/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'unpostpemasangan'])->name('unpostpemasangan');
    Route::get('postingpemasangan/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'postingpemasangan'])->name('postingpemasangan');
    Route::get('hapuspemasangan/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'hapuspemasangan'])->name('hapuspemasangan');
    Route::get('lihat_pemasangan/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'lihat_pemasangan'])->name('lihat_pemasangan');
    Route::get('edit_pemasangan/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'edit_pemasangan'])->name('edit_pemasangan');
    Route::get('konfirmasiselesai/{id}', [\App\Http\Controllers\Admin\StatusPerjalananController::class, 'konfirmasiselesai'])->name('konfirmasiselesai');

    Route::get('inquery_pelepasanban', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'index']);
    Route::get('unpostpelepasan/{id}', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'unpostpelepasan'])->name('unpostpelepasan');
    Route::get('postingpelepasan/{id}', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'postingpelepasan'])->name('postingpelepasan');
    Route::get('lihat_pelepasan/{id}', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'lihat_pelepasan'])->name('lihat_pelepasan');
    Route::get('hapuspelepasan/{id}', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'hapuspelepasan'])->name('hapuspelepasan');
    Route::get('edit_pelepasan/{id}', [\App\Http\Controllers\Admin\InqueryPelepasanbanController::class, 'edit_pelepasan'])->name('edit_pelepasan');
    Route::get('inquery_perpanjanganstnk', [\App\Http\Controllers\Admin\InqueryPerpanjanganstnkController::class, 'index']);
    Route::get('inquery_perpanjanganstnk/cetak-pdf/{id}', [\App\Http\Controllers\Admin\InqueryPerpanjanganstnkController::class, 'cetakpdf']);
    Route::get('inquery_perpanjangankir', [\App\Http\Controllers\Admin\InqueryPerpanjangankirController::class, 'index']);
    Route::get('inquery_perpanjangankir/cetak-pdf/{id}', [\App\Http\Controllers\Admin\InqueryPerpanjangankirController::class, 'cetakpdf']);
    Route::get('departemen/cetak-pdf/{id}', [\App\Http\Controllers\Admin\DepartemenController::class, 'cetakpdf']);
    Route::get('golongan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\GolonganController::class, 'cetakpdf']);
    Route::get('karyawan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\KaryawanController::class, 'cetakpdf']);
    Route::get('user/cetak-pdf/{id}', [\App\Http\Controllers\Admin\UserController::class, 'cetakpdf']);
    Route::get('supplier/cetak-pdf/{id}', [\App\Http\Controllers\Admin\SupplierController::class, 'cetakpdf']);
    Route::get('pelanggan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PelangganController::class, 'cetakpdf']);
    Route::get('kendaraan/cetak-pdfsolar/{id}', [\App\Http\Controllers\Admin\KendaraanController::class, 'cetakpdfsolar']);
    Route::get('kendaraan/cetak-pdfstnk/{id}', [\App\Http\Controllers\Admin\KendaraanController::class, 'cetakpdfstnk']);
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
    Route::get('memo_ekspedisi/cetak-pdf/{id}', [\App\Http\Controllers\Admin\MemoekspedisiController::class, 'cetakpdf']);
    Route::get('deposit_driver/cetak-pdf/{id}', [\App\Http\Controllers\Admin\DepositdriverController::class, 'cetakpdf']);
    Route::get('kasbon_karyawan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\KasbonkaryawanController::class, 'cetakpdf']);
    Route::get('return_ekspedisi/cetak-pdf/{id}', [\App\Http\Controllers\Admin\ReturnekspedisiController::class, 'cetakpdf']);
    Route::get('inquery_memotambahan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\InqueryMemotambahanController::class, 'cetakpdf']);
    Route::get('listadministrasi/cetak-pdf/{id}', [\App\Http\Controllers\Admin\ListadministrasiController::class, 'cetakpdf']);
    Route::get('perhitungan_gaji/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PerhitungangajiController::class, 'cetakpdf']);
    Route::get('perhitungan_gajibulanan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PerhitungangajibulananController::class, 'cetakpdf']);
    Route::get('inquery_perhitungangaji/unpostperhitungan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajiController::class, 'unpostperhitungan']);
    Route::get('inquery_perhitungangaji/postingperhitungan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajiController::class, 'postingperhitungan']);
    Route::get('hapusperhitungan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajiController::class, 'hapusperhitungan'])->name('hapusperhitungan');
    Route::get('inquery_perhitungangajibulanan/unpostperhitunganbulanan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajibulananController::class, 'unpostperhitunganbulanan']);
    Route::get('inquery_perhitungangajibulanan/postingperhitunganbulanan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajibulananController::class, 'postingperhitunganbulanan']);
    Route::get('hapusperhitunganbulanan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajibulananController::class, 'hapusperhitunganbulanan'])->name('hapusperhitunganbulanan');

    Route::get('karyawan/search', [\App\Http\Controllers\Admin\KaryawanController::class, 'search']);
    Route::get('pelanggan/search', [\App\Http\Controllers\Admin\PelangganController::class, 'search']);
    Route::get('vendor/search', [\App\Http\Controllers\Admin\VendorController::class, 'search']);

    Route::get('inquery_memoekspedisi/search', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'search']);

    Route::get('pelunasan_deposit/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PelunasandepositController::class, 'cetakpdf']);

    // Route::middleware('admin')->prefix('admin')->group(function () {
    Route::delete('inquery_pembelianpart/deletepart/{id}', [\App\Http\Controllers\Admin\InqueryPembelianPartController::class, 'deletepart']);

    Route::get('pembelian_part/tabelpart', [\App\Http\Controllers\Admin\PembelianpartController::class, 'tabelpart']);
    Route::get('pembelian_part/tabelpartmesin', [\App\Http\Controllers\Admin\PembelianpartController::class, 'tabelpartmesin']);
    Route::get('tablememoborongs', [\App\Http\Controllers\Admin\TablememoController::class, 'memoborongs']);
    Route::get('tablememotambahans', [\App\Http\Controllers\Admin\TablememoController::class, 'memotambahans']);

    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index']);
    Route::post('profile/update', [\App\Http\Controllers\Admin\ProfileController::class, 'update']);

    Route::get('inquery_kasbonkaryawan/unpostkasbon/{id}', [\App\Http\Controllers\Admin\InqueryKasbonkaryawanController::class, 'unpostkasbon']);
    Route::get('inquery_kasbonkaryawan/postingkasbon/{id}', [\App\Http\Controllers\Admin\InqueryKasbonkaryawanController::class, 'postingkasbon']);
    Route::delete('inquery_kasbonkaryawan/deletedetailcicilan/{id}', [\App\Http\Controllers\Admin\InqueryKasbonkaryawanController::class, 'deletedetailcicilan']);

    Route::get('deleteban/{id}', [\App\Http\Controllers\Admin\PemasanganbanController::class, 'deleteban'])->name('deleteban');
    Route::get('ban', [\App\Http\Controllers\Admin\BanController::class, 'index']);
    Route::get('sparepart', [\App\Http\Controllers\Admin\SparepartController::class, 'sparepart']);
    Route::delete('inquery_klaimperalatan/deletedetailklaim/{id}', [\App\Http\Controllers\Admin\InqueryKlaimperalatanController::class, 'deletedetailklaim']);

    Route::get('inquery_pemasanganpart', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'index']);
    Route::get('unpostpemasanganpart/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'unpostpemasanganpart'])->name('unpostpemasanganpart');
    Route::get('postingpemasanganpart/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'postingpemasanganpart'])->name('postingpemasanganpart');
    Route::get('hapuspemasanganpart/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'hapuspemasanganpart'])->name('hapuspemasanganpart');
    Route::get('lihat_pemasanganpart/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'lihat_pemasanganpart'])->name('lihat_pemasanganpart');
    Route::get('edit_pemasanganpart/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'edit_pemasanganpart'])->name('edit_pemasanganpart');
    Route::delete('inquery_pemasanganpart/deletepart/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'delete']);
    Route::delete('inquery_pemasanganpart/deletepartdetail/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganpartController::class, 'deletepart']);
    Route::get('inquery_memoekspedisi/unpostmemo/{id}', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'unpostmemo']);
    Route::get('inquery_memoekspedisi/postingmemo/{id}', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'postingmemo']);
    Route::get('inquery_memotambahan/unpostmemotambahan/{id}', [\App\Http\Controllers\Admin\InqueryMemotambahanController::class, 'unpostmemotambahan']);
    Route::get('inquery_memotambahan/postingmemotambahan/{id}', [\App\Http\Controllers\Admin\InqueryMemotambahanController::class, 'postingmemotambahan']);
    Route::get('inquery_memoborong/unpostmemoborong/{id}', [\App\Http\Controllers\Admin\InqueryMemoborongController::class, 'unpostmemoborong']);
    Route::get('inquery_memoborong/postingmemoborong/{id}', [\App\Http\Controllers\Admin\InqueryMemoborongController::class, 'postingmemoborong']);
    Route::get('inquery_fakturekspedisi/unpostfaktur/{id}', [\App\Http\Controllers\Admin\InqueryFakturekspedisiController::class, 'unpostfaktur']);
    Route::get('inquery_fakturekspedisi/postingfaktur/{id}', [\App\Http\Controllers\Admin\InqueryFakturekspedisiController::class, 'postingfaktur']);
    Route::get('inquery_perpanjanganstnk/unpoststnk/{id}', [\App\Http\Controllers\Admin\InqueryPerpanjanganstnkController::class, 'unpoststnk']);
    Route::get('inquery_perpanjanganstnk/postingstnk/{id}', [\App\Http\Controllers\Admin\InqueryPerpanjanganstnkController::class, 'postingstnk']);
    Route::get('inquery_perpanjangankir/unpostkir/{id}', [\App\Http\Controllers\Admin\InqueryPerpanjangankirController::class, 'unpostkir']);
    Route::get('inquery_perpanjangankir/postingkir/{id}', [\App\Http\Controllers\Admin\InqueryPerpanjangankirController::class, 'postingkir']);
    Route::get('inquery_pengeluarankaskecil/unpostpengeluaran/{id}', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'unpostpengeluaran']);
    Route::get('inquery_pengeluarankaskecil/postingpengeluaran/{id}', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'postingpengeluaran']);
    Route::get('inqueryklaim_ban/unpost_klaimban/{id}', [\App\Http\Controllers\Admin\InqueryKlaimbanController::class, 'unpost_klaimban']);
    Route::get('inqueryklaim_ban/posting_klaimban/{id}', [\App\Http\Controllers\Admin\InqueryKlaimbanController::class, 'posting_klaimban']);
    Route::get('klaim_peralatan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\KlaimperalatanController::class, 'cetakpdf']);

    Route::get('inquery_pengambilanujs/unpostpengeluaranujs/{id}', [\App\Http\Controllers\Admin\InqueryPengeluaranujsController::class, 'unpostpengeluaranujs']);
    Route::get('inquery_pengambilanujs/postingpengeluaranujs/{id}', [\App\Http\Controllers\Admin\InqueryPengeluaranujsController::class, 'postingpengeluaranujs']);
    Route::get('laporan_pemasanganpart', [\App\Http\Controllers\Admin\LaporanpemasanganpartController::class, 'index']);
    Route::get('print_pemasanganpart', [\App\Http\Controllers\Admin\LaporanpemasanganpartController::class, 'print_pemasanganpart']);
    Route::get('print_laporanstatusperjalanan', [\App\Http\Controllers\Admin\LaporanStatusPerjalananController::class, 'print_statusperjalanan']);
    Route::get('inquery_potonganpenjualan/unpostpotongan/{id}', [\App\Http\Controllers\Admin\InqueryPotonganpenjualanController::class, 'unpostpotongan']);
    Route::get('inquery_potonganpenjualan/postingpotongan/{id}', [\App\Http\Controllers\Admin\InqueryPotonganpenjualanController::class, 'postingpotongan']);
    Route::get('hapuspotongan/{id}', [\App\Http\Controllers\Admin\InqueryPotonganpenjualanController::class, 'hapuspotongan'])->name('hapuspotongan');
    Route::get('inquery_pengeluaranujs/unpostpengeluaranujs/{id}', [\App\Http\Controllers\Admin\InqueryPengeluaranujsController::class, 'unpostpengeluaranujs']);
    Route::get('inquery_pengeluaranujs/postingpengeluaranujs/{id}', [\App\Http\Controllers\Admin\InqueryPengeluaranujsController::class, 'postingpengeluaranujs']);
    Route::get('unpostpotongan/{id}', [\App\Http\Controllers\Admin\InqueryPotonganpenjualanController::class, 'unpostpotongan'])->name('unpostpotongan');
    Route::get('postingpotongan/{id}', [\App\Http\Controllers\Admin\InqueryPotonganpenjualanController::class, 'postingpotongan'])->name('postingpotongan');

    Route::get('inquery_penerimaankaskecil/unpostpenerimaan/{id}', [\App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class, 'unpostpenerimaan']);
    Route::get('inquery_penerimaankaskecil/postingpenerimaan/{id}', [\App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class, 'postingpenerimaan']);

    Route::get('inquery_penambahansaldokasbon/unpostpenambahansaldokasbon/{id}', [\App\Http\Controllers\Admin\InqueryPenambahansaldokasbonController::class, 'unpostpenambahansaldokasbon']);
    Route::get('inquery_penambahansaldokasbon/postingpenambahansaldokasbon/{id}', [\App\Http\Controllers\Admin\InqueryPenambahansaldokasbonController::class, 'postingpenambahansaldokasbon']);

    Route::get('inquery_penggantianoli', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'index']);
    Route::get('unpostpenggantianoli/{id}', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'unpostpenggantianoli'])->name('unpostpenggantianoli');
    Route::get('postingpenggantianoli/{id}', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'postingpenggantianoli'])->name('postingpenggantianoli');
    Route::get('hapuspenggantianoli/{id}', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'hapuspenggantianoli'])->name('hapuspenggantianoli');
    Route::get('lihat_penggantianoli/{id}', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'lihat_penggantianoli'])->name('lihat_penggantianoli');
    Route::get('edit_penggantianoli/{id}', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'edit_penggantianoli'])->name('edit_penggantianoli');
    Route::delete('inquery_penggantianoli/deleteoli/{id}', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'delete']);
    Route::delete('inquery_penggantianoli/deleteolidetail/{id}', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'deleteoli']);
    Route::delete('inquery_penggantianoli/deletefilterdetail/{id}', [\App\Http\Controllers\Admin\InqueryPenggantianoliController::class, 'deletefilter']);

    Route::get('laporan_penggantianoli', [\App\Http\Controllers\Admin\LaporanPenggantianoliController::class, 'index']);
    Route::get('print_penggantianoli', [\App\Http\Controllers\Admin\LaporanPenggantianoliController::class, 'print_penggantianoli']);
    Route::get('status_perjalanan', [\App\Http\Controllers\Admin\StatusPerjalananController::class, 'index']);
    Route::get('laporan_statusperjalanan', [\App\Http\Controllers\Admin\LaporanStatusPerjalananController::class, 'index']);

    Route::get('unpoststnk/{id}', [\App\Http\Controllers\Admin\InqueryPerpanjanganstnkController::class, 'unpoststnk'])->name('unpoststnk');
    Route::get('postingstnk/{id}', [\App\Http\Controllers\Admin\InqueryPerpanjanganstnkController::class, 'postingstnk'])->name('postingstnk');
    Route::get('hapusstnk/{id}', [\App\Http\Controllers\Admin\InqueryPerpanjanganstnkController::class, 'hapusstnk'])->name('hapusstnk');
    Route::get('unpostkir/{id}', [\App\Http\Controllers\Admin\InqueryPerpanjangankirController::class, 'unpostkir'])->name('unpostkir');
    Route::get('postingkir/{id}', [\App\Http\Controllers\Admin\InqueryPerpanjangankirController::class, 'postingkir'])->name('postingkir');
    Route::get('hapuskir/{id}', [\App\Http\Controllers\Admin\InqueryPerpanjangankirController::class, 'hapuskir'])->name('hapuskir');

    Route::get('unpostpenerimaan/{id}', [\App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class, 'unpostpenerimaan'])->name('unpostpenerimaan');
    Route::get('postingpenerimaan/{id}', [\App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class, 'postingpenerimaan'])->name('postingpenerimaan');
    Route::get('hapuspenerimaan/{id}', [\App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class, 'hapuspenerimaan'])->name('hapuspenerimaan');

    Route::get('unpostpenambahankasbon/{id}', [\App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class, 'unpostpenambahankasbon'])->name('unpostpenambahankasbon');
    Route::get('postingpenambahankasbon/{id}', [\App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class, 'postingpenambahankasbon'])->name('postingpenambahankasbon');
    Route::get('hapuspenambahankasbon/{id}', [\App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class, 'hapuspenambahankasbon'])->name('hapuspenambahankasbon');

    Route::get('hapuspenambahansaldokasbon/{id}', [\App\Http\Controllers\Admin\InqueryPenambahansaldokasbonController::class, 'hapuspenambahansaldokasbon'])->name('hapuspenambahansaldokasbon');

    Route::get('unpostmemoselesai/{id}', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'unpostmemoselesai'])->name('unpostmemoselesai');
    Route::get('unpostmemo/{id}', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'unpostmemo'])->name('unpostmemo');
    Route::get('postingmemo/{id}', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'postingmemo'])->name('postingmemo');
    Route::get('hapusmemo/{id}', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'hapusmemo'])->name('hapusmemo');

    Route::get('unpostmemoborongselesai/{id}', [\App\Http\Controllers\Admin\InqueryMemoborongController::class, 'unpostmemoborongselesai'])->name('unpostmemoborongselesai');
    Route::get('unpostmemoborong/{id}', [\App\Http\Controllers\Admin\InqueryMemoborongController::class, 'unpostmemoborong'])->name('unpostmemoborong');
    Route::get('postingmemoborong/{id}', [\App\Http\Controllers\Admin\InqueryMemoborongController::class, 'postingmemoborong'])->name('postingmemoborong');
    Route::get('hapusmemoborong/{id}', [\App\Http\Controllers\Admin\InqueryMemoborongController::class, 'hapusmemoborong'])->name('hapusmemoborong');

    Route::get('unpostmemotambahanselesai/{id}', [\App\Http\Controllers\Admin\InqueryMemotambahanController::class, 'unpostmemotambahanselesai'])->name('unpostmemotambahanselesai');
    Route::get('unpostmemotambahan/{id}', [\App\Http\Controllers\Admin\InqueryMemotambahanController::class, 'unpostmemotambahan'])->name('unpostmemotambahan');
    Route::get('postingmemotambahan/{id}', [\App\Http\Controllers\Admin\InqueryMemotambahanController::class, 'postingmemotambahan'])->name('postingmemotambahan');
    Route::get('hapusmemotambahan/{id}', [\App\Http\Controllers\Admin\InqueryMemotambahanController::class, 'hapusmemotambahan'])->name('hapusmemotambahan');
    Route::get('inqueryklaim_ban/cetak-pdf/{id}', [\App\Http\Controllers\Admin\InqueryKlaimbanController::class, 'cetakpdf']);
    Route::get('hapusperalatan/{id}', [\App\Http\Controllers\Admin\InqueryKlaimperalatanController::class, 'hapusperalatan'])->name('hapusperalatan');

    Route::get('penambahan_saldokasbon/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PenambahansaldokasbonController::class, 'cetakpdf']);
    Route::get('penerimaan_kaskecil/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PenerimaankaskecilController::class, 'cetakpdf']);
    Route::get('laporan_penerimaankaskecil', [\App\Http\Controllers\Admin\LaporanPenerimaankaskecilController::class, 'index']);
    Route::get('print_penerimaankaskecil', [\App\Http\Controllers\Admin\LaporanPenerimaankaskecilController::class, 'print_penerimaankaskecil']);
    Route::get('print_memoekspedisi', [\App\Http\Controllers\Admin\LaporanMemoekspedisiController::class, 'print_memoekspedisi']);
    Route::get('laporan_memoekspedisi', [\App\Http\Controllers\Admin\LaporanMemoekspedisiController::class, 'index']);
    Route::get('print_memoborong', [\App\Http\Controllers\Admin\LaporanMemoborongController::class, 'print_memoborong']);
    Route::get('laporan_memoborong', [\App\Http\Controllers\Admin\LaporanMemoborongController::class, 'index']);
    Route::get('print_memotambahan', [\App\Http\Controllers\Admin\LaporanMemotambahanController::class, 'print_memotambahan']);
    Route::get('laporan_memotambahan', [\App\Http\Controllers\Admin\LaporanMemotambahanController::class, 'index']);
    Route::get('laporan_saldokas', [\App\Http\Controllers\Admin\LaporanSaldokasController::class, 'index']);
    Route::get('print_saldokas', [\App\Http\Controllers\Admin\LaporanSaldokasController::class, 'print_saldokas']);
    Route::get('print_saldoujs', [\App\Http\Controllers\Admin\LaporanSaldoujsController::class, 'print_saldoujs']);
    Route::get('print_saldokasbon', [\App\Http\Controllers\Admin\LaporanSaldokasbonController::class, 'print_saldokasbon']);

    Route::get('laporan_pengeluarankaskecil', [\App\Http\Controllers\Admin\LaporanPengeluarankaskecilController::class, 'index']);
    Route::get('print_pengeluarankaskecil', [\App\Http\Controllers\Admin\LaporanPengeluarankaskecilController::class, 'print_pengeluarankaskecil']);

    Route::get('laporan_pengeluaranujs', [\App\Http\Controllers\Admin\LaporanPengambilanujsController::class, 'index']);
    Route::get('print_pengeluaranujs', [\App\Http\Controllers\Admin\LaporanPengambilanujsController::class, 'print_pengeluaranujs']);

    Route::get('laporan_pengeluarankaskecilakun', [\App\Http\Controllers\Admin\LaporanPengeluarankaskecilakunController::class, 'index']);
    Route::get('print_pengeluarankaskecilakun', [\App\Http\Controllers\Admin\LaporanPengeluarankaskecilakunController::class, 'print_pengeluarankaskecilakun']);

    Route::get('laporan_pph', [\App\Http\Controllers\Admin\LaporanPphController::class, 'index']);
    Route::get('print_pph', [\App\Http\Controllers\Admin\LaporanPphController::class, 'print_pph']);

    Route::get('hakaksesdriver', [\App\Http\Controllers\Admin\AksesController::class, 'indexdriver']);

    Route::get('indexnon', [\App\Http\Controllers\Admin\TagihanekspedisiController::class, 'indexnonpph']);
    Route::get('inquery_depositdriver/unpostdeposit/{id}', [\App\Http\Controllers\Admin\InqueryDepositdriverController::class, 'unpostdeposit']);
    Route::get('inquery_depositdriver/postingdeposit/{id}', [\App\Http\Controllers\Admin\InqueryDepositdriverController::class, 'postingdeposit']);
    Route::get('hapusdeposit/{id}', [\App\Http\Controllers\Admin\InqueryDepositdriverController::class, 'hapusdeposit'])->name('hapusdeposit');

    // Route::get('unposkasbon/{id}', [\App\Http\Controllers\Admin\InqueryKasbonkaryawanController::class, 'unpostkasbon'])->name('unpostkasbon');
    // Route::get('postingkasbon/{id}', [\App\Http\Controllers\Admin\InqueryKasbonkaryawanController::class, 'postingkasbon'])->name('postingkasbon');
    Route::get('hapuskasbon/{id}', [\App\Http\Controllers\Admin\InqueryKasbonkaryawanController::class, 'hapuskasbon'])->name('hapuskasbon');

    Route::get('inquery_pemasukandeposit/unpostdepositpemasukan/{id}', [\App\Http\Controllers\Admin\InqueryPemasukandepositController::class, 'unpostdepositpemasukan']);
    Route::get('inquery_pemasukandeposit/postingdepositpemasukan/{id}', [\App\Http\Controllers\Admin\InqueryPemasukandepositController::class, 'postingdepositpemasukan']);
    Route::get('hapusdepositpemasukan/{id}', [\App\Http\Controllers\Admin\InqueryPemasukandepositController::class, 'hapusdepositpemasukan'])->name('hapusdepositpemasukan');
    Route::get('print_depositdriver', [\App\Http\Controllers\Admin\LaporanDepositdriverController::class, 'print_depositdriver']);
    Route::get('cetak_depositdriver', [\App\Http\Controllers\Admin\LaporanDepositdriverController::class, 'cetak_depositdriver']);
    Route::get('print_kasbonkaryawan', [\App\Http\Controllers\Admin\LaporanKasbonkaryawanController::class, 'print_kasbonkaryawan']);
    Route::get('inquery_tagihanekspedisi/editnonpph/{id}', [\App\Http\Controllers\Admin\InqueryTagihanekspedisiController::class, 'editnonpph']);

    Route::get('postingtagihan/{id}', [\App\Http\Controllers\Admin\InqueryTagihanekspedisiController::class, 'postingtagihan'])->name('postingtagihan');
    Route::get('unposttagihan/{id}', [\App\Http\Controllers\Admin\InqueryTagihanekspedisiController::class, 'unposttagihan'])->name('unposttagihan');
    Route::get('inquery_tagihanekspedisi/unposttagihan/{id}', [\App\Http\Controllers\Admin\InqueryTagihanekspedisiController::class, 'unposttagihan']);
    Route::get('inquery_tagihanekspedisi/postingtagihan/{id}', [\App\Http\Controllers\Admin\InqueryTagihanekspedisiController::class, 'postingtagihan']);
    Route::get('hapustagihan/{id}', [\App\Http\Controllers\Admin\InqueryTagihanekspedisiController::class, 'hapustagihan'])->name('hapustagihan');
    Route::get('hapusstnk/{id}', [\App\Http\Controllers\Admin\InqueryPerpanjanganstnkController::class, 'hapusstnk'])->name('hapusstnk');

    // Route::get('update_deleted_atpelunasan', [\App\Http\Controllers\Admin\InqueryFakturpelunasanController::class, 'updateDeletedAtpelunasan']);
    Route::get('inquery_fakturpelunasan/update_deleted_atpelunasan', [\App\Http\Controllers\Admin\InqueryFakturpelunasanController::class, 'updateDeletedAtpelunasan']);

    // Route::get('unpostfakturselesai/{id}', [\App\Http\Controllers\Admin\InqueryFakturekspedisiController::class, 'unpostfakturselesai'])->name('unpostfakturselesai');
    Route::get('unpostfaktur/{id}', [\App\Http\Controllers\Admin\InqueryFakturekspedisiController::class, 'unpostfaktur'])->name('unpostfaktur');
    Route::get('postingfaktur/{id}', [\App\Http\Controllers\Admin\InqueryFakturekspedisiController::class, 'postingfaktur'])->name('postingfaktur');
    Route::get('hapusfaktur/{id}', [\App\Http\Controllers\Admin\InqueryFakturekspedisiController::class, 'hapusfaktur'])->name('hapusfaktur');
    Route::get('hapuspemasanganban/{id}', [\App\Http\Controllers\Admin\InqueryPemasanganbanController::class, 'hapuspemasanganban'])->name('hapuspemasanganban');
    Route::get('print_faktur', [\App\Http\Controllers\Admin\LaporanFakturekspedisiController::class, 'print_faktur']);
    Route::get('cetak_faktur', [\App\Http\Controllers\Admin\LaporanFakturekspedisiController::class, 'cetak_faktur']);
    Route::get('faktur_ekspedisi/cetak-pdf/{id}', [\App\Http\Controllers\Admin\FakturekspedisiController::class, 'cetakpdf']);
    Route::get('print_fakturekspedisi', [\App\Http\Controllers\Admin\LaporanFakturekspedisiController::class, 'print_fakturekspedisi']);
    Route::get('laporan_fakturekspedisi', [\App\Http\Controllers\Admin\LaporanFakturekspedisiController::class, 'index']);
    Route::get('print_tagihanekspedisi', [\App\Http\Controllers\Admin\LaporanTagihanekspedisiController::class, 'print_tagihanekspedisi']);
    Route::get('laporan_tagihanekspedisi', [\App\Http\Controllers\Admin\LaporanTagihanekspedisiController::class, 'index']);
    Route::get('tagihan_ekspedisi/cetak-pdf/{id}', [\App\Http\Controllers\Admin\TagihanekspedisiController::class, 'cetakpdf']);
    Route::get('inquery_fakturekspedisi', [\App\Http\Controllers\Admin\InqueryFakturekspedisiController::class, 'index']);

    Route::get('unpostreturn/{id}', [\App\Http\Controllers\Admin\InqueryReturnekspedisiController::class, 'unpostreturn'])->name('unpostreturn');
    Route::get('postingreturn/{id}', [\App\Http\Controllers\Admin\InqueryReturnekspedisiController::class, 'postingreturn'])->name('postingreturn');
    Route::get('hapusreturn/{id}', [\App\Http\Controllers\Admin\InqueryReturnekspedisiController::class, 'hapusreturn'])->name('hapusreturn');

    Route::get('unpostnota/{id}', [\App\Http\Controllers\Admin\InqueryNotareturnController::class, 'unpostnota'])->name('unpostnota');
    Route::get('postingnota/{id}', [\App\Http\Controllers\Admin\InqueryNotareturnController::class, 'postingnota'])->name('postingnota');
    Route::get('hapusnota/{id}', [\App\Http\Controllers\Admin\InqueryNotareturnController::class, 'hapusnota'])->name('hapusnota');
    Route::get('nota_returnbarang/cetak-pdf/{id}', [\App\Http\Controllers\Admin\NotareturnController::class, 'cetakpdf']);

    Route::get('unpostpengeluaran/{id}', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'unpostpengeluaran'])->name('unpostpengeluaran');
    Route::get('postingpengeluaran/{id}', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'postingpengeluaran'])->name('postingpengeluaran');
    Route::get('hapuspengeluaran/{id}', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'hapuspengeluaran'])->name('hapuspengeluaran');
    Route::get('pengeluaran_kaskecil/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PengeluarankaskecilController::class, 'cetakpdf']);
    Route::get('hapuspengeluaranujs/{id}', [\App\Http\Controllers\Admin\InqueryPengeluaranujsController::class, 'hapuspengeluaranujs'])->name('hapuspengeluaranujs');

    Route::get('pengambilan_ujs/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PengambilanujsController::class, 'cetakpdf']);

    Route::get('unpostpenjualan/{id}', [\App\Http\Controllers\Admin\InqueryFakturpenjualanreturnController::class, 'unpostpenjualan'])->name('unpostpenjualan');
    Route::get('postingpenjualan/{id}', [\App\Http\Controllers\Admin\InqueryFakturpenjualanreturnController::class, 'postingpenjualan'])->name('postingpenjualan');
    Route::get('hapuspenjualan/{id}', [\App\Http\Controllers\Admin\InqueryFakturpenjualanreturnController::class, 'hapuspenjualan'])->name('hapuspenjualan');
    Route::get('faktur_penjualanreturn/cetak-pdf/{id}', [\App\Http\Controllers\Admin\FakturpenjualanreturnController::class, 'cetakpdf']);

    Route::get('unpostpelunasan/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanController::class, 'unpostpelunasan'])->name('unpostpelunasan');
    Route::get('postingpelunasan/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanController::class, 'postingpelunasan'])->name('postingpelunasan');
    Route::get('hapuspelunasan/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanController::class, 'hapuspelunasan'])->name('hapuspelunasan');
    Route::get('faktur_pelunasan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\FakturpelunasanController::class, 'cetakpdf']);

    Route::get('unpostpelunasanban/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanbanController::class, 'unpostpelunasanban'])->name('unpostpelunasanban');
    Route::get('postingpelunasanban/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanbanController::class, 'postingpelunasanban'])->name('postingpelunasanban');
    Route::get('hapuspelunasanban/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanbanController::class, 'hapuspelunasanban'])->name('hapuspelunasanban');
    Route::get('faktur_pelunasanban/cetak-pdf/{id}', [\App\Http\Controllers\Admin\FakturpelunasanbanController::class, 'cetakpdf']);

    // Route::post('whatsapp/{id)', [\App\Http\Controllers\Admin\InqueryslipgajibulananController::class, 'whatsapp'])->name('whatsapp');

    Route::get('unpostpelunasanpart/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanpartController::class, 'unpostpelunasanpart'])->name('unpostpelunasanpart');
    Route::get('postingpelunasanpart/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanpartController::class, 'postingpelunasanpart'])->name('postingpelunasanpart');
    Route::get('hapuspelunasanpart/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanpartController::class, 'hapuspelunasanpart'])->name('hapuspelunasanpart');
    Route::get('faktur_pelunasanpart/cetak-pdf/{id}', [\App\Http\Controllers\Admin\FakturpelunasanpartController::class, 'cetakpdf']);
    Route::get('potongan_penjualan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PotonganpenjualanController::class, 'cetakpdf']);

    Route::get('laporan_pelunasan', [\App\Http\Controllers\Admin\LaporanPelunasanController::class, 'index']);
    Route::get('print_pelunasan', [\App\Http\Controllers\Admin\LaporanPelunasanController::class, 'print_pelunasan']);
    Route::get('laporan_pelunasanglobal', [\App\Http\Controllers\Admin\LaporanPelunasanController::class, 'indexglobal']);
    Route::get('print_pelunasanglobal', [\App\Http\Controllers\Admin\LaporanPelunasanController::class, 'print_pelunasanglobal']);

    Route::get('laporan_fakturpelunasanban', [\App\Http\Controllers\Admin\LaporanPelunasanbanController::class, 'index']);
    Route::get('print_pelunasanban', [\App\Http\Controllers\Admin\LaporanPelunasanbanController::class, 'print_pelunasanban']);
    Route::get('laporan_pelunasanglobalban', [\App\Http\Controllers\Admin\LaporanPelunasanbanController::class, 'indexglobalban']);
    Route::get('print_pelunasanglobalban', [\App\Http\Controllers\Admin\LaporanPelunasanbanController::class, 'print_pelunasanglobalban']);

    Route::get('laporan_fakturpelunasanpart', [\App\Http\Controllers\Admin\LaporanPelunasanpartController::class, 'index']);
    Route::get('print_pelunasanpart', [\App\Http\Controllers\Admin\LaporanPelunasanpartController::class, 'print_pelunasanpart']);
    Route::get('laporan_pelunasanglobalpart', [\App\Http\Controllers\Admin\LaporanPelunasanpartController::class, 'indexglobalpart']);
    Route::get('print_pelunasanglobalpart', [\App\Http\Controllers\Admin\LaporanPelunasanpartController::class, 'print_pelunasanglobalpart']);

    Route::get('laporan_notareturn', [\App\Http\Controllers\Admin\LaporannotareturnController::class, 'index']);
    Route::get('print_nota', [\App\Http\Controllers\Admin\LaporannotareturnController::class, 'print_nota']);

    Route::get('laporan_return', [\App\Http\Controllers\Admin\LaporanReturnController::class, 'index']);
    Route::get('print_return', [\App\Http\Controllers\Admin\LaporanReturnController::class, 'print_return']);

    Route::get('laporan_penjualanreturn', [\App\Http\Controllers\Admin\LaporanPenjualanreturnController::class, 'index']);
    Route::get('print_penjualan', [\App\Http\Controllers\Admin\LaporanPenjualanreturnController::class, 'print_penjualan']);

    Route::get('laporan_mobillogistik', [\App\Http\Controllers\Admin\LaporanMobillogistikController::class, 'index']);
    Route::get('print_mobillogistik', [\App\Http\Controllers\Admin\LaporanMobillogistikController::class, 'print_mobillogistik']);

    Route::get('laporan_mobillogistikglobal', [\App\Http\Controllers\Admin\LaporanMobillogistikglobalController::class, 'index']);
    Route::get('print_mobillogistikglobal', [\App\Http\Controllers\Admin\LaporanMobillogistikglobalController::class, 'print_mobillogistikglobal']);

    Route::delete('inquery_perhitungangaji/deletedetailperhitungangaji/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajiController::class, 'deletedetailperhitungangaji']);
    Route::delete('inquery_perhitungangajibulanan/deletedetailperhitungan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajibulananController::class, 'deletedetailperhitungan']);
    Route::delete('inquery_fakturekspedisi/deletedetailfaktur/{id}', [\App\Http\Controllers\Admin\InqueryFakturekspedisiController::class, 'deletedetailfaktur']);
    Route::delete('inquery_memotambahan/deletedetailtambahan/{id}', [\App\Http\Controllers\Admin\InqueryMemotambahanController::class, 'deletedetailtambahan']);
    Route::delete('inquery_fakturpenjualanreturn/dell/{id}', [\App\Http\Controllers\Admin\InqueryFakturpenjualanreturnController::class, 'dell']);
    Route::delete('inquery_pengeluarankaskecil/deletedetailpengeluaran/{id}', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'deletedetailpengeluaran']);
    Route::delete('inquery_fakturekspedisi/delettariftambahan/{id}', [\App\Http\Controllers\Admin\InqueryFakturekspedisiController::class, 'delettariftambahan']);
    Route::delete('inquery_returnekspedisi/deletedetailsurat/{id}', [\App\Http\Controllers\Admin\InqueryReturnekspedisiController::class, 'deletedetailsurat']);

    Route::delete('inquery_tagihanekspedisi/deletedetailtagihan/{id}', [\App\Http\Controllers\Admin\InqueryTagihanekspedisiController::class, 'deletedetailtagihan']);
    Route::delete('inquery_memoekspedisi/deletedetailbiayatambahan/{id}', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'deletedetailbiayatambahan']);
    Route::delete('inquery_memoekspedisi/deletedetailbiayapotongan/{id}', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'deletedetailbiayapotongan']);

    Route::delete('inquery_fakturpelunasan/deletedetailpelunasan/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanController::class, 'deletedetailpelunasan']);
    Route::delete('inquery_fakturpelunasan/deletedetailpelunasanreturn/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanController::class, 'deletedetailpelunasanreturn']);
    Route::delete('inquery_fakturpelunasan/deletedetailpelunasanpotongan/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanController::class, 'deletedetailpelunasanpotongan']);

    Route::get('faktur_pelunasan/get_fakturpelunasan/{id}', [\App\Http\Controllers\Admin\FakturpelunasanController::class, 'get_fakturpelunasan']);
    Route::get('tagihan_ekspedisi/get_fakturtagihan/{id}', [\App\Http\Controllers\Admin\TagihanekspedisiController::class, 'get_fakturtagihan']);
    Route::get('tagihan_ekspedisi/get_fakturtagihannonpph/{id}', [\App\Http\Controllers\Admin\TagihanekspedisiController::class, 'get_fakturtagihannonpph']);
    Route::get('inquery_tagihanekspedisi/get_fakturtagihan/{id}', [\App\Http\Controllers\Admin\InqueryTagihanekspedisiController::class, 'get_fakturtagihan']);
    Route::get('inquery_tagihanekspedisi/get_fakturtagihannonpph/{id}', [\App\Http\Controllers\Admin\InqueryTagihanekspedisiController::class, 'get_fakturtagihannonpph']);
    Route::get('faktur_ekspedisi/get_faktur/{id}', [\App\Http\Controllers\Admin\FakturekspedisiController::class, 'get_faktur']);

    Route::get('postingfilter', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'postingfilter']);
    Route::get('unpostfilter', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'unpostfilter']);
    Route::post('delete-row', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'deleteRow'])->name('delete.row');

    Route::get('postingmemoborongfilter', [\App\Http\Controllers\Admin\InqueryMemoborongController::class, 'postingmemoborongfilter']);
    Route::get('unpostmemoborongfilter', [\App\Http\Controllers\Admin\InqueryMemoborongController::class, 'unpostmemoborongfilter']);

    Route::get('postingmemotambahanfilter', [\App\Http\Controllers\Admin\InqueryMemotambahanController::class, 'postingmemotambahanfilter']);
    Route::get('unpostmemotambahanfilter', [\App\Http\Controllers\Admin\InqueryMemotambahanController::class, 'unpostmemotambahanfilter']);

    Route::get('postingpengeluaranfilter', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'postingpengeluaranfilter']);
    Route::get('unpostpengeluaranfilter', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'unpostpengeluaranfilter']);
    // Route::get('cetak_pengeluaranfilter', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'cetak_pengeluaranfilter']);
    Route::get('cetak_buktifilter', [\App\Http\Controllers\Admin\InqueryBuktipotongpajakController::class, 'cetak_buktifilter']);
    Route::get('cetak_buktifilterfoto', [\App\Http\Controllers\Admin\InqueryBuktipotongpajakController::class, 'cetak_buktifilterfoto']);

    Route::get('cetak_memoekspedisifilter', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'cetak_memoekspedisifilter']);
    Route::get('cetak_memoborongfilter', [\App\Http\Controllers\Admin\InqueryMemoborongController::class, 'cetak_memoborongfilter']);
    Route::get('cetak_memotambahanfilter', [\App\Http\Controllers\Admin\InqueryMemotambahanController::class, 'cetak_memotambahanfilter']);
    Route::get('cetak_fakturekspedisifilter', [\App\Http\Controllers\Admin\InqueryFakturekspedisiController::class, 'cetak_fakturekspedisifilter']);
    Route::get('deletefakturfilter', [\App\Http\Controllers\Admin\InqueryFakturekspedisiController::class, 'deletefakturfilter']);
    Route::get('deletememotambahanfilter', [\App\Http\Controllers\Admin\InqueryMemotambahanController::class, 'deletememotambahanfilter']);

    Route::get('cetak_gajibulananfilter', [\App\Http\Controllers\Admin\InqueryslipgajibulananController::class, 'cetak_gajibulananfilter']);
    Route::get('cetak_gajifilter', [\App\Http\Controllers\Admin\InqueryslipgajiController::class, 'cetak_gajifilter']);

    Route::get('download_gajibulananfilter', [\App\Http\Controllers\Admin\InqueryslipgajibulananController::class, 'downloadMultiplePDFs']);

    Route::get('laporan_perhitungangaji', [\App\Http\Controllers\Admin\LaporanPerhitungangajiController::class, 'index']);
    Route::get('print_perhitungangaji', [\App\Http\Controllers\Admin\LaporanPerhitungangajiController::class, 'print_perhitungangaji']);
    Route::get('laporan_perhitungangajibulanan', [\App\Http\Controllers\Admin\LaporanPerhitungangajibulananController::class, 'index']);
    Route::get('print_perhitungangajibulanan', [\App\Http\Controllers\Admin\LaporanPerhitungangajibulananController::class, 'print_perhitungangajibulanan']);

    Route::get('laporan_slipgaji', [\App\Http\Controllers\Admin\LaporanSlipgajiController::class, 'index']);
    Route::get('print_slipgaji', [\App\Http\Controllers\Admin\LaporanSlipgajiController::class, 'print_slipgaji']);
    Route::resource('laporan_slipgaji', \App\Http\Controllers\Admin\LaporanSlipgajiController::class);

    Route::get('inquery_slipgaji', [\App\Http\Controllers\Admin\InqueryslipgajiController::class, 'index']);
    Route::get('inquery_printslipgaji', [\App\Http\Controllers\Admin\InqueryslipgajiController::class, 'inquery_printslipgaji']);

    Route::get('inquery_slipgajibulanan', [\App\Http\Controllers\Admin\InqueryslipgajibulananController::class, 'index']);
    Route::get('inquery_printslipgajibulanan', [\App\Http\Controllers\Admin\InqueryslipgajibulananController::class, 'inquery_printslipgajibulanan']);

    Route::get('laporan_slipgajibulanan', [\App\Http\Controllers\Admin\LaporanSlipgajibulananController::class, 'index']);
    Route::get('print_slipgajibulanan', [\App\Http\Controllers\Admin\LaporanSlipgajibulananController::class, 'print_slipgajibulanan']);
    Route::resource('laporan_slipgajibulanan', \App\Http\Controllers\Admin\LaporanSlipgajibulananController::class);

    Route::resource('saldo_ujs', \App\Http\Controllers\Admin\LaporanSaldoujsController::class);
    Route::resource('saldo_kasbon', \App\Http\Controllers\Admin\LaporanSaldokasbonController::class);

    Route::get('inquery_buktipotongpajak/unpostbukti/{id}', [\App\Http\Controllers\Admin\InqueryBuktipotongpajakController::class, 'unpostbukti']);
    Route::get('inquery_buktipotongpajak/postingbukti/{id}', [\App\Http\Controllers\Admin\InqueryBuktipotongpajakController::class, 'postingbukti']);
    Route::get('inquery_buktipotongpajak/delete_item/{id}', [\App\Http\Controllers\Admin\InqueryBuktipotongpajakController::class, 'delete_item']);
    Route::get('hapusbukti/{id}', [\App\Http\Controllers\Admin\InqueryBuktipotongpajakController::class, 'hapusbukti'])->name('hapusbukti');
    Route::get('bukti_potongpajak/cetak-pdf/{id}', [\App\Http\Controllers\Admin\BuktipotongController::class, 'cetakpdf']);
    Route::post('updatebuktitagihan/{id}', [\App\Http\Controllers\Admin\BuktipotongController::class, 'updatebuktitagihan'])->name('updatebuktitagihan');
    Route::get('driver/cetak-pdf/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'cetakpdf']);

    Route::get('klaim_peralatan/get_detailinventory/{id}', [\App\Http\Controllers\Admin\KlaimperalatanController::class, 'get_detailinventory']);

    Route::resource('faktur_pelunasanperinvoice', \App\Http\Controllers\Admin\FakturpelunasanperinvoiceController::class);
    Route::resource('faktur_pelunasanperfaktur', \App\Http\Controllers\Admin\FakturpelunasanperfakturController::class);
    Route::resource('buktipotong', \App\Http\Controllers\Admin\BuktipotongController::class);
    Route::resource('karyawan', \App\Http\Controllers\Admin\KaryawanController::class);
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('departemen', \App\Http\Controllers\Admin\DepartemenController::class);
    Route::resource('supplier', \App\Http\Controllers\Admin\SupplierController::class);
    Route::resource('pelanggan', \App\Http\Controllers\Admin\PelangganController::class);
    Route::resource('vendor', \App\Http\Controllers\Admin\VendorController::class);
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
    Route::resource('inquery_pemasanganpart', \App\Http\Controllers\Admin\InqueryPemasanganpartController::class);
    Route::resource('laporan_pemasanganpart', \App\Http\Controllers\Admin\LaporanpemasanganpartController::class);
    Route::resource('penggantian_oli', \App\Http\Controllers\Admin\PenggantianOliController::class);
    Route::resource('inquery_penggantianoli', \App\Http\Controllers\Admin\InqueryPenggantianoliController::class);
    Route::resource('laporan_penggantianoli', \App\Http\Controllers\Admin\LaporanPenggantianoliController::class);
    Route::resource('status_perjalanan', \App\Http\Controllers\Admin\StatusPerjalananController::class);
    Route::resource('laporan_statusperjalanan', \App\Http\Controllers\Admin\LaporanStatusPerjalananController::class);
    Route::resource('kota', \App\Http\Controllers\Admin\KotaController::class);
    Route::resource('inquery_perpanjanganstnk', \App\Http\Controllers\Admin\InqueryPerpanjanganstnkController::class);
    Route::resource('inquery_perpanjangankir', \App\Http\Controllers\Admin\InqueryPerpanjangankirController::class);
    Route::resource('penerimaan_kaskecil', \App\Http\Controllers\Admin\PenerimaankaskecilController::class);
    Route::resource('penambahan_saldokasbon', \App\Http\Controllers\Admin\PenambahansaldokasbonController::class);
    Route::resource('inquery_penerimaankaskecil', \App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class);
    Route::resource('inquery_penambahansaldokasbon', \App\Http\Controllers\Admin\InqueryPenambahansaldokasbonController::class);
    Route::resource('rute_perjalanan', \App\Http\Controllers\Admin\RuteperjalananController::class);
    Route::resource('memo_ekspedisi', \App\Http\Controllers\Admin\MemoekspedisiController::class);
    Route::resource('inquery_memoekspedisi', \App\Http\Controllers\Admin\InqueryMemoekspedisiController::class);
    Route::resource('inquery_memoborong', \App\Http\Controllers\Admin\InqueryMemoborongController::class);
    Route::resource('inquery_memotambahan', \App\Http\Controllers\Admin\InqueryMemotambahanController::class);
    Route::resource('biaya_tambahan', \App\Http\Controllers\Admin\BiayatambahanController::class);
    Route::resource('potongan_memo', \App\Http\Controllers\Admin\PotonganmemoController::class);
    Route::resource('driver', \App\Http\Controllers\Admin\DriverController::class);
    Route::resource('deposit_driver', \App\Http\Controllers\Admin\DepositdriverController::class);
    Route::resource('inquery_depositdriver', \App\Http\Controllers\Admin\InqueryDepositdriverController::class);
    Route::resource('inquery_kasbonkaryawan', \App\Http\Controllers\Admin\InqueryKasbonkaryawanController::class);
    Route::resource('inquery_pemasukandeposit', \App\Http\Controllers\Admin\InqueryPemasukandepositController::class);
    Route::resource('laporan_depositdriver', \App\Http\Controllers\Admin\LaporanDepositdriverController::class);
    Route::resource('tarif', \App\Http\Controllers\Admin\TarifController::class);
    Route::resource('faktur_ekspedisi', \App\Http\Controllers\Admin\FakturekspedisiController::class);
    Route::resource('inquery_fakturekspedisi', \App\Http\Controllers\Admin\InqueryFakturekspedisiController::class);
    Route::resource('tagihan_ekspedisi', \App\Http\Controllers\Admin\TagihanekspedisiController::class);
    Route::resource('potongan_penjualan', \App\Http\Controllers\Admin\PotonganpenjualanController::class);
    Route::resource('inquery_tagihanekspedisi', \App\Http\Controllers\Admin\InqueryTagihanekspedisiController::class);
    Route::resource('satuan', \App\Http\Controllers\Admin\SatuanController::class);
    Route::resource('return_ekspedisi', \App\Http\Controllers\Admin\ReturnekspedisiController::class);
    Route::resource('nota_returnbarang', \App\Http\Controllers\Admin\NotareturnController::class);
    Route::resource('barang', \App\Http\Controllers\Admin\BarangController::class);
    Route::resource('inquery_returnekspedisi', \App\Http\Controllers\Admin\InqueryReturnekspedisiController::class);
    Route::resource('inquery_notareturn', \App\Http\Controllers\Admin\InqueryNotareturnController::class);
    Route::resource('faktur_pelunasan', \App\Http\Controllers\Admin\FakturpelunasanController::class);
    Route::resource('faktur_pelunasanban', \App\Http\Controllers\Admin\FakturpelunasanbanController::class);
    Route::resource('faktur_pelunasanpart', \App\Http\Controllers\Admin\FakturpelunasanpartController::class);
    Route::resource('inquery_fakturpelunasan', \App\Http\Controllers\Admin\InqueryFakturpelunasanController::class);
    Route::resource('inquery_banpembelianlunas', \App\Http\Controllers\Admin\InqueryFakturpelunasanbanController::class);
    Route::resource('inquery_partpembelianlunas', \App\Http\Controllers\Admin\InqueryFakturpelunasanpartController::class);
    Route::resource('inquery_pilihmemo', \App\Http\Controllers\Admin\InqueryPilihmemoController::class);
    Route::resource('inquery_pilihdeposit', \App\Http\Controllers\Admin\InqueryPilihdepositController::class);
    Route::resource('pilih_returnekspedisi', \App\Http\Controllers\Admin\PilihreturnekspedisiController::class);
    Route::resource('pilih_inqueryreturnekspedisi', \App\Http\Controllers\Admin\InquerypilihreturnekspedisiController::class);
    Route::resource('pilih_laporanreturn', \App\Http\Controllers\Admin\PilihLaporanreturnController::class);
    Route::resource('pilihlaporanmemo', \App\Http\Controllers\Admin\PilihLaporanmemoController::class);
    Route::resource('pilih_laporankaskecil', \App\Http\Controllers\Admin\PilihLaporankaskecilController::class);
    Route::resource('pilih_deposit', \App\Http\Controllers\Admin\PilihdepositController::class);
    Route::resource('faktur_penjualanreturn', \App\Http\Controllers\Admin\FakturpenjualanreturnController::class);
    Route::resource('inquery_fakturpenjualanreturn', \App\Http\Controllers\Admin\InqueryFakturpenjualanreturnController::class);
    Route::resource('akun', \App\Http\Controllers\Admin\BarangakunController::class);
    Route::resource('pengeluaran_kaskecil', \App\Http\Controllers\Admin\PengeluarankaskecilController::class);
    Route::resource('inquery_pengeluarankaskecil', \App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class);
    Route::resource('tablememo', \App\Http\Controllers\Admin\TablememoController::class);
    Route::resource('tabletagihan', \App\Http\Controllers\Admin\TabletagihanController::class);
    Route::resource('tablepotongan', \App\Http\Controllers\Admin\TablepotonganController::class);
    Route::resource('tablefaktur', \App\Http\Controllers\Admin\TablefakturController::class);
    Route::resource('tablepengeluaran', \App\Http\Controllers\Admin\TablepengeluaranController::class);
    Route::resource('tablepelunasan', \App\Http\Controllers\Admin\TablefakturpelunasanController::class);
    Route::resource('tablepembelianban', \App\Http\Controllers\Admin\TablePelunasanbanController::class);
    Route::resource('tablepembelianpart', \App\Http\Controllers\Admin\TablePelunasanpartController::class);
    Route::resource('listadministrasi', \App\Http\Controllers\Admin\ListadministrasiController::class);
    Route::resource('deposit_driver', \App\Http\Controllers\Admin\DepositdriverController::class);
    Route::resource('pengambilanujs', \App\Http\Controllers\Admin\PengambilanujsController::class);
    Route::resource('inquery_pengeluaranujs', \App\Http\Controllers\Admin\InqueryPengeluaranujsController::class);
    Route::resource('laporan_kasbonkaryawan', \App\Http\Controllers\Admin\LaporanKasbonkaryawanController::class);
    Route::resource('pelunasan_deposit', \App\Http\Controllers\Admin\PelunasandepositController::class);
    Route::resource('laporan_buktipotongpajak', \App\Http\Controllers\Admin\LaporanBuktipotongpajakController::class);
    Route::resource('laporan_buktipotongpajakglobal', \App\Http\Controllers\Admin\LaporanBuktipotongpajakglobalController::class);

    Route::resource('gaji_karyawan', \App\Http\Controllers\Admin\GajikaryawanController::class);
    Route::resource('perhitungan_gaji', \App\Http\Controllers\Admin\PerhitungangajiController::class);
    Route::resource('inquery_potonganpenjualan', \App\Http\Controllers\Admin\InqueryPotonganpenjualanController::class);
    Route::resource('kasbon_karyawan', \App\Http\Controllers\Admin\KasbonkaryawanController::class);
    Route::resource('memo_posting', \App\Http\Controllers\Admin\MemopostingController::class);
    Route::resource('klaim_ban', \App\Http\Controllers\Admin\KlaimbanController::class);
    Route::resource('inqueryklaim_ban', \App\Http\Controllers\Admin\InqueryKlaimbanController::class);
    Route::resource('perhitungan_gajibulanan', \App\Http\Controllers\Admin\PerhitungangajibulananController::class);
    Route::resource('inquery_perhitungangaji', \App\Http\Controllers\Admin\InqueryPerhitungangajiController::class);
    Route::resource('inquery_perhitungangajibulanan', \App\Http\Controllers\Admin\InqueryPerhitungangajibulananController::class);
    Route::resource('report_slipgajibulanan', \App\Http\Controllers\Admin\ReportgajibulananController::class);
    Route::resource('report_slipgajimingguan', \App\Http\Controllers\Admin\ReportgajimingguanController::class);
    Route::resource('bukti_potongpajak', \App\Http\Controllers\Admin\BuktipotongpajakController::class);
    Route::resource('inquery_buktipotongpajak', \App\Http\Controllers\Admin\InqueryBuktipotongpajakController::class);
    Route::resource('laporan_buktipotongpajak', \App\Http\Controllers\Admin\LaporanBuktipotongpajakController::class);
    Route::resource('alamat_muat', \App\Http\Controllers\Admin\AlamatmuatController::class);
    Route::resource('alamat_bongkar', \App\Http\Controllers\Admin\AlamatbongkarController::class);
    Route::resource('pengambilan_do', \App\Http\Controllers\Admin\PengambilandoController::class);

    Route::get('inquery_pemakaianperalatan/unpostpemakaian/{id}', [\App\Http\Controllers\Admin\InqueryPemakaianperalatanController::class, 'unpostpemakaian']);
    Route::get('inquery_pemakaianperalatan/postingpemakaian/{id}', [\App\Http\Controllers\Admin\InqueryPemakaianperalatanController::class, 'postingpemakaian']);
    Route::get('hapuspemakaian/{id}', [\App\Http\Controllers\Admin\InqueryPemakaianperalatanController::class, 'hapuspemakaian'])->name('hapuspemakaian');
    Route::delete('inquery_pemakaianperalatan/deletedetailpemakaians/{id}', [\App\Http\Controllers\Admin\InqueryPemakaianperalatanController::class, 'deletedetailpemakaians']);
    Route::get('pemakaian_peralatan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PemakainperalatanController::class, 'cetakpdf']);
    Route::get('inquery_klaimperalatan/unpostklaimperalatan/{id}', [\App\Http\Controllers\Admin\InqueryKlaimperalatanController::class, 'unpostklaimperalatan']);
    Route::get('inquery_klaimperalatan/postingklaimperalatan/{id}', [\App\Http\Controllers\Admin\InqueryKlaimperalatanController::class, 'postingklaimperalatan']);
    Route::get('pengambilan_do/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PengambilandoController::class, 'cetakpdf']);

    Route::get('postingfilterpenerimaansj', [\App\Http\Controllers\Admin\PenerimaansjController::class, 'postingfilterpenerimaansj']);
    Route::get('unpostfilterpenerimaansj', [\App\Http\Controllers\Admin\PenerimaansjController::class, 'unpostfilterpenerimaansj']);
    Route::resource('memo_ekspedisispk', \App\Http\Controllers\Admin\MemoekspedisispkController::class);
    Route::resource('inquery_memoekspedisispk', \App\Http\Controllers\Admin\InqueryMemoekspedisispkController::class);
    Route::resource('inquery_memoborongspk', \App\Http\Controllers\Admin\InqueryMemoborongspkController::class);
    Route::resource('faktur_ekspedisispk', \App\Http\Controllers\Admin\FakturekspedisispkController::class);
    Route::resource('inquery_fakturekspedisispk', \App\Http\Controllers\Admin\InqueryFakturekspedisispkController::class);
    Route::delete('inquery_fakturekspedisispk/deletedetailfaktur/{id}', [\App\Http\Controllers\Admin\InqueryFakturekspedisispkController::class, 'deletedetailfaktur']);
    Route::delete('inquery_memoekspedisispk/deletedetailbiayatambahan/{id}', [\App\Http\Controllers\Admin\InqueryMemoekspedisispkController::class, 'deletedetailbiayatambahan']);
    Route::delete('inquery_memoekspedisispk/deletedetailbiayapotongan/{id}', [\App\Http\Controllers\Admin\InqueryMemoekspedisispkController::class, 'deletedetailbiayapotongan']);
    Route::get('inquery_fakturekspedisispk', [\App\Http\Controllers\Admin\InqueryFakturekspedisispkController::class, 'index']);
    Route::get('inquery_memoekspedisispk/unpostmemo/{id}', [\App\Http\Controllers\Admin\InqueryMemoekspedisispkController::class, 'unpostmemo']);
    Route::get('inquery_memoekspedisispk/postingmemo/{id}', [\App\Http\Controllers\Admin\InqueryMemoekspedisispkController::class, 'postingmemo']);
    Route::delete('inquery_fakturekspedisispk/delettariftambahan/{id}', [\App\Http\Controllers\Admin\InqueryFakturekspedisispkController::class, 'delettariftambahan']);
    Route::get('hapusspk/{id}', [\App\Http\Controllers\Admin\InquerySpkController::class, 'hapusspk'])->name('hapusspk');
    Route::resource('spk', \App\Http\Controllers\Admin\SpkController::class);
    Route::resource('inquery_spk', \App\Http\Controllers\Admin\InquerySpkController::class);
    Route::resource('status_spk', \App\Http\Controllers\Admin\StatusSpkController::class);
    Route::resource('penerimaan_sj', \App\Http\Controllers\Admin\PenerimaansjController::class);
    Route::post('tambah_spk', [\App\Http\Controllers\Admin\MemoekspedisispkController::class, 'tambah_spk']);
    Route::get('inquery_spk/unpostspk/{id}', [\App\Http\Controllers\Admin\InquerySpkController::class, 'unpostspk']);
    Route::get('inquery_spk/postingspk/{id}', [\App\Http\Controllers\Admin\InquerySpkController::class, 'postingspk']);
    Route::get('penerimaan_sj/unpostspkpenerimaan/{id}', [\App\Http\Controllers\Admin\PenerimaansjController::class, 'unpostspkpenerimaan']);
    Route::get('penerimaan_sj/postingspkpenerimaan/{id}', [\App\Http\Controllers\Admin\PenerimaansjController::class, 'postingspkpenerimaan']);
    Route::get('inquery_spk/unpostspk/{id}', [\App\Http\Controllers\Admin\InquerySpkController::class, 'unpostspk']);
    Route::get('inquery_spk/postingspk/{id}', [\App\Http\Controllers\Admin\InquerySpkController::class, 'postingspk']);
    Route::resource('inquery_spk', \App\Http\Controllers\Admin\InquerySpkController::class);
    Route::resource('inventory_peralatan', \App\Http\Controllers\Admin\InventoryPeralatanController::class);
    Route::resource('pemakaian_peralatan', \App\Http\Controllers\Admin\PemakainperalatanController::class);
    Route::resource('inquery_pemakaianperalatan', \App\Http\Controllers\Admin\InqueryPemakaianperalatanController::class);
    Route::resource('klaim_peralatan', \App\Http\Controllers\Admin\KlaimperalatanController::class);
    Route::resource('inquery_klaimperalatan', \App\Http\Controllers\Admin\InqueryKlaimperalatanController::class);
    Route::resource('marketing', \App\Http\Controllers\Admin\MarketingController::class);

    Route::get('laporan_pemakaianperalatan', [\App\Http\Controllers\Admin\LaporanpemakaianperalatanController::class, 'index']);
    Route::get('print_pemakaianperalatan', [\App\Http\Controllers\Admin\LaporanpemakaianperalatanController::class, 'print_pemakaianperalatan']);

    Route::get('laporan_klaimperalatan', [\App\Http\Controllers\Admin\LaporanklaimperalatanController::class, 'index']);
    Route::get('print_klaimperalatan', [\App\Http\Controllers\Admin\LaporanklaimperalatanController::class, 'print_klaimperalatan']);

    Route::get('laporan_klaimban', [\App\Http\Controllers\Admin\LaporanklaimbanController::class, 'index']);
    Route::get('print_klaimban', [\App\Http\Controllers\Admin\LaporanklaimbanController::class, 'print_klaimban']);

    Route::resource('inquery_pengambilando', \App\Http\Controllers\Admin\InqueryPengambilandoController::class);
    Route::get('inquery_pengambilando/unpostpengambilando/{id}', [\App\Http\Controllers\Admin\InqueryPengambilandoController::class, 'unpostpengambilando']);
    Route::get('inquery_pengambilando/postingpengambilando/{id}', [\App\Http\Controllers\Admin\InqueryPengambilandoController::class, 'postingpengambilando']);
    Route::get('hapuspengambilando/{id}', [\App\Http\Controllers\Admin\InqueryPengambilandoController::class, 'hapuspengambilando'])->name('hapuspengambilando');
    Route::resource('status_pemberiando', \App\Http\Controllers\Admin\StatusPemberiandoController::class);

    Route::get('inquery_fakturpelunasan/unpostpelunasan/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanController::class, 'unpostpelunasan']);
    Route::get('inquery_fakturpelunasan/postingpelunasan/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanController::class, 'postingpelunasan']);
});