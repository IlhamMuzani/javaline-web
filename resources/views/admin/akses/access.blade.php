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
                        <input type="checkbox" id="option-all" onchange="checkAll(this)">
                        <label for="option-all">Select All</label>
                        <br>
                        @foreach ($menus as $menu)
                            @if ($loop->iteration === 1)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class=" form-check-label">MASTER</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 34)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class=" form-check-label">TRANSANKSI</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 49)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class=" form-check-label">FINANCE</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 70)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class=" form-check-label">LAPORAN</label>
                                <br>
                            @endif
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="menu[]" value="{{ $menu }}"
                                    {{ $akses->menu[$menu] ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    @if ($loop->iteration === 1)
                                        <h5 style="font-size: 17px">
                                            DATA KARYAWAN
                                        </h5>
                                    @elseif ($loop->iteration === 19)
                                        <h5 style="font-size: 17px;">
                                            DATA DRIVER
                                        </h5>
                                    @elseif ($loop->iteration === 3)
                                        <h5 style="font-size: 17px;">
                                            HAK AKSES
                                        </h5>
                                    @elseif ($loop->iteration === 42)
                                        <h5 style="font-size: 17px;">
                                            PELUNASAN FAKTUR EKSPEDISI
                                        </h5>
                                    @elseif ($loop->iteration === 48)
                                        <h5 style="font-size: 17px;">
                                            UJS (UANG JAMINAN SOPIR)
                                        </h5>
                                    @else
                                        <h1 style="font-size:17px">
                                            {{ $loop->iteration <= 25 ? 'DATA ' : '' }}
                                            {{ strtoupper(ucfirst($menu)) }}
                                        </h1>
                                    @endif
                                </label>
                            </div>
                            {{-- @if ($loop->iteration === 1)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-karyawan" onchange="checkAllCategory('karyawan')">
                                        <label for="select-karyawan" style="margin-left:5px;">Select All</label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration <= 4)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="karyawan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif --}}

                            @if ($loop->iteration === 1)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-karyawan" onchange="checkAllCategory('karyawan')">
                                        <label for="select-karyawan" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 1 && $loop->iteration <= 1)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="karyawan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 5 && $loop->iteration <= 5)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="karyawan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 3 && $loop->iteration <= 3)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="karyawan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 4 && $loop->iteration <= 4)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="karyawan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 2)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-user" onchange="checkAllCategory('user')">
                                        <label for="select-user" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 5 && $loop->iteration <= 5)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="user" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 6 && $loop->iteration <= 6)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="user" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 3)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-akses" onchange="checkAllCategory('akses')">
                                        <label for="select-akses" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 7 && $loop->iteration <= 7)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="akses" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif


                            @if ($loop->iteration === 4)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-gaji" onchange="checkAllCategory('gaji')">
                                        <label for="select-gaji" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 242 && $loop->iteration <= 242)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="gaji" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 5)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-departemen"
                                            onchange="checkAllCategory('departemen')">
                                        <label for="select-departemen" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 8 && $loop->iteration <= 8)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="departemen" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 9 && $loop->iteration <= 9)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="departemen" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 6)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-supplier"
                                            onchange="checkAllCategory('supplier')">
                                        <label for="select-supplier" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 10 && $loop->iteration <= 10)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="supplier" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 11 && $loop->iteration <= 11)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="supplier" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 12 && $loop->iteration <= 12)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="supplier" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 13 && $loop->iteration <= 13)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="supplier" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 7)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-pelanggan"
                                            onchange="checkAllCategory('pelanggan')">
                                        <label for="select-pelanggan" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 14 && $loop->iteration <= 14)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelanggan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 15 && $loop->iteration <= 15)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelanggan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 16 && $loop->iteration <= 16)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelanggan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 17 && $loop->iteration <= 17)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelanggan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 8)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-divisi" onchange="checkAllCategory('divisi')">
                                        <label for="select-divisi" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 18 && $loop->iteration <= 18)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="divisi" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 19 && $loop->iteration <= 19)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="divisi" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 20 && $loop->iteration <= 20)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="divisi" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 9)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-jenis kendaraan"
                                            onchange="checkAllCategory('jenis kendaraan')">
                                        <label for="select-jenis kendaraan" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 21 && $loop->iteration <= 21)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="jenis kendaraan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 22 && $loop->iteration <= 22)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="jenis kendaraan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 23 && $loop->iteration <= 23)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="jenis kendaraan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 10)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-golongan"
                                            onchange="checkAllCategory('golongan')">
                                        <label for="select-golongan" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 24 && $loop->iteration <= 24)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="golongan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 25 && $loop->iteration <= 25)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="golongan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 26 && $loop->iteration <= 26)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="golongan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 11)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-kendaraan"
                                            onchange="checkAllCategory('kendaraan')">
                                        <label for="select-kendaraan" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 27 && $loop->iteration <= 27)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="kendaraan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 28 && $loop->iteration <= 28)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="kendaraan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 29 && $loop->iteration <= 29)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="kendaraan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 30 && $loop->iteration <= 30)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="kendaraan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 12)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-ukuran ban"
                                            onchange="checkAllCategory('ukuran ban')">
                                        <label for="select-ukuran ban" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 31 && $loop->iteration <= 31)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="ukuran ban" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 32 && $loop->iteration <= 32)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="ukuran ban" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 33 && $loop->iteration <= 33)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="ukuran ban" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 13)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-merek ban"
                                            onchange="checkAllCategory('merek ban')">
                                        <label for="select-merek ban" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 34 && $loop->iteration <= 34)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="merek ban" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 35 && $loop->iteration <= 35)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="merek ban" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 36 && $loop->iteration <= 36)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="merek ban" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 14)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-type ban"
                                            onchange="checkAllCategory('type ban')">
                                        <label for="select-type ban" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 37 && $loop->iteration <= 37)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="type ban" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 38 && $loop->iteration <= 38)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="type ban" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 39 && $loop->iteration <= 39)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="type ban" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 15)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-ban" onchange="checkAllCategory('ban')">
                                        <label for="select-ban" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 40 && $loop->iteration <= 40)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="ban" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 41 && $loop->iteration <= 41)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="ban" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 42 && $loop->iteration <= 42)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="ban" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 43 && $loop->iteration <= 43)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="ban" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 16)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-nokir" onchange="checkAllCategory('nokir')">
                                        <label for="select-nokir" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 44 && $loop->iteration <= 44)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="nokir" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Print</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 45 && $loop->iteration <= 45)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="nokir" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 46 && $loop->iteration <= 46)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="nokir" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 47 && $loop->iteration <= 47)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="nokir" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 48 && $loop->iteration <= 48)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="nokir" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 17)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-stnk" onchange="checkAllCategory('stnk')">
                                        <label for="select-stnk" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 49 && $loop->iteration <= 49)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="stnk" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 52 && $loop->iteration <= 52)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="stnk" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 53 && $loop->iteration <= 53)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="stnk" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 54 && $loop->iteration <= 54)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="stnk" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 18)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-part" onchange="checkAllCategory('part')">
                                        <label for="select-part" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 53 && $loop->iteration <= 53)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="part" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 54 && $loop->iteration <= 54)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="part" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 55 && $loop->iteration <= 55)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="part" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 56 && $loop->iteration <= 56)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="part" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 19)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-driver" onchange="checkAllCategory('driver')">
                                        <label for="select-driver" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 58 && $loop->iteration <= 58)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="driver" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 20)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-rute" onchange="checkAllCategory('rute')">
                                        <label for="select-rute" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 59 && $loop->iteration <= 59)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="rute" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 60 && $loop->iteration <= 60)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="rute" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($loop->iteration === 21)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-biaya tambahan"
                                            onchange="checkAllCategory('biaya tambahan')">
                                        <label for="select-biaya tambahan" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 61 && $loop->iteration <= 61)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="biaya tambahan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 62 && $loop->iteration <= 62)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="biaya tambahan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 63 && $loop->iteration <= 63)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="biaya tambahan" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($loop->iteration === 22)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-potongan memo"
                                            onchange="checkAllCategory('potongan memo')">
                                        <label for="select-potongan memo" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 64 && $loop->iteration <= 64)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="potongan memo" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 65 && $loop->iteration <= 65)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="potongan memo" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 66 && $loop->iteration <= 66)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="potongan memo" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($loop->iteration === 23)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-biaya tarif"
                                            onchange="checkAllCategory('biaya tarif')">
                                        <label for="select-biaya tarif" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 67 && $loop->iteration <= 67)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="biaya tarif" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 68 && $loop->iteration <= 68)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="biaya tarif" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 69 && $loop->iteration <= 69)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="biaya tarif" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            {{-- @if ($loop->iteration === 24)
                                <div class="row">
                            @endif --}}

                            @if ($loop->iteration === 24)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-biaya barang return"
                                            onchange="checkAllCategory('biaya barang return')">
                                        <label for="select-biaya barang return" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 73 && $loop->iteration <= 73)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="biaya barang return" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 74 && $loop->iteration <= 74)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="biaya barang return" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 75 && $loop->iteration <= 75)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="biaya barang return" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 25)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-biaya akun"
                                            onchange="checkAllCategory('biaya akun')">
                                        <label for="select-biaya akun" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 243 && $loop->iteration <= 243)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="biaya akun" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 244 && $loop->iteration <= 244)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="biaya akun" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 245 && $loop->iteration <= 245)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="biaya akun" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 27)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-perpanjangan stnk"
                                            onchange="checkAllCategory('perpanjangan stnk')">
                                        <label for="select-perpanjangan stnk" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 76 && $loop->iteration <= 76)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="perpanjangan stnk" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 77 && $loop->iteration <= 77)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="perpanjangan stnk" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 28)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-perpanjangan nokir"
                                            onchange="checkAllCategory('perpanjangan nokir')">
                                        <label for="select-perpanjangan nokir" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 78 && $loop->iteration <= 78)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="perpanjangan nokir" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 79 && $loop->iteration <= 79)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="perpanjangan nokir" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 32)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-penggantian oli"
                                            onchange="checkAllCategory('penggantian oli')">
                                        <label for="select-penggantian oli" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 80 && $loop->iteration <= 80)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="penggantian oli" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($loop->iteration === 38)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-memos" onchange="checkAllCategory('memos')">
                                        <label for="select-memos" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 246 && $loop->iteration <= 246)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 247 && $loop->iteration <= 247)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 248 && $loop->iteration <= 248)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 249 && $loop->iteration <= 249)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 250 && $loop->iteration <= 250)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 251 && $loop->iteration <= 251)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($loop->iteration === 38)
                                <div class="row">
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 252 && $loop->iteration <= 252)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting Memo Perjalanan
                                                        Continue</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 253 && $loop->iteration <= 253)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting Memo Borong Continue</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 254 && $loop->iteration <= 254)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting Memo Tambahan Continue</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($loop->iteration === 39)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-memos" onchange="checkAllCategory('memos')">
                                        <label for="select-memos" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 255 && $loop->iteration <= 255)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 256 && $loop->iteration <= 256)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 257 && $loop->iteration <= 257)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 258 && $loop->iteration <= 258)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 259 && $loop->iteration <= 259)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 260 && $loop->iteration <= 260)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="memos" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 40)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-invoice faktur ekspedisi"
                                            onchange="checkAllCategory('invoice faktur ekspedisi')">
                                        <label for="select-invoice faktur ekspedisi" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 261 && $loop->iteration <= 261)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="invoice faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 262 && $loop->iteration <= 262)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="invoice faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 263 && $loop->iteration <= 263)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="invoice faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 264 && $loop->iteration <= 264)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="invoice faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 265 && $loop->iteration <= 265)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="invoice faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 266 && $loop->iteration <= 266)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="invoice faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 42)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-pelunasan faktur ekspedisi"
                                            onchange="checkAllCategory('pelunasan faktur ekspedisi')">
                                        <label for="select-pelunasan faktur ekspedisi" style="margin-left:5px">Select
                                            All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 267 && $loop->iteration <= 267)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 268 && $loop->iteration <= 268)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 269 && $loop->iteration <= 269)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 270 && $loop->iteration <= 270)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 271 && $loop->iteration <= 271)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 272 && $loop->iteration <= 272)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 43)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-pelunasan pembelian ban"
                                            onchange="checkAllCategory('pelunasan pembelian ban')">
                                        <label for="select-pelunasan pembelian ban" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 273 && $loop->iteration <= 273)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 274 && $loop->iteration <= 274)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 275 && $loop->iteration <= 275)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 276 && $loop->iteration <= 276)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 277 && $loop->iteration <= 277)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 278 && $loop->iteration <= 278)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 44)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-pelunasan pembelian part"
                                            onchange="checkAllCategory('pelunasan pembelian part')">
                                        <label for="select-pelunasan pembelian part" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 279 && $loop->iteration <= 279)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 280 && $loop->iteration <= 280)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 281 && $loop->iteration <= 281)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 282 && $loop->iteration <= 282)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 283 && $loop->iteration <= 283)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 284 && $loop->iteration <= 284)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pelunasan pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 46)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-pengambilan kas kecil"
                                            onchange="checkAllCategory('pengambilan kas kecil')">
                                        <label for="select-pengambilan kas kecil" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 285 && $loop->iteration <= 285)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pengambilan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 286 && $loop->iteration <= 286)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pengambilan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 287 && $loop->iteration <= 287)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pengambilan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 288 && $loop->iteration <= 288)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pengambilan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 289 && $loop->iteration <= 289)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pengambilan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 290 && $loop->iteration <= 290)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="pengambilan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 49)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-perhitungan gaji karyawan"
                                            onchange="checkAllCategory('perhitungan gaji karyawan')">
                                        <label for="select-perhitungan gaji karyawan" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 291 && $loop->iteration <= 291)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="perhitungan gaji karyawan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting Mingguan</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 292 && $loop->iteration <= 292)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="perhitungan gaji karyawan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost Mingguan</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 293 && $loop->iteration <= 293)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="perhitungan gaji karyawan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 294 && $loop->iteration <= 294)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="perhitungan gaji karyawan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 295 && $loop->iteration <= 295)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="perhitungan gaji karyawan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 49)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-perhitungan gaji bulanan"
                                            onchange="checkAllCategory('perhitungan gaji bulanan')">
                                        <label for="select-perhitungan gaji bulanan" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 296 && $loop->iteration <= 296)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="perhitungan gaji bulanan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting Bulanan</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 297 && $loop->iteration <= 297)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="perhitungan gaji bulanan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost Bulanan</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 298 && $loop->iteration <= 298)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="perhitungan gaji bulanan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 299 && $loop->iteration <= 299)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="perhitungan gaji bulanan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 300 && $loop->iteration <= 300)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="perhitungan gaji bulanan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif


                            @if ($loop->iteration === 50)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery kasbon karyawan"
                                            onchange="checkAllCategory('inquery kasbon karyawan')">
                                        <label for="select-inquery kasbon karyawan" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 301 && $loop->iteration <= 301)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery kasbon karyawan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 302 && $loop->iteration <= 302)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery kasbon karyawan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 303 && $loop->iteration <= 303)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery kasbon karyawan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 304 && $loop->iteration <= 304)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery kasbon karyawan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 305 && $loop->iteration <= 305)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery kasbon karyawan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 51)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery penerimaan kaskecil"
                                            onchange="checkAllCategory('inquery penerimaan kaskecil')">
                                        <label for="select-inquery penerimaan kaskecil" style="margin-left:5px">Select
                                            All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 81 && $loop->iteration <= 81)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery penerimaan kaskecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 82 && $loop->iteration <= 82)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery penerimaan kaskecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 83 && $loop->iteration <= 83)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery penerimaan kaskecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 84 && $loop->iteration <= 84)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery penerimaan kaskecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 85 && $loop->iteration <= 85)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery penerimaan kaskecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 52)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery pengambilan kas kecil"
                                            onchange="checkAllCategory('inquery pengambilan kas kecil')">
                                        <label for="select-inquery pengambilan kas kecil" style="margin-left:5px">Select
                                            All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 86 && $loop->iteration <= 86)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pengambilan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 87 && $loop->iteration <= 87)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pengambilan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 88 && $loop->iteration <= 88)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pengambilan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 89 && $loop->iteration <= 89)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pengambilan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 90 && $loop->iteration <= 90)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pengambilan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 53)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery deposit sopir"
                                            onchange="checkAllCategory('inquery deposit sopir')">
                                        <label for="select-inquery deposit sopir" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 91 && $loop->iteration <= 91)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery deposit sopir"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 92 && $loop->iteration <= 92)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery deposit sopir"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 93 && $loop->iteration <= 93)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery deposit sopir"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 94 && $loop->iteration <= 94)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery deposit sopir"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 95 && $loop->iteration <= 95)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery deposit sopir"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 54)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery update km"
                                            onchange="checkAllCategory('inquery update km')">
                                        <label for="select-inquery update km" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 96 && $loop->iteration <= 96)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery update km" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 97 && $loop->iteration <= 97)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery update km" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 98 && $loop->iteration <= 98)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery update km" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 99 && $loop->iteration <= 99)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery update km" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 100 && $loop->iteration <= 100)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery update km" value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 55)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery pemebelian ban"
                                            onchange="checkAllCategory('inquery pemebelian ban')">
                                        <label for="select-inquery pemebelian ban" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 101 && $loop->iteration <= 101)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemebelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 102 && $loop->iteration <= 102)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemebelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 103 && $loop->iteration <= 103)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemebelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 104 && $loop->iteration <= 104)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemebelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 105 && $loop->iteration <= 105)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemebelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 56)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery pemebelian part"
                                            onchange="checkAllCategory('inquery pemebelian part')">
                                        <label for="select-inquery pemebelian part" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 106 && $loop->iteration <= 106)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemebelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 107 && $loop->iteration <= 107)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemebelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 108 && $loop->iteration <= 108)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemebelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 109 && $loop->iteration <= 109)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemebelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 110 && $loop->iteration <= 110)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemebelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 57)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery pemasangan ban"
                                            onchange="checkAllCategory('inquery pemasangan ban')">
                                        <label for="select-inquery pemasangan ban" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 111 && $loop->iteration <= 111)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemasangan ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 112 && $loop->iteration <= 112)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemasangan ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 113 && $loop->iteration <= 113)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemasangan ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 114 && $loop->iteration <= 114)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemasangan ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 115 && $loop->iteration <= 115)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemasangan ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 58)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery pelepasan ban"
                                            onchange="checkAllCategory('inquery pelepasan ban')">
                                        <label for="select-inquery pelepasan ban" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 116 && $loop->iteration <= 116)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelepasan ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 117 && $loop->iteration <= 117)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelepasan ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 118 && $loop->iteration <= 118)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelepasan ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 119 && $loop->iteration <= 119)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelepasan ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 120 && $loop->iteration <= 120)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelepasan ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 59)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery pemasangan part"
                                            onchange="checkAllCategory('inquery pemasangan part')">
                                        <label for="select-inquery pemasangan part" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 121 && $loop->iteration <= 121)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemasangan part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 122 && $loop->iteration <= 122)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemasangan part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 123 && $loop->iteration <= 123)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemasangan part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 124 && $loop->iteration <= 124)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemasangan part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 125 && $loop->iteration <= 125)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pemasangan part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 60)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery penggantian oli"
                                            onchange="checkAllCategory('inquery penggantian oli')">
                                        <label for="select-inquery penggantian oli" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 126 && $loop->iteration <= 126)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery penggantian oli"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 127 && $loop->iteration <= 127)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery penggantian oli"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 128 && $loop->iteration <= 128)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery penggantian oli"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 129 && $loop->iteration <= 129)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery penggantian oli"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 130 && $loop->iteration <= 130)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery penggantian oli"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 61)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery perpanjangan stnk"
                                            onchange="checkAllCategory('inquery perpanjangan stnk')">
                                        <label for="select-inquery perpanjangan stnk" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 131 && $loop->iteration <= 131)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery perpanjangan stnk"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 132 && $loop->iteration <= 132)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery perpanjangan stnk"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 133 && $loop->iteration <= 133)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery perpanjangan stnk"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 134 && $loop->iteration <= 134)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery perpanjangan stnk"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 135 && $loop->iteration <= 135)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery perpanjangan stnk"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 62)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery perpanjangan kir"
                                            onchange="checkAllCategory('inquery perpanjangan kir')">
                                        <label for="select-inquery perpanjangan kir" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 136 && $loop->iteration <= 136)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery perpanjangan kir"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 137 && $loop->iteration <= 137)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery perpanjangan kir"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 138 && $loop->iteration <= 138)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery perpanjangan kir"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 139 && $loop->iteration <= 139)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery perpanjangan kir"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 140 && $loop->iteration <= 140)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery perpanjangan kir"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 63)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery memo perjalanan"
                                            onchange="checkAllCategory('inquery memo perjalanan')">
                                        <label for="select-inquery memo perjalanan" style="margin-left:5px">Select All
                                            Memo Perjalanan
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 141 && $loop->iteration <= 141)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo perjalanan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 142 && $loop->iteration <= 142)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo perjalanan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 143 && $loop->iteration <= 143)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo perjalanan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 144 && $loop->iteration <= 144)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo perjalanan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 145 && $loop->iteration <= 145)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo perjalanan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 63)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery memo borong"
                                            onchange="checkAllCategory('inquery memo borong')">
                                        <label for="select-inquery memo borong" style="margin-left:5px">Select All Memo
                                            Borong
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 146 && $loop->iteration <= 146)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo borong"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 147 && $loop->iteration <= 147)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo borong"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 148 && $loop->iteration <= 148)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo borong"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 149 && $loop->iteration <= 149)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo borong"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 150 && $loop->iteration <= 150)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo borong"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 63)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery memo tambahan"
                                            onchange="checkAllCategory('inquery memo tambahan')">
                                        <label for="select-inquery memo tambahan" style="margin-left:5px">Select All
                                            Memo Tambahan
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 151 && $loop->iteration <= 151)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo tambahan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 152 && $loop->iteration <= 152)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo tambahan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 153 && $loop->iteration <= 153)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo tambahan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 154 && $loop->iteration <= 154)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo tambahan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 155 && $loop->iteration <= 155)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery memo tambahan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 64)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery faktur ekspedisi"
                                            onchange="checkAllCategory('inquery faktur ekspedisi')">
                                        <label for="select-inquery faktur ekspedisi" style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 156 && $loop->iteration <= 156)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 157 && $loop->iteration <= 157)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 158 && $loop->iteration <= 158)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 159 && $loop->iteration <= 159)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 160 && $loop->iteration <= 160)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 65)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery invoice faktur ekspedisi"
                                            onchange="checkAllCategory('inquery invoice faktur ekspedisi')">
                                        <label for="select-inquery invoice faktur ekspedisi"
                                            style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 161 && $loop->iteration <= 161)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery invoice faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 162 && $loop->iteration <= 162)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery invoice faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 163 && $loop->iteration <= 163)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery invoice faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 164 && $loop->iteration <= 164)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery invoice faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 165 && $loop->iteration <= 165)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery invoice faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 66)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery return penerimaan barang"
                                            onchange="checkAllCategory('inquery return penerimaan barang')">
                                        <label for="select-inquery return penerimaan barang"
                                            style="margin-left:5px">Select All Return Penerimaan Barang
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 166 && $loop->iteration <= 166)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery return penerimaan barang"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 167 && $loop->iteration <= 167)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery return penerimaan barang"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 168 && $loop->iteration <= 168)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery return penerimaan barang"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 169 && $loop->iteration <= 169)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery return penerimaan barang"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 170 && $loop->iteration <= 170)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery return penerimaan barang"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 66)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery nota return"
                                            onchange="checkAllCategory('inquery nota return')">
                                        <label for="select-inquery nota return" style="margin-left:5px">Select All Nota
                                            Return
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 171 && $loop->iteration <= 171)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery nota return"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 172 && $loop->iteration <= 172)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery nota return"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 173 && $loop->iteration <= 173)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery nota return"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 174 && $loop->iteration <= 174)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery nota return"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 175 && $loop->iteration <= 175)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery nota return"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 66)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery return penpenjuan"
                                            onchange="checkAllCategory('inquery return penpenjuan')">
                                        <label for="select-inquery return penpenjuan" style="margin-left:5px">Select All
                                        Penjualan Return
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 176 && $loop->iteration <= 176)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery return penpenjuan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 177 && $loop->iteration <= 177)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery return penpenjuan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 178 && $loop->iteration <= 178)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery return penpenjuan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 179 && $loop->iteration <= 179)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery return penpenjuan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 180 && $loop->iteration <= 180)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery return penpenjuan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                             @if ($loop->iteration === 67)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery pelunasan ekspedisi"
                                            onchange="checkAllCategory('inquery pelunasan ekspedisi')">
                                        <label for="select-inquery pelunasan ekspedisi" style="margin-left:5px">Select All

                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 181 && $loop->iteration <= 181)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 182 && $loop->iteration <= 182)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 183 && $loop->iteration <= 183)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 184 && $loop->iteration <= 184)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 185 && $loop->iteration <= 185)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 68)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery pelunasan faktur pembelian ban"
                                            onchange="checkAllCategory('inquery pelunasan faktur pembelian ban')">
                                        <label for="select-inquery pelunasan faktur pembelian ban"
                                            style="margin-left:5px">Select All
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 186 && $loop->iteration <= 186)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan faktur pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 187 && $loop->iteration <= 187)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan faktur pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 188 && $loop->iteration <= 188)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan faktur pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 189 && $loop->iteration <= 189)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan faktur pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 190 && $loop->iteration <= 190)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan faktur pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 69)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-inquery pelunasan faktur pembelian part"
                                            onchange="checkAllCategory('inquery pelunasan faktur pembelian part')">
                                        <label for="select-inquery pelunasan faktur pembelian part" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 191 && $loop->iteration <= 191)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan faktur pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Posting</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 192 && $loop->iteration <= 192)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan faktur pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Unpost</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 193 && $loop->iteration <= 193)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan faktur pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Update</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 194 && $loop->iteration <= 194)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan faktur pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 195 && $loop->iteration <= 195)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="inquery pelunasan faktur pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Show</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 70)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan perhitungan gaji"
                                            onchange="checkAllCategory('laporan perhitungan gaji')">
                                        <label for="select-laporan perhitungan gaji" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 306 && $loop->iteration <= 306)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan perhitungan gaji"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 307 && $loop->iteration <= 307)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan perhitungan gaji"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 71)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan kasbon karyawan"
                                            onchange="checkAllCategory('laporan kasbon karyawan')">
                                        <label for="select-laporan kasbon karyawan" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 308 && $loop->iteration <= 308)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan kasbon karyawan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 309 && $loop->iteration <= 309)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan kasbon karyawan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 72)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan pembelian ban"
                                            onchange="checkAllCategory('laporan pembelian ban')">
                                        <label for="select-laporan pembelian ban" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 196 && $loop->iteration <= 196)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 197 && $loop->iteration <= 197)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 73)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan pembelian part"
                                            onchange="checkAllCategory('laporan pembelian part')">
                                        <label for="select-laporan pembelian part" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 198 && $loop->iteration <= 198)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 199 && $loop->iteration <= 199)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 74)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan pemasangan ban"
                                            onchange="checkAllCategory('laporan pemasangan ban')">
                                        <label for="select-laporan pemasangan ban" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 200 && $loop->iteration <= 200)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pemasangan ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 201 && $loop->iteration <= 201)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pemasangan ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 75)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan pelepasan ban"
                                            onchange="checkAllCategory('laporan pelepasan ban')">
                                        <label for="select-laporan pelepasan ban" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 202 && $loop->iteration <= 202)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pelepasan ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 203 && $loop->iteration <= 203)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pelepasan ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 76)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan pemasangan part"
                                            onchange="checkAllCategory('laporan pemasangan part')">
                                        <label for="select-laporan pemasangan part" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 204 && $loop->iteration <= 204)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pemasangan part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 205 && $loop->iteration <= 205)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pemasangan part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 77)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan penggantian oli"
                                            onchange="checkAllCategory('laporan penggantian oli')">
                                        <label for="select-laporan penggantian oli" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 206 && $loop->iteration <= 206)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan penggantian oli"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 207 && $loop->iteration <= 207)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan penggantian oli"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 78)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan update km"
                                            onchange="checkAllCategory('laporan update km')">
                                        <label for="select-laporan update km" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 208 && $loop->iteration <= 208)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan update km"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 209 && $loop->iteration <= 209)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan update km"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 81)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan status perjalanan"
                                            onchange="checkAllCategory('laporan status perjalanan')">
                                        <label for="select-laporan status perjalanan" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 210 && $loop->iteration <= 210)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan status perjalanan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 211 && $loop->iteration <= 211)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan status perjalanan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 82)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan penerimaan kas kecil"
                                            onchange="checkAllCategory('laporan penerimaan kas kecil')">
                                        <label for="select-laporan penerimaan kas kecil" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 212 && $loop->iteration <= 212)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan penerimaan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 213 && $loop->iteration <= 213)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan penerimaan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 83)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan pengambilan kas kecil"
                                            onchange="checkAllCategory('laporan pengambilan kas kecil')">
                                        <label for="select-laporan pengambilan kas kecil" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 214 && $loop->iteration <= 214)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pengambilan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 215 && $loop->iteration <= 215)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pengambilan kas kecil"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 84)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan deposit driver"
                                            onchange="checkAllCategory('laporan deposit driver')">
                                        <label for="select-laporan deposit driver" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 217 && $loop->iteration <= 217)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan deposit driver"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 218 && $loop->iteration <= 218)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan deposit driver"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 85)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan memo perjalanan"
                                            onchange="checkAllCategory('laporan memo perjalanan')">
                                        <label for="select-laporan memo perjalanan" style="margin-left:5px">Select All Memo Perjalan
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 218 && $loop->iteration <= 218)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan memo perjalanan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 219 && $loop->iteration <= 219)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan memo perjalanan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 85)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan memo borong"
                                            onchange="checkAllCategory('laporan memo borong')">
                                        <label for="select-laporan memo borong" style="margin-left:5px">Select All Memo Borong
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 220 && $loop->iteration <= 220)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan memo borong"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 221 && $loop->iteration <= 221)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan memo borong"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 85)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan memo tambahan"
                                            onchange="checkAllCategory('laporan memo tambahan')">
                                        <label for="select-laporan memo tambahan" style="margin-left:5px">Select All Memo Tambahan
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 222 && $loop->iteration <= 222)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan memo tambahan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 223 && $loop->iteration <= 223)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan memo tambahan"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 86)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan faktur ekspedisi"
                                            onchange="checkAllCategory('laporan faktur ekspedisi')">
                                        <label for="select-laporan faktur ekspedisi" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 224 && $loop->iteration <= 224)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 225 && $loop->iteration <= 225)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan faktur ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 87)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan faktur pph"
                                            onchange="checkAllCategory('laporan faktur pph')">
                                        <label for="select-laporan faktur pph" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 226 && $loop->iteration <= 226)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan faktur pph"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 227 && $loop->iteration <= 227)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan faktur pph"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 88)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan invoicr ekspedisi"
                                            onchange="checkAllCategory('laporan invoicr ekspedisi')">
                                        <label for="select-laporan invoicr ekspedisi" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 228 && $loop->iteration <= 228)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan invoicr ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 229 && $loop->iteration <= 229)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan invoicr ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 89)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan return barang"
                                            onchange="checkAllCategory('laporan return barang')">
                                        <label for="select-laporan return barang" style="margin-left:5px">Select All Penerimaan Return
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 230 && $loop->iteration <= 230)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan return barang"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 231 && $loop->iteration <= 231)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan return barang"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 89)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan nota return barang"
                                            onchange="checkAllCategory('laporan nota return barang')">
                                        <label for="select-laporan nota return barang" style="margin-left:5px">Select All Nota Return
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 232 && $loop->iteration <= 232)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan nota return barang"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 233 && $loop->iteration <= 233)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan nota return barang"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 89)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan penjualan return"
                                            onchange="checkAllCategory('laporan penjualan return')">
                                        <label for="select-laporan penjualan return" style="margin-left:5px">Select All Penjualan Return
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 234 && $loop->iteration <= 234)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan penjualan return"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 235 && $loop->iteration <= 235)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan penjualan return"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 90)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan pelunasan ekspedisi"
                                            onchange="checkAllCategory('laporan pelunasan ekspedisi')">
                                        <label for="select-laporan pelunasan ekspedisi" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 237 && $loop->iteration <= 237)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pelunasan ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 238 && $loop->iteration <= 238)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pelunasan ekspedisi"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 91)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan pelunasan pembelian ban"
                                            onchange="checkAllCategory('laporan pelunasan pembelian ban')">
                                        <label for="select-laporan pelunasan pembelian ban" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 238 && $loop->iteration <= 238)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pelunasan pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 239 && $loop->iteration <= 239)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pelunasan pembelian ban"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($loop->iteration === 92)
                                <div class="row">
                                    <div class="form-check" style="margin-left:28px">
                                        <input type="checkbox" id="select-laporan pelunasan pembelian part"
                                            onchange="checkAllCategory('laporan pelunasan pembelian part')">
                                        <label for="select-laporan pelunasan pembelian part" style="margin-left:5px">Select All
                                        
                                        </label>
                                    </div>
                                    <div class="mb-3" style="display: flex; flex-wrap: wrap;">
                                        @foreach ($fiturs as $fitur)
                                            @if ($loop->iteration >= 240 && $loop->iteration <= 240)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pelunasan pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cari</label>
                                                </div>
                                            @endif
                                            @if ($loop->iteration >= 241 && $loop->iteration <= 241)
                                                <div class="form-check ml-5 mb-3">
                                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                                        data-category="laporan pelunasan pembelian part"
                                                        value="{{ $fitur }}"
                                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                                    <label class="form-check-label">Cetak</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        var checkboxes = document.querySelectorAll("input[type = 'checkbox']");

        function checkAll(myCheckbox) {
            if (myCheckbox.checked == true) {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = true;
                });
            } else {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
            }
        }

        function checkAllCategory(category) {
            var categoryCheckboxes = document.querySelectorAll("input[name='fitur[]'][data-category='" + category + "']");

            if (categoryCheckboxes.length > 0) {
                var selectAllCheckbox = document.getElementById('select-' + category);

                categoryCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            }
        }
    </script>
@endsection
