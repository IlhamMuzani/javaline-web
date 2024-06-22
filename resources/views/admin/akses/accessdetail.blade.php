@extends('layouts.app')

@section('title', 'Hak Akses Menu')

@section('content')
    <div id="loadingSpinner" style="display: flex; align-items: center; justify-content: center; height: 100vh;">
        <i class="fas fa-spinner fa-spin" style="font-size: 3rem;"></i>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                document.getElementById("loadingSpinner").style.display = "none";
                document.getElementById("mainContent").style.display = "block";
                document.getElementById("mainContentSection").style.display = "block";
            }, 100); // Adjust the delay time as needed
        });
    </script>

    <!-- Content Header (Page header) -->
    <div class="content-header" style="display: none;" id="mainContent">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Hak Akses Menu</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/akses') }}">Hak akses menu</a>
                        </li>
                        <li class="breadcrumb-item active">Lihat</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content" style="display: none;" id="mainContentSection">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambahkan</h3>
                    <div class="float-right">
                    </div>
                </div>
                <!-- /.card-header -->
                <form action="{{ url('admin/akses-accessdetail/' . $akses->id) }}" method="post"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <label style="margin-left: 22px; margin-top: 15px"
                        for="option-all">{{ $akses->karyawan->nama_lengkap }}</label>
                    <div class="card-body">
                        <input type="checkbox" id="option-all" onchange="checkAll(this)">
                        <label for="option-all">Select All</label>
                        <br>


                        <label style="font-weight: bold; margin-bottom:10px; margin-top:20px"
                            class="form-check-label">KARYAWAN</label>
                        <br>
                        <input type="checkbox" id="select-karyawan" onchange="checkAllCategory('karyawan')">
                        <label for="select-karyawan">Select All KARYAWAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration <= 4)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]" data-category="karyawan"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach
                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px"
                            class="form-check-label">USER</label>
                        <br>
                        <input type="checkbox" id="select-user" onchange="checkAllCategory('user')">
                        <label for="select-user">Select All USER</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 5 && $loop->iteration <= 6)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]" data-category="user"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">HAK
                            AKSES</label>
                        <br>
                        <input type="checkbox" id="select-akses" onchange="checkAllCategory('akses')">
                        <label for="select-akses">Select All HAK AKSES</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 7 && $loop->iteration <= 7)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]" data-category="akses"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px"
                            class="form-check-label">DEPARTEMEN</label>
                        <br>
                        <input type="checkbox" id="select-departemen" onchange="checkAllCategory('departemen')">
                        <label for="select-departemen">Select All DEPARTEMEN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 8 && $loop->iteration <= 9)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="departemen" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px"
                            class="form-check-label">SUPPLIER</label>
                        <br>
                        <input type="checkbox" id="select-supplier" onchange="checkAllCategory('supplier')">
                        <label for="select-supplier">Select All SUPPLIER</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 10 && $loop->iteration <= 13)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]" data-category="supplier"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px"
                            class="form-check-label">PELANGGAN</label>
                        <br>
                        <input type="checkbox" id="select-pelanggan" onchange="checkAllCategory('pelanggan')">
                        <label for="select-pelanggan">Select All PELANGGAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 14 && $loop->iteration <= 17)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="pelanggan" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px"
                            class="form-check-label">DIVISI</label>
                        <br>
                        <input type="checkbox" id="select-divisi" onchange="checkAllCategory('divisi')">
                        <label for="select-divisi">Select All DIVISI</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 18 && $loop->iteration <= 20)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="divisi" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px"
                            class="form-check-label">JENIS KENDARAAN</label>
                        <br>
                        <input type="checkbox" id="select-jenis kendaraan"
                            onchange="checkAllCategory('jenis kendaraan')">
                        <label for="select-jenis kendaraan">Select All JENIS KENDARAAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 21 && $loop->iteration <= 23)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="jenis kendaraan" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px"
                            class="form-check-label">GOLONGAN</label>
                        <br>
                        <input type="checkbox" id="select-golongan" onchange="checkAllCategory('golongan')">
                        <label for="select-golongan">Select All GOLONGAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 24 && $loop->iteration <= 26)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="golongan" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px"
                            class="form-check-label">KENDARAAN</label>
                        <br>
                        <input type="checkbox" id="select-kendaraan" onchange="checkAllCategory('kendaraan')">
                        <label for="select-kendaraan">Select All KENDARAAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 27 && $loop->iteration <= 30)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="kendaraan" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px"
                            class="form-check-label">UKURAN BAN</label>
                        <br>
                        <input type="checkbox" id="select-ukuran ban" onchange="checkAllCategory('ukuran ban')">
                        <label for="select-ukuran ban">Select All UKURAN BAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 31 && $loop->iteration <= 33)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="ukuran ban" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px"
                            class="form-check-label">MEREK BAN</label>
                        <br>
                        <input type="checkbox" id="select-merek ban" onchange="checkAllCategory('merek ban')">
                        <label for="select-merek ban">Select All MEREK BAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 34 && $loop->iteration <= 36)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="merek ban" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px"
                            class="form-check-label">TYPE BAN</label>
                        <br>
                        <input type="checkbox" id="select-type ban" onchange="checkAllCategory('type ban')">
                        <label for="select-type ban">Select All TYPE BAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 37 && $loop->iteration <= 39)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="type ban" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px"
                            class="form-check-label">BAN</label>
                        <br>
                        <input type="checkbox" id="select-ban" onchange="checkAllCategory('ban')">
                        <label for="select-ban">Select All BAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 40 && $loop->iteration <= 43)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]" data-category="ban"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">NO
                            KIR</label>
                        <br>
                        <input type="checkbox" id="select-nokir" onchange="checkAllCategory('nokir')">
                        <label for="select-nokir">Select All NO KIR</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 44 && $loop->iteration <= 48)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]" data-category="nokir"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            STNK</label>
                        <br>
                        <input type="checkbox" id="select-stnk" onchange="checkAllCategory('stnk')">
                        <label for="select-stnk">Select All STNK</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 49 && $loop->iteration <= 52)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]" data-category="stnk"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            PART</label>
                        <br>
                        <input type="checkbox" id="select-part" onchange="checkAllCategory('part')">
                        <label for="select-part">Select All PART</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 53 && $loop->iteration <= 56)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]" data-category="part"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        {{-- <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            SOPIR</label>
                        <br>
                        <input type="checkbox" id="select-sopir" onchange="checkAllCategory('sopir')">
                        <label for="select-sopir">Select All SOPIR</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 57 && $loop->iteration <= 57)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]" data-category="sopir"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach --}}

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            RUTE</label>
                        <br>
                        <input type="checkbox" id="select-rute" onchange="checkAllCategory('rute')">
                        <label for="select-rute">Select All RUTE</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 58 && $loop->iteration <= 60)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]" data-category="rute"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            BIAYA TAMBAHAN</label>
                        <br>
                        <input type="checkbox" id="select-biaya tambahan" onchange="checkAllCategory('biaya tambahan')">
                        <label for="select-biaya tambahan">Select All BIAYA TAMBAHAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 61 && $loop->iteration <= 63)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="biaya tambahan" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            POTONGAN MEMO</label>
                        <br>
                        <input type="checkbox" id="select-potongan memo" onchange="checkAllCategory('potongan memo')">
                        <label for="select-potongan memo">Select All POTONGAN MEMO</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 64 && $loop->iteration <= 66)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="potongan memo" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            POTONGAN MEMO</label>
                        <br>
                        <input type="checkbox" id="select-potongan memo" onchange="checkAllCategory('potongan memo')">
                        <label for="select-potongan memo">Select All POTONGAN MEMO</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 64 && $loop->iteration <= 66)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="potongan memo" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            TARIF</label>
                        <br>
                        <input type="checkbox" id="select-tarif" onchange="checkAllCategory('tarif')">
                        <label for="select-tarif">Select All TARIF</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 67 && $loop->iteration <= 69)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]" data-category="tarif"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        {{-- <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            SATUAN</label>
                        <br>
                        <input type="checkbox" id="select-satuan" onchange="checkAllCategory('satuan')">
                        <label for="select-satuan">Select All SATUAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 71 && $loop->iteration <= 73)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]" data-category="satuan"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach --}}

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            BARANG RETURN</label>
                        <br>
                        <input type="checkbox" id="select-barang return" onchange="checkAllCategory('barang return')">
                        <label for="select-barang return">Select All BARANG RETURN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 73 && $loop->iteration <= 75)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="barang return" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            PERPANJANGAN STNK</label>
                        <br>
                        <input type="checkbox" id="select-perpanjangan stnk"
                            onchange="checkAllCategory('perpanjangan stnk')">
                        <label for="select-perpanjangan stnk">Select All PERPANJANGAN STNK</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 76 && $loop->iteration <= 77)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="perpanjangan stnk" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            PERPANJANGAN KIR</label>
                        <br>
                        <input type="checkbox" id="select-perpanjangan kir"
                            onchange="checkAllCategory('perpanjangan kir')">
                        <label for="select-perpanjangan kir">Select All PERPANJANGAN KIR</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 78 && $loop->iteration <= 79)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="perpanjangan kir" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            PENGGANTIAN OLI</label>
                        <br>
                        <input type="checkbox" id="select-penggantian oli"
                            onchange="checkAllCategory('penggantian oli')">
                        <label for="select-penggantian oli">Select All PENGGANTIAN OLI</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 80 && $loop->iteration <= 80)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="penggantian oli" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY PENERIMAAN KAS KECIL</label>
                        <br>
                        <input type="checkbox" id="select-inquery penerimaan kas kecil"
                            onchange="checkAllCategory('inquery penerimaan kas kecil')">
                        <label for="select-inquery penerimaan kas kecil">Select All INQUERY PENERIMAAN KAS KECIL</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 81 && $loop->iteration <= 85)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery penerimaan kas kecil" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY PENGAMBILAN KAS KECIL</label>
                        <br>
                        <input type="checkbox" id="select-inquery pengambilan kas kecil"
                            onchange="checkAllCategory('inquery pengambilan kas kecil')">
                        <label for="select-inquery pengambilan kas kecil">Select All INQUERY PENGAMBILAN KAS KECIL</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 86 && $loop->iteration <= 90)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery pengambilan kas kecil" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY DEPOSIT SOPIR</label>
                        <br>
                        <input type="checkbox" id="select-inquery deposit sopir"
                            onchange="checkAllCategory('inquery deposit sopir')">
                        <label for="select-inquery deposit sopir">Select All INQUERY DEPOSIT SOPIR</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 91 && $loop->iteration <= 95)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery deposit sopir" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY UPDATE KM</label>
                        <br>
                        <input type="checkbox" id="select-inquery update km"
                            onchange="checkAllCategory('inquery update km')">
                        <label for="select-inquery update km">Select All INQUERY UPDATE KM</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 96 && $loop->iteration <= 100)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery update km" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY PEMBELIAN BAN</label>
                        <br>
                        <input type="checkbox" id="select-inquery pembelian ban"
                            onchange="checkAllCategory('inquery pembelian ban')">
                        <label for="select-inquery pembelian ban">Select All INQUERY PEMBELIAN BAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 101 && $loop->iteration <= 105)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery pembelian ban" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY PEMBELIAN PART</label>
                        <br>
                        <input type="checkbox" id="select-inquery pembelian part"
                            onchange="checkAllCategory('inquery pembelian part')">
                        <label for="select-inquery pembelian part">Select All INQUERY PEMBELIAN PART</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 106 && $loop->iteration <= 110)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery pembelian part" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY PEMASANGAN BAN</label>
                        <br>
                        <input type="checkbox" id="select-inquery pemasangan ban"
                            onchange="checkAllCategory('inquery pemasangan ban')">
                        <label for="select-inquery pemasangan ban">Select All INQUERY PEMASANGAN BAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 111 && $loop->iteration <= 115)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery pemasangan ban" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY PELEPASAN BAN</label>
                        <br>
                        <input type="checkbox" id="select-inquery pelepasan ban"
                            onchange="checkAllCategory('inquery pelepasan ban')">
                        <label for="select-inquery pelepasan ban">Select All INQUERY PELEPASAN BAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 116 && $loop->iteration <= 120)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery pelepasan ban" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY PEMASANGAN PART</label>
                        <br>
                        <input type="checkbox" id="select-inquery pemasangan part"
                            onchange="checkAllCategory('inquery pemasangan part')">
                        <label for="select-inquery pemasangan part">Select All INQUERY PEMASANGAN PART</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 121 && $loop->iteration <= 125)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery pemasangan part" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY PENGGANTIAN OLI</label>
                        <br>
                        <input type="checkbox" id="select-inquery penggantian oli"
                            onchange="checkAllCategory('inquery penggantian oli')">
                        <label for="select-inquery penggantian oli">Select All INQUERY PENGGANTIAN OLI</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 126 && $loop->iteration <= 130)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery penggantian oli" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY PERPANJANGAN STNK</label>
                        <br>
                        <input type="checkbox" id="select-inquery perpanjangan stnk"
                            onchange="checkAllCategory('inquery perpanjangan stnk')">
                        <label for="select-inquery perpanjangan stnk">Select All INQUERY PERPANJANGAN STNK</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 131 && $loop->iteration <= 135)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery perpanjangan stnk" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY PERPANJANGAN KIR</label>
                        <br>
                        <input type="checkbox" id="select-inquery perpanjangan kir"
                            onchange="checkAllCategory('inquery perpanjangan kir')">
                        <label for="select-inquery perpanjangan kir">Select All INQUERY PERPANJANGAN KIR</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 136 && $loop->iteration <= 140)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery perpanjangan kir" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY MEMO PERJALANAN</label>
                        <br>
                        <input type="checkbox" id="select-inquery memo perjalanan"
                            onchange="checkAllCategory('inquery memo perjalanan')">
                        <label for="select-inquery memo perjalanan">Select All INQUERY MEMO PERJALANAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 141 && $loop->iteration <= 145)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery memo perjalanan" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY MEMO BORONG</label>
                        <br>
                        <input type="checkbox" id="select-inquery memo borong"
                            onchange="checkAllCategory('inquery memo borong')">
                        <label for="select-inquery memo borong">Select All INQUERY MEMO BORONG</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 146 && $loop->iteration <= 150)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery memo borong" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY MEMO TAMBAHAN</label>
                        <br>
                        <input type="checkbox" id="select-inquery memo tambahan"
                            onchange="checkAllCategory('inquery memo tambahan')">
                        <label for="select-inquery memo tambahan">Select All INQUERY MEMO TAMBAHAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 151 && $loop->iteration <= 155)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery memo tambahan" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY FAKTUR EKSPEDISI</label>
                        <br>
                        <input type="checkbox" id="select-inquery faktur ekspedisi"
                            onchange="checkAllCategory('inquery faktur ekspedisi')">
                        <label for="select-inquery faktur ekspedisi">Select All INQUERY FAKTUR EKSPEDISI</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 156 && $loop->iteration <= 160)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery faktur ekspedisi" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY INVOICE EKSPEDISI</label>
                        <br>
                        <input type="checkbox" id="select-inquery invoice ekspedisi"
                            onchange="checkAllCategory('inquery invoice ekspedisi')">
                        <label for="select-inquery invoice ekspedisi">Select All INQUERY INVOICE EKSPEDISI</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 161 && $loop->iteration <= 165)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery invoice ekspedisi" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY RETURN PENERIMAAN BARANG</label>
                        <br>
                        <input type="checkbox" id="select-inquery return penerimaan barang"
                            onchange="checkAllCategory('inquery return penerimaan barang')">
                        <label for="select-inquery return penerimaan barang">Select All INQUERY RETURN PENERIMAAN
                            BARANG</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 166 && $loop->iteration <= 170)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery return penerimaan barang" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY RETURN NOTA</label>
                        <br>
                        <input type="checkbox" id="select-inquery return nota"
                            onchange="checkAllCategory('inquery return nota')">
                        <label for="select-inquery return nota">Select All INQUERY RETURN NOTA</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 171 && $loop->iteration <= 175)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery return nota" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY RETURN PENJUALAN</label>
                        <br>
                        <input type="checkbox" id="select-inquery return penjualan"
                            onchange="checkAllCategory('inquery return penjualan')">
                        <label for="select-inquery return penjualan">Select All INQUERY RETURN PENJUALAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 176 && $loop->iteration <= 180)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery return penjualan" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY PELUNASAN EKSPEDISI</label>
                        <br>
                        <input type="checkbox" id="select-inquery pelunasan ekspedisi"
                            onchange="checkAllCategory('inquery pelunasan ekspedisi')">
                        <label for="select-inquery pelunasan ekspedisi">Select All INQUERY PELUNASAN EKSPEDISI</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 181 && $loop->iteration <= 185)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery pelunasan ekspedisi" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY PELUNASAN FAKTUR PEMBELIAN BAN</label>
                        <br>
                        <input type="checkbox" id="select-inquery pelunasan faktur pembelian ban"
                            onchange="checkAllCategory('inquery pelunasan faktur pembelian ban')">
                        <label for="select-inquery pelunasan faktur pembelian ban">Select All INQUERY PELUNASAN FAKTUR
                            PEMBELIAN BAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 186 && $loop->iteration <= 190)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery pelunasan faktur pembelian ban"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            INQUERY PELUNASAN FAKTUR PEMBELIAN PART</label>
                        <br>
                        <input type="checkbox" id="select-inquery pelunasan faktur pembelian part"
                            onchange="checkAllCategory('inquery pelunasan faktur pembelian part')">
                        <label for="select-inquery pelunasan faktur pembelian part">Select All INQUERY PELUNASAN FAKTUR
                            PEMBELIAN PART</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 191 && $loop->iteration <= 195)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="inquery pelunasan faktur pembelian part"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN PEMBELIAN BAN</label>
                        <br>
                        <input type="checkbox" id="select-laporan pembelian ban"
                            onchange="checkAllCategory('laporan pembelian ban')">
                        <label for="select-laporan pembelian ban">Select All LAPORAN PEMBELIAN BAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 196 && $loop->iteration <= 197)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan pembelian ban" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN PEMBELIAN PART</label>
                        <br>
                        <input type="checkbox" id="select-laporan pembelian part"
                            onchange="checkAllCategory('laporan pembelian part')">
                        <label for="select-laporan pembelian part">Select All LAPORAN PEMBELIAN PART</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 198 && $loop->iteration <= 199)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan pembelian part" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN PEMASANGAN BAN</label>
                        <br>
                        <input type="checkbox" id="select-laporan pemasangan ban"
                            onchange="checkAllCategory('laporan pemasangan ban')">
                        <label for="select-laporan pemasangan ban">Select All LAPORAN PEMASANGAN BAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 200 && $loop->iteration <= 201)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan pemasangan ban" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN PELEPASAN BAN</label>
                        <br>
                        <input type="checkbox" id="select-laporan pelepasan ban"
                            onchange="checkAllCategory('laporan pelepasan ban')">
                        <label for="select-laporan pelepasan ban">Select All LAPORAN PELEPASAN BAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 202 && $loop->iteration <= 203)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan pelepasan ban" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN PEMASANGAN PART</label>
                        <br>
                        <input type="checkbox" id="select-laporan pemasangan part"
                            onchange="checkAllCategory('laporan pemasangan part')">
                        <label for="select-laporan pemasangan part">Select All LAPORAN PEMASANGAN PART</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 204 && $loop->iteration <= 205)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan pemasangan part" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN PENGGANTIAN OLI</label>
                        <br>
                        <input type="checkbox" id="select-laporan penggantian oli"
                            onchange="checkAllCategory('laporan penggantian oli')">
                        <label for="select-laporan penggantian oli">Select All LAPORAN PENGGANTIAN OLI</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 206 && $loop->iteration <= 207)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan penggantian oli" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN UPDATE KM</label>
                        <br>
                        <input type="checkbox" id="select-laporan update km"
                            onchange="checkAllCategory('laporan update km')">
                        <label for="select-laporan update km">Select All LAPORAN UPDATE KM</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 208 && $loop->iteration <= 209)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan update km" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN STATUS PERJALANAN</label>
                        <br>
                        <input type="checkbox" id="select-laporan status perjalanan"
                            onchange="checkAllCategory('laporan status perjalanan')">
                        <label for="select-laporan status perjalanan">Select All LAPORAN STATUS PERJALANAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 210 && $loop->iteration <= 211)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan status perjalanan" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN PENERIMAAN KAS KECIL</label>
                        <br>
                        <input type="checkbox" id="select-laporan penerimaan kas kecil"
                            onchange="checkAllCategory('laporan penerimaan kas kecil')">
                        <label for="select-laporan penerimaan kas kecil">Select All LAPORAN PENERIMAAN KAS KECIL</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 212 && $loop->iteration <= 213)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan penerimaan kas kecil" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN PENGAMBILAN KAS KECIL</label>
                        <br>
                        <input type="checkbox" id="select-laporan pengambilan kas kecil"
                            onchange="checkAllCategory('laporan pengambilan kas kecil')">
                        <label for="select-laporan pengambilan kas kecil">Select All LAPORAN PENGAMBILAN KAS KECIL</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 214 && $loop->iteration <= 215)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan pengambilan kas kecil" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN DEPOSIT SOPIR</label>
                        <br>
                        <input type="checkbox" id="select-laporan deposit sopir"
                            onchange="checkAllCategory('laporan deposit sopir')">
                        <label for="select-laporan deposit sopir">Select All LAPORAN DEPOSIT SOPIR</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 216 && $loop->iteration <= 217)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan deposit sopir" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN MEMO PERJALANAN</label>
                        <br>
                        <input type="checkbox" id="select-laporan memo perjalanan"
                            onchange="checkAllCategory('laporan memo perjalanan')">
                        <label for="select-laporan memo perjalanan">Select All LAPORAN MEMO PERJALANAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 218 && $loop->iteration <= 219)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan memo perjalanan" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN MEMO BORONG</label>
                        <br>
                        <input type="checkbox" id="select-laporan memo borong"
                            onchange="checkAllCategory('laporan memo borong')">
                        <label for="select-laporan memo borong">Select All LAPORAN MEMO BORONG</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 220 && $loop->iteration <= 221)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan memo borong" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN MEMO TAMBAHAN</label>
                        <br>
                        <input type="checkbox" id="select-laporan memo tambahan"
                            onchange="checkAllCategory('laporan memo tambahan')">
                        <label for="select-laporan memo tambahan">Select All LAPORAN MEMO TAMBAHAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 222 && $loop->iteration <= 223)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan memo tambahan" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN FAKTUR EKSPEDISI</label>
                        <br>
                        <input type="checkbox" id="select-laporan faktur eskpedisi"
                            onchange="checkAllCategory('laporan faktur eskpedisi')">
                        <label for="select-laporan faktur eskpedisi">Select All LAPORAN FAKTUR EKSPEDISI</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 224 && $loop->iteration <= 225)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan faktur eskpedisi" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN PPH</label>
                        <br>
                        <input type="checkbox" id="select-laporan pph" onchange="checkAllCategory('laporan pph')">
                        <label for="select-laporan pph">Select All LAPORAN PPH</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 226 && $loop->iteration <= 227)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan pph" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN INVOICE EKSPEDISI</label>
                        <br>
                        <input type="checkbox" id="select-laporan invoice ekspedisi"
                            onchange="checkAllCategory('laporan invoice ekspedisi')">
                        <label for="select-laporan invoice ekspedisi">Select All LAPORAN INVOICE EKSPEDISI</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 228 && $loop->iteration <= 229)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan invoice ekspedisi" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN PENERIMAAN RETURN BARANG</label>
                        <br>
                        <input type="checkbox" id="select-laporan penerimaan return barang"
                            onchange="checkAllCategory('laporan penerimaan return barang')">
                        <label for="select-laporan penerimaan return barang">Select All LAPORAN PENERIMAAN RETURN
                            BARANG</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 230 && $loop->iteration <= 231)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan penerimaan return barang" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN NOTA RETURN</label>
                        <br>
                        <input type="checkbox" id="select-laporan nota return"
                            onchange="checkAllCategory('laporan nota return')">
                        <label for="select-laporan nota return">Select All LAPORAN NOTA RETURN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 232 && $loop->iteration <= 233)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan nota return" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN PENJUALAN RETURN</label>
                        <br>
                        <input type="checkbox" id="select-laporan penjualan return"
                            onchange="checkAllCategory('laporan penjualan return')">
                        <label for="select-laporan penjualan return">Select All LAPORAN PENJUALAN RETURN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 234 && $loop->iteration <= 235)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan penjualan return" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN PELUNASAN EKSPEDISI</label>
                        <br>
                        <input type="checkbox" id="select-laporan pelunasan ekspedisi"
                            onchange="checkAllCategory('laporan pelunasan ekspedisi')">
                        <label for="select-laporan pelunasan ekspedisi">Select All LAPORAN PELUNASAN EKSPEDISI</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 236 && $loop->iteration <= 237)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan pelunasan ekspedisi" value="{{ $fitur }}"
                                        {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN PELUNASAN FAKTUR PEMBELIAN BAN</label>
                        <br>
                        <input type="checkbox" id="select-laporan pelunasan faktur pembelian ban"
                            onchange="checkAllCategory('laporan pelunasan faktur pembelian ban')">
                        <label for="select-laporan pelunasan faktur pembelian ban">Select All LAPORAN PELUNASAN FAKTUR
                            PEMBELIAN BAN</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 238 && $loop->iteration <= 239)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan pelunasan faktur pembelian ban"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                                </div>
                            @endif
                        @endforeach

                        <label style="font-weight: bold; margin-bottom:10px; margin-top:10px" class="form-check-label">
                            LAPORAN PELUNASAN FAKTUR PEMBELIAN PART</label>
                        <br>
                        <input type="checkbox" id="select-laporan pelunasan faktur pembelian part"
                            onchange="checkAllCategory('laporan pelunasan faktur pembelian part')">
                        <label for="select-laporan pelunasan faktur pembelian part">Select All LAPORAN PELUNASAN FAKTUR
                            PEMBELIAN PART</label>
                        <br>
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration >= 240 && $loop->iteration <= 241)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="fitur[]"
                                        data-category="laporan pelunasan faktur pembelian part"
                                        value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($fitur) }}</label>
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
        var checkboxes = document.querySelectorAll("input[type='checkbox'][name='fitur[]']");

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
