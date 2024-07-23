<li class="nav-header">
    Dashboard</li>
<li class="nav-item">
    <a href="{{ url('admin') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-header">Search</li>

<div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
            </button>
        </div>
    </div>
</div>
<li class="nav-header">Menu</li>
<li
    class="nav-item {{ request()->is('admin/akun*') ||
    request()->is('admin/gaji_karyawan*') ||
    request()->is('admin/barang*') ||
    request()->is('admin/satuan*') ||
    request()->is('admin/driver*') ||
    request()->is('admin/tarif*') ||
    request()->is('admin/potongan_memo*') ||
    request()->is('admin/biaya_tambahan*') ||
    request()->is('admin/rute_perjalanan*') ||
    request()->is('admin/karyawan*') ||
    request()->is('admin/user*') ||
    request()->is('admin/akses*') ||
    request()->is('admin/departemen*') ||
    request()->is('admin/supplier*') ||
    request()->is('admin/pelanggan*') ||
    request()->is('admin/vendor*') ||
    request()->is('admin/kendaraan') ||
    request()->is('admin/ban') ||
    request()->is('admin/golongan') ||
    request()->is('admin/divisi') ||
    request()->is('admin/jenis_kendaraan') ||
    request()->is('admin/ukuran_ban') ||
    request()->is('admin/merek_ban') ||
    request()->is('admin/type_ban') ||
    request()->is('admin/nokir') ||
    request()->is('admin/stnk') ||
    request()->is('admin/inventory_peralatan') ||
    request()->is('admin/sparepart')
        ? 'menu-open'
        : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/akun*') ||
        request()->is('admin/gaji_karyawan*') ||
        request()->is('admin/barang*') ||
        request()->is('admin/satuan*') ||
        request()->is('admin/driver*') ||
        request()->is('admin/tarif*') ||
        request()->is('admin/potongan_memo*') ||
        request()->is('admin/biaya_tambahan*') ||
        request()->is('admin/rute_perjalanan*') ||
        request()->is('admin/karyawan*') ||
        request()->is('admin/user*') ||
        request()->is('admin/akses*') ||
        request()->is('admin/departemen*') ||
        request()->is('admin/supplier*') ||
        request()->is('admin/pelanggan*') ||
        request()->is('admin/vendor*') ||
        request()->is('admin/kendaraan') ||
        request()->is('admin/ban') ||
        request()->is('admin/golongan') ||
        request()->is('admin/divisi') ||
        request()->is('admin/jenis_kendaraan') ||
        request()->is('admin/ukuran_ban') ||
        request()->is('admin/merek_ban') ||
        request()->is('admin/type_ban') ||
        request()->is('admin/nokir') ||
        request()->is('admin/stnk') ||
        request()->is('admin/inventory_peralatan') ||
        request()->is('admin/sparepart')
            ? 'active'
            : '' }}">

        <i class="nav-icon fas fa-grip-horizontal"></i>
        <p>
            <strong style="color: rgb(255, 255, 255);">MASTER</strong>
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if (auth()->check() && auth()->user()->menu['karyawan'])
            <li class="nav-item">
                <a href="{{ url('admin/karyawan') }}"
                    class="nav-link {{ request()->is('admin/karyawan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Karyawan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['user'])
            <li class="nav-item">
                <a href="{{ url('admin/user') }}" class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data User</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['akses'])
            <li class="nav-item">
                <a href="{{ url('admin/akses') }}" class="nav-link {{ request()->is('admin/akses*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Hak Akses</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['gaji karyawan'])
            <li class="nav-item">
                <a href="{{ url('admin/gaji_karyawan') }}"
                    class="nav-link {{ request()->is('admin/gaji_karyawan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Gaji Karyawan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['departemen'])
            <li class="nav-item">
                <a href="{{ url('admin/departemen') }}"
                    class="nav-link {{ request()->is('admin/departemen*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Departemen</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['supplier'])
            <li class="nav-item">
                <a href="{{ url('admin/supplier') }}"
                    class="nav-link {{ request()->is('admin/supplier*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Supplier</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pelanggan'])
            <li class="nav-item">
                <a href="{{ url('admin/pelanggan') }}"
                    class="nav-link {{ request()->is('admin/pelanggan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Pelanggan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pelanggan'])
            <li class="nav-item">
                <a href="{{ url('admin/vendor') }}"
                    class="nav-link {{ request()->is('admin/vendor*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Vendor</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['divisi mobil'])
            <li class="nav-item">
                <a href="{{ url('admin/divisi') }}"
                    class="nav-link {{ request()->is('admin/divisi*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Divisi Mobil</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['jenis kendaraan'])
            <li class="nav-item">
                <a href="{{ url('admin/jenis_kendaraan') }}"
                    class="nav-link {{ request()->is('admin/jenis_kendaraan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Jenis Kendaraan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['golongan'])
            <li class="nav-item">
                <a href="{{ url('admin/golongan') }}"
                    class="nav-link {{ request()->is('admin/golongan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Golongan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['kendaraan'])
            <li class="nav-item">
                <a href="{{ url('admin/kendaraan') }}"
                    class="nav-link {{ request()->is('admin/kendaraan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Kendaraan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['ukuran ban'])
            <li class="nav-item">
                <a href="{{ url('admin/ukuran_ban') }}"
                    class="nav-link {{ request()->is('admin/ukuran_ban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Ukuran Ban</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['merek ban'])
            <li class="nav-item">
                <a href="{{ url('admin/merek_ban') }}"
                    class="nav-link {{ request()->is('admin/merek_ban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Merek Ban</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['type ban'])
            <li class="nav-item">
                <a href="{{ url('admin/type_ban') }}"
                    class="nav-link {{ request()->is('admin/type_ban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Type Ban</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['ban'])
            <li class="nav-item">
                <a href="{{ url('admin/ban') }}" class="nav-link {{ request()->is('admin/ban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Ban</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['nokir'])
            <li class="nav-item">
                <a href="{{ url('admin/nokir') }}"
                    class="nav-link {{ request()->is('admin/nokir*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data No. Kir</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['stnk'])
            <li class="nav-item">
                <a href="{{ url('admin/stnk') }}"
                    class="nav-link {{ request()->is('admin/stnk*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data No. Stnk</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['part'])
            <li class="nav-item">
                <a href="{{ url('admin/sparepart') }}"
                    class="nav-link {{ request()->is('admin/sparepart*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Part</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['sopir'])
            <li class="nav-item">
                <a href="{{ url('admin/driver') }}"
                    class="nav-link {{ request()->is('admin/driver*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Driver</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['rute perjalanan'])
            <li class="nav-item">
                <a href="{{ url('admin/rute_perjalanan') }}"
                    class="nav-link {{ request()->is('admin/rute_perjalanan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Rute Perjalanan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['biaya tambahan'])
            <li class="nav-item">
                <a href="{{ url('admin/biaya_tambahan') }}"
                    class="nav-link {{ request()->is('admin/biaya_tambahan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Biaya Tambahan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['potongan memo'])
            <li class="nav-item">
                <a href="{{ url('admin/potongan_memo') }}"
                    class="nav-link {{ request()->is('admin/potongan_memo*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Potongan Memo</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['tarif'])
            <li class="nav-item">
                <a href="{{ url('admin/tarif') }}"
                    class="nav-link {{ request()->is('admin/tarif*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Tarif</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['satuan barang'])
            <li class="nav-item" hidden>
                <a href="{{ url('admin/satuan') }}"
                    class="nav-link {{ request()->is('admin/satuan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Satuan Barang</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['barang return'])
            <li class="nav-item">
                <a href="{{ url('admin/barang') }}"
                    class="nav-link {{ request()->is('admin/barang*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Barang Return</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['akun'])
            <li class="nav-item">
                <a href="{{ url('admin/akun') }}"
                    class="nav-link {{ request()->is('admin/akun*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Barang Akun</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['akun'])
            <li class="nav-item">
                <a href="{{ url('admin/inventory_peralatan') }}"
                    class="nav-link {{ request()->is('admin/inventory_peralatan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Inventory Peralatan</p>
                </a>
            </li>
        @endif
    </ul>
</li>
@php
    $stnk = \App\Models\Stnk::where([['status_notif', false]])->get();
    $nokir = \App\Models\Nokir::where([['status_notif', false]])->get();
    $penggantianoli1 = \App\Models\Kendaraan::where([['status_notifkm', false]])->get();

    $currentDate = now(); // Menggunakan Carbon untuk mendapatkan tanggal saat ini
    $twoWeeksLater = $currentDate->copy()->addWeeks(2); // Menambahkan 1 bulan ke tanggal saat ini

    $peringatan = \App\Models\Stnk::where('status_stnk', 'belum perpanjang')
        ->whereDate('expired_stnk', '<', $twoWeeksLater)
        ->get();
    $peringatankir = \App\Models\Nokir::where('status_kir', 'belum perpanjang')
        ->whereDate('masa_berlaku', '<', $twoWeeksLater)
        ->get();

    $peringatan_oli = \App\Models\Kendaraan::where(function ($query) {
        $query
            ->where('status_olimesin', 'belum penggantian')
            ->orWhere('status_oligardan', 'belum penggantian')
            ->orWhere('status_olitransmisi', 'belum penggantian');
    })->get();
@endphp
<li
    class="nav-item {{ request()->is('admin/km*') ||
    request()->is('admin/perpanjangan_stnk*') ||
    request()->is('admin/perpanjangan_kir*') ||
    request()->is('admin/pemasangan_ban*') ||
    request()->is('admin/pelepasan_ban*') ||
    request()->is('admin/pemasangan_part*') ||
    request()->is('admin/penggantian_oli*') ||
    request()->is('admin/status_perjalanan*') ||
    request()->is('admin/pemakaian_peralatan*')
        ? 'menu-open'
        : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/km*') ||
        request()->is('admin/perpanjangan_stnk*') ||
        request()->is('admin/perpanjangan_kir*') ||
        request()->is('admin/pemasangan_ban*') ||
        request()->is('admin/pelepasan_ban*') ||
        request()->is('admin/pemasangan_part*') ||
        request()->is('admin/penggantian_oli*') ||
        request()->is('admin/status_perjalanan*') ||
        request()->is('admin/pemakaian_peralatan*')
            ? 'active'
            : '' }}">

        <i class="nav-icon fas fa-users-cog"></i>
        <p>
            <strong style="color: rgb(255, 255, 255);"> OPERASIONAL</strong>
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if (auth()->check() && auth()->user()->menu['update km'])
            <li class="nav-item">
                <a href="{{ url('admin/km') }}" class="nav-link {{ request()->is('admin/km*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Update KM</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['perpanjangan stnk'])
            <li class="nav-item">
                <a href="{{ url('admin/perpanjangan_stnk') }}"
                    class="nav-link {{ request()->is('admin/perpanjangan_stnk*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Perpanjangan STNK
                        @if (count($stnk) > 0)
                            <span class="right badge badge-info">{{ count($stnk) }}</span>
                        @endif

                        @if (count($peringatan) > 0)
                            <span class="">
                                <i class="fas fa-exclamation-circle" style="color: red;"></i>
                            </span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['perpanjangan kir'])
            <li class="nav-item">
                <a href="{{ url('admin/perpanjangan_kir') }}"
                    class="nav-link {{ request()->is('admin/perpanjangan_kir*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Perpanjangan KIR
                        @if (count($nokir) > 0)
                            <span class="right badge badge-info">{{ count($nokir) }}</span>
                        @endif
                        @if (count($peringatankir) > 0)
                            <span class="">
                                <i class="fas fa-exclamation-circle" style="color: red;"></i>
                            </span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pemasangan ban'])
            <li class="nav-item">
                <a href="{{ url('admin/pemasangan_ban') }}"
                    class="nav-link {{ request()->is('admin/pemasangan_ban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Pemasangan Ban</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pelepasan ban'])
            <li class="nav-item">
                <a href="{{ url('admin/pelepasan_ban') }}"
                    class="nav-link {{ request()->is('admin/pelepasan_ban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Pelepasan Ban</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pemasangan part'])
            <li class="nav-item">
                <a href="{{ url('admin/pemasangan_part') }}"
                    class="nav-link {{ request()->is('admin/pemasangan_part*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Pemasangan Part</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['penggantian oli'])
            <li class="nav-item">
                <a href="{{ url('admin/penggantian_oli') }}"
                    class="nav-link {{ request()->is('admin/penggantian_oli*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Penggantian Oli @if (count($penggantianoli1) > 0)
                            <span class="right badge badge-info">{{ count($penggantianoli1) }}</span>
                        @endif
                        @if (count($peringatan_oli) > 0)
                            <span class="">
                                <i class="fas fa-exclamation-circle" style="color: red;"></i>
                            </span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['status perjalanan kendaraan'])
            <li class="nav-item">
                <a href="{{ url('admin/status_perjalanan') }}"
                    class="nav-link {{ request()->is('admin/status_perjalanan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Status Perjalanan Kendaraan
                    </p>
                </a>
            </li>
        @endif

        @if (auth()->check() && auth()->user()->menu['pemasangan part'])
            <li class="nav-item">
                <a href="{{ url('admin/pemakaian_peralatan') }}"
                    class="nav-link {{ request()->is('admin/pemakaian_peralatan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Pemakaian Peralatan</p>
                </a>
            </li>
        @endif
    </ul>
</li>
@php
    $pembelian = \App\Models\Pembelian_ban::where([['status', 'posting'], ['status_notif', false]])->get();
    $pembelian_part = \App\Models\Pembelian_part::where([['status', 'posting'], ['status_notif', false]])->get();
    $pemasangan = \App\Models\Pemasangan_ban::where([['status', 'posting'], ['status_notif', false]])->get();
    $pelepasan = \App\Models\Pelepasan_ban::where([['status', 'posting'], ['status_notif', false]])->get();
    $pemasanganpart = \App\Models\Pemasangan_part::where([['status', 'posting'], ['status_notif', false]])->get();
    $penggantianoli = \App\Models\Penggantian_oli::where([['status', 'posting'], ['status_notif', false]])->get();
    $kendaraan = \App\Models\LogAktivitas::where([['status', 'posting'], ['status_notif', false]])->get();
@endphp
<li
    class="nav-item {{ request()->is('admin/memo_ekspedisi*') ||
    request()->is('admin/perhitungan_gaji*') ||
    request()->is('admin/kasbon_karyawan*') ||
    request()->is('admin/pelunasan_deposit*') ||
    request()->is('admin/tablememo*') ||
    request()->is('admin/tablefaktur*') ||
    request()->is('admin/tablepotongan*') ||
    request()->is('admin/tabletagihan*') ||
    request()->is('admin/tablepengeluaran*') ||
    request()->is('admin/tablepelunasan*') ||
    request()->is('admin/tablepembelianban*') ||
    request()->is('admin/tablepembelianpart*') ||
    request()->is('admin/saldo_kasbon*') ||
    request()->is('admin/faktur_ekspedisi*') ||
    request()->is('admin/potongan_penjualan*') ||
    request()->is('admin/faktur_pelunasan*') ||
    request()->is('admin/return_ekspedisi*') ||
    request()->is('admin/tagihan_ekspedisi*') ||
    request()->is('admin/pembelian_ban*') ||
    request()->is('admin/pengeluaran_kaskecil*') ||
    request()->is('admin/pilih_deposit*') ||
    request()->is('admin/klaim_ban*') ||
    request()->is('admin/klaim_peralatan*') ||
    request()->is('admin/indexnon*') ||
    request()->is('admin/buktipotong*') ||
    request()->is('admin/status_spk*') ||
    request()->is('admin/spk*') ||
    request()->is('admin/penerimaan_sj*') ||
    request()->is('admin/pembelian_part*')
        ? 'menu-open'
        : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/memo_ekspedisi*') ||
        request()->is('admin/perhitungan_gaji*') ||
        request()->is('admin/kasbon_karyawan*') ||
        request()->is('admin/pelunasan_deposit*') ||
        request()->is('admin/tablememo*') ||
        request()->is('admin/tablefaktur*') ||
        request()->is('admin/tablepotongan*') ||
        request()->is('admin/tabletagihan*') ||
        request()->is('admin/tablepengeluaran*') ||
        request()->is('admin/tablepelunasan*') ||
        request()->is('admin/tablepembelianban*') ||
        request()->is('admin/tablepembelianpart*') ||
        request()->is('admin/saldo_kasbon*') ||
        request()->is('admin/faktur_ekspedisi*') ||
        request()->is('admin/potongan_penjualan*') ||
        request()->is('admin/faktur_pelunasan*') ||
        request()->is('admin/return_ekspedisi*') ||
        request()->is('admin/tagihan_ekspedisi*') ||
        request()->is('admin/pembelian_ban*') ||
        request()->is('admin/pengeluaran_kaskecil*') ||
        request()->is('admin/pilih_deposit*') ||
        request()->is('admin/klaim_ban*') ||
        request()->is('admin/klaim_peralatan*') ||
        request()->is('admin/indexnon*') ||
        request()->is('admin/buktipotong*') ||
        request()->is('admin/status_spk*') ||
        request()->is('admin/spk*') ||
        request()->is('admin/penerimaan_sj*') ||
        request()->is('admin/pembelian_part*')
            ? 'active'
            : '' }}">
        <i class="nav-icon fas fa-exchange-alt"></i>
        <p>
            <strong style="color: rgb(255, 255, 255);">TRANSAKSI</strong>
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if (auth()->check() && auth()->user()->menu['perhitungan gaji'])
            <li class="nav-item">
                <a href="{{ url('admin/perhitungan_gaji') }}"
                    class="nav-link {{ request()->is('admin/perhitungan_gaji*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Perhitungan Gaji Karyawan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['kasbon karyawan'])
            <li class="nav-item">
                <a href="{{ url('admin/kasbon_karyawan') }}"
                    class="nav-link {{ request()->is('admin/kasbon_karyawan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Memo Hutang Karyawan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pembelian ban'])
            <li class="nav-item">
                <a href="{{ url('admin/pembelian_ban') }}"
                    class="nav-link {{ request()->is('admin/pembelian_ban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Faktur Pembelian Ban</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pembelian part'])
            <li class="nav-item">
                <a href="{{ url('admin/pembelian_part') }}"
                    class="nav-link {{ request()->is('admin/pembelian_part*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Faktur Pembelian Part</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pembelian ban'])
            <li class="nav-item">
                <a href="{{ url('admin/klaim_ban') }}"
                    class="nav-link {{ request()->is('admin/klaim_ban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Klaim Ban
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pembelian ban'])
            <li class="nav-item">
                <a href="{{ url('admin/klaim_peralatan') }}"
                    class="nav-link {{ request()->is('admin/klaim_peralatan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Klaim Peralatan
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['deposit sopir'])
            <li class="nav-item">
                <a href="{{ url('admin/pilih_deposit') }}"
                    class="nav-link {{ request()->is('admin/pilih_deposit*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Deposit Sopir
                    </p>
                </a>
            </li>
        @endif
        {{-- @if (auth()->check() && auth()->user()->menu['deposit sopir'])
            <li class="nav-item">
                <a href="{{ url('admin/saldo_kasbon') }}"
                    class="nav-link {{ request()->is('admin/saldo_kasbon*') || request()->is('admin/pelunasan_deposit*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Deposit Karyawan
                    </p>
                </a>
            </li>
        @endif --}}
        @if (auth()->check() && auth()->user()->menu['memo ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/status_spk') }}"
                    class="nav-link {{ request()->is('admin/status_spk*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 13px;">Status Pemesanan Kendaraan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['memo ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/spk') }}"
                    class="nav-link {{ request()->is('admin/spk*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">SPK</p>
                </a>
            </li>
        @endif

        @if (auth()->check() && auth()->user()->menu['memo ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/tablememo') }}"
                    class="nav-link {{ request()->is('admin/tablememo*') || request()->is('admin/memo_ekspedisi*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Memo Ekspedisi</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['faktur ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/penerimaan_sj') }}"
                    class="nav-link {{ request()->is('admin/penerimaan_sj*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Penerimaan Surat Jalan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['faktur ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/tablefaktur') }}"
                    class="nav-link {{ request()->is('admin/tablefaktur*') || request()->is('admin/faktur_ekspedisi*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Faktur Ekspedisi
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['invoice faktur ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/tabletagihan') }}"
                    class="nav-link {{ request()->is('admin/tabletagihan*') || request()->is('admin/tagihan_ekspedisi*') || request()->is('admin/indexnon*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Invoice Faktur Ekspedisi</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['return barang ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/pilih_returnekspedisi') }}"
                    class="nav-link {{ request()->is('admin/pilih_returnekspedisi*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Return Barang Ekspedisi</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['return barang ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/tablepotongan') }}"
                    class="nav-link {{ request()->is('admin/tablepotongan*') || request()->is('admin/potongan_penjualan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Potongan Penjualan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['faktur pelunasan ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/tablepelunasan') }}"
                    class="nav-link {{ request()->is('admin/tablepelunasan*') || request()->is('admin/faktur_pelunasan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Pelunasan Faktur Ekspedisi</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pelunasan faktur pembelian ban'])
            <li class="nav-item">
                <a href="{{ url('admin/tablepembelianban') }}"
                    class="nav-link {{ request()->is('admin/tablepembelianban*') || request()->is('admin/pembelian_ban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Pelunasan Faktur -<br>
                        <span style="margin-left: 32px">Pembelian Ban</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pelunasan faktur pembelian part'])
            <li class="nav-item">
                <a href="{{ url('admin/tablepembelianpart') }}"
                    class="nav-link {{ request()->is('admin/tablepembelianpart*') || request()->is('admin/pembelian_part*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Pelunasan Faktur -<br>
                        <span style="margin-left: 32px">Pembelian Part</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan invoice ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/buktipotong') }}"
                    class="nav-link {{ request()->is('admin/buktipotong*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Bukti Potong</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pengambilan kas kecil'])
            <li class="nav-item">
                <a href="{{ url('admin/tablepengeluaran') }}"
                    class="nav-link {{ request()->is('admin/tablepengeluaran*') || request()->is('admin/pengeluaran_kaskecil*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Pengambilan kas kecil</p>
                </a>
            </li>
        @endif
    </ul>
</li>
<li
    class="nav-item {{ request()->is('admin/inquery_fakturpelunasan*') ||
    request()->is('admin/inquery_perhitungangaji*') ||
    request()->is('admin/inquery_kasbonkaryawan*') ||
    request()->is('admin/listadministrasi*') ||
    request()->is('admin/saldo_ujs*') ||
    request()->is('admin/inquery_banpembelianlunas*') ||
    request()->is('admin/inquery_partpembelianlunas*') ||
    request()->is('admin/inquery_returnekspedisi*') ||
    request()->is('admin/inquery_tagihanekspedisi*') ||
    request()->is('admin/inquery_pembelianban*') ||
    request()->is('admin/inquery_pembelianpart*') ||
    request()->is('admin/inquery_pemasanganban*') ||
    request()->is('admin/inquery_pelepasanban*') ||
    request()->is('admin/inquery_pemasanganpart*') ||
    request()->is('admin/inquery_penggantianoli*') ||
    request()->is('admin/inquery_updatekm*') ||
    request()->is('admin/inquery_perpanjanganstnk*') ||
    request()->is('admin/inquery_perpanjangankir*') ||
    request()->is('admin/inquery_fakturekspedisi*') ||
    request()->is('admin/inquery_depositdriver*') ||
    request()->is('admin/inquery_pengeluaranujs*') ||
    request()->is('admin/inquery_memoekspedisi*') ||
    request()->is('admin/inquery_memoborong*') ||
    request()->is('admin/inquery_memotambahan*') ||
    request()->is('admin/penerimaan_kaskecil*') ||
    request()->is('admin/inquery_penerimaankaskecil*') ||
    request()->is('admin/inquery_potonganpenjualan*') ||
    request()->is('admin/inquery_penambahansaldokasbon*') ||
    request()->is('admin/inqueryklaim_ban*') ||
    request()->is('admin/bukti_potongpajak*') ||
    request()->is('admin/inquery_buktipotongpajak*') ||
    request()->is('admin/inquery_spk*') ||
    request()->is('admin/inquery_pemakaianperalatan*') ||
    request()->is('admin/inquery_pengeluarankaskecil*')
        ? 'menu-open'
        : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/inquery_fakturpelunasan*') ||
        request()->is('admin/inquery_perhitungangaji*') ||
        request()->is('admin/inquery_kasbonkaryawan*') ||
        request()->is('admin/listadministrasi*') ||
        request()->is('admin/saldo_ujs*') ||
        request()->is('admin/inquery_banpembelianlunas*') ||
        request()->is('admin/inquery_partpembelianlunas*') ||
        request()->is('admin/inquery_returnekspedisi*') ||
        request()->is('admin/inquery_tagihanekspedisi*') ||
        request()->is('admin/inquery_pembelianban*') ||
        request()->is('admin/inquery_pembelianpart*') ||
        request()->is('admin/inquery_pemasanganban*') ||
        request()->is('admin/inquery_pelepasanban*') ||
        request()->is('admin/inquery_pemasanganpart*') ||
        request()->is('admin/inquery_penggantianoli*') ||
        request()->is('admin/inquery_updatekm*') ||
        request()->is('admin/inquery_perpanjanganstnk*') ||
        request()->is('admin/inquery_perpanjangankir*') ||
        request()->is('admin/inquery_fakturekspedisi*') ||
        request()->is('admin/inquery_depositdriver*') ||
        request()->is('admin/inquery_pengeluaranujs*') ||
        request()->is('admin/inquery_memoekspedisi*') ||
        request()->is('admin/inquery_memoborong*') ||
        request()->is('admin/inquery_memotambahan*') ||
        request()->is('admin/penerimaan_kaskecil*') ||
        request()->is('admin/inquery_penerimaankaskecil*') ||
        request()->is('admin/inquery_potonganpenjualan*') ||
        request()->is('admin/inquery_penambahansaldokasbon*') ||
        request()->is('admin/inqueryklaim_ban*') ||
        request()->is('admin/bukti_potongpajak*') ||
        request()->is('admin/inquery_buktipotongpajak*') ||
        request()->is('admin/inquery_spk*') ||
        request()->is('admin/inquery_pemakaianperalatan*') ||
        request()->is('admin/inquery_pengeluarankaskecil*')
            ? 'active'
            : '' }}">
        <i class="nav-icon fas fa-file-invoice-dollar"></i>
        {{-- <i class="fas fa-file-invoice-dollar"></i> --}}
        <p>
            <strong style="color: rgb(255, 255, 255);">FINANCE</strong>
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if (auth()->check() && auth()->user()->menu['penerimaan kas kecil'])
            <li class="nav-item">
                <a href="{{ url('admin/penerimaan_kaskecil') }}"
                    class="nav-link {{ request()->is('admin/penerimaan_kaskecil*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Saldo Kas Kecil</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery penerimaan kas kecil'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_penerimaankaskecil') }}"
                    class="nav-link {{ request()->is('admin/inquery_penerimaankaskecil*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Saldo Kas Kecil
                    </p>
                </a>
            </li>
        @endif
        {{-- @if (auth()->check() && auth()->user()->menu['inquery penerimaan kas kecil'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_penambahansaldokasbon') }}"
                    class="nav-link {{ request()->is('admin/inquery_penambahansaldokasbon*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Saldo -<br>
                        <span style="margin-left: 32px">Deposit Karyawan</span>
                    </p>
                </a>
            </li>
        @endif --}}
        @if (auth()->check() && auth()->user()->menu['inquery deposit sopir'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pilihdeposit') }}"
                    class="nav-link {{ request()->is('admin/inquery_pilihdeposit*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Deposit Sopir
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery deposit sopir'])
            <li class="nav-item">
                <a href="{{ url('admin/saldo_ujs') }}"
                    class="nav-link {{ request()->is('admin/saldo_ujs*') || request()->is('admin/listadministrasi*') || request()->is('admin/pengambilanujs*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">UJS(Uang Jaminan Sopir)
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery deposit sopir'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pengeluaranujs') }}"
                    class="nav-link {{ request()->is('admin/inquery_pengeluaranujs*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Pengambilan UJS
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery update km'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_updatekm') }}"
                    class="nav-link {{ request()->is('admin/inquery_updatekm*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Update Km @if (count($kendaraan) > 0)
                            <span class="right badge badge-info">{{ count($kendaraan) }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
        {{-- @if (auth()->check() && auth()->user()->menu['inquery pembelian ban'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pengeluaranujs') }}"
                    class="nav-link {{ request()->is('admin/inquery_pengeluaranujs*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Pengambilan UJS
                    </p>
                </a>
            </li>
        @endif --}}
        @if (auth()->check() && auth()->user()->menu['inquery pembelian ban'])
            <li class="nav-item">
                <a href="{{ url('admin/inqueryklaim_ban') }}"
                    class="nav-link {{ request()->is('admin/inqueryklaim_ban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Klaim Ban
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pembelian ban'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pembelianban') }}"
                    class="nav-link {{ request()->is('admin/inquery_pembelianban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 13px;">Inquery Faktur Pembelian Ban @if (count($pembelian) > 0)
                            <span class="right badge badge-info">{{ count($pembelian) }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pembelian part'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pembelianpart') }}"
                    class="nav-link {{ request()->is('admin/inquery_pembelianpart*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 13px;">Inquery Faktur Pembelian Part @if (count($pembelian_part) > 0)
                            <span class="right badge badge-info">{{ count($pembelian_part) }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pemasangan ban'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pemasanganban') }}"
                    class="nav-link {{ request()->is('admin/inquery_pemasanganban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Pemasangan Ban @if (count($pemasangan) > 0)
                            <span class="right badge badge-info">{{ count($pemasangan) }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pelepasan ban'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pelepasanban') }}"
                    class="nav-link {{ request()->is('admin/inquery_pelepasanban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Pelepasan Ban @if (count($pelepasan) > 0)
                            <span class="right badge badge-info">{{ count($pelepasan) }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pemasangan part'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pemasanganpart') }}"
                    class="nav-link {{ request()->is('admin/inquery_pemasanganpart*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Pemasangan Part @if (count($pemasanganpart) > 0)
                            <span class="right badge badge-info">{{ count($pemasanganpart) }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pemasangan part'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pemakaianperalatan') }}"
                    class="nav-link {{ request()->is('admin/inquery_pemakaianperalatan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 13px;">Inquery Pemakaian Peralatan
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery penggantian oli'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_penggantianoli') }}"
                    class="nav-link {{ request()->is('admin/inquery_penggantianoli*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Penggantian Oli @if (count($penggantianoli) > 0)
                            <span class="right badge badge-info">{{ count($penggantianoli) }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif

        @if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_perpanjanganstnk') }}"
                    class="nav-link {{ request()->is('admin/inquery_perpanjanganstnk*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Perpanjangan Stnk
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery perpanjangan kir'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_perpanjangankir') }}"
                    class="nav-link {{ request()->is('admin/inquery_perpanjangankir*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Perpanjangan Kir
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery kasbon karyawan'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_kasbonkaryawan') }}"
                    class="nav-link {{ request()->is('admin/inquery_kasbonkaryawan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Memo Hutang-<br>
                        <span style="margin-left: 32px">Karyawan</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery perhitungan gaji'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_perhitungangaji') }}"
                    class="nav-link {{ request()->is('admin/inquery_perhitungangaji*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Perhitungan Gaji
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery memo ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_spk') }}"
                    class="nav-link {{ request()->is('admin/inquery_spk*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery SPK
                    </p>
                </a>
            </li>
        @endif

        @if (auth()->check() && auth()->user()->menu['inquery memo ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_memoekspedisi') }}"
                    class="nav-link {{ request()->is('admin/inquery_memoekspedisi*') || request()->is('admin/inquery_memoborong*') || request()->is('admin/inquery_memotambahan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Memo Ekspedisi
                    </p>
                </a>
            </li>
        @endif
        {{-- @if (auth()->check() && auth()->user()->menu['inquery memo ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/memo_posting') }}"
                    class="nav-link {{ request()->is('admin/memo_posting*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Memo Posting Hari Ini
                    </p>
                </a>
            </li>
        @endif --}}
        @if (auth()->check() && auth()->user()->menu['inquery faktur ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_fakturekspedisi') }}"
                    class="nav-link {{ request()->is('admin/inquery_fakturekspedisi*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Faktur Ekspedisi
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery invoice faktur ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_tagihanekspedisi') }}"
                    class="nav-link {{ request()->is('admin/inquery_tagihanekspedisi*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Invoice F. Ekspedisi
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery return ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/pilih_inqueryreturnekspedisi') }}"
                    class="nav-link {{ request()->is('admin/pilih_inqueryreturnekspedisi*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Return Ekspedisi
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery return ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_potonganpenjualan') }}"
                    class="nav-link {{ request()->is('admin/inquery_potonganpenjualan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Potongan Penjualan
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pelunasan ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_fakturpelunasan') }}"
                    class="nav-link {{ request()->is('admin/inquery_fakturpelunasan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Pelunasan Ekspedisi
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pelunasan faktur pembelian ban'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_banpembelianlunas') }}"
                    class="nav-link {{ request()->is('admin/inquery_banpembelianlunas*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Pelunasan -<br>
                        <span style="margin-left: 32px">Faktur Pembelian Ban</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pelunasan faktur pembelian part'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_partpembelianlunas') }}"
                    class="nav-link {{ request()->is('admin/inquery_partpembelianlunas*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Pelunasan -<br>
                        <span style="margin-left: 32px">Faktur Pembelian Part</span>
                    </p>
                </a>
            </li>
        @endif
        {{-- @if (auth()->check() && auth()->user()->menu['laporan invoice ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/bukti_potongpajak') }}"
                    class="nav-link {{ request()->is('admin/bukti_potongpajak*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 13px;">Bukti Potong Pajak
                    </p>
                </a>
            </li>
        @endif --}}
        @if (auth()->check() && auth()->user()->menu['laporan invoice ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_buktipotongpajak') }}"
                    class="nav-link {{ request()->is('admin/inquery_buktipotongpajak*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 13px;">Inquery Bukti Potong Pajak
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pengambilan kas kecil'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pengeluarankaskecil') }}"
                    class="nav-link {{ request()->is('admin/inquery_pengeluarankaskecil*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 13px;">Inquery Pengambilan Kas Kecil
                    </p>
                </a>
            </li>
        @endif
    </ul>
</li>
<li
    class="nav-item {{ request()->is('admin/laporan_pph*') ||
    request()->is('admin/laporan_perhitungangaji*') ||
    request()->is('admin/laporan_kasbonkaryawan*') ||
    request()->is('admin/laporan_pelunasan*') ||
    request()->is('admin/laporan_fakturpelunasanban*') ||
    request()->is('admin/laporan_fakturpelunasanpart*') ||
    request()->is('admin/pilih_laporanreturn*') ||
    request()->is('admin/laporan_tagihanekspedisi*') ||
    request()->is('admin/laporan_fakturekspedisi*') ||
    request()->is('admin/laporan_depositdriver*') ||
    request()->is('admin/pilihlaporanmemo*') ||
    request()->is('admin/laporan_penerimaankaskecil*') ||
    request()->is('admin/laporan_pembelianban*') ||
    request()->is('admin/laporan_pembelianpart*') ||
    request()->is('admin/laporan_pemasanganban*') ||
    request()->is('admin/laporan_pelepasanban*') ||
    request()->is('admin/laporan_pemasanganpart*') ||
    request()->is('admin/laporan_penggantianoli*') ||
    request()->is('admin/laporan_updatekm*') ||
    request()->is('admin/laporan_statusperjalanan*') ||
    request()->is('admin/laporan_buktipotongpajak*') ||
    request()->is('admin/laporan_pengeluaranujs*')
        ? 'menu-open'
        : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/laporan_pph*') ||
        request()->is('admin/laporan_perhitungangaji*') ||
        request()->is('admin/laporan_kasbonkaryawan*') ||
        request()->is('admin/laporan_pelunasan*') ||
        request()->is('admin/laporan_fakturpelunasanban*') ||
        request()->is('admin/laporan_fakturpelunasanpart*') ||
        request()->is('admin/pilih_laporanreturn*') ||
        request()->is('admin/laporan_tagihanekspedisi*') ||
        request()->is('admin/laporan_fakturekspedisi*') ||
        request()->is('admin/laporan_depositdriver*') ||
        request()->is('admin/pilihlaporanmemo*') ||
        request()->is('admin/laporan_penerimaankaskecil*') ||
        request()->is('admin/laporan_pembelianban*') ||
        request()->is('admin/laporan_pembelianpart*') ||
        request()->is('admin/laporan_pemasanganban*') ||
        request()->is('admin/laporan_pelepasanban*') ||
        request()->is('admin/laporan_pemasanganpart*') ||
        request()->is('admin/laporan_penggantianoli*') ||
        request()->is('admin/laporan_updatekm*') ||
        request()->is('admin/laporan_statusperjalanan*') ||
        request()->is('admin/laporan_buktipotongpajak*') ||
        request()->is('admin/laporan_pengeluaranujs*')
            ? 'active'
            : '' }}">
        <i class="fas fa-clipboard-list nav-icon"></i>
        <p>
            <strong style="color: rgb(255, 255, 255);">LAPORAN</strong>
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if (auth()->check() && auth()->user()->menu['laporan pembelian ban'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_pembelianban') }}"
                    class="nav-link {{ request()->is('admin/laporan_pembelianban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Pembelian Ban</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pembelian part'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_pembelianpart') }}"
                    class="nav-link {{ request()->is('admin/laporan_pembelianpart*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Pembelian Part</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pemasangan ban'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_pemasanganban') }}"
                    class="nav-link {{ request()->is('admin/laporan_pemasanganban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Pemasangan Ban</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pelepasan ban'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_pelepasanban') }}"
                    class="nav-link {{ request()->is('admin/laporan_pelepasanban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Pelepasan Ban</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pemasangan part'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_pemasanganpart') }}"
                    class="nav-link {{ request()->is('admin/laporan_pemasanganpart*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Pemasangan Part</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan penggantian oli'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_penggantianoli') }}"
                    class="nav-link {{ request()->is('admin/laporan_penggantianoli*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Penggantian Oli</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan update km'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_updatekm') }}"
                    class="nav-link {{ request()->is('admin/laporan_updatekm*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Update KM</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan status perjalanan kendaraan'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_statusperjalanan') }}"
                    class="nav-link {{ request()->is('admin/laporan_statusperjalanan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Status Perjalanan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan kasbon karyawan'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_kasbonkaryawan') }}"
                    class="nav-link {{ request()->is('admin/laporan_kasbonkaryawan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Memo Hutang-<br>
                        <span style="margin-left: 32px">Karyawan</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan perhitungan gaji'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_perhitungangaji') }}"
                    class="nav-link {{ request()->is('admin/laporan_perhitungangaji*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Gaji Karyawan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan kas kecil'])
            <li class="nav-item">
                <a href="{{ url('admin/pilih_laporankaskecil') }}"
                    class="nav-link {{ request()->is('admin/pilih_laporankaskecil*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Kas Kecil</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan mobil logistik'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_mobillogistik') }}"
                    class="nav-link {{ request()->is('admin/laporan_mobillogistik*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Mobil Logistik</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan deposit sopir'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_depositdriver') }}"
                    class="nav-link {{ request()->is('admin/laporan_depositdriver*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Deposit Sopir
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan memo ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/pilihlaporanmemo') }}"
                    class="nav-link {{ request()->is('admin/pilihlaporanmemo*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Memo Ekspedisi
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan faktur ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_fakturekspedisi') }}"
                    class="nav-link {{ request()->is('admin/laporan_fakturekspedisi*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Faktur Ekspedisi
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pph'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_pph') }}"
                    class="nav-link {{ request()->is('admin/laporan_pph*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan PPH
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan invoice ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_tagihanekspedisi') }}"
                    class="nav-link {{ request()->is('admin/laporan_tagihanekspedisi*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Invoice Ekspedisi
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan return barang ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/pilih_laporanreturn') }}"
                    class="nav-link {{ request()->is('admin/pilih_laporanreturn*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Barang Return
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pelunasan ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_pelunasan') }}"
                    class="nav-link {{ request()->is('admin/laporan_pelunasan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Pelunasan -<br>
                        <span style="margin-left: 32px">Ekspedisi</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pelunasan pembelian ban'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_fakturpelunasanban') }}"
                    class="nav-link {{ request()->is('admin/laporan_fakturpelunasanban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Pelunasan -<br>
                        <span style="margin-left: 32px">Faktur Pembelian Ban</span>
                    </p>
                </a>
            </li>
        @endif

        @if (auth()->check() && auth()->user()->menu['laporan pelunasan pembelian part'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_fakturpelunasanpart') }}"
                    class="nav-link {{ request()->is('admin/laporan_fakturpelunasanpart*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Pelunasan -<br>
                        <span style="margin-left: 32px">Faktur Pembelian Part</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan deposit sopir'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_pengeluaranujs') }}"
                    class="nav-link {{ request()->is('admin/laporan_pengeluaranujs*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Pengambilan UJS
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pelunasan ekspedisi'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_buktipotongpajak') }}"
                    class="nav-link {{ request()->is('admin/laporan_buktipotongpajak*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Bukti Potong Pajak
                    </p>
                </a>
            </li>
        @endif
    </ul>
</li>
<li class="nav-header">Profile</li>
<li class="nav-item">
    <a href="{{ url('admin/profile') }}" class="nav-link {{ request()->is('admin/profile') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-edit"></i>
        <p>Update Profile</p>
    </a>
<li class="nav-item">
    <a href="#" data-toggle="modal" data-target="#modalLogout" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </a>
</li>
