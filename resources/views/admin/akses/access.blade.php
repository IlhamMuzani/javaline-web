@extends('layouts.app')

@section('title', 'Hak Akses')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-5">
                <div class="col-sm-6">
                    <h1 class="m-0">Hak Akses</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/akses') }}">Hak akses</a>
                        </li>
                        <li class="breadcrumb-item active">Lihat</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambahkan</h3>
                    <div class="float-right">
                        {{-- <a href="#" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Akses Menu
                        </a> --}}
                        {{-- <a href="{{ url('admin/akses/accessdetail/' . $akses->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Akses Menu
                        </a> --}}
                    </div>
                </div>
                <!-- /.card-header -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5>
                            <i class="icon fas fa-check"></i> Success!
                        </h5>
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ url('admin/akses-access/' . $akses->id) }}" method="post" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    <label style="margin-left: 22px; margin-top: 15px"
                        for="option-all">{{ $akses->karyawan->nama_lengkap }}</label>
                    <div class="card-body">
                        <br>
                        <input type="checkbox" id="option-all" onchange="checkAll(this)">
                        <label for="option-all">Select All</label>
                        @foreach ($menus as $menu)
                            @if (
                                $loop->iteration === 1 ||
                                    $loop->iteration === 2 ||
                                    $loop->iteration === 3 ||
                                    $loop->iteration === 4 ||
                                    $loop->iteration === 5 ||
                                    $loop->iteration === 6 ||
                                    $loop->iteration === 7 ||
                                    $loop->iteration === 8 ||
                                    $loop->iteration === 9 ||
                                    $loop->iteration === 10 ||
                                    $loop->iteration === 11 ||
                                    $loop->iteration === 12 ||
                                    $loop->iteration === 13 ||
                                    $loop->iteration === 14 ||
                                    $loop->iteration === 15 ||
                                    $loop->iteration === 16 ||
                                    $loop->iteration === 17 ||
                                    $loop->iteration === 18 ||
                                    $loop->iteration === 19 ||
                                    $loop->iteration === 20 ||
                                    $loop->iteration === 21 ||
                                    $loop->iteration === 22 ||
                                    $loop->iteration === 23 ||
                                    $loop->iteration === 24 ||
                                    $loop->iteration === 25)
                                <div id="master">
                                    @if ($loop->iteration === 1)
                                        <label style="font-weight: bold; margin-bottom:20px; margin-top:20px; font-size:17px"
                                            class="form-check-label">MASTER</label>
                                            <input type="checkbox" style="margin-left:10px" id="option-all" onchange="checkAllmaster(this)">
                                            <label for="option-all" >Select All</label>
                                            <br>
                                    @endif
                                    <div class="form-check mb-3">
                                        {{-- <input class="form-check-input" type="checkbox" name="menu[]"
                                            value="{{ $menu }}" {{ $akses->menu[$menu] ? 'checked' : '' }}> --}}
                                        <label class="form-check-label">
                                            @if ($loop->iteration === 1)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="karyawan" value="{{ $menu }}"
                                                     data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('karyawan', this)"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA KARYAWAN
                                            @elseif ($loop->iteration === 2)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="user" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('user')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA USER
                                            @elseif ($loop->iteration === 3)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="akses" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('akses')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> HAK AKSES
                                            @elseif ($loop->iteration === 4)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="gaji_karyawan" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange()"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA GAJI KARYAWAN
                                            @elseif ($loop->iteration === 5)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="departemen" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('departemen')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA DEPARTEMEN
                                            @elseif ($loop->iteration === 6)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="supplier" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('supplier')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA SUPPLIER
                                            @elseif ($loop->iteration === 7)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="pelanggan" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('pelanggan')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA PELANGGAN
                                            @elseif ($loop->iteration === 8)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="divisi" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('divisi')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA DIVISI MOBIL
                                            @elseif ($loop->iteration === 9)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="jenis_kendaraan" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('jenis_kendaraan')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA JENIS KENDARAAN
                                            @elseif ($loop->iteration === 10)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="golongan" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('golongan')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA GOLONGAN
                                            @elseif ($loop->iteration === 11)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="kendaraan" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('kendaraan')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA KENDARAAN
                                            @elseif ($loop->iteration === 12)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="ukuran_ban" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('ukuran_ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA UKURAN BAN
                                            @elseif ($loop->iteration === 13)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="merek_ban" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('merek_ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA MEREK BAN
                                            @elseif ($loop->iteration === 14)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="type_ban" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('type_ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA TYPE BAN
                                            @elseif ($loop->iteration === 15)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="ban" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA BAN
                                            @elseif ($loop->iteration === 16)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="nokir" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('nokir')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA NOKIR
                                            @elseif ($loop->iteration === 17)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="stnk" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('stnk')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA STNK
                                            @elseif ($loop->iteration === 18)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="part" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('part')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA PART
                                            @elseif ($loop->iteration === 19)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="driver" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('driver')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA DRIVER
                                            @elseif ($loop->iteration === 20)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="rute" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('rute')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA RUTE PERJALANAN
                                            @elseif ($loop->iteration === 21)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="biaya_tambahan" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('biaya_tambahan')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA BIAYA TAMBAHAN
                                            @elseif ($loop->iteration === 22)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="potongan_memo" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('potongan_memo')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA POTONGAN MEMO
                                            @elseif ($loop->iteration === 23)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="biaya_tarif" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('biaya_tarif')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA TARIF
                                            @elseif ($loop->iteration === 24)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="barang_return" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('barang_return')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA BARANG RETURN
                                            @elseif ($loop->iteration === 25)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="akun" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChange('akun')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DATA AKUN
                                            @endif
                                        </label>
                                    </div>

                                    {{-- Fitur checkboxes --}}
                                    @if ($loop->iteration === 1)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-karyawan"
                                                    onchange="checkAllCategory('karyawan')">
                                                <label for="select-karyawan" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 1)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="karyawan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('karyawan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 2)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="karyawan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('karyawan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 3)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="karyawan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('karyawan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 4)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}"
                                                                type="checkbox" name="fitur[]" data-category="karyawan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('karyawan', this)"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 2)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-user"
                                                    onchange="checkAllCategory('user')">
                                                <label for="select-user" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 5)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="user"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('user')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 6)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="user"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('user')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 3)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-akses"
                                                    onchange="checkAllCategory('akses')">
                                                <label for="select-akses" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration === 7)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="akses"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('akses')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 4)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-gaji_karyawan"
                                                    onchange="checkAllCategory('gaji_karyawan')">
                                                <label for="select-gaji_karyawan" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration === 242)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input"
                                                                type="checkbox" name="fitur[]" data-category="gaji_karyawan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('gaji_karyawan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}
                                                                data-show="show_{{ $menu }}">
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 5)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-departemen"
                                                    onchange="checkAllCategory('departemen')">
                                                <label for="select-departemen" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 8)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="departemen"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('departemen')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 9)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="departemen"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('departemen')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 6)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-supplier"
                                                    onchange="checkAllCategory('supplier')">
                                                <label for="select-supplier" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 10)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="supplier"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('supplier')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 11)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="supplier"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('supplier')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 12)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="supplier"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('supplier')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 13)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="supplier"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('supplier')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 7)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-pelanggan"
                                                    onchange="checkAllCategory('pelanggan')">
                                                <label for="select-pelanggan" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 14)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="pelanggan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('pelanggan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 15)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="pelanggan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('pelanggan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 16)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="pelanggan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('pelanggan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 17)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="pelanggan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('pelanggan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 8)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-divisi"
                                                    onchange="checkAllCategory('divisi')">
                                                <label for="select-divisi" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 18)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="divisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('divisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 19)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="divisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('divisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 20)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="divisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('divisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 9)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-jenis_kendaraan"
                                                    onchange="checkAllCategory('jenis_kendaraan')">
                                                <label for="select-jenis_kendaraan" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 21)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="jenis_kendaraan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('jenis_kendaraan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 22)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="jenis_kendaraan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('jenis_kendaraan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 23)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="jenis_kendaraan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('jenis_kendaraan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 10)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-golongan"
                                                    onchange="checkAllCategory('golongan')">
                                                <label for="select-golongan" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 24)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="golongan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('golongan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 25)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="golongan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('golongan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 26)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="golongan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('golongan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 11)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-kendaraan"
                                                    onchange="checkAllCategory('kendaraan')">
                                                <label for="select-kendaraan" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 27)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="kendaraan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('kendaraan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 28)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="kendaraan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('kendaraan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 29)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="kendaraan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('kendaraan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 30)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="kendaraan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('kendaraan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 12)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-ukuran_ban"
                                                    onchange="checkAllCategory('ukuran_ban')">
                                                <label for="select-ukuran_ban" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 31)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="ukuran_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('ukuran_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 32)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="ukuran_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('ukuran_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 33)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="ukuran_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('ukuran_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 13)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-merek_ban"
                                                    onchange="checkAllCategory('merek_ban')">
                                                <label for="select-merek_ban" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 34)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="merek_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('merek_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 35)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="merek_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('merek_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 36)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="merek_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('merek_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 14)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-type_ban"
                                                    onchange="checkAllCategory('type_ban')">
                                                <label for="select-type_ban" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 37)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="type_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('type_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 38)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="type_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('type_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 39)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="type_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('type_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 15)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-ban"
                                                    onchange="checkAllCategory('ban')">
                                                <label for="select-ban" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 40)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 41)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 42)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 43)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 16)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-nokir"
                                                    onchange="checkAllCategory('nokir')">
                                                <label for="select-nokir" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 44)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="nokir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('nokir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Print</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 45)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="nokir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('nokir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 46)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="nokir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('nokir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 47)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="nokir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('nokir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 48)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="nokir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('nokir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 17)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-stnk"
                                                    onchange="checkAllCategory('stnk')">
                                                <label for="select-stnk" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 49)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="stnk"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('stnk')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 50)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="stnk"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('stnk')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 51)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="stnk"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('stnk')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 52)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="stnk"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('stnk')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 18)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-part"
                                                    onchange="checkAllCategory('part')">
                                                <label for="select-part" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 53)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 54)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 55)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 56)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 19)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-driver"
                                                    onchange="checkAllCategory('driver')">
                                                <label for="select-driver" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 57)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="driver"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('driver')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 20)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-rute"
                                                    onchange="checkAllCategory('rute')">
                                                <label for="select-rute" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 58)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="rute"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('rute')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 59)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="rute"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('rute')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 60)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="rute"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('rute')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 20)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-rute"
                                                    onchange="checkAllCategory('rute')">
                                                <label for="select-rute" style="margin-left:5px">Select All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 58)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="rute"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('rute')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 59)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="rute"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('rute')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 60)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="rute"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('rute')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 21)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-biaya_tambahan"
                                                    onchange="checkAllCategory('biaya_tambahan')">
                                                <label for="select-biaya_tambahan" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 61)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="biaya_tambahan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('biaya_tambahan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 62)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="biaya_tambahan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('biaya_tambahan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 63)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="biaya_tambahan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('biaya_tambahan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 22)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-potongan_memo"
                                                    onchange="checkAllCategory('potongan_memo')">
                                                <label for="select-potongan_memo" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 64)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="potongan_memo"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('potongan_memo')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 65)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="potongan_memo"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('potongan_memo')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 66)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="potongan_memo"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('potongan_memo')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 23)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-biaya_tarif" onchange="checkAllCategory('biaya_tarif')">
                                                <label for="select-biaya_tarif" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 67)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="biaya_tarif"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('biaya_tarif')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 68)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="biaya_tarif"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('biaya_tarif')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 69)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="biaya_tarif"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('biaya_tarif')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 24)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-barang_return"
                                                    onchange="checkAllCategory('barang_return')">
                                                <label for="select-barang_return" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 73)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="barang_return"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('barang_return')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 74)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="barang_return"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('barang_return')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 75)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="barang_return"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('barang_return')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 25)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox" id="select-akun"
                                                    onchange="checkAllCategory('akun')">
                                                <label for="select-akun" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 243)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="akun"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('akun')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 244)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="akun"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('akun')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 245)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="akun"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChange('akun')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if (
                                $loop->iteration === 26 ||
                                    $loop->iteration === 27 ||
                                    $loop->iteration === 28 ||
                                    $loop->iteration === 29 ||
                                    $loop->iteration === 30 ||
                                    $loop->iteration === 31 ||
                                    $loop->iteration === 32 ||
                                    $loop->iteration === 33)
                                <div id="operasional">
                                    @if ($loop->iteration === 26)
                                        <label style="font-weight: bold; margin-bottom:20px; margin-top:20px; font-size:17px"
                                            class="form-check-label">OPERASIONAL</label>
                                            <input type="checkbox" style="margin-left:10px" id="option-all" onchange="checkAlloperasional(this)">
                                            <label for="option-all" >Select All</label>
                                            <br>
                                    @endif
                                    <div class="form-check mb-3">
                                        {{-- <input class="form-check-input" type="checkbox" name="menu[]"
                                            value="{{ $menu }}" {{ $akses->menu[$menu] ? 'checked' : '' }}> --}}
                                        <label class="form-check-label">
                                            @if ($loop->iteration === 26)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="update_km" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangeoperasional('update_km')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> UPDATE KM
                                            @elseif ($loop->iteration === 27)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="perpanjangan_stnk" value="{{ $menu }}"
                                                    data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangeoperasional('perpanjangan_stnk')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> PERPANJANGAN STNK
                                            @elseif ($loop->iteration === 28)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="perpanjangan_kir"
                                                    data-show="show_{{ $menu }}" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangeoperasional('perpanjangan_kir')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> PERPANJANGAN KIR
                                            @elseif ($loop->iteration === 29)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="pemasangan_ban" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangeoperasional('pemasangan_ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> PEMASANGAN BAN
                                            @elseif ($loop->iteration === 30)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="pelepasan_ban" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangeoperasional('pelepasan_ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> PELEPASAN BAN
                                            @elseif ($loop->iteration === 31)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="pemasangan_part" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangeoperasional('pemasangan_part')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> PEMASANGAN PART
                                            @elseif ($loop->iteration === 32)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="penggantian_oli" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangeoperasional('penggantian_oli')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> PENGGANTIAN OLI
                                            @elseif ($loop->iteration === 33)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="status_perjalanan" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangeoperasional('status_perjalanan')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> STATUS PERJALANAN
                                            @endif
                                        </label>
                                    </div>

                                    {{-- Fitur checkboxes --}}
                                    @if ($loop->iteration === 27)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-perpanjangan_stnk"
                                                    onchange="checkAllCategoryoperasional('perpanjangan_stnk')">
                                                <label for="select-perpanjangan_stnk" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 76)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="perpanjangan_stnk"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangeoperasional('perpanjangan_stnk')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 77)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="perpanjangan_stnk"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangeoperasional('perpanjangan_stnk')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 28)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-perpanjangan_kir"
                                                    onchange="checkAllCategoryoperasional('perpanjangan_kir')">
                                                <label for="select-perpanjangan_kir" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 76)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="perpanjangan_kir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangeoperasional('perpanjangan_kir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 77)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="perpanjangan_kir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangeoperasional('perpanjangan_kir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 32)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-penggantian_oli"
                                                    onchange="checkAllCategoryoperasional('penggantian_oli')">
                                                <label for="select-penggantian_oli" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 80)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="penggantian_oli"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangeoperasional('penggantian_oli')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if (
                                $loop->iteration === 34 ||
                                    $loop->iteration === 35 ||
                                    $loop->iteration === 36 ||
                                    $loop->iteration === 37 ||
                                    $loop->iteration === 38 ||
                                    $loop->iteration === 39 ||
                                    $loop->iteration === 40 ||
                                    $loop->iteration === 41 ||
                                    $loop->iteration === 42 ||
                                    $loop->iteration === 43 ||
                                    $loop->iteration === 44 ||
                                    $loop->iteration === 45 ||
                                    $loop->iteration === 46 ||
                                    $loop->iteration === 47)
                                <div id="transaksi">
                                    @if ($loop->iteration === 34)
                                        <label style="font-weight: bold; margin-bottom:20px; margin-top:20px; font-size:17px"
                                            class="form-check-label">TRANSAKSI</label>
                                            <input type="checkbox" style="margin-left:10px" id="option-all" onchange="checkAlltransaksi(this)">
                                            <label for="option-all" >Select All</label>
                                            <br>
                                    @endif
                                    <div class="form-check mb-3">
                                        {{-- <input class="form-check-input" type="checkbox" name="menu[]"
                                            value="{{ $menu }}" {{ $akses->menu[$menu] ? 'checked' : '' }}> --}}
                                        <label class="form-check-label">
                                            @if ($loop->iteration === 34)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="perhitungan_gaji" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangetransaksi('perhitungan_gaji')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> PERHITUNGAN GAJI
                                            @elseif ($loop->iteration === 35)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="kasbon_karyawan" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangetransaksi('kasbon_karyawan')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> KASBON KARYAWAN
                                            @elseif ($loop->iteration === 36)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="pembelian_ban" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangetransaksi('pembelian_ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> PEMBELIAN BAN
                                            @elseif ($loop->iteration === 37)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="pembelian_part" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangetransaksi('pembelian_part')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> PEMBELIAN PART
                                            @elseif ($loop->iteration === 38)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="memo_ekspedisi" value="{{ $menu }}"
                                                    data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangetransaksi('memo_ekspedisi')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> MEMO EKSPEDISI
                                            @elseif ($loop->iteration === 39)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="faktur_ekspedisi"
                                                    data-show="show_{{ $menu }}" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangetransaksi('faktur_ekspedisi')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> FAKTUR EKSPEDISI
                                            @elseif ($loop->iteration === 40)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="invoice_ekspedisi" data-show="show_{{ $menu }}" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangetransaksi('invoice_ekspedisi')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INVOICE FAKTUR EKSPEDISI
                                            @elseif ($loop->iteration === 41)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="return_barang_ekspedisi"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangetransaksi('return_barang_ekspedisi')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> RETURN BARANG EKSPEDISI
                                            @elseif ($loop->iteration === 42)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="pelunasan_faktur_ekspedisi" data-show="show_{{ $menu }}"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_ekspedisi')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> PELUNASAN FAKTUR EKSPEDISI
                                            @elseif ($loop->iteration === 43)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="pelunasan_faktur_pembelianban" data-show="show_{{ $menu }}"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_pembelianban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> PELUNASAN FAKTUR PEMBELIAN
                                                BAN
                                            @elseif ($loop->iteration === 44)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="pelunasan_faktur_pembelianpart" data-show="show_{{ $menu }}"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_pembelianpart')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> PELUNASAN FAKTUR PEMBELIAN
                                                PART
                                            @elseif ($loop->iteration === 45)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="penerimaan_kaskecil" value="{{ $menu }}" data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangetransaksi('penerimaan_kaskecil')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> PENERIMAAN KAS KECIL
                                            @elseif ($loop->iteration === 46)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="pengambilan_kaskecil" value="{{ $menu }}" data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangetransaksi('pengambilan_kaskecil')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> PENGAMBILAN KAS KECIL
                                            @elseif ($loop->iteration === 47)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="deposit_sopir" value="{{ $menu }}" data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangetransaksi('deposit_sopir')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> DEPOSIT SOPIR
                                            @endif
                                        </label>
                                    </div>

                                    {{-- Fitur checkboxes --}}
                                    @if ($loop->iteration === 38)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-memo_ekspedisi"
                                                    onchange="checkAllCategorytransaksi('memo_ekspedisi')">
                                                <label for="select-memo_ekspedisi" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 246)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 247)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 248)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 249)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 250)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 251)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 252)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting Memo Perjalanan
                                                                Continue</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 253)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting Memo Borong
                                                                Continue</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 254)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting Memo Tambahan
                                                                Continue</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- <div class="row">
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 309)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost Memo Perjalanan
                                                                Continue</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 310)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost Memo Borong
                                                                Continue</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 311)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost Memo Tambahan
                                                                Continue</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div> --}}
                                    @elseif ($loop->iteration === 39)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-faktur_ekspedisi"
                                                    onchange="checkAllCategorytransaksi('faktur_ekspedisi')">
                                                <label for="select-faktur_ekspedisi" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 255)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 256)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 257)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 258)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 259)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 260)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 40)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-invoice_ekspedisi"
                                                    onchange="checkAllCategorytransaksi('invoice_ekspedisi')">
                                                <label for="select-invoice_ekspedisi" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 261)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="invoice_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('invoice_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 262)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="invoice_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('invoice_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 263)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="invoice_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('invoice_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 264)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="invoice_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('invoice_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 265)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="invoice_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('invoice_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 266)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="invoice_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('invoice_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 42)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-pelunasan_faktur_ekspedisi"
                                                    onchange="checkAllCategorytransaksi('pelunasan_faktur_ekspedisi')">
                                                <label for="select-pelunasan_faktur_ekspedisi"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 267)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 268)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 269)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 270)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 271)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 272)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 43)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-pelunasan_faktur_pembelianban"
                                                    onchange="checkAllCategorytransaksi('pelunasan_faktur_pembelianban')">
                                                <label for="select-pelunasan_faktur_pembelianban"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 273)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_pembelianban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_pembelianban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 274)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_pembelianban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_pembelianban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 275)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_pembelianban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_pembelianban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 276)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_pembelianban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_pembelianban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 277)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_pembelianban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_pembelianban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 278)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_pembelianban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_pembelianban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 44)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-pelunasan_faktur_pembelianpart"
                                                    onchange="checkAllCategorytransaksi('pelunasan_faktur_pembelianpart')">
                                                <label for="select-pelunasan_faktur_pembelianpart"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 279)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_pembelianpart"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_pembelianpart')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 280)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_pembelianpart"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_pembelianpart')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 281)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_pembelianpart"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_pembelianpart')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 282)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_pembelianpart"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_pembelianpart')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 283)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_pembelianpart"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_pembelianpart')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 284)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="pelunasan_faktur_pembelianpart"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pelunasan_faktur_pembelianpart')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 46)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-pengambilan_kaskecil"
                                                    onchange="checkAllCategorytransaksi('pengambilan_kaskecil')">
                                                <label for="select-pengambilan_kaskecil" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 285)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="pengambilan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pengambilan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Create</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 286)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="pengambilan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pengambilan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 287)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="pengambilan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pengambilan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 288)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="pengambilan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pengambilan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 289)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="pengambilan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pengambilan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 290)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="pengambilan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangetransaksi('pengambilan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if (
                                $loop->iteration === 49 ||
                                    $loop->iteration === 50 ||
                                    $loop->iteration === 51 ||
                                    $loop->iteration === 52 ||
                                    $loop->iteration === 53 ||
                                    $loop->iteration === 54 ||
                                    $loop->iteration === 55 ||
                                    $loop->iteration === 55 ||
                                    $loop->iteration === 56 ||
                                    $loop->iteration === 57 ||
                                    $loop->iteration === 58 ||
                                    $loop->iteration === 59 ||
                                    $loop->iteration === 60 ||
                                    $loop->iteration === 61 ||
                                    $loop->iteration === 62 ||
                                    $loop->iteration === 63 ||
                                    $loop->iteration === 64 ||
                                    $loop->iteration === 65 ||
                                    $loop->iteration === 66 ||
                                    $loop->iteration === 67 ||
                                    $loop->iteration === 68 ||
                                    $loop->iteration === 69)
                                <div id="finance">
                                    @if ($loop->iteration === 49)
                                        <label style="font-weight: bold; margin-bottom:20px; margin-top:20px; font-size:17px"
                                            class="form-check-label">FINANCE</label>
                                            <input type="checkbox" style="margin-left:10px" id="option-all" onchange="checkAllfinance(this)">
                                            <label for="option-all" >Select All</label>
                                            <br>
                                    @endif
                                    <div class="form-check mb-3">
                                        {{-- <input class="form-check-input" type="checkbox" name="menu[]"
                                            value="{{ $menu }}" {{ $akses->menu[$menu] ? 'checked' : '' }}> --}}
                                        <label class="form-check-label">
                                            @if ($loop->iteration === 49)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_perhitungan_gaji"
                                                    value="{{ $menu }}"data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_perhitungan_gaji')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY PERHITUNGAN GAJI
                                            @elseif ($loop->iteration === 50)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_kasbon_karyawan"
                                                    value="{{ $menu }}"data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_kasbon_karyawan')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY KASBON KARYAWAN
                                            @elseif ($loop->iteration === 51)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_penerimaan_kaskecil"
                                                    value="{{ $menu }}"data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_penerimaan_kaskecil')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY PENERIMAAN KAS
                                                KECIL
                                            @elseif ($loop->iteration === 52)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_pengambilan_kaskecil"
                                                    value="{{ $menu }}"data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_pengambilan_kaskecil')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY PENGAMBILAN KAS
                                                KECIL
                                            @elseif ($loop->iteration === 53)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_deposit_sopir" value="{{ $menu }}" data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_deposit_sopir')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY DEPOSIT SOPIR
                                            @elseif ($loop->iteration === 54)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_update_km" value="{{ $menu }}" data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_update_km')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY UPDATE KM
                                            @elseif ($loop->iteration === 55)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_pembelian_ban" value="{{ $menu }}" data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_pembelian_ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY PEMBELIAN BAN
                                            @elseif ($loop->iteration === 56)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_pembelian_part" value="{{ $menu }}" data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_pembelian_part')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY PEMBELIAN PART
                                            @elseif ($loop->iteration === 57)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_pemasangan_ban" value="{{ $menu }}"data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_pemasangan_ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY PEMASANGAN BAN
                                            @elseif ($loop->iteration === 58)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_pelepasan_ban" value="{{ $menu }}"data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_pelepasan_ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY PELEPASAN BAN
                                            @elseif ($loop->iteration === 59)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_pemasangan_part"
                                                    value="{{ $menu }}"data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_pemasangan_part')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY PEMASANGAN PART
                                            @elseif ($loop->iteration === 60)
                                                <input class="form-check-input" type="checkbox" name="menu[]"data-show="show_{{ $menu }}"
                                                    data-category="inquery_penggantian_oli"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_penggantian_oli')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY PENGGANTIAN OLI
                                            @elseif ($loop->iteration === 61)
                                                <input class="form-check-input" type="checkbox" name="menu[]"data-show="show_{{ $menu }}"
                                                    data-category="inquery_perpanjangan_stnk"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_perpanjangan_stnk')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY PERPANJANGAN STNK
                                            @elseif ($loop->iteration === 62)
                                                <input class="form-check-input" type="checkbox" name="menu[]"data-show="show_{{ $menu }}"
                                                    data-category="inquery_perpanjangan_kir"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_perpanjangan_kir')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY PERPANJANGAN KIR
                                            @elseif ($loop->iteration === 63)
                                                <input class="form-check-input" type="checkbox" name="menu[]"data-show="show_{{ $menu }}"
                                                    data-category="inquery_memo_ekspedisi" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY MEMO EKSPEDISI
                                            @elseif ($loop->iteration === 64)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_faktur_ekspedisi"
                                                    value="{{ $menu }}"data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_faktur_ekspedisi')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY FAKTUR EKSPEDISI
                                            @elseif ($loop->iteration === 65)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_invoice_ekspedisi"
                                                    value="{{ $menu }}"data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_invoice_ekspedisi')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY INVOICE FAKTUR
                                                EKSPEDISI
                                            @elseif ($loop->iteration === 66)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_return_ekspedisi"
                                                    value="{{ $menu }}"data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY RETURN EKSPEDISI
                                            @elseif ($loop->iteration === 67)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_pelunasan_ekspedisi"
                                                    value="{{ $menu }}"data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_ekspedisi')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY PELUNASAN
                                                EKSPEDISI
                                            @elseif ($loop->iteration === 68)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_pelunasan_faktur_pembelian_ban"
                                                    value="{{ $menu }}"data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_faktur_pembelian_ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY PELUNASAN FAKTUR
                                                PEMBELIAN BAN
                                            @elseif ($loop->iteration === 69)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="inquery_pelunasan_faktur_pembelian_part"
                                                    value="{{ $menu }}"data-show="show_{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_faktur_pembelian_part')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> INQUERY PELUNASAN FAKTUR
                                                PEMBELIAN PART
                                            @endif
                                        </label>
                                    </div>

                                    {{-- Fitur checkboxes --}}
                                    @if ($loop->iteration === 49)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_perhitungan_gaji"
                                                    onchange="checkAllCategoryfinance('inquery_perhitungan_gaji')">
                                                <label for="select-inquery_perhitungan_gaji"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 291)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perhitungan_gaji"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perhitungan_gaji')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting Mingguan</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 292)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perhitungan_gaji"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perhitungan_gaji')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost Mingguan</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 293)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perhitungan_gaji"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perhitungan_gaji')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 294)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perhitungan_gaji"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perhitungan_gaji')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 295)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perhitungan_gaji"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perhitungan_gaji')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="row ml-5">
                                                <div class="mb-3 ml-5" style="display: flex; flex-wrap: wrap;">
                                                    @foreach ($fiturs as $fitur)
                                                        @if ($loop->iteration == 296)
                                                            <div class="form-check ml-5 mb-3">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="fitur[]"
                                                                    data-category="inquery_perhitungan_gaji"
                                                                    value="{{ $fitur }}"
                                                                    onchange="handleIndividualCheckboxChangefinance('inquery_perhitungan_gaji')"
                                                                    {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                <label class="form-check-label">Posting Mingguan</label>
                                                            </div>
                                                        @elseif ($loop->iteration == 297)
                                                            <div class="form-check ml-5 mb-3">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="fitur[]"
                                                                    data-category="inquery_perhitungan_gaji"
                                                                    value="{{ $fitur }}"
                                                                    onchange="handleIndividualCheckboxChangefinance('inquery_perhitungan_gaji')"
                                                                    {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                <label class="form-check-label">Unpost Mingguan</label>
                                                            </div>
                                                        @elseif ($loop->iteration == 298)
                                                            <div class="form-check ml-5 mb-3">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="fitur[]"
                                                                    data-category="inquery_perhitungan_gaji"
                                                                    value="{{ $fitur }}"
                                                                    onchange="handleIndividualCheckboxChangefinance('inquery_perhitungan_gaji')"
                                                                    {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                <label class="form-check-label">Update</label>
                                                            </div>
                                                        @elseif ($loop->iteration == 299)
                                                            <div class="form-check ml-5 mb-3">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="fitur[]"
                                                                    data-category="inquery_perhitungan_gaji"
                                                                    value="{{ $fitur }}"
                                                                    onchange="handleIndividualCheckboxChangefinance('inquery_perhitungan_gaji')"
                                                                    {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                <label class="form-check-label">Delete</label>
                                                            </div>
                                                        @elseif ($loop->iteration == 300)
                                                            <div class="form-check ml-5 mb-3">
                                                                <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                    name="fitur[]"
                                                                    data-category="inquery_perhitungan_gaji"
                                                                    value="{{ $fitur }}"
                                                                    onchange="handleIndividualCheckboxChangefinance('inquery_perhitungan_gaji')"
                                                                    {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                <label class="form-check-label">Show</label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 50)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_kasbon_karyawan"
                                                    onchange="checkAllCategoryfinance('inquery_kasbon_karyawan')">
                                                <label for="select-inquery_kasbon_karyawan"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 301)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_kasbon_karyawan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_kasbon_karyawan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 302)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_kasbon_karyawan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_kasbon_karyawan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 303)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_kasbon_karyawan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_kasbon_karyawan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 304)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_kasbon_karyawan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_kasbon_karyawan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 305)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_kasbon_karyawan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_kasbon_karyawan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 51)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_penerimaan_kaskecil"
                                                    onchange="checkAllCategoryfinance('inquery_penerimaan_kaskecil')">
                                                <label for="select-inquery_penerimaan_kaskecil"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 81)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_penerimaan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_penerimaan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 82)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_penerimaan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_penerimaan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 83)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_penerimaan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_penerimaan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 84)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_penerimaan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_penerimaan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 85)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_penerimaan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_penerimaan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 52)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_pengambilan_kaskecil"
                                                    onchange="checkAllCategoryfinance('inquery_pengambilan_kaskecil')">
                                                <label for="select-inquery_pengambilan_kaskecil"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 86)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pengambilan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pengambilan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 87)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pengambilan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pengambilan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 88)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pengambilan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pengambilan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 89)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pengambilan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pengambilan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 90)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pengambilan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pengambilan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 53)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_deposit_sopir"
                                                    onchange="checkAllCategoryfinance('inquery_deposit_sopir')">
                                                <label for="select-inquery_deposit_sopir" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 91)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_deposit_sopir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_deposit_sopir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 92)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_deposit_sopir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_deposit_sopir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 93)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_deposit_sopir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_deposit_sopir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 94)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_deposit_sopir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_deposit_sopir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 95)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_deposit_sopir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_deposit_sopir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 54)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_update_km"
                                                    onchange="checkAllCategoryfinance('inquery_update_km')">
                                                <label for="select-inquery_update_km" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 96)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_update_km"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_update_km')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 97)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_update_km"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_update_km')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 98)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_update_km"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_update_km')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 99)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_update_km"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_update_km')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 100)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_update_km"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_update_km')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 55)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_pembelian_ban"
                                                    onchange="checkAllCategoryfinance('inquery_pembelian_ban')">
                                                <label for="select-inquery_pembelian_ban" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 101)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pembelian_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pembelian_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 102)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pembelian_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pembelian_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 103)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pembelian_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pembelian_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 104)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pembelian_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pembelian_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 105)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pembelian_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pembelian_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 56)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_pembelian_part"
                                                    onchange="checkAllCategoryfinance('inquery_pembelian_part')">
                                                <label for="select-inquery_pembelian_part"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 106)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pembelian_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pembelian_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 107)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pembelian_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pembelian_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 108)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pembelian_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pembelian_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 109)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pembelian_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pembelian_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 110)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pembelian_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pembelian_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 57)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_pemasangan_ban"
                                                    onchange="checkAllCategoryfinance('inquery_pemasangan_ban')">
                                                <label for="select-inquery_pemasangan_ban"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 111)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pemasangan_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pemasangan_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 112)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pemasangan_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pemasangan_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 113)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pemasangan_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pemasangan_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 114)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pemasangan_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pemasangan_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 115)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pemasangan_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pemasangan_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 58)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_pelepasan_ban"
                                                    onchange="checkAllCategoryfinance('inquery_pelepasan_ban')">
                                                <label for="select-inquery_pelepasan_ban" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 116)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pelepasan_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelepasan_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 117)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pelepasan_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelepasan_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 118)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pelepasan_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelepasan_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 119)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pelepasan_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelepasan_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 120)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pelepasan_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelepasan_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 59)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_pemasangan_part"
                                                    onchange="checkAllCategoryfinance('inquery_pemasangan_part')">
                                                <label for="select-inquery_pemasangan_part"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 121)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pemasangan_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pemasangan_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 122)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pemasangan_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pemasangan_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 123)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pemasangan_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pemasangan_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 124)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pemasangan_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pemasangan_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 125)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_pemasangan_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pemasangan_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 60)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_penggantian_oli"
                                                    onchange="checkAllCategoryfinance('inquery_penggantian_oli')">
                                                <label for="select-inquery_penggantian_oli"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 126)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_penggantian_oli"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_penggantian_oli')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 127)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_penggantian_oli"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_penggantian_oli')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 128)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_penggantian_oli"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_penggantian_oli')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 129)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_penggantian_oli"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_penggantian_oli')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 130)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_penggantian_oli"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_penggantian_oli')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 61)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_perpanjangan_stnk"
                                                    onchange="checkAllCategoryfinance('inquery_perpanjangan_stnk')">
                                                <label for="select-inquery_perpanjangan_stnk"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 131)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perpanjangan_stnk"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perpanjangan_stnk')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 132)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perpanjangan_stnk"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perpanjangan_stnk')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 133)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perpanjangan_stnk"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perpanjangan_stnk')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 134)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perpanjangan_stnk"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perpanjangan_stnk')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 135)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perpanjangan_stnk"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perpanjangan_stnk')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 62)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_perpanjangan_kir"
                                                    onchange="checkAllCategoryfinance('inquery_perpanjangan_kir')">
                                                <label for="select-inquery_perpanjangan_kir"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 136)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perpanjangan_kir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perpanjangan_kir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 137)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perpanjangan_kir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perpanjangan_kir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 138)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perpanjangan_kir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perpanjangan_kir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 139)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perpanjangan_kir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perpanjangan_kir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 140)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_perpanjangan_kir"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_perpanjangan_kir')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 63)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_memo_ekspedisi"
                                                    onchange="checkAllCategoryfinance('inquery_memo_ekspedisi')">
                                                <label for="select-inquery_memo_ekspedisi"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 141)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting Memo
                                                                Perjalanan</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 142)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost Memo Perjalanan</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 143)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 144)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 145)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="ml-5">
                                                <div class="row ml-5">
                                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                        @foreach ($fiturs as $fitur)
                                                            @if ($loop->iteration == 146)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_memo_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Posting Memo
                                                                        Borong</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 147)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_memo_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Unpost Memo
                                                                        Borong</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 148)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_memo_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Update</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 149)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_memo_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Delete</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 150)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_memo_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Show</label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="ml-5">
                                                <div class="row ml-5">
                                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                        @foreach ($fiturs as $fitur)
                                                            @if ($loop->iteration == 151)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_memo_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Posting Memo
                                                                        Tambahan</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 152)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_memo_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Unpost Memo
                                                                        Tambahan</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 153)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_memo_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Update</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 154)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_memo_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Delete</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 155)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_memo_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_memo_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Show</label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 64)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_faktur_ekspedisi"
                                                    onchange="checkAllCategoryfinance('inquery_faktur_ekspedisi')">
                                                <label for="select-inquery_faktur_ekspedisi"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 156)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 157)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 158)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 159)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 160)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 65)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_invoice_ekspedisi"
                                                    onchange="checkAllCategoryfinance('inquery_invoice_ekspedisi')">
                                                <label for="select-inquery_invoice_ekspedisi"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 161)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_invoice_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_invoice_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 162)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_invoice_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_invoice_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 163)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_invoice_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_invoice_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 164)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_invoice_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_invoice_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 165)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_invoice_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_invoice_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 66)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_return_ekspedisi"
                                                    onchange="checkAllCategoryfinance('inquery_return_ekspedisi')">
                                                <label for="select-inquery_return_ekspedisi"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 166)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_return_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting Penerimaan
                                                                Barang</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 167)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_return_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost Penerimaan
                                                                Barang</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 168)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_return_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 169)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="inquery_return_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 170)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]" data-category="inquery_return_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="ml-5">
                                                <div class="row ml-5">
                                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                        @foreach ($fiturs as $fitur)
                                                            @if ($loop->iteration == 171)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_return_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Posting Nota
                                                                        Return</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 172)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_return_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Unpost Nota
                                                                        Return</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 173)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_return_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Update</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 174)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_return_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Delete</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 175)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_return_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Show</label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="ml-5">
                                                <div class="row ml-5">
                                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                        @foreach ($fiturs as $fitur)
                                                            @if ($loop->iteration == 176)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_return_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Posting Penjualan
                                                                        Return</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 177)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_return_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Unpost Penjualan
                                                                        Return</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 178)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_return_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Update</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 179)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_return_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Delete</label>
                                                                </div>
                                                            @elseif ($loop->iteration == 180)
                                                                <div class="form-check ml-5 mb-3">
                                                                    <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                        name="fitur[]"
                                                                        data-category="inquery_return_ekspedisi"
                                                                        value="{{ $fitur }}"
                                                                        onchange="handleIndividualCheckboxChangefinance('inquery_return_ekspedisi')"
                                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Show</label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 67)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_pelunasan_ekspedisi"
                                                    onchange="checkAllCategoryfinance('inquery_pelunasan_ekspedisi')">
                                                <label for="select-inquery_pelunasan_ekspedisi"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 181)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 182)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 183)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 184)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 185)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 68)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_pelunasan_faktur_pembelian_ban"
                                                    onchange="checkAllCategoryfinance('inquery_pelunasan_faktur_pembelian_ban')">
                                                <label for="select-inquery_pelunasan_faktur_pembelian_ban"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 186)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_faktur_pembelian_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_faktur_pembelian_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 187)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_faktur_pembelian_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_faktur_pembelian_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 188)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_faktur_pembelian_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_faktur_pembelian_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 189)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_faktur_pembelian_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_faktur_pembelian_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 190)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_faktur_pembelian_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_faktur_pembelian_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 69)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-inquery_pelunasan_faktur_pembelian_part"
                                                    onchange="checkAllCategoryfinance('inquery_pelunasan_faktur_pembelian_part')">
                                                <label for="select-inquery_pelunasan_faktur_pembelian_part"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 191)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_faktur_pembelian_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_faktur_pembelian_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Posting</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 192)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_faktur_pembelian_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_faktur_pembelian_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Unpost</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 193)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_faktur_pembelian_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_faktur_pembelian_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Update</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 194)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_faktur_pembelian_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_faktur_pembelian_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Delete</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 195)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input show_{{ $menu }}" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="inquery_pelunasan_faktur_pembelian_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangefinance('inquery_pelunasan_faktur_pembelian_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Show</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if (
                                $loop->iteration === 70 ||
                                    $loop->iteration === 71 ||
                                    $loop->iteration === 72 ||
                                    $loop->iteration === 73 ||
                                    $loop->iteration === 74 ||
                                    $loop->iteration === 75 ||
                                    $loop->iteration === 76 ||
                                    $loop->iteration === 77 ||
                                    $loop->iteration === 78 ||
                                    $loop->iteration === 79 ||
                                    $loop->iteration === 80 ||
                                    $loop->iteration === 81 ||
                                    $loop->iteration === 82 ||
                                    $loop->iteration === 83 ||
                                    $loop->iteration === 84 ||
                                    $loop->iteration === 85 ||
                                    $loop->iteration === 86 ||
                                    $loop->iteration === 87 ||
                                    $loop->iteration === 88 ||
                                    $loop->iteration === 89 ||
                                    $loop->iteration === 90 ||
                                    $loop->iteration === 91 ||
                                    $loop->iteration === 92)
                                <div id="laporan">
                                    @if ($loop->iteration === 70)
                                        <label style="font-weight: bold; margin-bottom:20px; margin-top:20px; font-size:17px"
                                            class="form-check-label">LAPORAN</label>
                                            <input type="checkbox" style="margin-left:10px" id="option-all" onchange="checkAlllaporan(this)">
                                            <label for="option-all" >Select All</label>
                                            <br>
                                    @endif
                                    <div class="form-check mb-3">
                                        {{-- <input class="form-check-input" type="checkbox" name="menu[]"
                                            value="{{ $menu }}" {{ $akses->menu[$menu] ? 'checked' : '' }}> --}}
                                        <label class="form-check-label">
                                            @if ($loop->iteration === 70)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_perhitungan_gaji"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_perhitungan_gaji')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN PERHITUNGAN GAJI
                                            @elseif ($loop->iteration === 71)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_kasbon_karyawan"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_kasbon_karyawan')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN KASBON KARYAWAN
                                            @elseif ($loop->iteration === 72)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_pembelian_ban" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_pembelian_ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN PEMBELIAN BAN
                                            @elseif ($loop->iteration === 73)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_pembelian_part" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_pembelian_part')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN PEMBELIAN PART
                                            @elseif ($loop->iteration === 74)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_pemasangan_ban" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_pemasangan_ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN PEMASANGAN BAN
                                            @elseif ($loop->iteration === 75)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_pelepasan_ban" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_pelepasan_ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN PELEPASAN BAN
                                            @elseif ($loop->iteration === 76)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_pemasangan_part"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_pemasangan_part')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN PEMASANGAN PART
                                            @elseif ($loop->iteration === 77)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_penggantian_oli"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_penggantian_oli')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN PENGGANTIAN OLI
                                            @elseif ($loop->iteration === 78)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_update_km" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_update_km')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN UPDATE KM
                                                    @elseif ($loop->iteration === 79)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_kas_kecil" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_kas_kecil')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN KAS KECIL
                                                    @elseif ($loop->iteration === 80)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_mobil_logistik" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_mobil_logistik')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN MOBIL LOGISTIK
                                            @elseif ($loop->iteration === 81)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_status_perjalanan"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_status_perjalanan')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN STATUS PERJALANAN
                                            @elseif ($loop->iteration === 82)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_penerimaan_kaskecil"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_penerimaan_kaskecil')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN PENERIMAAN KAS
                                                KECIL
                                            @elseif ($loop->iteration === 83)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_pengambilan_kaskecil"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_pengambilan_kaskecil')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN PENGAMBILAN KAS
                                                KECIL
                                            @elseif ($loop->iteration === 84)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_deposit_driver" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_deposit_driver')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN DEPOSIT DRIVER
                                            @elseif ($loop->iteration === 85)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_memo_perjalanan"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_memo_perjalanan')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN MEMO EKSPEDISI
                                            @elseif ($loop->iteration === 86)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_faktur_ekspedisi"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_faktur_ekspedisi')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN FAKTUR EKSPEDISI
                                            @elseif ($loop->iteration === 87)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_pph" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_pph')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN PPH
                                            @elseif ($loop->iteration === 88)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_invoice_ekspedisi"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_invoice_ekspedisi')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN INVOICE EKSPEDISI
                                            @elseif ($loop->iteration === 89)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_return_barang" value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_return_barang')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN RETURN BARANG
                                            @elseif ($loop->iteration === 90)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_pelunasan_ekspedisi"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_pelunasan_ekspedisi')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN PELUNASAN
                                                EKSPEDISI
                                            @elseif ($loop->iteration === 91)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_pelunasan_pembelian_ban"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_pelunasan_pembelian_ban')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN PELUNASAN
                                                PEMBELIAN BAN
                                            @elseif ($loop->iteration === 92)
                                                <input class="form-check-input" type="checkbox" name="menu[]"
                                                    data-category="laporan_pelunasan_pembelian_part"
                                                    value="{{ $menu }}"
                                                    onchange="handleIndividualCheckboxChangelaporan('laporan_pelunasan_pembelian_part')"
                                                    {{ $akses->menu[$menu] ? 'checked' : '' }}> LAPORAN PELUNASAN
                                                PEMBELIAN PART
                                            @endif
                                        </label>
                                    </div>

                                    {{-- Fitur checkboxes --}}
                                    @if ($loop->iteration === 70)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_perhitungan_gaji"
                                                    onchange="checkAllCategorylaporan('laporan_perhitungan_gaji')">
                                                <label for="select-laporan_perhitungan_gaji"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 306)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_perhitungan_gaji"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_perhitungan_gaji')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 307)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_perhitungan_gaji"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_perhitungan_gaji')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 71)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_kasbon_karyawan"
                                                    onchange="checkAllCategorylaporan('laporan_kasbon_karyawan')">
                                                <label for="select-laporan_kasbon_karyawan"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 308)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_kasbon_karyawan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_kasbon_karyawan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 309)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_kasbon_karyawan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_kasbon_karyawan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 72)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_pembelian_ban"
                                                    onchange="checkAllCategorylaporan('laporan_pembelian_ban')">
                                                <label for="select-laporan_pembelian_ban" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 310)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pembelian_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pembelian_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 311)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pembelian_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pembelian_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 73)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_pembelian_part"
                                                    onchange="checkAllCategorylaporan('laporan_pembelian_part')">
                                                <label for="select-laporan_pembelian_part"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 198)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pembelian_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pembelian_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 199)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pembelian_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pembelian_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 74)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_pemasangan_ban"
                                                    onchange="checkAllCategorylaporan('laporan_pemasangan_ban')">
                                                <label for="select-laporan_pemasangan_ban"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 200)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pemasangan_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pemasangan_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 201)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pemasangan_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pemasangan_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 75)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_pelepasan_ban"
                                                    onchange="checkAllCategorylaporan('laporan_pelepasan_ban')">
                                                <label for="select-laporan_pelepasan_ban" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 202)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pelepasan_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pelepasan_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 203)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pelepasan_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pelepasan_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 76)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_pemasangan_part"
                                                    onchange="checkAllCategorylaporan('laporan_pemasangan_part')">
                                                <label for="select-laporan_pemasangan_part"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 204)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pemasangan_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pemasangan_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 205)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pemasangan_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pemasangan_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 77)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_penggantian_oli"
                                                    onchange="checkAllCategorylaporan('laporan_penggantian_oli')">
                                                <label for="select-laporan_penggantian_oli"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 206)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_penggantian_oli"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_penggantian_oli')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 207)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_penggantian_oli"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_penggantian_oli')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 78)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_updatekm"
                                                    onchange="checkAllCategorylaporan('laporan_updatekm')">
                                                <label for="select-laporan_updatekm" style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 208)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_updatekm"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_updatekm')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 209)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_updatekm"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_updatekm')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 81)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_status_perjalanan"
                                                    onchange="checkAllCategorylaporan('laporan_status_perjalanan')">
                                                <label for="select-laporan_status_perjalanan"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 210)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_status_perjalanan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_status_perjalanan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 211)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_status_perjalanan"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_status_perjalanan')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 82)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_penerimaan_kaskecil"
                                                    onchange="checkAllCategorylaporan('laporan_penerimaan_kaskecil')">
                                                <label for="select-laporan_penerimaan_kaskecil"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 212)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="laporan_penerimaan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_penerimaan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 213)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="laporan_penerimaan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_penerimaan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 83)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_pengambilan_kaskecil"
                                                    onchange="checkAllCategorylaporan('laporan_pengambilan_kaskecil')">
                                                <label for="select-laporan_pengambilan_kaskecil"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 214)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="laporan_pengambilan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pengambilan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 215)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]"
                                                                data-category="laporan_pengambilan_kaskecil"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pengambilan_kaskecil')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 84)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_deposit_driver"
                                                    onchange="checkAllCategorylaporan('laporan_deposit_driver')">
                                                <label for="select-laporan_deposit_driver"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 216)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_deposit_driver"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_deposit_driver')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 217)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_deposit_driver"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_deposit_driver')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 85)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_memo_ekspedisi"
                                                    onchange="checkAllCategorylaporan('laporan_memo_ekspedisi')">
                                                <label for="select-laporan_memo_ekspedisi"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 218)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari Memo Perjalanan</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 219)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_memo_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_memo_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="ml-5">
                                            <div class="ml-5">
                                                <div class="ml-4">
                                                    <div class="row">
                                                        <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                            @foreach ($fiturs as $fitur)
                                                                @if ($loop->iteration == 220)
                                                                    <div class="form-check ml-5 mb-3">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="fitur[]"
                                                                            data-category="laporan_memo_ekspedisi"
                                                                            value="{{ $fitur }}"
                                                                            onchange="handleIndividualCheckboxChangelaporan('laporan_memo_ekspedisi')"
                                                                            {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                        <label class="form-check-label">Cari Memo
                                                                            Borong</label>
                                                                    </div>
                                                                @elseif ($loop->iteration == 221)
                                                                    <div class="form-check ml-5 mb-3">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="fitur[]"
                                                                            data-category="laporan_memo_ekspedisi"
                                                                            value="{{ $fitur }}"
                                                                            onchange="handleIndividualCheckboxChangelaporan('laporan_memo_ekspedisi')"
                                                                            {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                        <label class="form-check-label">Cetak</label>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-5">
                                            <div class="ml-5">
                                                <div class="ml-4">
                                                    <div class="row">
                                                        <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                            @foreach ($fiturs as $fitur)
                                                                @if ($loop->iteration == 222)
                                                                    <div class="form-check ml-5 mb-3">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="fitur[]"
                                                                            data-category="laporan_memo_ekspedisi"
                                                                            value="{{ $fitur }}"
                                                                            onchange="handleIndividualCheckboxChangelaporan('laporan_memo_ekspedisi')"
                                                                            {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                        <label class="form-check-label">Cari Memo
                                                                            Tambahan</label>
                                                                    </div>
                                                                @elseif ($loop->iteration == 223)
                                                                    <div class="form-check ml-5 mb-3">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="fitur[]"
                                                                            data-category="laporan_memo_ekspedisi"
                                                                            value="{{ $fitur }}"
                                                                            onchange="handleIndividualCheckboxChangelaporan('laporan_memo_ekspedisi')"
                                                                            {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                        <label class="form-check-label">Cetak</label>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 86)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_faktur_ekspedisi"
                                                    onchange="checkAllCategorylaporan('laporan_faktur_ekspedisi')">
                                                <label for="select-laporan_faktur_ekspedisi"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 224)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 225)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_faktur_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_faktur_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 87)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_pph"
                                                    onchange="checkAllCategorylaporan('laporan_pph')">
                                                <label for="select-laporan_pph"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 226)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pph"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pph')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 227)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pph"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pph')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 88)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_invoice_ekspedisi"
                                                    onchange="checkAllCategorylaporan('laporan_invoice_ekspedisi')">
                                                <label for="select-laporan_invoice_ekspedisi"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 228)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_invoice_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_invoice_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 229)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_invoice_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_invoice_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 89)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_return_ekspedisi"
                                                    onchange="checkAllCategorylaporan('laporan_return_ekspedisi')">
                                                <label for="select-laporan_return_ekspedisi"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 230)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_return_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_return_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari Surat Penerimaan Return Barang</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 231)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_return_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_return_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="ml-5">
                                            <div class="ml-5">
                                                <div class="ml-4">
                                                    <div class="row">
                                                        <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                            @foreach ($fiturs as $fitur)
                                                                @if ($loop->iteration == 232)
                                                                    <div class="form-check ml-5 mb-3">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="fitur[]"
                                                                            data-category="laporan_return_ekspedisi"
                                                                            value="{{ $fitur }}"
                                                                            onchange="handleIndividualCheckboxChangelaporan('laporan_return_ekspedisi')"
                                                                            {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                        <label class="form-check-label">Cari Nota Return Barang</label>
                                                                    </div>
                                                                @elseif ($loop->iteration == 233)
                                                                    <div class="form-check ml-5 mb-3">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="fitur[]"
                                                                            data-category="laporan_return_ekspedisi"
                                                                            value="{{ $fitur }}"
                                                                            onchange="handleIndividualCheckboxChangelaporan('laporan_return_ekspedisi')"
                                                                            {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                        <label class="form-check-label">Cetak</label>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-5">
                                            <div class="ml-5">
                                                <div class="ml-4">
                                                    <div class="row">
                                                        <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                            @foreach ($fiturs as $fitur)
                                                                @if ($loop->iteration == 234)
                                                                    <div class="form-check ml-5 mb-3">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="fitur[]"
                                                                            data-category="laporan_return_ekspedisi"
                                                                            value="{{ $fitur }}"
                                                                            onchange="handleIndividualCheckboxChangelaporan('laporan_return_ekspedisi')"
                                                                            {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                        <label class="form-check-label">Cari Penjualan Return Barang</label>
                                                                    </div>
                                                                @elseif ($loop->iteration == 235)
                                                                    <div class="form-check ml-5 mb-3">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="fitur[]"
                                                                            data-category="laporan_return_ekspedisi"
                                                                            value="{{ $fitur }}"
                                                                            onchange="handleIndividualCheckboxChangelaporan('laporan_return_ekspedisi')"
                                                                            {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                                        <label class="form-check-label">Cetak</label>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($loop->iteration === 90)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_pelunasan_ekspedisi"
                                                    onchange="checkAllCategorylaporan('laporan_pelunasan_ekspedisi')">
                                                <label for="select-laporan_pelunasan_ekspedisi"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 236)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pelunasan_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pelunasan_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 237)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pelunasan_ekspedisi"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pelunasan_ekspedisi')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                    @elseif ($loop->iteration === 91)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_pelunasan_pembelian_ban"
                                                    onchange="checkAllCategorylaporan('laporan_pelunasan_pembelian_ban')">
                                                <label for="select-laporan_pelunasan_pembelian_ban"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 238)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pelunasan_pembelian_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pelunasan_pembelian_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 239)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pelunasan_pembelian_ban"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pelunasan_pembelian_ban')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                    @elseif ($loop->iteration === 92)
                                        <div class="row">
                                            <div class="form-check" style="margin-left:28px">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select-laporan_pelunasan_pembelian_part"
                                                    onchange="checkAllCategorylaporan('laporan_pelunasan_pembelian_part')">
                                                <label for="select-laporan_pelunasan_pembelian_part"
                                                    style="margin-left:5px">Select
                                                    All</label>
                                            </div>
                                            <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                                @foreach ($fiturs as $fitur)
                                                    @if ($loop->iteration == 240)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pelunasan_pembelian_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pelunasan_pembelian_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cari</label>
                                                        </div>
                                                    @elseif ($loop->iteration == 241)
                                                        <div class="form-check ml-5 mb-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="fitur[]" data-category="laporan_pelunasan_pembelian_part"
                                                                value="{{ $fitur }}"
                                                                onchange="handleIndividualCheckboxChangelaporan('laporan_pelunasan_pembelian_part')"
                                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                            <label class="form-check-label">Cetak</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                    @endif
                                </div>
                            @endif
                        @endforeach



                        {{-- {{ ucfirst($fitur) }} --}}


                        {{-- JavaScript --}}
                        <script>
                            function checkAll(myCheckbox) {
                                var checkboxesInMaster = document.querySelectorAll("input[type='checkbox']");

                                checkboxesInMaster.forEach(function(checkbox) {
                                    checkbox.checked = myCheckbox.checked;
                                });
                            }

                            function checkAllmaster(myCheckbox) {
                                var checkboxesInMaster = document.querySelectorAll("#master input[type='checkbox']");

                                checkboxesInMaster.forEach(function(checkbox) {
                                    checkbox.checked = myCheckbox.checked;
                                });
                            }

                            function checkAllCategory(category) {
                                var checkboxes = document.querySelectorAll('#master input[type="checkbox"][data-category="' + category + '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                checkboxes.forEach(function(checkbox) {
                                    checkbox.checked = selectAllCheckbox.checked;
                                });

                                updateSelectAllCheckbox(category);
                            }

                            function updateSelectAllCheckbox(category) {
                                var checkboxes = document.querySelectorAll('#master input[type="checkbox"][data-category="' + category + '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                var allChecked = true;
                                checkboxes.forEach(function(checkbox) {
                                    if (!checkbox.checked) {
                                        allChecked = false;
                                    }
                                });

                                selectAllCheckbox.checked = allChecked;
                            }

                            function handleIndividualCheckboxChange(category) {
                                var checkboxes = document.querySelectorAll('#master input[type="checkbox"][data-category="' + category + '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                var allChecked = true;
                                checkboxes.forEach(function(checkbox) {
                                    if (!checkbox.checked) {
                                        allChecked = false;
                                    }
                                });

                                selectAllCheckbox.checked = allChecked;

                                var showCheckbox = document.querySelector('.' + checkbox.getAttribute('data-show'));
                                if (checkbox.checked) {
                                    // Lakukan sesuatu saat kotak centang dicentang
                                    showCheckbox.checked = true;
                                } else {
                                    // Lakukan sesuatu saat kotak centang tidak dicentang
                                    showCheckbox.checked = false;
                                }
                            }

                            // Initial update for user and akses categories
                            window.onload = function() {
                                updateSelectAllCheckbox('karyawan');
                                updateSelectAllCheckbox('user');
                                updateSelectAllCheckbox('akses');
                                updateSelectAllCheckbox('gaji_karyawan');
                                updateSelectAllCheckbox('departemen');
                                updateSelectAllCheckbox('supplier');
                                updateSelectAllCheckbox('pelanggan');
                                updateSelectAllCheckbox('divisi');
                                updateSelectAllCheckbox('jenis_kendaraan');
                                updateSelectAllCheckbox('golongan');
                                updateSelectAllCheckbox('kendaraan');
                                updateSelectAllCheckbox('ukuran_ban');
                                updateSelectAllCheckbox('merek_ban');
                                updateSelectAllCheckbox('type_ban');
                                updateSelectAllCheckbox('ban');
                                updateSelectAllCheckbox('nokir');
                                updateSelectAllCheckbox('stnk');
                                updateSelectAllCheckbox('part');
                                updateSelectAllCheckbox('driver');
                                updateSelectAllCheckbox('rute');
                                updateSelectAllCheckbox('biaya_tambahan');
                                updateSelectAllCheckbox('potongan_memo');
                                updateSelectAllCheckbox('biaya_tarif');
                                updateSelectAllCheckbox('barang_return');
                                updateSelectAllCheckbox('akun');

                                updateSelectAllCheckboxoperasional('perpanjangan_stnk');
                                updateSelectAllCheckboxoperasional('perpanjangan_kir');
                                updateSelectAllCheckboxoperasional('penggantian_oli');

                                updateSelectAllCheckboxtransaksi('memo_ekspedisi');
                                updateSelectAllCheckboxtransaksi('faktur_ekspedisi');
                                updateSelectAllCheckboxtransaksi('invoice_ekspedisi');
                                updateSelectAllCheckboxtransaksi('pelunasan_faktur_ekspedisi');
                                updateSelectAllCheckboxtransaksi('pelunasan_faktur_pembelianban');
                                updateSelectAllCheckboxtransaksi('pelunasan_faktur_pembelianpart');
                                updateSelectAllCheckboxtransaksi('pengambilan_kaskecil');

                                updateSelectAllCheckboxfinance('inquery_perhitungan_gaji');
                                updateSelectAllCheckboxfinance('inquery_kasbon_karyawan');
                                updateSelectAllCheckboxfinance('inquery_penerimaan_kaskecil');
                                updateSelectAllCheckboxfinance('inquery_pengambilan_kaskecil');
                                updateSelectAllCheckboxfinance('inquery_deposit_sopir');
                                updateSelectAllCheckboxfinance('inquery_update_km');
                                updateSelectAllCheckboxfinance('inquery_pembelian_ban');
                                updateSelectAllCheckboxfinance('inquery_pembelian_part');
                                updateSelectAllCheckboxfinance('inquery_pemasangan_ban');
                                updateSelectAllCheckboxfinance('inquery_pelepasan_ban');
                                updateSelectAllCheckboxfinance('inquery_pemasangan_part');
                                updateSelectAllCheckboxfinance('inquery_penggantian_oli');
                                updateSelectAllCheckboxfinance('inquery_perpanjangan_stnk');
                                updateSelectAllCheckboxfinance('inquery_perpanjangan_kir');
                                updateSelectAllCheckboxfinance('inquery_memo_ekspedisi');
                                updateSelectAllCheckboxfinance('inquery_faktur_ekspedisi');
                                updateSelectAllCheckboxfinance('inquery_invoice_ekspedisi');
                                updateSelectAllCheckboxfinance('inquery_return_ekspedisi');
                                updateSelectAllCheckboxfinance('inquery_pelunasan_ekspedisi');
                                updateSelectAllCheckboxfinance('inquery_pelunasan_faktur_pembelian_ban');
                                updateSelectAllCheckboxfinance('inquery_pelunasan_faktur_pembelian_part');

                                updateSelectAllCheckboxfinance('laporan_perhitungan_gaji');
                                updateSelectAllCheckboxfinance('laporan_kasbon_karyawan');
                                updateSelectAllCheckboxfinance('laporan_pembelian_ban');
                                updateSelectAllCheckboxfinance('laporan_pembelian_part');
                                updateSelectAllCheckboxfinance('laporan_pemasangan_ban');
                                updateSelectAllCheckboxfinance('laporan_pelepasan_ban');
                                updateSelectAllCheckboxfinance('laporan_pemasangan_part');
                                updateSelectAllCheckboxfinance('laporan_updatekm');
                                updateSelectAllCheckboxfinance('laporan_status_perjalanan');
                                updateSelectAllCheckboxfinance('laporan_penerimaan_kaskecil');
                                updateSelectAllCheckboxfinance('laporan_pengambilan_kaskecil');
                                updateSelectAllCheckboxfinance('laporan_deposit_driver');
                                updateSelectAllCheckboxfinance('laporan_memo_ekspedisi');
                                updateSelectAllCheckboxfinance('laporan_penggantian_oli');
                                updateSelectAllCheckboxfinance('laporan_pph');
                                updateSelectAllCheckboxfinance('laporan_invoice_ekspedisi');
                                updateSelectAllCheckboxfinance('laporan_faktur_ekspedisi');
                                updateSelectAllCheckboxfinance('laporan_return_ekspedisi');
                                updateSelectAllCheckboxfinance('laporan_pelunasan_ekspedisi');
                                updateSelectAllCheckboxfinance('laporan_pelunasan_pembelian_ban');
                                updateSelectAllCheckboxfinance('laporan_pelunasan_pembelian_part');
                            }
                        </script>


                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var checkboxes = document.querySelectorAll('input[name="menu[]"]');
                                checkboxes.forEach(function(checkbox) {
                                    checkbox.addEventListener('change', function() {
                                        var showCheckbox = document.querySelector('.' + checkbox.getAttribute(
                                            'data-show'));
                                        if (checkbox.checked) {
                                            showCheckbox.checked = true;
                                        } else {
                                            showCheckbox.checked = false;
                                        }
                                    });
                                });
                            });
                        </script>
                        
                        {{-- operasional --}}
                        <script>

                            function checkAlloperasional(myCheckbox) {
                                var checkboxesInMaster = document.querySelectorAll("#operasional input[type='checkbox']");

                                checkboxesInMaster.forEach(function(checkbox) {
                                    checkbox.checked = myCheckbox.checked;
                                });
                            }

                            function checkAllCategoryoperasional(category) {
                                var checkboxes = document.querySelectorAll('#operasional input[type="checkbox"][data-category="' + category +
                                    '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                checkboxes.forEach(function(checkbox) {
                                    checkbox.checked = selectAllCheckbox.checked;
                                });

                                updateSelectAllCheckboxoperasional(category);
                            }

                            function updateSelectAllCheckboxoperasional(category) {
                                var checkboxes = document.querySelectorAll('#operasional input[type="checkbox"][data-category="' + category +
                                    '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                var allChecked = true;
                                checkboxes.forEach(function(checkbox) {
                                    if (!checkbox.checked) {
                                        allChecked = false;
                                    }
                                });

                                selectAllCheckbox.checked = allChecked;
                            }

                            function handleIndividualCheckboxChangeoperasional(category) {
                                var checkboxes = document.querySelectorAll('#operasional input[type="checkbox"][data-category="' + category +
                                    '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                var allChecked = true;
                                checkboxes.forEach(function(checkbox) {
                                    if (!checkbox.checked) {
                                        allChecked = false;
                                    }
                                });

                                selectAllCheckbox.checked = allChecked;
                            }

                            // Initial update for user and akses categories
                        </script>

                        {{-- transaksi --}}
                        <script>

                            function checkAlltransaksi(myCheckbox) {
                                var checkboxesInMaster = document.querySelectorAll("#transaksi input[type='checkbox']");

                                checkboxesInMaster.forEach(function(checkbox) {
                                    checkbox.checked = myCheckbox.checked;
                                });
                            }

                            function checkAllCategorytransaksi(category) {
                                var checkboxes = document.querySelectorAll('#transaksi input[type="checkbox"][data-category="' + category +
                                    '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                checkboxes.forEach(function(checkbox) {
                                    checkbox.checked = selectAllCheckbox.checked;
                                });

                                updateSelectAllCheckboxtransaksi(category);
                            }

                            function updateSelectAllCheckboxtransaksi(category) {
                                var checkboxes = document.querySelectorAll('#transaksi input[type="checkbox"][data-category="' + category +
                                    '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                var allChecked = true;
                                checkboxes.forEach(function(checkbox) {
                                    if (!checkbox.checked) {
                                        allChecked = false;
                                    }
                                });

                                selectAllCheckbox.checked = allChecked;
                            }

                            function handleIndividualCheckboxChangetransaksi(category) {
                                var checkboxes = document.querySelectorAll('#transaksi input[type="checkbox"][data-category="' + category +
                                    '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                var allChecked = true;
                                checkboxes.forEach(function(checkbox) {
                                    if (!checkbox.checked) {
                                        allChecked = false;
                                    }
                                });

                                selectAllCheckbox.checked = allChecked;
                            }

                            // Initial update for user and akses categories
                        </script>

                        {{-- finance --}}
                        <script>
                            function checkAllfinance(myCheckbox) {
                                var checkboxesInMaster = document.querySelectorAll("#finance input[type='checkbox']");

                                checkboxesInMaster.forEach(function(checkbox) {
                                    checkbox.checked = myCheckbox.checked;
                                });
                            }
                            function checkAllCategoryfinance(category) {
                                var checkboxes = document.querySelectorAll('#finance input[type="checkbox"][data-category="' + category +
                                    '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                checkboxes.forEach(function(checkbox) {
                                    checkbox.checked = selectAllCheckbox.checked;
                                });

                                updateSelectAllCheckboxfinance(category);
                            }

                            function updateSelectAllCheckboxfinance(category) {
                                var checkboxes = document.querySelectorAll('#finance input[type="checkbox"][data-category="' + category +
                                    '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                var allChecked = true;
                                checkboxes.forEach(function(checkbox) {
                                    if (!checkbox.checked) {
                                        allChecked = false;
                                    }
                                });

                                selectAllCheckbox.checked = allChecked;
                            }

                            function handleIndividualCheckboxChangefinance(category) {
                                var checkboxes = document.querySelectorAll('#finance input[type="checkbox"][data-category="' + category +
                                    '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                var allChecked = true;
                                checkboxes.forEach(function(checkbox) {
                                    if (!checkbox.checked) {
                                        allChecked = false;
                                    }
                                });

                                selectAllCheckbox.checked = allChecked;
                            }

                            // Initial update for user and akses categories
                        </script>

                        {{-- laporan --}}
                        <script>
                            function checkAlllaporan(myCheckbox) {
                                var checkboxesInMaster = document.querySelectorAll("#laporan input[type='checkbox']");

                                checkboxesInMaster.forEach(function(checkbox) {
                                    checkbox.checked = myCheckbox.checked;
                                });
                            }

                            function checkAllCategorylaporan(category) {
                                var checkboxes = document.querySelectorAll('#laporan input[type="checkbox"][data-category="' + category +
                                    '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                checkboxes.forEach(function(checkbox) {
                                    checkbox.checked = selectAllCheckbox.checked;
                                });

                                updateSelectAllCheckboxlaporan(category);
                            }

                            function updateSelectAllCheckboxlaporan(category) {
                                var checkboxes = document.querySelectorAll('#laporan input[type="checkbox"][data-category="' + category +
                                    '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                var allChecked = true;
                                checkboxes.forEach(function(checkbox) {
                                    if (!checkbox.checked) {
                                        allChecked = false;
                                    }
                                });

                                selectAllCheckbox.checked = allChecked;
                            }

                            function handleIndividualCheckboxChangelaporan(category) {
                                var checkboxes = document.querySelectorAll('#laporan input[type="checkbox"][data-category="' + category +
                                    '"]');
                                var selectAllCheckbox = document.getElementById('select-' + category);

                                var allChecked = true;
                                checkboxes.forEach(function(checkbox) {
                                    if (!checkbox.checked) {
                                        allChecked = false;
                                    }
                                });

                                selectAllCheckbox.checked = allChecked;
                            }

                            // Initial update for user and akses categories
                        </script>
                    </div>



                    {{-- <script>
                        function checkAlls(myCheckbox) {
                            var checkboxesInMaster = document.querySelectorAll("#transaksi input[type='checkbox']");

                            if (myCheckbox.checked == true) {
                                checkboxesInMaster.forEach(function(checkbox) {
                                    checkbox.checked = true;
                                });
                            } else {
                                checkboxesInMaster.forEach(function(checkbox) {
                                    checkbox.checked = false;
                                });
                            }
                        }
                    </script> --}}
            </div>
            <div class="card-footer text-right">
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
        </div>
    </section>

@endsection
