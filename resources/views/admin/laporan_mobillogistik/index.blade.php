@extends('layouts.app')

@section('title', 'Laporan Mobil Logistik')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Mobil Logistik</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Mobil Logistik</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Success!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Laporan Mobil Logistik</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label for="created_at">Kategori</label>
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih Laporan -</option>
                                    <option value="laporandetail" selected>Laporan Detail</option>
                                    <option value="laporanglobal">Laporan Global</option>
                                    {{-- <option value="akun">Laporan Kas Keluar Group by Akun</option>
                                    <option value="memo_tambahan">Saldo Kas</option> --}}
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="created_at">Kendaraan</label>
                                <select class="select2bs4 select2-hidden-accessible" name="kendaraan_id"
                                    data-placeholder="Cari Kendaraan.." style="width: 100%;" data-select2-id="23"
                                    tabindex="-1" aria-hidden="true" id="kendaraan_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($kendaraans as $kendaraan)
                                        <option value="{{ $kendaraan->id }}"
                                            {{ Request::get('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                                            {{ $kendaraan->no_kabin }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="created_at">Tanggal Awal</label>
                                <input class="form-control" id="created_at" name="created_at" type="date"
                                    value="{{ Request::get('created_at') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-2 mb-3">
                                {{-- @if (auth()->check() && auth()->user()->fitur['laporan pengambilan kas kecil cari']) --}}
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                {{-- @endif
                                @if (auth()->check() && auth()->user()->fitur['laporan pengambilan kas kecil cetak']) --}}
                                <button type="button" class="btn btn-primary btn-block" onclick="printReport()"
                                    target="_blank">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                                {{-- @endif --}}
                            </div>
                        </div>
                    </form>
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th>Faktur Ekspedisi</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>No Polisi</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalGrandTotal = 0;
                                $totalGrandTotalMemo = 0;
                                $totalTambahan = 0;

                                $created_at = isset($created_at) ? $created_at : null;
                                $tanggal_akhir = isset($tanggal_akhir) ? $tanggal_akhir : null;
                            @endphp
                            @foreach ($inquery as $pengeluaran)
                                <tr style="background: rgb(156, 156, 156)">
                                    <td>{{ $pengeluaran->kode_faktur }}</td>
                                    <td>{{ $pengeluaran->created_at }}</td>
                                    <td>{{ $pengeluaran->nama_pelanggan }}</td>
                                    <td>
                                        @if ($pengeluaran->detail_faktur)
                                            {{ $pengeluaran->detail_faktur->first()->nama_driver }}
                                        @else
                                            tidak ada
                                        @endif

                                        @if ($pengeluaran->kendaraan)
                                            ({{ $pengeluaran->kendaraan->no_kabin }})
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($pengeluaran->grand_total, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @foreach ($pengeluaran->detail_faktur as $memo)
                                    <tr>
                                        <td>{{ $memo->kode_memo }}</td>
                                        <td>{{ $memo->created_at }}</td>
                                        <td>{{ $memo->nama_rute }} @if ($pengeluaran->kendaraan)
                                                {{ $pengeluaran->kendaraan->no_kabin }}
                                            @else
                                                tidak ada
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <span style="margin-right:30px">
                                                @if ($memo->memo_ekspedisi)
                                                    {{ number_format($memo->memo_ekspedisi->uang_jalan, 0, ',', '.') }}
                                                @else
                                                    tidak ada
                                                @endif
                                            </span>
                                            <span style="margin-right:30px">
                                                @if ($memo->memo_ekspedisi)
                                                    {{ number_format($memo->memo_ekspedisi->biaya_tambahan, 0, ',', '.') }}
                                                @else
                                                    tidak ada
                                                @endif
                                            </span>
                                            <span>
                                                @if ($memo->memo_ekspedisi)
                                                    {{ number_format($memo->memo_ekspedisi->deposit_driver, 0, ',', '.') }}
                                                @else
                                                    tidak ada
                                                @endif
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            @if ($memo->memo_ekspedisi)
                                                {{ number_format($memo->memo_ekspedisi->hasil_jumlah, 0, ',', '.') }}
                                            @else
                                                tidak ada
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- Loop hanya jika ada memo tambahan --}}
                                    @if ($memo->memo_ekspedisi && $memo->memo_ekspedisi->memotambahan->isNotEmpty())
                                        @foreach ($memo->memo_ekspedisi->memotambahan as $memoTambahan)
                                            <tr>
                                                <td><span
                                                        style="margin-right:30px">{{ $memoTambahan->kode_tambahan }}</span>
                                                </td>
                                                <td><span style="margin-right:30px">{{ $memoTambahan->created_at }}</span>
                                                </td>
                                                <td><span
                                                        style="margin-right:30px">{{ $memoTambahan->memo_ekspedisi->nama_rute }}</span>
                                                </td>
                                                <td class="text-right">
                                                    <span
                                                        style="margin-right:30px">{{ number_format($memoTambahan->grand_total, 0, ',', '.') }}</span>
                                                    <span style="margin-right:30px">0</span>
                                                    <span style="margin-right:37px">0</span>
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($memoTambahan->grand_total, 0, ',', '.') }}
                                                </td>
                                            </tr>

                                            @php
                                                $totalTambahan += $memoTambahan->grand_total;

                                            @endphp
                                        @endforeach
                                    @endif
                                @endforeach

                                @php
                                    $totalGrandTotal += $pengeluaran->grand_total;
                                    $totalGrandTotalMemo += $memo->memo_ekspedisi->hasil_jumlah ?? 0;
                                    // $Selisih = $totalGrandTotal - $totalGrandTotalMemo;
                                    // $Totals = $totalGrandTotal - $totalGrandTotalMemo;
                                @endphp
                            @endforeach

                            @php
                                $Selisih = $totalGrandTotal - $totalGrandTotalMemo - $totalTambahan;
                                $Totals = $totalGrandTotal - $totalGrandTotalMemo - $totalTambahan;
                            @endphp
                        </tbody>
                    </table>

                </div>

                {{-- <div class="card"> --}}
                <div class="card-body">
                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    {{-- <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-size:14px; margin-top:5px" for="tarif">Deposit
                                                            Sopir
                                                            <span style="margin-left:19px">:</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input style="font-size:14px;" type="text"
                                                            class="form-control pph2" id="deposit_driver"
                                                            name="deposit_driver" value="{{ old('deposit_driver') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6" style="color: white">
                                                    <div class="form-group">
                                                        <label style="font-size:14px; margin-top:5px" for="tarif">.
                                                            <span class="ml-3">:</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input style="margin-left: 0px" class="form-check-input"
                                                            type="checkbox" id="additional_checkbox"
                                                            name="additional_checkbox" onchange="limitInput()">
                                                        <label style="margin-left: 20px" class="form-check-label"
                                                            for="additional_checkbox">
                                                            Min Deposit 50.000
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6" style="color: white">
                                                    <div class="form-group">
                                                        <label style="font-size:18px; margin-top:5px" for="tarif">.
                                                            <span class="ml-3">:</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6" style="color: white">
                                                    <div class="form-group">
                                                        <label style="font-size:18px; margin-top:5px" for="tarif">.
                                                            <span class="ml-3">:</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px" for="tarif">Total
                                                        Faktur
                                                        <span style="margin-left:70px">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" id="total_faktur"
                                                        value="{{ number_format($totalGrandTotal, 0, ',', '.') }}"
                                                        type="text" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px">Total
                                                        Memo
                                                        <span style="margin-left:72px">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control" readonly
                                                        value="{{ number_format($totalGrandTotalMemo + $totalTambahan, 0, ',', '.') }}">
                                                </div>
                                            </div>
                                            <hr
                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                            <span
                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;"></span>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px">Selisih
                                                        <span style="margin-left:101px">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control" readonly
                                                        value="{{ number_format($Selisih, 0, ',', '.') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px" for="tarif">Biaya
                                                        Operasional
                                                        <span style="margin-left:31px">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control" readonly
                                                        value="{{ number_format(
                                                            $kendaraans->flatMap(function ($kendaraan) use ($created_at, $tanggal_akhir) {
                                                                    return $kendaraan->detail_pengeluaran->where('barangakun_id', 29)->where('status', 'posting')->whereBetween('created_at', [$created_at, $tanggal_akhir])->pluck('nominal');
                                                                })->sum() ?? 0,
                                                            0,
                                                            ',',
                                                            '.',
                                                        ) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px" for="tarif">Biaya
                                                        Perbaikan
                                                        <span style="margin-left:40px">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control" readonly
                                                        value="{{ number_format(
                                                            $kendaraans->flatMap(function ($kendaraan) use ($created_at, $tanggal_akhir) {
                                                                    return $kendaraan->detail_pengeluaran->where('barangakun_id', 5)->where('status', 'posting')->whereBetween('created_at', [$created_at, $tanggal_akhir])->pluck('nominal');
                                                                })->sum() ?? 0,
                                                            0,
                                                            ',',
                                                            '.',
                                                        ) }}">
                                                </div>
                                            </div>
                                            <hr
                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                            <span
                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;"></span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px">Sub
                                                        Total
                                                        <span style="margin-left:81px">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control"
                                                        value="{{ number_format($Totals, 0, ',', '.') }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- </div> --}}


                {{-- <div class="card-body">
                    <div class="text-right">
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px" for="tarif">Total
                                                        Faktur
                                                        <span style="margin-left:50px">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control" id="uangjalans" readonly name="uang_jalans"
                                                        placeholder="" value="{{ old('uang_jalans') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px" for="tarif">Total Memo
                                                        <span style="margin-left:17px">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control pph2" readonly id="harga_tambahan" readonly
                                                        name="biaya_tambahan" value="{{ old('biaya_tambahan') }}">
                                                </div>
                                            </div>
                                            <hr
                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                            <span
                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;"></span>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px" for="tarif">Selisih
                                                        <span style="margin-left:19px">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control" id="potongan_memo" readonly
                                                        name="potongan_memo" placeholder=""
                                                        value="{{ old('potongan_memo') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px" for="tarif">Biaya
                                                        Operasional
                                                        <span style="margin-left:35px">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control" id="depositsdriverss" readonly
                                                        name="deposit_drivers" placeholder=""
                                                        value="{{ old('deposit_drivers') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px" for="tarif">Biaya
                                                        Perbaikan
                                                        <span style="margin-left:35px">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control" id="depositsdriverss" readonly
                                                        name="deposit_drivers" placeholder=""
                                                        value="{{ old('deposit_drivers') }}">
                                                </div>
                                            </div>
                                            <hr
                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                            <span
                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;"></span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px" for="tarif">Sub Total
                                                        <span style="margin-left:35px">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control" id="depositsdriverss" readonly
                                                        name="deposit_drivers" placeholder=""
                                                        value="{{ old('deposit_drivers') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- /.card-body -->
            </div>
        </div>
    </section>
    <!-- /.card -->
    <script>
        var tanggalAwal = document.getElementById('created_at');
        var tanggalAkhir = document.getElementById('tanggal_akhir');
        var kendaraanId = document.getElementById('kendaraan_id');
        var form = document.getElementById('form-action');

        if (tanggalAwal.value == "") {
            tanggalAkhir.readOnly = true;
        }

        tanggalAwal.addEventListener('change', function() {
            if (this.value == "") {
                tanggalAkhir.readOnly = true;
            } else {
                tanggalAkhir.readOnly = false;
            }
            tanggalAkhir.value = "";
            var today = new Date().toISOString().split('T')[0];
            tanggalAkhir.value = today;
            tanggalAkhir.setAttribute('min', this.value);
        });

        function cari() {
            // Dapatkan nilai tanggal awal dan tanggal akhir
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;
            var Kendaraanid = kendaraanId.value;

            // Cek apakah tanggal awal dan tanggal akhir telah diisi
            if (startDate && endDate && Kendaraanid) {
                form.action = "{{ url('admin/laporan_mobillogistik') }}";
                form.submit();
            } else {
                alert("Silakan pilih kendaraan dan isi kedua tanggal sebelum mencetak.");
            }
        }


        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print_mobillogistik') }}" + "?start_date=" + startDate + "&end_date=" +
                    endDate;
                form.submit();
            } else {
                alert("Silakan isi kedua tanggal sebelum mencetak.");
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            // Detect the change event on the 'status' dropdown
            $('#statusx').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'laporandetail':
                        window.location.href = "{{ url('admin/laporan_mobillogistik') }}";
                        break;
                    case 'laporanglobal':
                        window.location.href = "{{ url('admin/laporan_mobillogistikglobal') }}";
                        break;
                        // case 'akun':
                        //     window.location.href = "{{ url('admin/laporan_pengeluarankaskecilakun') }}";
                        //     break;
                        // case 'memo_tambahan':
                        //     window.location.href = "{{ url('admin/laporan_saldokas') }}";
                        //     break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>

@endsection
