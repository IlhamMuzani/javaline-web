@extends('layouts.app')

@section('title', 'Tambah Klaim Ban')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Klaim Ban</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/klaim_ban') }}">Inquery Klaim Ban</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section class="content">
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            @if (session('erorrss'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    {{ session('erorrss') }}
                </div>
            @endif

            @if (session('error_pelanggans') || session('error_pesanans'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @if (session('error_pelanggans'))
                        @foreach (session('error_pelanggans') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @endif
                    @if (session('error_pesanans'))
                        @foreach (session('error_pesanans') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @endif
                </div>
            @endif
            <form action="{{ url('admin/klaim_ban') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Klaim Ban</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group" hidden>
                            <label for="kendaraan_id">Id Kendaraan</label>
                            <input type="text" class="form-control" id="kendaraan_x1b" readonly name="kendaraan_id"
                                placeholder="" value="{{ old('kendaraan_id') }}">
                        </div>
                        <div class="form-group" hidden>
                            <label for="km_pemasangan">Ban Id</label>
                            <input type="text" class="form-control" id="" name="ban_id" placeholder=""
                                value="{{ old('ban_id') }}">
                        </div>
                        <div class="form-group">
                            <div class="form-group d-flex">
                                <input onclick="showBan(this.value)" class="form-control" id="kode_ban" name="kode_ban"
                                    type="text" placeholder="" value="{{ old('kode_ban') }}" readonly
                                    style="margin-right: 10px; font-size:14px" />
                                <button class="btn btn-primary" type="button" onclick="showBan(this.value)">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="km_pemasangan">No. Seri</label>
                            <input type="text" class="form-control" id="" readonly name="no_seri" placeholder=""
                                value="{{ old('no_seri') }}">
                        </div>
                        <div class="form-group">
                            <label for="km_pemasangan">Km Pemasangan</label>
                            <input type="text" class="form-control" readonly id="km_pemasangan1" name="km_pemasangan"
                                placeholder="Masukan km pemasangan" value="{{ old('km_pemasangan') }}">
                        </div>
                        <div class="form-group">
                            <label for="km_pelepasan1">Km Pelepasan</label>
                            <input type="text" class="form-control" id="km_pelepasan1" name="km_pelepasan"
                                placeholder="Masukan km pelepasan" value="{{ old('km_pelepasan') }}">
                        </div>
                        <div class="form-group" id="perhitungan_klaim">
                            <div class="form-group">
                                <label for="km_pemasangan">Harga Ban</label>
                                <input type="text" class="form-control" id="harga" readonly name="harga"
                                    placeholder="" value="{{ old('harga') }}">
                            </div>
                            <div class="form-group">
                                <label for="km_pemasangan">Target Km</label>
                                <input type="text" class="form-control" id="" readonly name="target_km_ban"
                                    placeholder="" value="{{ old('target_km_ban') }}">
                            </div>
                            <div class="form-group" hidden>
                                <label for="km_pemasangan">KM target</label>
                                <input type="text" class="form-control" id="km_target" readonly name="km_target"
                                    placeholder="" value="{{ old('km_target') }}">
                            </div>
                            <div class="form-group">
                                <label for="km_terpakai">KM Terpakai</label>
                                <input type="text" class="form-control" id="km_terpakai" readonly name="km_terpakai"
                                    value="{{ old('km_terpakai') }}" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="sisa_harga">Harga Klaim</label>
                                <input type="text" class="form-control" id="sisa_harga" readonly name="sisa_harga"
                                    placeholder="" value="{{ old('sisa_harga') }}">
                            </div>
                            <div id="pengambilan">
                                <div class="card-header mb-3">
                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="sisa_saldo">Kode Sopir</label>
                                            <div class="form-group d-flex">
                                                <input readonly type="text" hidden class="form-control"
                                                    id="karyawan_id" name="karyawan_id" placeholder=""
                                                    value="{{ old('karyawan_id') }}">
                                                <input onclick="showSopir(this.value)" class="form-control"
                                                    id="kode_karyawan" name="kode_karyawan" type="text"
                                                    placeholder="" value="{{ old('kode_karyawan') }}" readonly
                                                    style="margin-right: 10px; font-size:14px" />
                                                <button class="btn btn-primary" type="button"
                                                    onclick="showSopir(this.value)">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                <input style="text-align: end;margin:right:10px" type="text"
                                                    class="form-control" id="sisa_saldo" readonly name="sisa_saldo"
                                                    value="{{ old('tabungan') }}" placeholder="">

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="nama_lengkap">Nama Sopir</label>
                                                <input readonly type="text" class="form-control" id="nama_lengkap"
                                                    name="nama_lengkap" placeholder=""
                                                    value="{{ old('nama_lengkap') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                <input style="text-align: end" type="text" class="form-control"
                                                    readonly id="saldo_keluar" name="saldo_keluar" placeholder=""
                                                    value="{{ old('saldo_keluar') }}">
                                            </div>
                                            <hr
                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                            <span
                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="alamat">Keterangan</label>
                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="sub_total">Sub Total</label>
                                                <input style="text-align: end; margin:right:10px" type="text"
                                                    class="form-control" readonly id="sub_totals" name="sub_totals"
                                                    placeholder="" value="{{ old('sub_totals') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            // Definisikan fungsi perhitungan
                            function hitung() {
                                var km_pemasangan = parseInt($('#km_pemasangan1').val());
                                var km_pelepasan = parseInt($('#km_pelepasan1').val());
                                var km_terpakai = km_pelepasan - km_pemasangan;
                                $('#km_terpakai').val(km_terpakai);
                                var km_target = parseFloat($('#km_target').val());
                                var hargaString = $('#harga').val().replaceAll('.', '');
                                var harga = parseFloat(hargaString);
                                console.log(harga);
                                var hasil_persen = km_terpakai / km_target * 100;
                                var hasil_harga = harga * hasil_persen / 100;
                                // Pastikan hasil_harga tidak negatif
                                hasil_harga = Math.max(0, hasil_harga);

                                // Memperoleh hasil harga yang dibulatkan
                                var hasil_harga_bulat = Math.round(hasil_harga);
                                var sisa_harga = harga - hasil_harga_bulat;

                                // Pastikan sisa_harga tidak negatif
                                sisa_harga = Math.max(0, sisa_harga);

                                var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                $('#sisa_harga').val(hasil_harga_formatted);
                                $('#saldo_keluar').val(hasil_harga_formatted);

                                // Hitung selisih antara sisa_saldo dan saldo_keluar
                                var sisa_saldo = parseFloat($('#sisa_saldo').val().replace(/\D/g, ''));
                                var saldo_keluar = parseFloat($('#saldo_keluar').val().replace(/\D/g, ''));
                                var sub_totals = sisa_saldo - saldo_keluar;
                                var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                $('#sub_totals').val(formattedSubTotals);
                            }
                            // Panggil fungsi perhitungan saat dokumen siap
                            hitung();
                            // Panggil fungsi perhitungan saat input berubah
                            $('#km_pelepasan1').on('input', function() {
                                hitung();
                            });
                        });
                    </script>
                </div>
                <div class="card-footer text-right">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
        <div class="modal fade" id="tableSopir" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="datatables1" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableBan" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Ban</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="datatables1" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Ban</th>
                                        <th>No seri</th>
                                        <th>Merek</th>
                                        <th>Type</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bans as $ban)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $ban->kode_ban }}</td>
                                            <td>{{ $ban->no_seri }}</td>
                                            <td>{{ $ban->merek->nama_merek }}</td>
                                            <td>{{ $ban->typeban->nama_type }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedDataban('{{ $ban->id }}',
                                                    '{{ $ban->kode_karyawan }}',
                                                    '{{ $ban->nama_lengkap }}',
                                                    '{{ $ban->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        function showSopir(selectedCategory) {
            $('#tableSopir').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }


        function getSelectedData(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id').value = Sopir_id;
            document.getElementById('kode_karyawan').value = KodeSopir;
            document.getElementById('nama_lengkap').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
        }
    </script>

    <script>
        function showSopir(selectedCategory) {
            $('#tableBan').modal('show');
        }
    </script>

@endsection
