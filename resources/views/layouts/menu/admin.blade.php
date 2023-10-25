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
<li class="nav-header">Menu</li>
<li
    class="nav-item {{ request()->is('admin/karyawan*') || request()->is('admin/user*') || request()->is('admin/akses*') || request()->is('admin/departemen*') || request()->is('admin/supplier*') || request()->is('admin/pelanggan*') || request()->is('admin/kendaraan') || request()->is('admin/ban') || request()->is('admin/golongan') || request()->is('admin/divisi') || request()->is('admin/jenis_kendaraan') || request()->is('admin/ukuran_ban') || request()->is('admin/merek_ban') || request()->is('admin/type_ban') || request()->is('admin/nokir') || request()->is('admin/stnk') || request()->is('admin/sparepart') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/karyawan*') || request()->is('admin/user*') || request()->is('admin/akses*') || request()->is('admin/departemen*') || request()->is('admin/supplier*') || request()->is('admin/pelanggan*') || request()->is('admin/kendaraan') || request()->is('admin/ban') || request()->is('admin/golongan') || request()->is('admin/divisi') || request()->is('admin/jenis_kendaraan') || request()->is('admin/ukuran_ban') || request()->is('admin/merek_ban') || request()->is('admin/type_ban') || request()->is('admin/nokir') || request()->is('admin/stnk') || request()->is('admin/sparepart') ? 'active' : '' }}">

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
    class="nav-item {{ request()->is('admin/km*') || request()->is('admin/perpanjangan_stnk*') || request()->is('admin/perpanjangan_kir*') || request()->is('admin/pemasangan_ban*') || request()->is('admin/pelepasan_ban*') || request()->is('admin/pemasangan_part*') || request()->is('admin/penggantian_oli*') || request()->is('admin/status_perjalanan*') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/km*') || request()->is('admin/perpanjangan_stnk*') || request()->is('admin/perpanjangan_kir*') || request()->is('admin/pemasangan_ban*') || request()->is('admin/pelepasan_ban*') || request()->is('admin/pemasangan_part*') || request()->is('admin/penggantian_oli*') || request()->is('admin/status_perjalanan*') ? 'active' : '' }}">

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
    </ul>
</li>
@php
    $pembelian = \App\Models\Pembelian_ban::where([['status', 'posting'], ['status_notif', false]])->get();
    $pembelian_part = \App\Models\Pembelian_part::where([['status', 'posting'], ['status_notif', false]])->get();
    $pemasangan = \App\Models\Pemasangan_ban::where([['status', 'posting'], ['status_notif', false]])->get();
    $pelepasan = \App\Models\Pelepasan_ban::where([['status', 'posting'], ['status_notif', false]])->get();
    $pemasanganpart = \App\Models\Pemasangan_part::where([['status', 'posting'], ['status_notif', false]])->get();
    $penggantianoli = \App\Models\Penggantian_oli::where([['status', 'posting'], ['status_notif', false]])->get();
    $kendaraan = \App\Models\Kendaraan::where([['status_post', 'posting'], ['status_notif', false]])->get();
@endphp
<li
    class="nav-item {{ request()->is('admin/pembelian_ban*') || request()->is('admin/pembelian_part*') || request()->is('admin/inquery_pembelianban*') || request()->is('admin/inquery_pembelianpart*') || request()->is('admin/inquery_pemasanganban*') || request()->is('admin/inquery_pelepasanban*') || request()->is('admin/inquery_pemasanganpart*') || request()->is('admin/inquery_penggantianoli*') || request()->is('admin/inquery_updatekm*')|| request()->is('admin/inquery_perpanjanganstnk*') || request()->is('admin/inquery_perpanjangankir*') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/pembelian_ban*') || request()->is('admin/pembelian_part*') || request()->is('admin/inquery_pembelianban*') || request()->is('admin/inquery_pembelianpart*') || request()->is('admin/inquery_pemasanganban*') || request()->is('admin/inquery_pelepasanban*') || request()->is('admin/inquery_pemasanganpart*') || request()->is('admin/inquery_penggantianoli*') || request()->is('admin/inquery_updatekm*')|| request()->is('admin/inquery_perpanjanganstnk*') || request()->is('admin/inquery_perpanjangankir*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-exchange-alt"></i>
        <p>
            <strong style="color: rgb(255, 255, 255);">TRANSAKSI</strong>
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if (auth()->check() && auth()->user()->menu['pembelian ban'])
            <li class="nav-item">
                <a href="{{ url('admin/pembelian_ban') }}"
                    class="nav-link {{ request()->is('admin/pembelian_ban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Pembelian Ban</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pembelian part'])
            <li class="nav-item">
                <a href="{{ url('admin/pembelian_part') }}"
                    class="nav-link {{ request()->is('admin/pembelian_part*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Pembelian Part</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pembelian ban'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pembelianban') }}"
                    class="nav-link {{ request()->is('admin/inquery_pembelianban*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Pembelian Ban @if (count($pembelian) > 0)
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
                    <p style="font-size: 14px;">Inquery Pembelian Part @if (count($pembelian_part) > 0)
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
        {{-- @if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) --}}
        <li class="nav-item">
            <a href="{{ url('admin/inquery_perpanjanganstnk') }}"
                class="nav-link {{ request()->is('admin/inquery_perpanjanganstnk*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                <p style="font-size: 14px;">Inquery Perpanjangan Stnk
                </p>
            </a>
        </li>
        {{-- @endif --}}
        {{-- @if (auth()->check() && auth()->user()->menu['inquery perpanjangan kir']) --}}
        <li class="nav-item">
            <a href="{{ url('admin/inquery_perpanjangankir') }}"
                class="nav-link {{ request()->is('admin/inquery_perpanjangankir*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                <p style="font-size: 14px;">Inquery Perpanjangan Kir
                </p>
            </a>
        </li>
        {{-- @endif --}}
    </ul>
</li>
<li
    class="nav-item {{ request()->is('admin/laporan_pembelianban*') || request()->is('admin/laporan_pembelianpart*') || request()->is('admin/laporan_pemasanganban*') || request()->is('admin/laporan_pelepasanban*') || request()->is('admin/laporan_pemasanganpart*') || request()->is('admin/laporan_penggantianoli*') || request()->is('admin/laporan_updatekm*') || request()->is('admin/laporan_statusperjalanan*') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/laporan_pembelianban*') || request()->is('admin/laporan_pembelianpart*') || request()->is('admin/laporan_pemasanganban*') || request()->is('admin/laporan_pelepasanban*') || request()->is('admin/laporan_pemasanganpart*') || request()->is('admin/laporan_penggantianoli*') || request()->is('admin/laporan_updatekm*') || request()->is('admin/laporan_statusperjalanan*') ? 'active' : '' }}">
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
