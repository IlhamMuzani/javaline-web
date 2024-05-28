@extends('layouts.app')

@section('title', 'Bukti Potong Pajak')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bukti Potong Pajak</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('sales/bukti_potongpajak') }}">Bukti Potong Pajak</a></li>
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
            @if (session('error_barangs') || session('error_pesanans'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    @if (session('error_barangs'))
                        @foreach (session('error_barangs') as $error)
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
            <form action="{{ url('admin/bukti_potongpajak') }}" method="POST" autocomplete="off">
                @csrf
                <div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Bukti Potong Pajak</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group" style="flex: 8;">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label style="font-size:14px" class="form-label" for="kategori">Pilih
                                                Status</label>
                                            <select style="font-size:14px" class="form-control" id="kategori"
                                                name="kategori">
                                                <option value="">- Pilih -</option>
                                                <option value="MASUKAN"
                                                    {{ old('kategori') == 'MASUKAN' ? 'selected' : null }}>
                                                    MASUKAN</option>
                                                <option value="PENGELUARAN"
                                                    {{ old('kategori') == 'PENGELUARAN' ? 'selected' : null }}>
                                                    PENGELUARAN</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label style="font-size:14px" class="form-label" for="kategoris">Pilih
                                                Kategori</label>
                                            <select style="font-size:14px" class="form-control" id="kategoris"
                                                name="kategoris">
                                                <option value="">- Pilih -</option>
                                                <option value="PPH 23"
                                                    {{ old('kategoris') == 'PPH 23' ? 'selected' : null }}>
                                                    PPH 23</option>
                                                <option value="PPN" {{ old('kategoris') == 'PPN' ? 'selected' : null }}>
                                                    PPN</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label style="font-size:14px" class="form-label" for="kategori">Nomor Bukti
                                                Penerimaan</label>
                                            <input class="form-control" type="text"
                                                placeholder="masukkan nomor penerimaan" value="{{ old('nomor_faktur') }}"
                                                name="nomor_faktur">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label style="font-size:14px">Tanggal:</label>
                                        <div class="input-group date" id="reservationdatetime">
                                            <input style="font-size:14px" type="date" id="periode_awal"
                                                name="periode_awal" placeholder="d M Y sampai d M Y"
                                                data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                                value="{{ old('periode_awal') }}" class="form-control datetimepicker-input"
                                                data-target="#reservationdatetime">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Invoice <span>
                                    </span></h3>
                                <div class="float-right">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#modal-barang">
                                        Pilih Invoice
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px" class="text-center">No</th>
                                            <th>Kode tagihan</th>
                                            <th>Tanggal</th>
                                            <th>Nama Pelanggan</th>
                                            <th>PPH</th>
                                            <th style="width: 220px;">Total</th>
                                            <th class="text-center" style="width: 40px;">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-barang">
                                        <tr id="tabel-barang-kosong">
                                            <td class="text-center" colspan="7">
                                                - Belum ada invoice yang dipilih -
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">Grand Total</th>
                                            <th class="text-right" colspan="3"> <!-- Added text-right class -->
                                                <span style="margin-right: 55px" id="span-grand-total">0</span>
                                                <input type="hidden" class="form-control" name="grand_total"
                                                    id="grand-total" value="0">
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                            <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                            <div id="loading" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade" id="modal-barang" data-backdrop="static">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Invoice</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 40px">#</th>
                                        <th>Kode Invoice</th>
                                        <th>Tanggal</th>
                                        <th>Pelanggan</th>
                                        <th class="text-right">PPH</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tagihanEkspedisis as $tagihan)
                                        <tr>
                                            <td class="text-center">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="checkbox-barang-{{ $tagihan->id }}"
                                                        onclick="add_item({{ $tagihan->id }})">
                                                    <label for="checkbox-barang-{{ $tagihan->id }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $tagihan->kode_tagihan }}</td>
                                            <td>{{ $tagihan->tanggal }}</td>
                                            <td>{{ $tagihan->nama_pelanggan }}</td>
                                            <td class="text-right">{{ number_format($tagihan->pph, 2, ',', '.') }}
                                            </td>
                                            <td class="text-right">{{ number_format($tagihan->grand_total, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Selesai</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script>
        var item_id = [];

        function add_item(id) {
            var checkbox = document.getElementById('checkbox-barang-' + id);
            if (checkbox.checked) {
                if (!item_id.includes(id)) {
                    item_id.push(id);
                    $.ajax({
                        url: "{{ url('admin/bukti_potongpajak/get_item') }}" + '/' + id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var urutan = item_id.length;
                            set_item(urutan, data);
                        },
                    });
                }
                if (item_id.length > 0) {
                    $('#tabel-barang-kosong').hide();
                }
            } else {
                delete_item(id);
            }
        }

        function set_item(urutan, data, is_session = false) {
            // Ensure total is fetched correctly from data object
            var kode_tagihan = data.kode_tagihan;
            var tanggal = data.tanggal;
            var nama_pelanggan = data.nama_pelanggan;
            var pph = data.pph;
            var total = is_session ? data.total : data.grand_total; // Correctly fetch the total

            var col = '<tr id="tr-barang-' + data.id + '">';
            col += '<td class="text-center" id="urutan">' + urutan + '</td>';
            col += '<td hidden>';
            col += '<input type="hidden" class="form-control" name="id[]" value="' + data.id + '">';
            col += data.id;
            col += '</td>';
            col += '<td>';
            col += '<input type="hidden" class="form-control" name="kode_tagihan[]" value="' + data.id + '">';
            col += kode_tagihan;
            col += '</td>';
            col += '<td>';
            col += '<input type="hidden" class="form-control" name="tanggal[]" value="' + data.id + '">';
            col += tanggal;
            col += '</td>';
            col += '<td>';
            col += '<input type="hidden" class="form-control" name="nama_pelanggan[]" value="' + data.id + '">';
            col += nama_pelanggan;
            col += '</td>';
            col += '<td class="text-right">';
            col += '<span id="span-pph-' + data.id + '">' + rupiah("" + pph, "Rp") +
                '</span>'; // Correctly format the total
            col += '<input type="hidden" class="form-control total" id="pph-' + data.id + '" name="pph[' + data.id +
                ']" value="' + pph + '">';
            col += '</td>';
            col += '<td class="text-right">';
            col += '<span id="span-total-' + data.id + '">' + rupiah("" + total, "Rp") +
                '</span>'; // Correctly format the total
            col += '<input type="hidden" class="form-control total" id="total-' + data.id + '" name="total[' + data.id +
                ']" value="' + total + '">';
            col += '</td>';
            col += '<td class="text-center">';
            col += '<button type="button" class="btn btn-danger btn-sm" onclick="delete_item(' + data.id + ')">';
            col += '<i class="fas fa-trash"></i>';
            col += '</button>';
            col += '</td>';
            col += '</tr>';

            $('#tabel-barang').append(col);

            set_grand_total(); // Recalculate grand total
        }

        function delete_item(id) {
            $('#tr-barang-' + id).remove();
            item_id = item_id.filter(i => i !== id);

            document.getElementById('checkbox-barang-' + id).checked = false;
            if (item_id.length === 0) {
                $('#tabel-barang-kosong').show();
            } else {
                var urutan = document.querySelectorAll('#urutan');
                for (let i = 0; i < urutan.length; i++) {
                    urutan[i].innerText = i + 1;
                }
            }

            set_grand_total();
        }

        function rupiah(angka) {
            var number_string = angka.toString(),
                split = number_string.split('.'),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }


        function set_grand_total() {
            var grand_total = 0;
            $('#tabel-barang tr').each(function() {
                var totalText = $(this).find('td').eq(6).text().replace(/[^,\d]/g,
                    ''); // Remove non-digit characters
                if (totalText) {
                    var total = parseFloat(totalText.replace(/\./g, '').replace(',',
                        '.')); // Parse float instead of integer
                    if (!isNaN(total)) {
                        grand_total += total;
                    }
                }
            });

            // Format grand total dengan dua digit desimal
            var grand_total_formatted = grand_total.toFixed(2);
            $('#span-grand-total').text(rupiah(grand_total_formatted,
                "Rp")); // Format the grand total with the rupiah function
            $('#grand-total').val(rupiah(grand_total_formatted));
        }

        var data_item = @json(session('data_pembelians'));

        if (data_item !== null) {
            if (data_item.length > 0) {
                $('#tabel-barang-kosong').hide();
                $.each(data_item, function(key, value) {
                    item_id.push(value.id);
                    var urutan = item_id.length;
                    set_item(urutan, value, true);
                });
            }
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
@endsection
