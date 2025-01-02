@extends('layouts.app')

@section('title', 'Perbarui Pembelian Aki')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Perbarui Pembelian Aki</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery-pembelianaki') }}">Transaksi</a></li>
                        <li class="breadcrumb-item active">Perbarui Pembelian aki</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
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
            <form action="{{ url('admin/inquery-pembelianaki/' . $inquery->id) }}" method="post" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Supplier</h3>
                        <div class="float-right">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div style="font-size: 14px" class="form-group">
                            <label for="supplier_id">Nama Supplier</label>
                            <select class="custom-select form-control" id="supplier_id" name="supplier_id"
                                onchange="getData(0)">
                                <option value="">- Pilih Supplier -</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id', $inquery->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama_supp }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="alamat">Alamat</label>
                            <textarea style="font-size: 14px" type="text" class="form-control" readonly id="alamat" name="alamat"
                                placeholder="Masukan alamat" value="">{{ old('alamat', $inquery->supplier->alamat) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Aki</h3>
                        <div class="float-right">
                            <button type="button" class="btn btn-primary btn-sm" onclick="addPesanan()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="font-size: 14px" class="text-center">No</th>
                                    <th style="font-size: 14px">No Seri</th>
                                    <th style="font-size: 14px">Kondisi Aki</th>
                                    <th style="font-size: 14px">Merek</th>
                                    <th style="font-size: 14px">Harga</th>
                                    <th style="font-size: 14px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                @foreach ($details as $detail)
                                    <tr id="pembelian-{{ $loop->index }}">
                                        <td style="font-size: 14px" class="text-center" id="urutan">
                                            {{ $loop->index + 1 }}</td>
                                        <td style="width: 240px">
                                            <div class="form-group" hidden>
                                                <input type="text" class="form-control" id="nomor_seri-0"
                                                    name="detail_ids[]" value="{{ $detail['id'] }}">
                                            </div>
                                            <div class="form-group">
                                                <input style="font-size: 14px" type="text" class="form-control"
                                                    id="nomor_seri-0" name="no_seri[]" value="{{ $detail['no_seri'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select style="font-size: 14px" class="form-control" id="kondisi_aki-0"
                                                    name="kondisi_aki[]">
                                                    <option value="">- Pilih Kondisi -</option>
                                                    <option value="BARU"
                                                        {{ old('kondisi_aki', $detail['kondisi_aki']) == 'BARU' ? 'selected' : null }}>
                                                        BARU</option>
                                                    <option value="BEKAS"
                                                        {{ old('kondisi_aki', $detail['kondisi_aki']) == 'BEKAS' ? 'selected' : null }}>
                                                        BEKAS</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <select style="font-size: 14px" class="form-control"
                                                        id="merek_aki_id-{{ $loop->index }}" name="merek_aki_id[]">
                                                        <option value="">- Pilih Merek -</option>
                                                        @foreach ($mereks as $merek)
                                                            <option value="{{ $merek->id }}"
                                                                {{ old('merek_aki_id.' . $loop->parent->index, $detail['merek_aki_id']) == $merek->id ? 'selected' : '' }}>
                                                                {{ $merek->nama_merek }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size: 14px" type="text" class="form-control"
                                                    id="harga-0" name="harga[]" value="{{ $detail['harga'] }}"
                                                    onkeypress="return /[0-9,]/.test(event.key)">
                                            </div>
                                        </td>
                                        <td>
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
                    <div style="margin-right: 20px; margin-left:20px" class="form-group">
                        <label style="font-size:14px" class="mt-3" for="nopol">Total</label>
                        <input style="font-size:14px" type="text" class="form-control text-right" id="grand_total"
                            name="grand_total" readonly placeholder=""
                            value="{{ old('grand_total', $inquery->grand_total) }}">
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div style="margin-right: 20px; margin-left:20px" class="form-group">
                                <input style="font-size:14px" type="text" class="form-control" id="qty_akibekas"
                                    onkeypress="return /[0-9.]/.test(event.key)" name="qty_akibekas"
                                    placeholder="qty aki bekas"
                                    value="{{ old('qty_akibekas', $inquery->qty_akibekas) }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div style="margin-right: 20px; margin-left:20px" class="form-group">
                                <input style="font-size:14px" type="text" class="form-control" id="harga_akibekas"
                                    onkeypress="return /[0-9.]/.test(event.key)" name="harga_akibekas"
                                    placeholder="harga aki bekas"
                                    value="{{ old('harga_akibekas', $inquery->harga_akibekas) }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div style="margin-right: 20px; margin-left:20px" class="form-group">
                                <input style="font-size:14px" type="text" class="form-control text-right"
                                    id="total_akibekas" name="total_akibekas" readonly placeholder="total"
                                    value="{{ old('total_akibekas', $inquery->total_akibekas) }}">
                            </div>
                        </div>
                    </div>
                    <div style="margin-right: 20px; margin-left:20px" class="form-group">
                        <label style="font-size:14px" class="mt-3" for="nopol">Grand Total</label>
                        <input style="font-size:14px" type="text" class="form-control text-right" id="total_harga"
                            name="total_harga" readonly placeholder=""
                            value="{{ old('total_harga', $inquery->total_harga) }}">
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <script>
        function getData(id) {
            var supplier_id = document.getElementById('supplier_id');
            $.ajax({
                url: "{{ url('admin/pembelian_ban/supplier') }}" + "/" + supplier_id.value,
                type: "GET",
                dataType: "json",
                success: function(supplier_id) {
                    var alamat = document.getElementById('alamat');
                    alamat.value = supplier_id.alamat;
                },
            });
        }


        var data_pembelian = @json(session('data_pembelians'));
        var jumlah_ban = 1;

        if (data_pembelian != null) {
            jumlah_ban = data_pembelian.length;
            $('#tabel-pembelian').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelian(urutan, key, value);
            });
        }

        function updateUrutan() {
            var urutan = document.querySelectorAll('#urutan');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
        }

        var counter = 0;

        function addPesanan() {
            counter++;
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-pembelian').empty();
            }

            itemPembelian(jumlah_ban, jumlah_ban - 1);

            updateUrutan();
        }


        function removeBan(identifier, detailId) {
            var row = document.getElementById('pembelian-' + identifier);
            row.remove();

            $.ajax({
                url: "{{ url('admin/inquery-pembelianaki/deletedetailaki/') }}/" + detailId,
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
            updateGrandTotal()
            updateUrutan();
        }

        function itemPembelian(identifier, key, value = null) {
            var no_seri = '';
            var merek_aki_id = '';
            var harga = '';
            var kondisi_aki = '';

            if (value !== null) {
                no_seri = value.no_seri;
                merek_aki_id = value.merek_aki_id;
                harga = value.harga;
                kondisi_aki = value.kondisi_aki;
            }

            console.log(no_seri);
            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td style="font-size: 14px" class="text-center" id="urutan">' + urutan + '</td>';
            item_pembelian += '<td style="width: 240px">';

            // no_seri 
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input style="font-size: 14px" type="text" class="form-control" id="nomor_seri-' + key +
                '" name="no_seri[]" value="' +
                no_seri +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kondisi_aki
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select style="font-size: 14px" class="form-control" id="kondisi_aki-' + key +
                '" name="kondisi_aki[]">';
            item_pembelian += '<option value="">- Pilih Kondisi -</option>';
            item_pembelian += '<option value="BARU"' + (kondisi_aki === 'BARU' ? ' selected' : '') + '>BARU</option>';
            item_pembelian += '<option value="BEKAS"' + (kondisi_aki === 'BEKAS' ? ' selected' : '') +
                '>BEKAS</option>';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // merek
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select style="font-size: 14px" class="form-control select2bs4" id="merek_aki_id-' + key +
                '" name="merek_aki_id[]">';
            item_pembelian += '<option value="">- Pilih Merek -</option>';
            item_pembelian += '@foreach ($mereks as $merek_aki_id)';
            item_pembelian +=
                '<option value="{{ $merek_aki_id->id }}" {{ $merek_aki_id->id == ' + merek_aki_id + ' ? 'selected' : '' }}>{{ $merek_aki_id->nama_merek }}</option>';
            item_pembelian += '@endforeach';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';
            item_pembelian += '</td>'

            // harga
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" style="font-size: 14px" class="form-control" onkeypress="return /[0-9,]/.test(event.key)" id="harga-' +
                key +
                '" name="harga[]" value="' +
                harga +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // delete
            item_pembelian += '<td>';
            item_pembelian += '<button type="button" class="btn btn-danger btn-sm" onclick="removeBan(' + urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);


            if (value !== null) {
                $('#nomor_seri-' + key).val(value.no_seri);
                $('#kondisi_aki-' + key).val(value.kondisi_aki);
                $('#merek_aki_id-' + key).val(value.merek_aki_id);
                $('#harga-' + key).val(value.harga);
            }
        }
    </script>

    <script>
        function updateGrandTotal() {
            var grandTotal = 0;

            // Loop through all elements with name "nominal_tambahan[]"
            $('input[name^="harga"]').each(function() {
                var nominalValue = parseFloat($(this).val().replace(/\./g, '').replace(',', '.')) || 0;
                grandTotal += nominalValue;
            });
            var qtyAkibekas = parseFloat($('#qty_akibekas').val().replace('.', ',').replace(/\./g, '').replace(',', '.')) ||
                0;
            var priceAkibekas = parseFloat($('#harga_akibekas').val().replace(/\./g, '').replace(',', '.')) || 0;
            var totalAkibekas = qtyAkibekas * priceAkibekas;
            $('#grand_total').val(formatRupiah(grandTotal));
            $('#total_akibekas').val(formatRupiah(totalAkibekas));
            var totalHarga = grandTotal - totalAkibekas;
            $('#total_harga').val(formatRupiah(totalHarga));
        }

        $('body').on('input', 'input[name^="harga"], #qty_akibekas, #harga_akibekas', function() {
            updateGrandTotal();
        });

        // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
        $(document).ready(function() {
            updateGrandTotal();
        });

        function formatRupiah(value) {
            return value.toLocaleString('id-ID');
        }

        // function formatRupiahsss(number) {
        //     var formatted = new Intl.NumberFormat('id-ID', {
        //         minimumFractionDigits: 1,
        //         maximumFractionDigits: 1
        //     }).format(number);
        //     return '' + formatted;
        // }
    </script>
@endsection
