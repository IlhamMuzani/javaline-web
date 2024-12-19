@extends('layouts.app')

@section('title', 'Inquery Memo Tambahan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Memo Tambahan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_memotambahan') }}">Memo Ekspedisi</a></li>
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
                        <i class="icon fas fa-ban"></i> Gagal!
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
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    {{ session('erorrss') }}
                </div>
            @endif
            @if (session('error_pelanggans') || session('error_pesanans'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
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
            <form action="{{ url('admin/inquery_memotambahan/' . $inquery->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui Memo Tambahan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label style="font-size:14px" for="kategori">Kategori</label>
                            <input style="font-size:14px" type="text" class="form-control" id="kategori" readonly
                                name="kategori" placeholder="" value="{{ old('kategori', $inquery->kategori) }}">
                        </div>
                        <div id="formmemotambahans" class="form-group" style="flex: 8;">
                            <div class="mb-3 mt-4">
                                <button class="btn btn-primary btn-sm" type="button" onclick="ShowMemo(this.value)">
                                    <i class="fas fa-plus mr-2"></i> Pilih Memo
                                </button>
                            </div>
                            {{-- <div class="form-group" hidden>
                                <label for="nopol">Id Memo</label>
                                <input type="text" class="form-control" id="memo_ekspedisi_id" name="memo_ekspedisi_id"
                                    value="@if ($inquery->memo_ekspedisi) {{ old('memo_ekspedisi_id', $inquery->memo_ekspedisi->id) }}
                                            @else @endif"
                                    readonly placeholder="" value="">
                            </div> --}}
                            <div class="form-group" hidden>
                                <label for="nopol">Id Memo</label>
                                <input type="text" class="form-control" id="memo_ekspedisi_id" name="memo_ekspedisi_id"
                                    value="{{ old('memo_ekspedisi_id', $inquery->memo_ekspedisi->id) }}" readonly
                                    placeholder="" value="">
                            </div>
                            <div class="form-group" hidden>
                                <label for="nopol">Id User</label>
                                <input type="text" class="form-control" id="user_id" name="user_id"
                                    value="{{ old('user_id', $inquery->memo_ekspedisi->user->id ?? null) }}" readonly
                                    placeholder="" value="">
                            </div>
                            <div class="form-group">
                                <label style="font-size:14px" for="nopol">No Memo</label>
                                <input style="font-size:14px" type="text" class="form-control" readonly id="kode_memosa"
                                    name="kode_memosa" placeholder="" value="{{ old('kode_memosa', $inquery->no_memo) }}">
                            </div>
                            <div class="form-group">
                                <label style="font-size:14px" for="nopol">Nama Sopir</label>
                                <input style="font-size:14px" type="text" class="form-control" readonly
                                    name="nama_driversa" id="nama_driversa" placeholder=""
                                    value="{{ old('nama_driversa', $inquery->nama_driver) }}">
                            </div>
                            <div class="form-group" hidden>
                                <label style="font-size:14px" for="nopol">Telp</label>
                                <input style="font-size:14px" type="text" class="form-control" name="telps"
                                    id="telps" placeholder="" value="{{ old('telps', $inquery->telp) }}">
                            </div>
                            <div class="form-group" hidden>
                                <label style="font-size:14px" style="font-size:14px" for="nama">Kendaraan id</label>
                                <input style="font-size:14px" style="font-size:14px" type="text" class="form-control"
                                    name="kendaraan_idsa" id="kendaraan_idsa" placeholder=""
                                    value="{{ old('kendaraan_idsa', $inquery->kendaraan_id) }}">
                            </div>
                            <div class="form-group">
                                <label style="font-size:14px" style="font-size:14px" for="nama">No Kabin</label>
                                <input style="font-size:14px" readonly style="font-size:14px" type="text"
                                    class="form-control" name="no_kabinsa" id="no_kabinsa" placeholder=""
                                    value="{{ old('no_kabinsa', $inquery->no_kabin) }}">
                            </div>
                            <div class="form-group" hidden>
                                <label style="font-size:14px" style="font-size:14px" for="nama">No Pol</label>
                                <input style="font-size:14px" style="font-size:14px" type="text" class="form-control"
                                    name="no_polsa" id="no_polsa" placeholder=""
                                    value="{{ old('no_polsa', $inquery->no_pol) }}">
                            </div>
                            <div class="form-group">
                                <label style="font-size:14px" for="nama">Rute Perjalanan</label>
                                <input style="font-size:14px" readonly type="text" class="form-control"
                                    name="nama_rutesa" id="nama_rutesa" placeholder=""
                                    value="{{ old('nama_rutesa', $inquery->nama_rute) }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="memotambahanss">
                    <div class="card" id="form_biayatambahan">
                        <div class="card-header">
                            <h3 class="card-title">Memo Tambahan <span>
                                </span></h3>
                            <div class="float-right">
                                <button type="button" class="btn btn-primary btn-sm" onclick="addMemotambahan()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="font-size:14px" class="text-center">No</th>
                                        <th style="font-size:14px">Keterangan</th>
                                        <th style="font-size:14px">Qty</th>
                                        <th style="font-size:14px">Satuan</th>
                                        <th style="font-size:14px">Nominal</th>
                                        <th style="font-size:14px">Total</th>
                                        <th style="font-size:14px">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody id="tabel-memotambahan">
                                    @foreach ($details as $detail)
                                        <tr id="memotambah-{{ $loop->index }}">
                                            <td style="width: 70px; font-size:14px" class="text-center"
                                                id="urutantambah">
                                                {{ $loop->index + 1 }}
                                            </td>
                                            <td hidden>
                                                <div class="form-group" hidden>
                                                    <input type="text" class="form-control"
                                                        name="detail_idstambahan[]" value="{{ $detail['id'] }}">
                                                </div>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="keterangan_tambahan-0" name="keterangan_tambahan[]"
                                                        value="{{ $detail['keterangan_tambahan'] }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control qty"
                                                        id="qty-0" name="qty[]" data-row-id="0"
                                                        value="{{ $detail['qty'] }}"
                                                        onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <select style="font-size:14px" class="form-control" id="satuans-0"
                                                        name="satuans[]">
                                                        <option value="">- Pilih -</option>
                                                        <option value="pcs"
                                                            {{ old('satuans', $detail['satuans']) == 'pcs' ? 'selected' : null }}>
                                                            pcs</option>
                                                        <option value="ltr"
                                                            {{ old('satuans', $detail['satuans']) == 'ltr' ? 'selected' : null }}>
                                                            ltr</option>
                                                        <option value="kg"
                                                            {{ old('satuans', $detail['satuans']) == 'kg' ? 'selected' : null }}>
                                                            kg</option>
                                                        <option value="ton"
                                                            {{ old('satuans', $detail['satuans']) == 'ton' ? 'selected' : null }}>
                                                            ton</option>
                                                        <option value="dus"
                                                            {{ old('satuans', $detail['satuans']) == 'dus' ? 'selected' : null }}>
                                                            dus</option>
                                                        <option value="kubik"
                                                            {{ old('satuans', $detail['satuans']) == 'kubik' ? 'selected' : null }}>
                                                            kubik</option>
                                                        <option value="malam"
                                                            {{ old('satuans', $detail['satuans']) == 'malam' ? 'selected' : null }}>
                                                            malam</option>
                                                        <option value="hari"
                                                            {{ old('satuans', $detail['satuans']) == 'hari' ? 'selected' : null }}>
                                                            hari</option>
                                                        <option value="minggu"
                                                            {{ old('satuans', $detail['satuans']) == 'minggu' ? 'selected' : null }}>
                                                            minggu</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="number"
                                                        class="form-control hargasatuan" id="hargasatuan-0"
                                                        name="hargasatuan[]" data-row-id="0"
                                                        value="{{ $detail['hargasatuan'] }}"
                                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">

                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text"
                                                        class="form-control nominal_tambahan" readonly
                                                        id="nominal_tambahan-0" name="nominal_tambahan[]"
                                                        value="{{ number_format($detail['nominal_tambahan'], 0, ',', '.') }}">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="removeBan({{ $loop->index }}, {{ $detail['id'] }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="card" id="form_notabon">
                    <div class="card-header">
                        <h3 class="card-title">Nota Bon Uang Jalan <span>
                            </span></h3>
                        <div class="float-right">
                            <button type="button" class="btn btn-primary btn-sm" onclick="addNotabon()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="font-size:14px" class="text-center">No</th>
                                    <th style="font-size:14px">Kode Nota</th>
                                    <th style="font-size:14px">Nama Driver</th>
                                    <th style="font-size:14px">Nominal</th>
                                    <th style="font-size:14px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-nota">
                                @foreach ($detailnotas as $detail)
                                    <tr id="nota-{{ $loop->index }}">
                                        <td style="width: 70px; font-size:14px" class="text-center" id="urutannota">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td hidden>
                                            <div class="form-group" hidden>
                                                <input type="text" class="form-control"
                                                    id="nomor_seri-{{ $loop->index }}" name="detail_idnotas[]"
                                                    value="{{ $detail['id'] }}">
                                            </div>
                                        </td>
                                        <td hidden>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    id="notabon_ujs_id-{{ $loop->index }}" name="notabon_ujs_id[]"
                                                    value="{{ $detail['notabon_ujs_id'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="notabons({{ $loop->index }})" style="font-size:14px"
                                                    type="text" class="form-control" readonly
                                                    id="kode_nota-{{ $loop->index }}" name="kode_nota[]"
                                                    value="{{ $detail['kode_nota'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="notabons({{ $loop->index }})" style="font-size:14px"
                                                    type="text" class="form-control" readonly
                                                    id="nama_drivernota-{{ $loop->index }}" name="nama_drivernota[]"
                                                    value="{{ $detail['nama_drivernota'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="notabons({{ $loop->index }})" style="font-size:14px"
                                                    type="text" class="form-control"
                                                    id="nominal_nota-{{ $loop->index }}" readonly name="nominal_nota[]"
                                                    value="{{ number_format($detail['nominal_nota'], 0, ',', '.') }}">
                                            </div>
                                        </td>
                                        <td style="width: 100px">
                                            <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
                                                onclick="removeNotabon({{ $loop->index }}, {{ $detail['id'] }})">

                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="notabons({{ $loop->index }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="form-group">
                            <label style="font-size:14px" class="mt-3" for="nopol">Total Nota Bon</label>
                            <input style="font-size:14px" type="text" class="form-control text-right"
                                id="nota_bontambahan" name="nota_bontambahan" readonly placeholder=""
                                value="{{ old('nota_bontambahan', number_format($inquery->nota_bontambahan, 0, ',', '.')) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px" class="mt-3" for="nopol">Grand Total</label>
                            <input style="font-size:14px" type="text" class="form-control text-right"
                                id="grand_total" name="grand_total" readonly placeholder=""
                                value="{{ old('grand_total', number_format($inquery->grand_total, 0, ',', '.')) }}">
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>


            </form>
        </div>

        <div class="modal fade" id="tableMemo" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Memo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="datatables7" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>No. Memo</th>
                                        <th>Tanggal</th>
                                        <th>Nama Sopir</th>
                                        <th>No. Kabin</th>
                                        <th>Rute Perjalanan</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($memos as $memo)
                                        <tr
                                            onclick="getSelectedData('{{ $memo->id }}',
                                                    '{{ $memo->user_id }}',
                                                    '{{ $memo->kode_memo }}',
                                                    '{{ $memo->nama_driver }}',
                                                    '{{ $memo->telp }}',
                                                    '{{ $memo->kendaraan_id }}',
                                                    '{{ $memo->no_kabin }}',
                                                    '{{ $memo->kendaraan->no_pol }}',
                                                    '{{ $memo->nama_rute }}',   
                                                    )">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $memo->kode_memo }}</td>
                                            <td>{{ $memo->tanggal_awal }}</td>
                                            <td>{{ $memo->nama_driver }}</td>
                                            <td>{{ $memo->no_kabin }}</td>
                                            <td>{{ $memo->nama_rute }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData('{{ $memo->id }}',
                                                    '{{ $memo->user_id }}',
                                                    '{{ $memo->kode_memo }}',
                                                    '{{ $memo->nama_driver }}',
                                                    '{{ $memo->telp }}',
                                                    '{{ $memo->kendaraan_id }}',
                                                    '{{ $memo->no_kabin }}',
                                                    '{{ $memo->kendaraan->no_pol }}',
                                                    '{{ $memo->nama_rute }}',   
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

        <div class="modal fade" id="tableNota" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Nota</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="tables" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Nota</th>
                                    <th>Nama Driver</th>
                                    <th>Nominal</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notas as $nota)
                                    <tr onclick="getNota({{ $loop->index }})" data-id="{{ $nota->id }}"
                                        data-kode_nota="{{ $nota->kode_nota }}"
                                        data-nama_drivernota="{{ $nota->nama_driver }}"
                                        data-nominal_nota="{{ $nota->nominal }}" data-param="{{ $loop->index }}"
                                        data-user_id="{{ $nota->user_id }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $nota->kode_nota }}</td>
                                        <td>{{ $nota->karyawan->nama_lengkap ?? null }}</td>
                                        <td>{{ number_format($nota->nominal, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                onclick="getNota({{ $loop->index }})">
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
    </section>


    <script>
        function ShowMemo(selectedCategory) {
            $('#tableMemo').modal('show');
        }

        function getSelectedData(Memo_id, UserId, KodeMemo, NamaSopir, Telp, Kendaraan_id, NoKabin, NoPol, RutePerjalanan) {
            // Set the values in the form fields
            document.getElementById('memo_ekspedisi_id').value = Memo_id;
            document.getElementById('user_id').value = UserId;
            document.getElementById('kode_memosa').value = KodeMemo;
            document.getElementById('nama_driversa').value = NamaSopir;
            document.getElementById('telps').value = Telp;
            document.getElementById('kendaraan_idsa').value = Kendaraan_id;
            document.getElementById('no_kabinsa').value = NoKabin;
            document.getElementById('no_polsa').value = NoPol;
            document.getElementById('nama_rutesa').value = RutePerjalanan;
            // Close the modal (if needed)
            $('#tableMemo').modal('hide');
        }
    </script>


    <script>
        // function updateGrandTotal() {
        //     var grandTotal = 0;

        //     // Loop through all elements with name "nominal_tambahan[]"
        //     $('input[name^="nominal_tambahan"]').each(function() {
        //         var nominalValue = parseFloat($(this).val()) || 0;
        //         grandTotal += nominalValue;
        //     });

        //     // Set the calculated grand total to the input with ID "grand_total"
        //     $('#grand_total').val(grandTotal.toLocaleString(
        //         'id-ID')); // Menggunakan toLocaleString() dengan 'id-ID' sebagai bahasa Indonesia
        // }

        // // Panggil fungsi saat ada perubahan pada input "nominal_tambahan[]"
        // $('body').on('input', 'input[name^="nominal_tambahan"]', function() {
        //     updateGrandTotal();
        // });

        // // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
        // $(document).ready(function() {
        //     updateGrandTotal();
        // });


        function notabons(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableNota').modal('show');
        }

        function getNota(rowIndex) {
            var selectedRow = $('#tables tbody tr:eq(' + rowIndex + ')');
            var Nota_id = selectedRow.data('id');
            var Kode_nota = selectedRow.data('kode_nota');
            var Nama_driversnot = selectedRow.data('nama_drivernota');
            var Nominal = selectedRow.data('nominal_nota');

            $('#notabon_ujs_id-' + activeSpecificationIndex).val(Nota_id);
            $('#kode_nota-' + activeSpecificationIndex).val(Kode_nota);
            $('#nama_drivernota-' + activeSpecificationIndex).val(Nama_driversnot);
            $('#nominal_nota-' + activeSpecificationIndex).val(Nominal.toLocaleString('id-ID'));

            $('#tableNota').modal('hide');
            updateTotalnota()
            updateGrandTotal()
        }

        function updateTotalnota() {
            var grandTotal = 0;

            // Iterate through all input elements with IDs starting with 'total-'
            $('input[id^="nominal_nota-"]').each(function() {
                // Remove dots and replace comma with dot, then parse as float
                var nilaiTotal = parseFloat($(this).val().replace(/\./g, '').replace(',', '.')) || 0;
                grandTotal += nilaiTotal;
            });

            // Format grandTotal as currency in Indonesian Rupiah
            var formattedGrandTotal = grandTotal.toLocaleString('id-ID');
            console.log(formattedGrandTotal);
            // Set the formatted grandTotal to the target element
            $('#nota_bontambahan').val(formattedGrandTotal);
        }



        var data_pembelian = @json(session('data_pembelians4'));
        var jumlah_ban = 1;

        if (data_pembelian != null) {
            jumlah_ban = data_pembelian.length;
            $('#tabel-memotambahan').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelian(urutan, key, value);
            });
        }

        function updateUrutan() {
            var urutan = document.querySelectorAll('#urutantambah');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
        }

        var counter = 0;

        function addMemotambahan() {
            counter++;
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-memotambahan').empty();
            }

            itemPembelian(jumlah_ban, jumlah_ban - 1);
            updateUrutan();
        }

        function removeBan(identifier, detailId) {

            var row = document.getElementById('memotambah-' + identifier);
            row.remove();

            $.ajax({
                url: "{{ url('admin/inquery_memotambahan/deletedetailtambahan/') }}/" + detailId,
                type: "POST",
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Data deleted successfully');
                },
                error: function(error) {
                    console.error('Failed to delete data:', error);
                }
            });

            updateTotalnota()
            updateGrandTotal();
            updateUrutan();
        }

        function itemPembelian(identifier, key, value = null) {
            var keterangan_tambahan = '';
            var qty = '';
            var satuans = '';
            var hargasatuan = '';
            var nominal_tambahan = '';

            if (value !== null) {
                keterangan_tambahan = value.keterangan_tambahan;
                qty = value.qty;
                satuans = value.satuans;
                hargasatuan = value.hargasatuan;
                nominal_tambahan = value.nominal_tambahan;
            }

            // urutan 
            var item_pembelian = '<tr id="memotambah-' + urutan + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutantambah">' + urutan +
                '</td>';


            // keterangan_tambahan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="keterangan_tambahan-' +
                key +
                '" name="keterangan_tambahan[]" value="' + keterangan_tambahan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // qty 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control qty" style="font-size:14px" id="qty-' +
                key +
                '" name="qty[]" value="' + qty + '" ';
            item_pembelian += 'onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46">';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // satuans
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select style="font-size:14px" class="form-control" id="satuans-' + key +
                '" name="satuans[]">';
            item_pembelian += '<option value="">- Pilih -</option>';
            item_pembelian += '<option value="pcs"' + (satuans === 'pcs' ? ' selected' : '') + '>pcs</option>';
            item_pembelian += '<option value="ltr"' + (satuans === 'ltr' ? ' selected' : '') +
                '>ltr</option>';
            item_pembelian += '<option value="kg"' + (satuans === 'kg' ? ' selected' : '') +
                '>kg</option>';
            item_pembelian += '<option value="ton"' + (satuans === 'ton' ? ' selected' : '') +
                '>ton</option>';
            item_pembelian += '<option value="dus"' + (satuans === 'dus' ? ' selected' : '') +
                '>dus</option>';
            item_pembelian += '<option value="kubik"' + (satuans === 'kubik' ? ' selected' : '') +
                '>kubik</option>';
            item_pembelian += '<option value="malam"' + (satuans === 'malam' ? ' selected' : '') +
                '>malam</option>';
            item_pembelian += '<option value="hari"' + (satuans === 'hari' ? ' selected' : '') +
                '>hari</option>';
            item_pembelian += '<option value="minggu"' + (satuans === 'minggu' ? ' selected' : '') +
                '>minggu</option>';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // hargasatuan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="number" class="form-control hargasatuan" style="font-size:14px" id="hargasatuan-' +
                key +
                '" name="hargasatuan[]" value="' + hargasatuan + '" ';
            item_pembelian += 'onkeypress="return event.charCode >= 48 && event.charCode <= 57">';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nominal_tambahan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control nominal_tambahan" readonly style="font-size:14px" id="nominal_tambahan-' +
                key +
                '" name="nominal_tambahan[]" value="' + nominal_tambahan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // opsi 
            item_pembelian += '<td style="width: 50px">';
            item_pembelian +=
                '<button type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
                urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-memotambahan').append(item_pembelian);
        }
    </script>


    <script>
        $(document).on("input", ".hargasatuan, .qty", function() {
            var currentRow = $(this).closest('tr');
            var hargasatuan = parseFloat(currentRow.find(".hargasatuan").val()) || 0;
            var jumlah = parseFloat(currentRow.find(".qty").val()) || 0;
            var harga = hargasatuan * jumlah;
            currentRow.find(".nominal_tambahan").val(harga.toLocaleString('id-ID'));
            updateGrandTotal()
        });
    </script>

    <script>
        function updateGrandTotal() {
            var grandTotal = 0;

            // Loop through all elements with name "nominal_tambahan[]"
            $('input[name^="nominal_tambahan"]').each(function() {
                var nominalValue = parseFloat($(this).val().replace(/\./g, '').replace(',', '.')) || 0;
                grandTotal += nominalValue;
            });
            var Nota_bon = parseFloat($('#nota_bontambahan').val().replace(/\./g, '').replace(',', '.')) || 0;
            var Hasil = grandTotal - Nota_bon;

            $('#grand_total').val(formatRupiahsss(Hasil));

        }

        $('body').on('input', 'input[name^="nominal_tambahan"]', function() {
            updateGrandTotal();
        });

        // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
        $(document).ready(function() {
            updateGrandTotal();
        });

        function formatRupiah(value) {
            return value.toLocaleString('id-ID');
        }

        function formatRupiahsss(number) {
            var formatted = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 1,
                maximumFractionDigits: 1
            }).format(number);
            return '' + formatted;
        }
    </script>


    <script>
        var data_pembeliannota = @json(session('data_pembeliannotas'));
        var jumlah_tambahan = 1;

        if (data_pembeliannota != null) {
            jumlah_tambahan = data_pembeliannota.length;
            $('#tabel-pembelian').empty();
            var urutan = 0;
            $.each(data_pembeliannota, function(key, value) {
                urutan = urutan + 1;
                itemNota(urutan, key, value);
            });
        }

        var counters = 0;

        function addNotabon() {
            counters++;
            jumlah_tambahan = jumlah_tambahan + 1;

            if (jumlah_tambahan === 1) {
                $('#tabel-nota').empty();
            } else {
                // Find the last row and get its index to continue the numbering
                var lastRow = $('#tabel-nota tr:last');
                var lastRowIndex = lastRow.find('#urutannota').text();
                jumlah_tambahan = parseInt(lastRowIndex) + 1;
            }

            console.log('Current jumlah_tambahan:', jumlah_tambahan);
            itemNota(jumlah_tambahan, jumlah_tambahan - 1);
            updateUrutansss();
        }


        function updateUrutansss() {
            var urutan = document.querySelectorAll('#urutannota');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
        }


        function removeNotabon(identifier, detailId) {
            var row = document.getElementById('nota-' + identifier);
            row.remove();

            console.log(detailId);
            $.ajax({
                url: "{{ url('admin/inquery_memoekspedisispk/deletedetailnota/') }}/" + detailId,
                type: "POST",
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Data deleted successfully');
                },
                error: function(error) {
                    console.error('Failed to delete data:', error);
                }
            });

            updateTotalnota()
            updateGrandTotal()
            updateUrutansss();
        }

        function itemNota(identifier, key, value = null) {
            var notabon_ujs_id = '';
            var kode_nota = '';
            var nama_drivernota = '';
            var nominal_nota = '';

            if (value !== null) {
                notabon_ujs_id = value.notabon_ujs_id;
                kode_nota = value.kode_nota;
                nama_drivernota = value.nama_drivernota;
                nominal_nota = value.nominal_nota;

            }

            // urutannota 
            var item_pembelian = '<tr id="nota-' + key + '">';
            item_pembelian += '<td  style="width: 70px; font-size:14px" class="text-center" id="urutannota">' + key +
                '</td>';

            // notabon_ujs_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="notabon_ujs_id-' + key +
                '" name="notabon_ujs_id[]" value="' + notabon_ujs_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_nota 
            item_pembelian += '<td onclick="notabons(' +
                key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_nota-' +
                key +
                '" name="kode_nota[]" value="' + kode_nota + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_drivernota 
            item_pembelian += '<td onclick="notabons(' +
                key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="nama_drivernota-' +
                key +
                '" name="nama_drivernota[]" value="' + nama_drivernota + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nominal_nota 
            item_pembelian += '<td onclick="notabons(' +
                key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="nominal_nota-' +
                key +
                '" name="nominal_nota[]" value="' + nominal_nota + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            //
            item_pembelian += '<td style="width: 100px">';
            item_pembelian +=
                '<button  style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removeNotabon(' +
                key + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian +=
                '<button  style="margin-left:3px" type="button" class="btn btn-primary btn-sm" onclick="notabons(' +
                key +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-nota').append(item_pembelian);
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userIdInput = document.getElementById('user_id');
            const tableNota = document.getElementById('tables');

            // Fungsi untuk memfilter nota
            function filterNotaByUserId() {
                const userId = userIdInput.value;
                const rows = tableNota.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    const rowUserId = row.getAttribute('data-user_id');
                    if (rowUserId === userId || userId === '') {
                        row.style.display = ''; // Tampilkan baris
                    } else {
                        row.style.display = 'none'; // Sembunyikan baris
                    }
                });
            }

            // Filter ulang saat modal ditampilkan
            $('#tableNota').on('show.bs.modal', filterNotaByUserId);

            // Jika `user_id` berubah, filter ulang
            userIdInput.addEventListener('change', filterNotaByUserId);
        });
    </script>

@endsection
