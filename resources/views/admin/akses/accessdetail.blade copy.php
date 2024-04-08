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
                                    class="form-check-label">SOPIR</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 58)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">RUTE</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 61)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">BIAYA TAMBAHAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 64)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">POTONGAN MEMO</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 67)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">TARIF</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 70)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">SATUAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 73)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">BARANG RETURN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 76)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">PERPANJANGAN STNK</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 78)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">PERPANJANGAN KIR</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 80)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">PENGGANTIAN OLI</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 81)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PENERIMAAN KAS KECIL</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 86)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PENGAMBILAN KAS KECIL</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 91)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY DEPOSIT SOPIR</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 96)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY UPDATE KM</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 101)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PEMBELIAN BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 106)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PEMBELIAN PART</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 111)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PEMASANGAN BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 116)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PELEPASAN BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 121)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PEMASANGAN PART</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 126)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PENGGANTIAN OLI</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 131)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PERPANJANGAN STNK</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 136)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PERPANJANGAN KIR</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 141)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY MEMO PERJALANAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 146)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY MEMO BORONG</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 151)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY MEMO TAMBAHAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 156)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY FAKTUR EKSPEDISI</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 161)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY INVOICE EKSPEDISI</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 166)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY RETURN PENERIMAAN BARANG</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 171)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY RETURN NOTA</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 176)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY RETURN PENJUALAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 181)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">INQUERY PELUNASAN EKSPEDISI</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 186)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PEMBELIAN BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 188)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PEMBELIAN PART</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 190)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PEMASANGAN BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 192)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PELEPASAN BAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 194)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PEMASANGAN PART</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 196)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PENGGANTIAN OLI</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 198)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN UPDATE KM</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 200)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN STATUS PERJALANAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 202)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PENERIMAAN KAS KECIL</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 204)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PENGAMBILAN KAS KECIL</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 206)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN DEPOSIT SOPIR</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 208)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN MEMO PERJALANAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 210)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN MEMO BORONG</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 212)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN MEMO TAMBAHAN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 214)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN FAKTUR EKSPEDISI</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 216)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PPH</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 218)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN INVOICE EKSPEDISI</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 220)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PENERIMAAN RETURN BARANG</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 222)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN NOTA RETURN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 224)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PENJUALAN RETURN</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 226)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN PELUNASAN EKSPEDISI</label>
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
