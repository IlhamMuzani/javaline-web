<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    {{-- <script src="{{ asset('js/pusher.js') }}"></script> --}}
</head>


<body class="hold-transition sidebar-mini @if (request()->is('admin/inquery_tagihanekspedisi*') ||
        // request()->is('admin/ban*') ||
        request()->is('admin/tagihan_ekspedisi*') ||
        request()->is('admin/indexnon*') ||
        request()->is('admin/faktur_ekspedisi*') ||
        request()->is('admin/inquery_fakturekspedisi*') ||
        request()->is('admin/tablememo*') ||
        request()->is('admin/tablefaktur*') ||
        request()->is('admin/inquery_memoekspedisi*') ||
        request()->is('admin/inquery_memoborong*') ||
        request()->is('admin/inquery_memotambahan*') ||
        request()->is('admin/laporan_memoekspedisi*') ||
        request()->is('admin/laporan_memoborong*') ||
        request()->is('admin/laporan_fakturekspedisi*') ||
        request()->is('admin/faktur_pelunasan*') ||
        request()->is('admin/faktur_penjualanreturn*') ||
        request()->is('admin/inquery_fakturpenjualanreturn*') ||
        request()->is('admin/inquery_fakturpelunasan*') ||
        request()->is('admin/bukti_potongpajak*') ||
        request()->is('admin/inquery_buktipotongpajak*') ||
        request()->is('admin/perhitungan_gaji*') ||
        request()->is('admin/perhitungan_gajibulanan*') ||
        request()->is('admin/inquery_perhitungangaji*') ||
        request()->is('admin/inquery_perhitungangajibulanan*') ||
        request()->is('admin/status_perjalanan*') ||
        // request()->is('pelanggan/status_kendaraan*') ||
        // request()->is('pelanggan*') ||
        // request()->is('admin/penggantian_bearing*') ||
        // request()->is('admin/inquery_penggantianbearing*') ||
        // request()->is('admin/status_pemberiando*') ||
        request()->is('admin/laporan_memotambahan*')) sidebar-open sidebar-collapse @endif">
    <div class="wrapper">
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="" src="{{ asset('storage/uploads/user/logo1.png') }}" alt="javaline" height="50"
                width="100">
        </div> --}}
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <img {{-- class="animation__wobble" --}} src="{{ asset('storage/uploads/user/logo1.png') }}" alt="AdminLTELogo"
                        height="60" width="200">
                    {{-- <a href="#" class="nav-link">Sistem - Javaline</a> --}}
                </li>
                @if (auth()->user()->karyawan)
                    <li class="nav-item d-none d-sm-inline-block dropdown">
                        <a href="#" class="nav-link" role="button" aria-expanded="false"
                            data-toggle="dropdown">Master</a>
                        <div style="width: 170px" class="dropdown-menu dropdown-menu-custom"
                            aria-labelledby="dropdownMenuButton">
                            <ul class="nav nav-treeview">
                                <div class="input-group ml-2 mr-2">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" id="menuSearchInput" class="form-control"
                                        placeholder="Search menu">
                                </div>
                                @if (auth()->check() && auth()->user()->menu['karyawan'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/karyawan') }}"
                                            class="nav-link {{ request()->is('admin/karyawan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Karyawan</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['user'])
                                    <li class="nav-item" style="mt-0">
                                        <a href="{{ url('admin/user') }}"
                                            class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data User</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['akses'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/akses') }}"
                                            class="nav-link {{ request()->is('admin/akses*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Hak Akses</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['gaji karyawan'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/gaji_karyawan') }}"
                                            class="nav-link {{ request()->is('admin/gaji_karyawan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Gaji Karyawan</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['departemen'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/departemen') }}"
                                            class="nav-link {{ request()->is('admin/departemen*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Departemen</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['supplier'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/supplier') }}"
                                            class="nav-link {{ request()->is('admin/supplier*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Supplier</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['pelanggan'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/pelanggan') }}"
                                            class="nav-link {{ request()->is('admin/pelanggan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Pelanggan</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['divisi mobil'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/divisi') }}"
                                            class="nav-link {{ request()->is('admin/divisi*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Divisi Mobil</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['jenis kendaraan'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/jenis_kendaraan') }}"
                                            class="nav-link {{ request()->is('admin/jenis_kendaraan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Jenis Kendaraan</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['golongan'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/golongan') }}"
                                            class="nav-link {{ request()->is('admin/golongan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Golongan</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['kendaraan'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/kendaraan') }}"
                                            class="nav-link {{ request()->is('admin/kendaraan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Kendaraan</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['ukuran ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/ukuran_ban') }}"
                                            class="nav-link {{ request()->is('admin/ukuran_ban*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Ukuran Ban</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['merek ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/merek_ban') }}"
                                            class="nav-link {{ request()->is('admin/merek_ban*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Merek Ban</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['type ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/type_ban') }}"
                                            class="nav-link {{ request()->is('admin/type_ban*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Type Ban</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/ban') }}"
                                            class="nav-link {{ request()->is('admin/ban*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Ban</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['nokir'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/nokir') }}"
                                            class="nav-link {{ request()->is('admin/nokir*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data No. Kir</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['stnk'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/stnk') }}"
                                            class="nav-link {{ request()->is('admin/stnk*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data No. Stnk</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['part'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/sparepart') }}"
                                            class="nav-link {{ request()->is('admin/sparepart*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Part</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['sopir'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/driver') }}"
                                            class="nav-link {{ request()->is('admin/driver*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Driver</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['rute perjalanan'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/rute_perjalanan') }}"
                                            class="nav-link {{ request()->is('admin/rute_perjalanan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Rute Perjalanan</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['biaya tambahan'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/biaya_tambahan') }}"
                                            class="nav-link {{ request()->is('admin/biaya_tambahan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Biaya Tambahan</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['potongan memo'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/potongan_memo') }}"
                                            class="nav-link {{ request()->is('admin/potongan_memo*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Potongan Memo</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['tarif'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/tarif') }}"
                                            class="nav-link {{ request()->is('admin/tarif*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Tarif</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['satuan barang'])
                                    <li class="nav-item" hidden>
                                        <a href="{{ url('admin/satuan') }}"
                                            class="nav-link {{ request()->is('admin/satuan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Satuan Barang</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['barang return'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/barang') }}"
                                            class="nav-link {{ request()->is('admin/barang*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Barang Return</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['akun'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/akun') }}"
                                            class="nav-link {{ request()->is('admin/akun*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Data Barang Akun</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block dropdown">
                        <a href="#" class="nav-link" role="button" aria-expanded="false"
                            data-toggle="dropdown">Operasional</a>
                        <div style="width: 170px" class="dropdown-menu dropdown-menu-custom"
                            aria-labelledby="dropdownMenuButton">
                            <ul class="nav nav-treeview">
                                <div class="input-group ml-2 mr-2">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" id="menuSearchInputopera" class="form-control"
                                        placeholder="Search menu">
                                </div>
                                @if (auth()->check() && auth()->user()->menu['update km'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/km') }}"
                                            class="nav-link {{ request()->is('admin/km*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Update KM</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['perpanjangan stnk'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/perpanjangan_stnk') }}"
                                            class="nav-link {{ request()->is('admin/perpanjangan_stnk*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Perpanjangan STNK
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['perpanjangan kir'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/perpanjangan_kir') }}"
                                            class="nav-link {{ request()->is('admin/perpanjangan_kir*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Perpanjangan KIR
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['pemasangan ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/pemasangan_ban') }}"
                                            class="nav-link {{ request()->is('admin/pemasangan_ban*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Pemasangan Ban</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['pelepasan ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/pelepasan_ban') }}"
                                            class="nav-link {{ request()->is('admin/pelepasan_ban*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Pelepasan Ban</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['pemasangan part'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/pemasangan_part') }}"
                                            class="nav-link {{ request()->is('admin/pemasangan_part*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Pemasangan Part</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['penggantian oli'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/penggantian_oli') }}"
                                            class="nav-link {{ request()->is('admin/penggantian_oli*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Penggantian Oli</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['status perjalanan kendaraan'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/status_perjalanan') }}"
                                            class="nav-link {{ request()->is('admin/status_perjalanan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Status Perjalanan <br>
                                                <span style="margin-left:7px">
                                                    Kendaraan
                                                </span>
                                            </p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block dropdown">
                        <a href="#" class="nav-link" role="button" aria-expanded="false"
                            data-toggle="dropdown">Transaksi</a>
                        <div style="width: 250px" class="dropdown-menu dropdown-menu-custom"
                            aria-labelledby="dropdownMenuButton">
                            <ul class="nav nav-treeview">
                                <div class="input-group ml-2 mr-2">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" id="menuSearchInputtransaksi" class="form-control"
                                        placeholder="Search menu">
                                </div>
                                @if (auth()->check() && auth()->user()->menu['perhitungan gaji'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/perhitungan_gaji') }}"
                                            class="nav-link {{ request()->is('admin/perhitungan_gaji*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Perhitungan Gaji Karyawan</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['kasbon karyawan'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/kasbon_karyawan') }}"
                                            class="nav-link {{ request()->is('admin/kasbon_karyawan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Kasbon Karyawan</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['pembelian ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/pembelian_ban') }}"
                                            class="nav-link {{ request()->is('admin/pembelian_ban*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Faktur Pembelian Ban</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['pembelian part'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/pembelian_part') }}"
                                            class="nav-link {{ request()->is('admin/pembelian_part*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Faktur Pembelian Part</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['deposit sopir'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/pilih_deposit') }}"
                                            class="nav-link {{ request()->is('admin/pilih_deposit*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Deposit Sopir
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['deposit sopir'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/saldo_kasbon') }}"
                                            class="nav-link {{ request()->is('admin/saldo_kasbon*') || request()->is('admin/pelunasan_deposit*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Deposit Karyawan
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['memo ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/tablememo') }}"
                                            class="nav-link {{ request()->is('admin/tablememo*') || request()->is('admin/memo_ekspedisi*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Memo Ekspedisi</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['faktur ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/tablefaktur') }}"
                                            class="nav-link {{ request()->is('admin/tablefaktur*') || request()->is('admin/faktur_ekspedisi*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Faktur Ekspedisi
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['invoice faktur ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/tabletagihan') }}"
                                            class="nav-link {{ request()->is('admin/tabletagihan*') || request()->is('admin/tagihan_ekspedisi*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Invoice Faktur Ekspedisi</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['return barang ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/pilih_returnekspedisi') }}"
                                            class="nav-link {{ request()->is('admin/pilih_returnekspedisi*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Return Barang Ekspedisi</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['return barang ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/tablepotongan') }}"
                                            class="nav-link {{ request()->is('admin/tablepotongan*') || request()->is('admin/potongan_penjualan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Potongan Penjualan</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['faktur pelunasan ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/tablepelunasan') }}"
                                            class="nav-link {{ request()->is('admin/tablepelunasan*') || request()->is('admin/faktur_pelunasan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Pelunasan Faktur Ekspedisi</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['pelunasan faktur pembelian ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/tablepembelianban') }}"
                                            class="nav-link {{ request()->is('admin/tablepembelianban*') || request()->is('admin/pembelian_ban*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Pelunasan Faktur Pembelian Ban</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['pelunasan faktur pembelian part'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/tablepembelianpart') }}"
                                            class="nav-link {{ request()->is('admin/tablepembelianpart*') || request()->is('admin/pembelian_part*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Pelunasan Faktur Pembelian Part</p>
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['pengambilan kas kecil'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/tablepengeluaran') }}"
                                            class="nav-link {{ request()->is('admin/tablepengeluaran*') || request()->is('admin/pengeluaran_kaskecil*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Pengambilan kas kecil</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block dropdown">
                        <a href="#" class="nav-link" role="button" aria-expanded="false"
                            data-toggle="dropdown">Finance</a>
                        <div style="width: 290px" class="dropdown-menu dropdown-menu-custom"
                            aria-labelledby="dropdownMenuButton">
                            <ul class="nav nav-treeview">
                                <div class="input-group ml-2 mr-2">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" id="menuSearchInputfinance" class="form-control"
                                        placeholder="Search menu">
                                </div>
                                @if (auth()->check() && auth()->user()->menu['penerimaan kas kecil'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/penerimaan_kaskecil') }}"
                                            class="nav-link {{ request()->is('admin/penerimaan_kaskecil*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Saldo Kas Kecil</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery penerimaan kas kecil'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_penerimaankaskecil') }}"
                                            class="nav-link {{ request()->is('admin/inquery_penerimaankaskecil*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Saldo Kas Kecil
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery penerimaan kas kecil'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_penambahansaldokasbon') }}"
                                            class="nav-link {{ request()->is('admin/inquery_penambahansaldokasbon*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Saldo Deposit Karyawan
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery deposit sopir'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_pilihdeposit') }}"
                                            class="nav-link {{ request()->is('admin/inquery_pilihdeposit*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Deposit Sopir
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['list administrasi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/saldo_ujs') }}"
                                            class="nav-link {{ request()->is('admin/saldo_ujs*') || request()->is('admin/listadministrasi*') || request()->is('admin/pengambilanujs*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- UJS(Uang Jaminan Sopir)
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['list administrasi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_pengeluaranujs') }}"
                                            class="nav-link {{ request()->is('admin/inquery_pengeluaranujs*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Pengambilan UJS
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery update km'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_updatekm') }}"
                                            class="nav-link {{ request()->is('admin/inquery_updatekm*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Update Km
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery pembelian ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_pembelianban') }}"
                                            class="nav-link {{ request()->is('admin/inquery_pembelianban*') ? 'active' : '' }}">
                                            <p style="font-size: 13px;">- Inquery Faktur Pembelian Ban
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery pembelian part'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_pembelianpart') }}"
                                            class="nav-link {{ request()->is('admin/inquery_pembelianpart*') ? 'active' : '' }}">
                                            <p style="font-size: 13px;">- Inquery Faktur Pembelian Part
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery pemasangan ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_pemasanganban') }}"
                                            class="nav-link {{ request()->is('admin/inquery_pemasanganban*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Pemasangan Ban
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery pelepasan ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_pelepasanban') }}"
                                            class="nav-link {{ request()->is('admin/inquery_pelepasanban*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Pelepasan Ban
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery pemasangan part'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_pemasanganpart') }}"
                                            class="nav-link {{ request()->is('admin/inquery_pemasanganpart*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Pemasangan Part
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery penggantian oli'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_penggantianoli') }}"
                                            class="nav-link {{ request()->is('admin/inquery_penggantianoli*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Penggantian Oli
                                            </p>
                                        </a>
                                    </li>
                                @endif

                                @if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_perpanjanganstnk') }}"
                                            class="nav-link {{ request()->is('admin/inquery_perpanjanganstnk*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Perpanjangan Stnk
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery perpanjangan kir'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_perpanjangankir') }}"
                                            class="nav-link {{ request()->is('admin/inquery_perpanjangankir*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Perpanjangan Kir
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery kasbon karyawan'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_kasbonkaryawan') }}"
                                            class="nav-link {{ request()->is('admin/inquery_kasbonkaryawan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Kasbon Karyawan
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery perhitungan gaji'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_perhitungangaji') }}"
                                            class="nav-link {{ request()->is('admin/inquery_perhitungangaji*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Perhitungan Gaji
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery memo ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_memoekspedisi') }}"
                                            class="nav-link {{ request()->is('admin/inquery_memoekspedisi*') || request()->is('admin/inquery_memoborong*') || request()->is('admin/inquery_memotambahan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Memo Ekspedisi
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery faktur ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_fakturekspedisi') }}"
                                            class="nav-link {{ request()->is('admin/inquery_fakturekspedisi*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Faktur Ekspedisi
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery invoice faktur ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_tagihanekspedisi') }}"
                                            class="nav-link {{ request()->is('admin/inquery_tagihanekspedisi*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Invoice F. Ekspedisi
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery return ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/pilih_inqueryreturnekspedisi') }}"
                                            class="nav-link {{ request()->is('admin/pilih_inqueryreturnekspedisi*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Return Ekspedisi
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery return ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_potonganpenjualan') }}"
                                            class="nav-link {{ request()->is('admin/inquery_potonganpenjualan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Potongan Penjualan
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery pelunasan ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_fakturpelunasan') }}"
                                            class="nav-link {{ request()->is('admin/inquery_fakturpelunasan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Pelunasan Ekspedisi
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery pelunasan faktur pembelian ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_banpembelianlunas') }}"
                                            class="nav-link {{ request()->is('admin/inquery_banpembelianlunas*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Pelunasan Faktur Pembelian Ban
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery pelunasan faktur pembelian part'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_partpembelianlunas') }}"
                                            class="nav-link {{ request()->is('admin/inquery_partpembelianlunas*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Inquery Pelunasan Faktur Pembelian Part
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['inquery pengambilan kas kecil'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/inquery_pengeluarankaskecil') }}"
                                            class="nav-link {{ request()->is('admin/inquery_pengeluarankaskecil*') ? 'active' : '' }}">
                                            <p style="font-size: 13px;">- Inquery Pengambilan Kas Kecil
                                            </p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block dropdown">
                        <a href="#" class="nav-link" role="button" aria-expanded="false"
                            data-toggle="dropdown">Laporan</a>
                        <div style="width: 290px" class="dropdown-menu dropdown-menu-custom"
                            aria-labelledby="dropdownMenuButton">
                            <ul class="nav nav-treeview">
                                <div class="input-group ml-2 mr-2">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" id="menuSearchInputlaporan" class="form-control"
                                        placeholder="Search menu">
                                </div>
                                @if (auth()->check() && auth()->user()->menu['laporan pembelian ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_pembelianban') }}"
                                            class="nav-link {{ request()->is('admin/laporan_pembelianban*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Pembelian Ban</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan pembelian part'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_pembelianpart') }}"
                                            class="nav-link {{ request()->is('admin/laporan_pembelianpart*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Pembelian Part</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan pemasangan ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_pemasanganban') }}"
                                            class="nav-link {{ request()->is('admin/laporan_pemasanganban*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Pemasangan Ban</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan pelepasan ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_pelepasanban') }}"
                                            class="nav-link {{ request()->is('admin/laporan_pelepasanban*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Pelepasan Ban</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan pemasangan part'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_pemasanganpart') }}"
                                            class="nav-link {{ request()->is('admin/laporan_pemasanganpart*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Pemasangan Part</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan penggantian oli'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_penggantianoli') }}"
                                            class="nav-link {{ request()->is('admin/laporan_penggantianoli*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Penggantian Oli</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan update km'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_updatekm') }}"
                                            class="nav-link {{ request()->is('admin/laporan_updatekm*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Update KM</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan status perjalanan kendaraan'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_statusperjalanan') }}"
                                            class="nav-link {{ request()->is('admin/laporan_statusperjalanan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Status Perjalanan</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan kasbon karyawan'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_kasbonkaryawan') }}"
                                            class="nav-link {{ request()->is('admin/laporan_kasbonkaryawan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Kasbon Karyawan</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan perhitungan gaji'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_perhitungangaji') }}"
                                            class="nav-link {{ request()->is('admin/laporan_perhitungangaji*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Gaji Karyawan</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan kas kecil'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/pilih_laporankaskecil') }}"
                                            class="nav-link {{ request()->is('admin/pilih_laporankaskecil*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Kas Kecil</p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan mobil logistik'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_mobillogistik') }}"
                                            class="nav-link {{ request()->is('admin/laporan_mobillogistik*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Mobil Logistik</p>
                                        </a>
                                    </li>
                                @endif

                                @if (auth()->check() && auth()->user()->menu['laporan deposit sopir'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_depositdriver') }}"
                                            class="nav-link {{ request()->is('admin/laporan_depositdriver*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Deposit Sopir
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan memo ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/pilihlaporanmemo') }}"
                                            class="nav-link {{ request()->is('admin/pilihlaporanmemo*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Memo Ekspedisi
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan faktur ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_fakturekspedisi') }}"
                                            class="nav-link {{ request()->is('admin/laporan_fakturekspedisi*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Faktur Ekspedisi
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan pph'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_pph') }}"
                                            class="nav-link {{ request()->is('admin/laporan_pph*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan PPH
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan invoice ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_tagihanekspedisi') }}"
                                            class="nav-link {{ request()->is('admin/laporan_tagihanekspedisi*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Invoice Ekspedisi
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan return barang ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/pilih_laporanreturn') }}"
                                            class="nav-link {{ request()->is('admin/pilih_laporanreturn*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Barang Return
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan pelunasan ekspedisi'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_pelunasan') }}"
                                            class="nav-link {{ request()->is('admin/laporan_pelunasan*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Pelunasan Ekspedisi
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan pelunasan pembelian ban'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_fakturpelunasanban') }}"
                                            class="nav-link {{ request()->is('admin/laporan_fakturpelunasanban*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Pelunasan Faktur Pembelian Ban
                                            </p>
                                        </a>
                                    </li>
                                @endif

                                @if (auth()->check() && auth()->user()->menu['laporan pelunasan pembelian part'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_fakturpelunasanpart') }}"
                                            class="nav-link {{ request()->is('admin/laporan_fakturpelunasanpart*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Pelunasan Faktur Pembelian Part
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->check() && auth()->user()->menu['laporan deposit sopir'])
                                    <li class="nav-item">
                                        <a href="{{ url('admin/laporan_pengeluaranujs') }}"
                                            class="nav-link {{ request()->is('admin/laporan_pengeluaranujs*') ? 'active' : '' }}">
                                            <p style="font-size: 14px;">- Laporan Pengambilan UJS
                                            </p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            {{-- <a href="" class="brand-link">
                @if (auth()->user()->karyawan->gambar)
                    <img src="{{ asset('storage/uploads/' . auth()->user()->karyawan->gambar) }}" alt="javaline"
                        class="brand-image">
                @else
                    <img src="{{ asset('storage/uploads/user/user.png') }}" alt="javaline" class="brand-image">
                @endif
                <span style="font-size: 18px"
                    class="brand-text font-wight-bold">{{ auth()->user()->karyawan->nama_lengkap }}</span>
            </a> --}}

            <a href="" class="brand-link d-flex align-items-center">
                @if (auth()->user()->karyawan)
                    @if (auth()->user()->karyawan->gambar)
                        <img src="{{ asset('storage/uploads/' . auth()->user()->karyawan->gambar) }}" alt="javaline"
                            class="brand-image rounded-circle">
                    @else
                        <img src="{{ asset('storage/uploads/user/user.png') }}" alt="javaline"
                            class="brand-image rounded-circle">
                    @endif
                    <span style="font-size: 18px"
                        class="brand-text font-wight-bold">{{ implode(' ', array_slice(str_word_count(auth()->user()->karyawan->nama_lengkap, 1), 0, 2)) }}</span>
                @else
                    <img src="{{ asset('storage/uploads/user/user.png') }}" alt="javaline"
                        class="brand-image rounded-circle">
                    <span style="font-size: 18px"
                        class="brand-text font-wight-bold">{{ implode(' ', array_slice(str_word_count(auth()->user()->pelanggan->nama_pell, 1), 0, 2)) }}</span>
                @endif
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        @if (auth()->user()->isAdmin())
                            @include('layouts.menu.admin')
                        @endif
                        @if (auth()->user()->isDriver())
                            @include('layouts.menu.driver')
                        @endif
                        @if (auth()->user()->isPelanggan())
                            @include('layouts.menu.pelanggan')
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @yield('content')

        </div>
        <!-- /.content-wrapper -->

        <div class="modal fade" id="modalLogout">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Logout</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin keluar sistem <strong>Sistem Javaline</strong>?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <form action="{{ url('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="main-footer">
            <strong>Copyright © 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('adminlte/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('adminlte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap') }}-4.min.js"></script>
    <!-- Summernote -->
    <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    {{-- <script src="{{ asset('adminlte/dist/js/pages/dashboard.js') }}"></script> --}}

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- bs-custom-file-input -->
    <script src="{{ asset('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>


    <link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">
    <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(function() {
            // Summernote
            $('#summernote').summernote()
        })
    </script>
    <script>
        $(function() {
            $('#compose-textarea').summernote()
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#datatables66').DataTable({
                "lengthMenu": [
                    [-1],
                    ["All"]
                ] // Use -1 to display all rows, and "All" as the label
            });
        });

        $(document).ready(function() {
            $('#datatables').DataTable();
        });
        $(document).ready(function() {
            $('#datatables1').DataTable();
        });
        $(document).ready(function() {
            $('#datatables2').DataTable();
        });
        $(document).ready(function() {
            $('#datatables3').DataTable();
        });
        $(document).ready(function() {
            $('#datatables4').DataTable();
        });
        $(document).ready(function() {
            $('#datatables5').DataTable();
        });
        $(document).ready(function() {
            $('#datatables6').DataTable();
        });
        $(document).ready(function() {
            $('#datatables7').DataTable();
        });
    </script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            bsCustomFileInput.init();
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>

    <script>
        $(document).ready(function() {
            // Add event listener to the search input
            $('#menuSearchInput').on('keyup', function() {
                var searchText = $(this).val().toLowerCase(); // Get the entered search text
                // Loop through each menu item
                $('.dropdown-menu-custom .nav-item').each(function() {
                    var menuItemText = $(this).text()
                        .toLowerCase(); // Get the text of the menu item
                    // Check if the menu item text contains the search text
                    if (menuItemText.includes(searchText)) {
                        $(this).show(); // Show the menu item if it matches the search
                    } else {
                        $(this).hide(); // Hide the menu item if it doesn't match the search
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Add event listener to the search input
            $('#menuSearchInputopera').on('keyup', function() {
                var searchText = $(this).val().toLowerCase(); // Get the entered search text
                // Loop through each menu item
                $('.dropdown-menu-custom .nav-item').each(function() {
                    var menuItemText = $(this).text()
                        .toLowerCase(); // Get the text of the menu item
                    // Check if the menu item text contains the search text
                    if (menuItemText.includes(searchText)) {
                        $(this).show(); // Show the menu item if it matches the search
                    } else {
                        $(this).hide(); // Hide the menu item if it doesn't match the search
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Add event listener to the search input
            $('#menuSearchInputtransaksi').on('keyup', function() {
                var searchText = $(this).val().toLowerCase(); // Get the entered search text
                // Loop through each menu item
                $('.dropdown-menu-custom .nav-item').each(function() {
                    var menuItemText = $(this).text()
                        .toLowerCase(); // Get the text of the menu item
                    // Check if the menu item text contains the search text
                    if (menuItemText.includes(searchText)) {
                        $(this).show(); // Show the menu item if it matches the search
                    } else {
                        $(this).hide(); // Hide the menu item if it doesn't match the search
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Add event listener to the search input
            $('#menuSearchInputfinance').on('keyup', function() {
                var searchText = $(this).val().toLowerCase(); // Get the entered search text
                // Loop through each menu item
                $('.dropdown-menu-custom .nav-item').each(function() {
                    var menuItemText = $(this).text()
                        .toLowerCase(); // Get the text of the menu item
                    // Check if the menu item text contains the search text
                    if (menuItemText.includes(searchText)) {
                        $(this).show(); // Show the menu item if it matches the search
                    } else {
                        $(this).hide(); // Hide the menu item if it doesn't match the search
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Add event listener to the search input
            $('#menuSearchInputlaporan').on('keyup', function() {
                var searchText = $(this).val().toLowerCase(); // Get the entered search text
                // Loop through each menu item
                $('.dropdown-menu-custom .nav-item').each(function() {
                    var menuItemText = $(this).text()
                        .toLowerCase(); // Get the text of the menu item
                    // Check if the menu item text contains the search text
                    if (menuItemText.includes(searchText)) {
                        $(this).show(); // Show the menu item if it matches the search
                    } else {
                        $(this).hide(); // Hide the menu item if it doesn't match the search
                    }
                });
            });
        });
    </script>
</body>

</html>
