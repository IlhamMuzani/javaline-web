@extends('layouts.app')

@section('title', 'Hak Akses')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
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
                                    class="form-check-label">MASTER</label>
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
                                    @else
                                        <h1 style="font-size:17px">
                                            {{ $loop->iteration <= 25 ? 'DATA ' : '' }}
                                            {{ strtoupper(ucfirst($menu)) }}
                                        </h1>
                                    @endif
                                </label>
                            </div>
                            @if ($loop->iteration === 1)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-karyawan" onchange="checkAllCategory('karyawan')">
                                    <label for="select-karyawan" style="margin-left:5px;">Select All KARYAWAN</label>
                                </div>
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
                            @endif
                            @if ($loop->iteration === 2)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-user" onchange="checkAllCategory('user')">
                                    <label for="select-user" style="margin-left:5px">Select All USER</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 5 && $loop->iteration <= 6)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="user" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if ($loop->iteration === 3)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-akses" onchange="checkAllCategory('akses')">
                                    <label for="select-akses" style="margin-left:5px">Select All AKSES</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 7 && $loop->iteration <= 7)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="akses" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            {{-- @if ($loop->iteration === 4)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-gaji" onchange="checkAllCategory('gaji')">
                                    <label for="select-gaji" style="margin-left:5px">Select All GAJI KARYAWAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 8 && $loop->iteration <= 8)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="gaji" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif --}}
                            @if ($loop->iteration === 5)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-departemen" onchange="checkAllCategory('departemen')">
                                    <label for="select-departemen" style="margin-left:5px">Select All DEPARTEMEN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 8 && $loop->iteration <= 9)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="departemen" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if ($loop->iteration === 6)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-supplier" onchange="checkAllCategory('supplier')">
                                    <label for="select-supplier" style="margin-left:5px">Select All SUPPLIER</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 10 && $loop->iteration <= 13)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="supplier" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 7)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-pelanggan"
                                        onchange="checkAllCategory('pelanggan')">
                                    <label for="select-pelanggan" style="margin-left:5px">Select All PELANGGAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 14 && $loop->iteration <= 17)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="pelanggan" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 8)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-divisi" onchange="checkAllCategory('divisi')">
                                    <label for="select-divisi" style="margin-left:5px">Select All DIVISI</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 18 && $loop->iteration <= 20)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="divisi" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 9)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-jenis kendaraan"
                                        onchange="checkAllCategory('jenis kendaraan')">
                                    <label for="select-jenis kendaraan" style="margin-left:5px">Select All JENIS
                                        KENDARAAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 21 && $loop->iteration <= 23)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="jenis kendaraan" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 10)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-golongan" onchange="checkAllCategory('golongan')">
                                    <label for="select-golongan" style="margin-left:5px">Select All GOLONGAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 24 && $loop->iteration <= 26)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="golongan" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 11)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-kendaraan"
                                        onchange="checkAllCategory('kendaraan')">
                                    <label for="select-kendaraan" style="margin-left:5px">Select All KENDARAAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 27 && $loop->iteration <= 30)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="kendaraan" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 12)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-ukuran ban"
                                        onchange="checkAllCategory('ukuran ban')">
                                    <label for="select-ukuran ban" style="margin-left:5px">Select All UKURAN BAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 31 && $loop->iteration <= 33)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="ukuran ban" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 13)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-merek ban"
                                        onchange="checkAllCategory('merek ban')">
                                    <label for="select-merek ban" style="margin-left:5px">Select All MEREK BAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 34 && $loop->iteration <= 36)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="merek ban" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 14)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-type ban" onchange="checkAllCategory('type ban')">
                                    <label for="select-type ban" style="margin-left:5px">Select All TYPE BAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 37 && $loop->iteration <= 39)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="type ban" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 15)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-ban" onchange="checkAllCategory('ban')">
                                    <label for="select-ban" style="margin-left:5px">Select All BAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 40 && $loop->iteration <= 43)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="ban" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 16)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-nokir" onchange="checkAllCategory('nokir')">
                                    <label for="select-nokir" style="margin-left:5px">Select All NOKIR</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 44 && $loop->iteration <= 48)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="nokir" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 17)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-stnk" onchange="checkAllCategory('stnk')">
                                    <label for="select-stnk" style="margin-left:5px">Select All STNK</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 49 && $loop->iteration <= 52)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="stnk" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 18)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-part" onchange="checkAllCategory('part')">
                                    <label for="select-part" style="margin-left:5px">Select All PART</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 53 && $loop->iteration <= 56)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="part" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 19)
                                {{-- <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-driver" onchange="checkAllCategory('driver')">
                                    <label for="select-driver" style="margin-left:5px">Select All STNK</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 49 && $loop->iteration <= 52)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="driver" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach --}}
                            @endif

                            @if ($loop->iteration === 20)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-rute" onchange="checkAllCategory('rute')">
                                    <label for="select-rute" style="margin-left:5px">Select All RUTE PERJALANAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 58 && $loop->iteration <= 60)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="rute" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 21)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-biaya tambahan"
                                        onchange="checkAllCategory('biaya tambahan')">
                                    <label for="select-biaya tambahan" style="margin-left:5px">Select All BIAYA
                                        TAMBAHAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 61 && $loop->iteration <= 63)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="biaya tambahan" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 22)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-potongan memo"
                                        onchange="checkAllCategory('potongan memo')">
                                    <label for="select-potongan memo" style="margin-left:5px">Select All POTONGAN
                                        MEMO</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 64 && $loop->iteration <= 66)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="potongan memo" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 23)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-biaya tarif"
                                        onchange="checkAllCategory('biaya tarif')">
                                    <label for="select-biaya tarif" style="margin-left:5px">Select All TARIF</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 67 && $loop->iteration <= 69)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="biaya tarif" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 24)
                                {{-- <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-satuan barang"
                                        onchange="checkAllCategory('satuan barang')">
                                    <label for="select-satuan barang" style="margin-left:5px">Select All SATUAN BARANG</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 67 && $loop->iteration <= 69)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="satuan barang" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach --}}
                            @endif

                            @if ($loop->iteration === 25)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-biaya barang return"
                                        onchange="checkAllCategory('biaya barang return')">
                                    <label for="select-biaya barang return" style="margin-left:5px">Select All BARANG
                                        RETURN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 73 && $loop->iteration <= 75)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="biaya barang return" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 26)
                                {{-- <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-biaya akun"
                                        onchange="checkAllCategory('biaya akun')">
                                    <label for="select-biaya akun" style="margin-left:5px">Select All AKUN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 73 && $loop->iteration <= 75)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="biaya akun" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach --}}
                            @endif

                            @if ($loop->iteration === 28)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-perpanjangan stnk"
                                        onchange="checkAllCategory('perpanjangan stnk')">
                                    <label for="select-perpanjangan stnk" style="margin-left:5px">Select All
                                        PERPANJANGAN STNK</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 76 && $loop->iteration <= 77)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="perpanjangan stnk" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 29)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-perpanjangan kir"
                                        onchange="checkAllCategory('perpanjangan kir')">
                                    <label for="select-perpanjangan kir" style="margin-left:5px">Select All
                                        PERPANJANGAN KIR</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 78 && $loop->iteration <= 79)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="perpanjangan kir" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 33)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-penggantian oli"
                                        onchange="checkAllCategory('penggantian oli')">
                                    <label for="select-penggantian oli" style="margin-left:5px">Select All
                                        PENGGANTIAN OLI</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 80 && $loop->iteration <= 80)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="penggantian oli" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if ($loop->iteration === 52)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery penerimaan kas kecil"
                                        onchange="checkAllCategory('inquery penerimaan kas kecil')">
                                    <label for="select-inquery penerimaan kas kecil" style="margin-left:5px">Select All
                                        INQUERY PENERIMAAN KAS KECIL</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 81 && $loop->iteration <= 85)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery penerimaan kas kecil" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 53)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery pengambilan kas kecil"
                                        onchange="checkAllCategory('inquery pengambilan kas kecil')">
                                    <label for="select-inquery pengambilan kas kecil" style="margin-left:5px">Select All
                                        INQUERY PENGAMBILAN KAS KECIL</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 86 && $loop->iteration <= 90)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery pengambilan kas kecil" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 54)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery deposit sopir"
                                        onchange="checkAllCategory('inquery deposit sopir')">
                                    <label for="select-inquery deposit sopir" style="margin-left:5px">Select All
                                        INQUERY DEPOSIT SOPIR</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 86 && $loop->iteration <= 90)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery deposit sopir" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 55)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery update km"
                                        onchange="checkAllCategory('inquery update km')">
                                    <label for="select-inquery update km" style="margin-left:5px">Select All
                                        INQUERY UPDATE KM</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 96 && $loop->iteration <= 100)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery update km" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 56)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery pembelian ban"
                                        onchange="checkAllCategory('inquery pembelian ban')">
                                    <label for="select-inquery pembelian ban" style="margin-left:5px">Select All
                                        INQUERY PEMBELIAN BAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 101 && $loop->iteration <= 105)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery pembelian ban" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 57)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery pembelian part"
                                        onchange="checkAllCategory('inquery pembelian part')">
                                    <label for="select-inquery pembelian part" style="margin-left:5px">Select All
                                        INQUERY PEMBELIAN PART</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 106 && $loop->iteration <= 110)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery pembelian part" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 58)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery pemasangan ban"
                                        onchange="checkAllCategory('inquery pemasangan ban')">
                                    <label for="select-inquery pemasangan ban" style="margin-left:5px">Select All
                                        INQUERY PEMASANGAN BAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 111 && $loop->iteration <= 115)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery pemasangan ban" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 59)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery pelepasan ban"
                                        onchange="checkAllCategory('inquery pelepasan ban')">
                                    <label for="select-inquery pelepasan ban" style="margin-left:5px">Select All
                                        INQUERY PELEPASAN BAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 116 && $loop->iteration <= 120)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery pelepasan ban" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 60)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery pemasangan part"
                                        onchange="checkAllCategory('inquery pemasangan part')">
                                    <label for="select-inquery pemasangan part" style="margin-left:5px">Select All
                                        INQUERY PEMASANGAN PART</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 121 && $loop->iteration <= 125)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery pemasangan part" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 61)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery penggantian oli"
                                        onchange="checkAllCategory('inquery penggantian oli')">
                                    <label for="select-inquery penggantian oli" style="margin-left:5px">Select All
                                        INQUERY PENGGANTIAN OLI</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 126 && $loop->iteration <= 130)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery penggantian oli" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 62)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery perpanjangan stnk"
                                        onchange="checkAllCategory('inquery perpanjangan stnk')">
                                    <label for="select-inquery perpanjangan stnk" style="margin-left:5px">Select All
                                        INQUERY PERPANJANGAN STNK</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 131 && $loop->iteration <= 135)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery perpanjangan stnk" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 63)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery perpanjangan kir"
                                        onchange="checkAllCategory('inquery perpanjangan kir')">
                                    <label for="select-inquery perpanjangan kir" style="margin-left:5px">Select All
                                        INQUERY PERPANJANGAN KIR</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 136 && $loop->iteration <= 140)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery perpanjangan kir" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 64)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery memo perjalanan"
                                        onchange="checkAllCategory('inquery memo perjalanan')">
                                    <label for="select-inquery memo perjalanan" style="margin-left:5px">Select All
                                        INQUERY MEMO PERJALANAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 141 && $loop->iteration <= 145)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery memo perjalanan" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 64)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery memo borong"
                                        onchange="checkAllCategory('inquery memo borong')">
                                    <label for="select-inquery memo borong" style="margin-left:5px">Select All
                                        INQUERY MEMO BORONG</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 220 && $loop->iteration <= 221)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery memo borong" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 64)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery memo tambahan"
                                        onchange="checkAllCategory('inquery memo tambahan')">
                                    <label for="select-inquery memo tambahan" style="margin-left:5px">Select All
                                        INQUERY MEMO TAMBAHAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 222 && $loop->iteration <= 223)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery memo tambahan" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 65)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery faktur ekspedisi"
                                        onchange="checkAllCategory('inquery faktur ekspedisi')">
                                    <label for="select-inquery faktur ekspedisi" style="margin-left:5px">Select All
                                        INQUERY FAKTUR EKSPEDISI</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 156 && $loop->iteration <= 160)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery faktur ekspedisi" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 66)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery invoice faktur ekspedisi"
                                        onchange="checkAllCategory('inquery invoice faktur ekspedisi')">
                                    <label for="select-inquery invoice faktur ekspedisi" style="margin-left:5px">Select
                                        All
                                        INQUERY INVOICE FAKTUR EKSPEDISI</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 161 && $loop->iteration <= 165)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery invoice faktur ekspedisi"
                                                value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 67)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery return penerimaan barang"
                                        onchange="checkAllCategory('inquery return penerimaan barang')">
                                    <label for="select-inquery return penerimaan barang" style="margin-left:5px">Select
                                        All
                                        INQUERY RETURN PENERIMAAN BARANG</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 166 && $loop->iteration <= 170)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery return penerimaan barang"
                                                value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 67)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery return nota barang"
                                        onchange="checkAllCategory('inquery return nota barang')">
                                    <label for="select-inquery return nota barang" style="margin-left:5px">Select
                                        All
                                        INQUERY RETURN NOTA BARANG</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 171 && $loop->iteration <= 175)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery return nota barang" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 67)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery return penjualan"
                                        onchange="checkAllCategory('inquery return penjualan')">
                                    <label for="select-inquery return penjualan" style="margin-left:5px">Select
                                        All
                                        INQUERY RETURN PENJUALAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 176 && $loop->iteration <= 180)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery return penjualan" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 68)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery pelunasan ekspedisi"
                                        onchange="checkAllCategory('inquery pelunasan ekspedisi')">
                                    <label for="select-inquery pelunasan ekspedisi" style="margin-left:5px">Select
                                        All
                                        INQUERY PELUNASAN EKSPEDISI</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 181 && $loop->iteration <= 185)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery pelunasan ekspedisi" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 69)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery pelunasan faktur pembelian ban"
                                        onchange="checkAllCategory('inquery faktur pelunasan pembelian ban')">
                                    <label for="select-inquery faktur pelunasan pembelian ban"
                                        style="margin-left:5px">Select
                                        All
                                        INQUERY PELUNASAN FAKTUR PEMBELIAN BAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 186 && $loop->iteration <= 190)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery faktur pelunasan pembelian ban"
                                                value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 70)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-inquery pelunasan faktur pembelian part"
                                        onchange="checkAllCategory('inquery faktur pelunasan pembelian part')">
                                    <label for="select-inquery faktur pelunasan pembelian part"
                                        style="margin-left:5px">Select
                                        All
                                        INQUERY PELUNASAN FAKTUR PEMBELIAN PART</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 191 && $loop->iteration <= 195)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="inquery faktur pelunasan pembelian part"
                                                value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 73)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan pembelian ban"
                                        onchange="checkAllCategory('laporan pembelian ban')">
                                    <label for="select-laporan pembelian ban" style="margin-left:5px">Select
                                        All
                                        LAPORAN PEMBELIAN BAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 196 && $loop->iteration <= 197)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan pembelian ban" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 74)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan pembelian part"
                                        onchange="checkAllCategory('laporan pembelian part')">
                                    <label for="select-laporan pembelian part" style="margin-left:5px">Select
                                        All
                                        LAPORAN PEMBELIAN PART</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 198 && $loop->iteration <= 199)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan pembelian part" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 75)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan pemasangan ban"
                                        onchange="checkAllCategory('laporan pemasangan ban')">
                                    <label for="select-laporan pemasangan ban" style="margin-left:5px">Select
                                        All
                                        LAPORAN PEMASANGAN BAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 200 && $loop->iteration <= 201)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan pemasangan ban" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 76)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan pelepasan ban"
                                        onchange="checkAllCategory('laporan pelepasan ban')">
                                    <label for="select-laporan pelepasan ban" style="margin-left:5px">Select
                                        All
                                        LAPORAN PELEPASAN BAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 202 && $loop->iteration <= 203)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan pelepasan ban" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 77)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan pemasangan part"
                                        onchange="checkAllCategory('laporan pemasangan part')">
                                    <label for="select-laporan pemasangan part" style="margin-left:5px">Select
                                        All
                                        LAPORAN PEMASANGAN PART</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 204 && $loop->iteration <= 205)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan pemasangan part" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 78)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan penggantian oli"
                                        onchange="checkAllCategory('laporan penggantian oli')">
                                    <label for="select-laporan penggantian oli" style="margin-left:5px">Select
                                        All
                                        LAPORAN PENGGANTIAN OLI</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 206 && $loop->iteration <= 207)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan penggantian oli" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 79)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan update km"
                                        onchange="checkAllCategory('laporan update km')">
                                    <label for="select-laporan update km" style="margin-left:5px">Select
                                        All
                                        LAPORAN UPDATE KM</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 208 && $loop->iteration <= 209)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan update km" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 82)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan status perjalanan"
                                        onchange="checkAllCategory('laporan status perjalanan')">
                                    <label for="select-laporan status perjalanan" style="margin-left:5px">Select
                                        All
                                        LAPORAN STATUS PERJALANAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 210 && $loop->iteration <= 211)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan status perjalanan" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 83)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan penerimaan kas kecil"
                                        onchange="checkAllCategory('laporan penerimaan kas kecil')">
                                    <label for="select-laporan penerimaan kas kecil" style="margin-left:5px">Select
                                        All
                                        LAPORAN PENERIMAAN KAS KECIL</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 212 && $loop->iteration <= 213)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan penerimaan kas kecil" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 84)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan pengambilan kas kecil"
                                        onchange="checkAllCategory('laporan pengambilan kas kecil')">
                                    <label for="select-laporan pengambilan kas kecil" style="margin-left:5px">Select
                                        All
                                        LAPORAN PENGAMBILAN KAS KECIL</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 214 && $loop->iteration <= 215)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan pengambilan kas kecil"
                                                value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 86)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan deposit driver"
                                        onchange="checkAllCategory('laporan deposit driver')">
                                    <label for="select-laporan deposit driver" style="margin-left:5px">Select
                                        All
                                        LAPORAN DEPOSIT DRIVER</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 216 && $loop->iteration <= 217)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan deposit driver" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 87)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan memo perjalanan"
                                        onchange="checkAllCategory('laporan memo perjalanan')">
                                    <label for="select-laporan memo perjalanan" style="margin-left:5px">Select
                                        All
                                        LAPORAN MEMO PERJALANAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 218 && $loop->iteration <= 219)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan memo perjalanan" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 87)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan memo borong"
                                        onchange="checkAllCategory('laporan memo borong')">
                                    <label for="select-laporan memo borong" style="margin-left:5px">Select
                                        All
                                        LAPORAN MEMO BORONG</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 220 && $loop->iteration <= 221)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan memo borong" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 87)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan memo borong"
                                        onchange="checkAllCategory('laporan memo borong')">
                                    <label for="select-laporan memo borong" style="margin-left:5px">Select
                                        All
                                        LAPORAN MEMO TAMBAHAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 220 && $loop->iteration <= 221)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan memo borong" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 88)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan faktur ekspedisi"
                                        onchange="checkAllCategory('laporan faktur ekspedisi')">
                                    <label for="select-laporan faktur ekspedisi" style="margin-left:5px">Select
                                        All
                                        LAPORAN FAKTUR EKSPEDISI</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 224 && $loop->iteration <= 225)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan faktur ekspedisi" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 89)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan faktur pph"
                                        onchange="checkAllCategory('laporan faktur pph')">
                                    <label for="select-laporan faktur pph" style="margin-left:5px">Select
                                        All
                                        LAPORAN PPH</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 226 && $loop->iteration <= 227)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan faktur pph" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 90)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan invoice ekspedisi"
                                        onchange="checkAllCategory('laporan invoice ekspedisi')">
                                    <label for="select-laporan invoice ekspedisi" style="margin-left:5px">Select
                                        All
                                        LAPORAN INVOICE EKSPEDISI</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 228 && $loop->iteration <= 229)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan invoice ekspedisi" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 91)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan return barang ekspedisi"
                                        onchange="checkAllCategory('laporan return barang ekspedisi')">
                                    <label for="select-laporan return barang ekspedisi" style="margin-left:5px">Select
                                        All
                                        LAPORAN RETURN BARANG EKSPEDISI</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 230 && $loop->iteration <= 231)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan return barang ekspedisi"
                                                value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 91)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan nota return barang ekspedisi"
                                        onchange="checkAllCategory('laporan nota return barang ekspedisi')">
                                    <label for="select-laporan nota return barang ekspedisi"
                                        style="margin-left:5px">Select
                                        All
                                        LAPORAN NOTA RETURN BARANG</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 232 && $loop->iteration <= 233)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan nota return barang ekspedisi"
                                                value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 91)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan penjualan return"
                                        onchange="checkAllCategory('laporan penjualan return')">
                                    <label for="select-laporan penjualan return" style="margin-left:5px">Select
                                        All
                                        LAPORAN PENJUALAN RETURN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 234 && $loop->iteration <= 235)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan penjualan return" value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            @if ($loop->iteration === 92)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan pelunasan ekspedisi"
                                        onchange="checkAllCategory('laporan pelunasan ekspedisi')">
                                    <label for="select-laporan pelunasan ekspedisi" style="margin-left:5px">Select
                                        All
                                        LAPORAN PELUNASAN EKSPEDISI</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 236 && $loop->iteration <= 237)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan pelunasan ekspedisi"
                                                value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if ($loop->iteration === 93)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan pelunasan pembelian ban"
                                        onchange="checkAllCategory('laporan pelunasan pembelian ban')">
                                    <label for="select-laporan pelunasan pembelian ban" style="margin-left:5px">Select
                                        All
                                        LAPORAN PELUNASAN PEMBELIAN BAN</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 238 && $loop->iteration <= 239)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan pelunasan pembelian ban"
                                                value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if ($loop->iteration === 94)
                                <div class="form-check" style="margin-left:28px">
                                    <input type="checkbox" id="select-laporan pelunasan pembelian part"
                                        onchange="checkAllCategory('laporan pelunasan pembelian part')">
                                    <label for="select-laporan pelunasan pembelian part" style="margin-left:5px">Select
                                        All
                                        LAPORAN PELUNASAN PEMBELIAN PART</label>
                                </div>
                                @foreach ($fiturs as $fitur)
                                    @if ($loop->iteration >= 240 && $loop->iteration <= 241)
                                        <div class="form-check ml-5 mb-3">
                                            <input class="form-check-input" type="checkbox" name="fitur[]"
                                                data-category="laporan pelunasan pembelian part"
                                                value="{{ $fitur }}"
                                                {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                        </div>
                                    @endif
                                @endforeach
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
