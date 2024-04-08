@extends('layouts.app')

@section('title', 'Hak Akses Menu')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
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

    <section class="content">
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
                        @foreach ($fiturs as $fitur)
                            @if ($loop->iteration === 1)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">KARYAWAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 5)
                                <label style="font-weight: bold; margin-bottom:20px" class="form-check-label">USER</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 7)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">HAK AKSES</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 8)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">DEPARTEMEN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 10)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">SUPPLIER</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 14)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">PELANGGAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 18)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">DIVISI</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 21)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">JENIS KENDARAAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 24)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">GOLONGAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 27)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">KENDARAAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 31)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">UKURAN BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 34)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">MEREK BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 37)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">TYPE BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 40)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 44)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">NO KIR</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 49)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">STNK</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 53)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">PART</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 57)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">RUTE</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 60)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">PERPANJANGAN STNK</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 62)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">PERPANJANGAN KIR</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 64)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">PENGGANTIAN OLI</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 65)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PEMBELIAN BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 70)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PEMBELIAN PART</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 75)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PEMASANGAN BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 80)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PELEPASAN BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 85)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PEMASANGAN PART</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 90)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PENGGANTIAN OLI</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 95)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY UPDATE KM</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 100)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PERPANJANGAN STNK</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 105)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PERPANJANGAN KIR</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 110)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PENERIMAAN KAS KECIL</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 115)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PEMBELIAN BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 117)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PEMBELIAN PART</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 119)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PEMASANGAN BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 121)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PELEPASAN BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 123)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PEMASANGAN PART</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 125)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PENGGANTIAN OLI</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 127)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN UPDATE KM</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 129)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN STATUS PERJALANAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 131)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PENERIMAAN KAS KECIL</label>
                                <br>
                            @endif
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="fitur[]"
                                    value="{{ $fitur }}" {{ $akses->fitur[$fitur] ? 'checked' : '' }}>
                                <label class="form-check-label">{{ ucfirst($fitur) }}</label>
                            </div>
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
    </script>
@endsection
