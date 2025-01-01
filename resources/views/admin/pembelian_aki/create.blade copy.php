@extends('layouts.app')

@section('title', 'Pembelian Aki')

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
    <div class="content-header" style="display: none;" id="mainContent">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pembelian Aki</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pembelian-aki') }}">Transaksi</a></li>
                        <li class="breadcrumb-item active">Pembelian Aki</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content" style="display: none;" id="mainContentSection">
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
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Berhasil!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
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
            <form action="{{ url('admin/pembelian-aki') }}" method="post" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Supplier</h3>
                        <div class="float-right">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group" style="flex: 8;">
                            <label style="font-size:14px" for="supplier_id">Nama Supplier</label>
                            <select class="select2bs4 select22-hidden-accessible" name="supplier_id"
                                data-placeholder="Cari Supplier.." style="width: 100%;" data-select22-id="23" tabindex="-1"
                                aria-hidden="true" id="supplier_id" onchange="getData(0)">
                                <option value="">- Pilih -</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama_supp }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px" for="alamat">Alamat</label>
                            <textarea style="font-size:14px" type="text" class="form-control" readonly id="alamat" name="alamat"
                                placeholder="Masukan alamat">{{ old('alamat') }}</textarea>
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
                                    <th style="font-size:14px" class="text-center">No</th>
                                    <th style="font-size:14px">No Seri</th>
                                    {{-- <th>Ukuran</th> --}}
                                    <th style="font-size:14px">Kondisi Aki</th>
                                    <th style="font-size:14px">Merek</th>
                                    {{-- <th>Type</th> --}}
                                    <th style="font-size:14px">Harga</th>
                                    <th style="font-size:14px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                <tr id="pembelian-0">
                                    <td style="font-size:14px" class="text-center" id="urutan">1</td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="nomor_seri-0" name="no_seri[]">
                                        </div>
                                    </td>

                                    <td style="width: 150px">
                                        <div class="form-group">
                                            <select style="font-size:14px" class="form-control" id="kondisi_aki-0"
                                                name="kondisi_aki[]">
                                                <option value="">- Pilih Kondisi -</option>
                                                <option value="BARU"
                                                    {{ old('kondisi_aki') == 'BARU' ? 'selected' : null }}>
                                                    BARU</option>
                                                <option value="BEKAS"
                                                    {{ old('kondisi_aki') == 'BEKAS' ? 'selected' : null }}>
                                                    BEKAS</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 14px" class="form-group">
                                            <select class="select2bs4 select2-hidden-accessible" name="merek_aki_id[]"
                                                data-placeholder="- Pilih Merek -" style="width: 100%;"
                                                data-select2-id="23" tabindex="-1" aria-hidden="true"
                                                id="merek_aki_id-0">
                                                <option value="">- Pilih Merek -</option>
                                                @foreach ($mereks as $merek_aki_id)
                                                    <option value="{{ $merek_aki_id->id }}">
                                                        {{ $merek_aki_id->nama_merek }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="harga-0" name="harga[]"
                                                onkeypress="return /[0-9,]/.test(event.key)">
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeBan(0)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-right: 20px; margin-left:20px" class="form-group">
                        <label style="font-size:14px" class="mt-3" for="nopol"> Total</label>
                        <input style="font-size:14px" type="text" class="form-control text-right" id="grand_total"
                            name="grand_total" readonly placeholder="" value="{{ old('grand_total') }}">
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div style="margin-right: 20px; margin-left:20px" class="form-group">
                                <input style="font-size:14px" type="text" class="form-control" id="qty_akibekas"
                                    name="qty_akibekas" placeholder="qty aki bekas" value="{{ old('qty_akibekas') }}"
                                    oninput="calculateTotal()">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div style="margin-right: 20px; margin-left:20px" class="form-group">
                                <input style="font-size:14px" type="text" class="form-control" id="harga_akibekas"
                                    name="harga_akibekas" placeholder="harga aki bekas"
                                    value="{{ old('harga_akibekas') }}" oninput="calculateTotal()">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div style="margin-right: 20px; margin-left:20px" class="form-group">
                                <input style="font-size:14px" type="text" class="form-control text-right"
                                    id="total_akibekas" name="total_akibekas" readonly placeholder="total"
                                    value="{{ old('total_akibekas') }}">
                            </div>
                        </div>
                    </div>



                    <div style="margin-right: 20px; margin-left:20px" class="form-group">
                        <label style="font-size:14px" class="mt-3" for="nopol">Grand Total</label>
                        <input style="font-size:14px" type="text" class="form-control text-right" id="total_harga"
                            name="total_harga" readonly placeholder="" value="{{ old('total_harga') }}">
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                        <div id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                        </div>
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
                itemPembelian(urutan, key, false, value);
            });
        }

        function addPesanan() {
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-pembelian').empty();
            }

            itemPembelian(jumlah_ban, jumlah_ban - 1, true);
        }

        function removeBan(params) {
            jumlah_ban = jumlah_ban - 1;

            console.log(jumlah_ban);

            var tabel_pesanan = document.getElementById('tabel-pembelian');
            var pembelian = document.getElementById('pembelian-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_ban === 0) {
                var item_pembelian = '<tr>';
                item_pembelian += '<td class="text-center" colspan="8">- Aki belum ditambahkan -</td>';
                item_pembelian += '</tr>';
                $('#tabel-pembelian').html(item_pembelian);
            } else {
                var urutan = document.querySelectorAll('#urutan');
                for (let i = 0; i < urutan.length; i++) {
                    urutan[i].innerText = i + 1;
                }
            }
            updateGrandTotal();
        }

        function itemPembelian(urutan, key, style, value = null) {
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

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td style="font-size:14px" class="text-center" id="urutan">' + urutan + '</td>';

            // no_seri 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input style="font-size:14px" type="text" class="form-control" id="nomor_seri-' + key +
                '" name="no_seri[]" value="' +
                no_seri +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            // kondisi_aki
            item_pembelian += '<td style="width: 150px">';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select style="font-size:14px" class="form-control" id="kondisi_aki-' + key +
                '" name="kondisi_aki[]">';
            item_pembelian += '<option value="">- Pilih Kondisi -</option>';
            item_pembelian += '<option value="BARU"' + (kondisi_aki === 'BARU' ? ' selected' : '') + '>BARU</option>';
            item_pembelian += '<option value="BEKAS"' + (kondisi_aki === 'BEKAS' ? ' selected' : '') +
                '>BEKAS</option>';
            // merek
            item_pembelian += '<td style="width: 220px">';
            item_pembelian += '<div style="font-size:14px" class="form-group">';
            item_pembelian += '<select  class="form-control select2bs4" id="merek_aki_id-' + key +
                '" name="merek_aki_id[]">';
            item_pembelian += '<option value="">- Pilih Merek -</option>';
            item_pembelian += '@foreach ($mereks as $merek_aki_id)';
            item_pembelian +=
                '<option value="{{ $merek_aki_id->id }}" {{ $merek_aki_id->id == ' + merek_aki_id + ' ? 'selected' : '' }}>{{ $merek_aki_id->nama_merek }}</option>';
            item_pembelian += '@endforeach';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            // harga
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input style="font-size:14px" type="text" class="form-control" onkeypress="return /[0-9,]/.test(event.key)" id="harga-' +
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

            if (style) {
                select2(key);
            }

            $('#tabel-pembelian').append(item_pembelian);

            $('#merek_aki_id-' + key + '').val(merek_aki_id).attr('selected', true);

        }

        function select2(id) {
            $(function() {
                $('#merek_aki_id-' + id).select2({
                    theme: 'bootstrap4'
                });
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            // Tambahkan event listener pada tombol "Simpan"
            $('#btnSimpan').click(function() {
                // Sembunyikan tombol "Simpan" dan "Reset", serta tampilkan elemen loading
                $(this).hide();
                $('#btnReset').hide(); // Tambahkan id "btnReset" pada tombol "Reset"
                $('#loading').show();

                // Lakukan pengiriman formulir
                $('form').submit();
            });
        });
    </script>

    <script>
        function calculateTotal() {
            var qty2 = parseFloat(document.getElementById('qty_akibekas').value) || 0;
            var harga2 = parseFloat(document.getElementById('harga_akibekas').value) || 0;
            var total = qty2 * harga2;
            document.getElementById('total_akibekas').value = total.toFixed(0);
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
            // $('#sub_total').val(grandTotal.toLocaleString('id-ID'));
            // $('#pph2').val(pph2Value.toLocaleString('id-ID'));
            $('#grand_total').val(formatRupiah(grandTotal));
            console.log(grandTotal);
        }

        $('body').on('input', 'input[name^="harga"]', function() {
            updateGrandTotal();
        });

        // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
        $(document).ready(function() {
            updateGrandTotal();
        });

        function formatRupiah(value) {
            return value.toLocaleString('id-ID');
        }
    </script>

@endsection
