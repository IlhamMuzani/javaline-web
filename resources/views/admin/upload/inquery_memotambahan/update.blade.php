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
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
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
                            <div class="form-group" hidden>
                                <label for="nopol">Id Memo</label>
                                <input type="text" class="form-control" id="memo_id" name="memo_id"
                                    value="{{ old('memo_id', $inquery->memo->id) }}" readonly placeholder="" value="">
                            </div>
                            <div class="form-group">
                                <label style="font-size:14px" for="nopol">No Memo</label>
                                <input style="font-size:14px" type="text" class="form-control" id="kode_memosa"
                                    name="kode_memosa" readonly placeholder=""
                                    value="{{ old('kode_memosa', $inquery->no_memo) }}">
                            </div>
                            <div class="form-group">
                                <label style="font-size:14px" for="nopol">Nama Sopir</label>
                                <input style="font-size:14px" type="text" class="form-control" name="nama_driversa"
                                    id="nama_driversa" readonly placeholder=""
                                    value="{{ old('nama_driversa', $inquery->nama_driver) }}">
                            </div>
                            <div class="form-group" hidden>
                                <label style="font-size:14px" for="nopol">Telp</label>
                                <input style="font-size:14px" type="text" class="form-control" name="telps"
                                    id="telps" readonly placeholder="" value="{{ old('telps', $inquery->telp) }}">
                            </div>
                            <div class="form-group" hidden>
                                <label style="font-size:14px" style="font-size:14px" for="nama">Kendaraan id</label>
                                <input style="font-size:14px" style="font-size:14px" type="text" class="form-control"
                                    name="kendaraan_idsa" id="kendaraan_idsa" readonly placeholder=""
                                    value="{{ old('kendaraan_idsa', $inquery->kendaraan_id) }}">
                            </div>
                            <div class="form-group">
                                <label style="font-size:14px" style="font-size:14px" for="nama">No Kabin</label>
                                <input style="font-size:14px" style="font-size:14px" type="text" class="form-control"
                                    name="no_kabinsa" id="no_kabinsa" readonly placeholder=""
                                    value="{{ old('no_kabinsa', $inquery->no_kabin) }}">
                            </div>
                            <div class="form-group" hidden>
                                <label style="font-size:14px" style="font-size:14px" for="nama">No Pol</label>
                                <input style="font-size:14px" style="font-size:14px" type="text" class="form-control"
                                    name="no_polsa" id="no_polsa" readonly placeholder=""
                                    value="{{ old('no_polsa', $inquery->no_pol) }}">
                            </div>
                            <div class="form-group">
                                <label style="font-size:14px" for="nama">Rute Perjalanan</label>
                                <input style="font-size:14px" type="text" class="form-control" name="nama_rutesa"
                                    id="nama_rutesa" readonly placeholder=""
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
                                        <th style="font-size:14px">Nominal</th>
                                        {{-- <th style="font-size:14px">Opsi</th> --}}
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
                                                    <input style="font-size:14px" type="number" class="form-control"
                                                        id="nominal_tambahan-0" name="nominal_tambahan[]"
                                                        value="{{ $detail['nominal_tambahan'] }}">
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
                            <div class="form-group">
                                <label style="font-size:14px" class="mt-3" for="nopol">Grand Total</label>
                                <input style="font-size:14px" type="text" class="form-control text-right"
                                    id="grand_total" name="grand_total" readonly placeholder=""
                                    value="{{ old('grand_total', $inquery->grand_total) }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $memo->kode_memo }}</td>
                                            <td>{{ $memo->tanggal_awal }}</td>
                                            <td>{{ $memo->nama_driver }}</td>
                                            <td>{{ $memo->no_kabin }}</td>
                                            <td>{{ $memo->nama_rute }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData('{{ $memo->id }}',
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
    </section>


    <script>
        function ShowMemo(selectedCategory) {
            $('#tableMemo').modal('show');
        }

        function getSelectedData(Memo_id, KodeMemo, NamaSopir, Telp, Kendaraan_id, NoKabin, NoPol, RutePerjalanan) {
            // Set the values in the form fields
            document.getElementById('memo_id').value = Memo_id;
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
        function updateGrandTotal() {
            var grandTotal = 0;

            // Loop through all elements with name "nominal_tambahan[]"
            $('input[name^="nominal_tambahan"]').each(function() {
                var nominalValue = parseFloat($(this).val()) || 0;
                grandTotal += nominalValue;
            });

            // Set the calculated grand total to the input with ID "grand_total"
            $('#grand_total').val(grandTotal.toLocaleString(
                'id-ID')); // Menggunakan toLocaleString() dengan 'id-ID' sebagai bahasa Indonesia
        }

        // Panggil fungsi saat ada perubahan pada input "nominal_tambahan[]"
        $('body').on('input', 'input[name^="nominal_tambahan"]', function() {
            updateGrandTotal();
        });

        // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
        $(document).ready(function() {
            updateGrandTotal();
        });



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

            updateGrandTotal();
            updateUrutan();
        }

        function itemPembelian(identifier, key, value = null) {
            var keterangan_tambahan = '';
            var nominal_tambahan = '';

            if (value !== null) {
                keterangan_tambahan = value.keterangan_tambahan;
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

            // nominal_tambahan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="nominal_tambahan-' +
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

@endsection
