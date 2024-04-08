@extends('layouts.app')

@section('title', 'Inquery Nota Return Barang')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Nota Return Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_returnekspedisi') }}">Inquery Nota Return
                                Barang</a></li>
                        <li class="breadcrumb-item active">Perbarui</li>
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
            <form action="{{ url('admin/inquery_notareturn/' . $inquery->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui Nota Return Barang</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <label style="font-size:14px" class="form-label" for="kode_penerimaan">Kode Penerimaan Return
                            Barang</label>
                        <div class="form-group">
                            <input class="form-control" hidden id="return_id" name="return_ekspedisi_id" type="text"
                                placeholder="" value="{{ old('return_ekspedisi_id', $inquery->return_ekspedisi_id) }}"
                                readonly style="margin-right: 10px; font-size:14px" />
                            <input class="form-control" id="kode_return" name="kode_return" type="text" placeholder=""
                                value="{{ old('kode_return', $inquery->kode_return) }}" readonly style="font-size:14px" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pelanggan</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group" hidden>
                                    <label for="pelanggan_id">return Id</label>
                                    <input type="text" class="form-control" id="pelanggan_id" readonly
                                        name="pelanggan_id" placeholder=""
                                        value="{{ old('pelanggan_id', $inquery->pelanggan_id) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="kode_pelanggan">Kode Pelanggan</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="kode_pelanggan"
                                        readonly name="kode_pelanggan" placeholder=""
                                        value="{{ old('kode_pelanggan', $inquery->kode_pelanggan) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="nama_pelanggan">Nama Pelanggan</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="nama_pelanggan"
                                        readonly name="nama_pelanggan" placeholder=""
                                        value="{{ old('nama_pelanggan', $inquery->nama_pelanggan) }}">
                                </div>
                                <div class="form-group" hidden>
                                    <div class="form-group">
                                        <label style="font-size:14px" for="alamat_pelanggan">Alamat
                                            return</label>
                                        <input style="font-size:14px" type="text" class="form-control"
                                            id="alamat_pelanggan" readonly name="alamat_pelanggan" placeholder=""
                                            value="{{ old('alamat_pelanggan', $inquery->alamat_pelanggan) }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="telp_pelanggan">No. Telp</label>
                                        <input style="font-size:14px" type="text" class="form-control"
                                            id="telp_pelanggan" readonly name="telp_pelanggan" placeholder=""
                                            value="{{ old('telp_pelanggan', $inquery->telp_pelanggan) }}">
                                    </div>
                                </div>
                                <div class="form-check" style="color:white">
                                    <label class="form-check-label">
                                        .
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Kendaraan</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group" hidden>
                                    <label for="kendaraan_id">Kendaraan Id</label>
                                    <input type="text" class="form-control" id="kendaraan_id" readonly
                                        name="kendaraan_id" placeholder=""
                                        value="{{ old('kendaraan_id', $inquery->kendaraan_id) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="no_kabin">No. Kabin</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="no_kabin"
                                        readonly name="no_kabin" placeholder=""
                                        value="{{ old('no_kabin', $inquery->no_kabin) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="no_pol">No. Mobil</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="no_pol"
                                        readonly name="no_pol" placeholder=""
                                        value="{{ old('no_pol', $inquery->no_pol) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="jenis_kendaraan">Jenis Kendaraan</label>
                                    <input style="font-size:14px" type="text" class="form-control"
                                        id="jenis_kendaraan" readonly name="jenis_kendaraan" placeholder=""
                                        value="{{ old('jenis_kendaraan', $inquery->jenis_kendaraan) }}">
                                </div>
                                <div class="form-check" style="color:white">
                                    <label class="form-check-label">
                                        .
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Sopir</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group" hidden>
                                    <label for="user_id">User Id</label>
                                    <input type="text" class="form-control" id="user_id" readonly name="user_id"
                                        placeholder="" value="{{ old('user_id', $inquery->user_id) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="kode_driver">Kode Sopir</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="kode_driver"
                                        readonly name="kode_driver" placeholder=""
                                        value="{{ old('kode_driver', $inquery->kode_driver) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="nama_driver">Nama Sopir</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="nama_driver"
                                        readonly name="nama_driver" placeholder=""
                                        value="{{ old('nama_driver', $inquery->nama_driver) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="telp">No. Telp</label>
                                    <input style="font-size:14px" type="tex" class="form-control" id="telp"
                                        readonly name="telp" placeholder=""
                                        value="{{ old('telp', $inquery->telp) }}">
                                </div>
                                <div class="form-check" style="color:white">
                                    <label class="form-check-label">
                                        .
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Barang <span>
                            </span></h3>
                        {{-- <div class="float-right">
                            <button type="button" class="btn btn-primary btn-sm" onclick="addPesanan()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div> --}}
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="font-size:14px" class="text-center">No</th>
                                    <th style="font-size:14px">Kode Barang</th>
                                    <th style="font-size:14px">Nama Barang</th>
                                    <th style="font-size:14px">Satuan</th>
                                    <th style="font-size:14px">Jumlah</th>
                                    <th style="font-size:14px">Harga</th>
                                    <th style="font-size:14px">Total</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                @foreach ($details as $detail)
                                    <tr id="pembelian-{{ $loop->index }}">
                                        <td style="width: 70px; font-size:14px" class="text-center" id="urutan">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <div class="form-group" hidden>
                                            <input type="text" class="form-control" id="nomor_seri-0"
                                                name="detail_ids[]" value="{{ $detail['id'] }}">
                                        </div>
                                        <td hidden>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="barang_id-0"
                                                    name="barang_id[]" value="{{ $detail['barang_id'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="kode_barang-0" name="kode_barang[]"
                                                    value="{{ $detail['kode_barang'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="nama_barang-0" name="nama_barang[]"
                                                    value="{{ $detail['nama_barang'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="satuan-0" name="satuan[]"
                                                    value="{{ $detail['satuan'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="number" class="form-control jumlah"
                                                    id="jumlah-0" name="jumlah[]" readonly
                                                    value="{{ $detail['jumlah'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text" class="form-control harga"
                                                    id="harga-0" name="harga[]"
                                                    value="{{ number_format($detail['harga'], 0, ',', '.') }}">

                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text" readonly
                                                    class="form-control total" id="total-0" name="total[]"
                                                    value="{{ number_format($detail['total'], 0, ',', '.') }}">

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label style="font-size:14px; margin-top:5px" for="grand_total">Grand
                                        Total <span style="margin-left:46px">:</span></label>
                                    <input style="text-align: end; margin:right:10px; font-size:14px;" type="text"
                                        class="form-control grand_total" id="grand_total" name="grand_total"
                                        placeholder="" value="{{ old('grand_total') }}">
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </section>

    <script>
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

            // $.ajax({
            //     url: "{{ url('admin/ban/') }}/" + detailId,
            //     type: "POST",
            //     data: {
            //         _method: 'DELETE',
            //         _token: '{{ csrf_token() }}'
            //     },
            //     success: function(response) {
            //         console.log('Data deleted successfully');
            //     },
            //     error: function(error) {
            //         console.error('Failed to delete data:', error);
            //     }
            // });

            updateUrutan();
        }

        function itemPembelian(identifier, key, value = null) {
            var barang_id = '';
            var kode_barang = '';
            var nama_barang = '';
            var satuan = '';
            var jumlah = '';
            var harga = '';
            var total = '';

            if (value !== null) {
                barang_id = value.barang_id;
                kode_barang = value.kode_barang;
                nama_barang = value.nama_barang;
                satuan = value.satuan;
                jumlah = value.jumlah;
                harga = value.harga;
                total = value.total;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + key + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutan">' + key + '</td>';

            // barang_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="barang_id-' + key +
                '" name="barang_id[]" value="' +
                barang_id +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_barang
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="kode_barang-' +
                key + '" name="kode_barang[]" value="' +
                kode_barang +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_barang
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="nama_barang-' +
                key + '" name="nama_barang[]" value="' +
                nama_barang +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            //satuan
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="satuan-' +
                key + '" name="satuan[]" value="' +
                satuan +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // jumlah
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="number" class="form-control jumlah" readonly style="font-size:14px" id="jumlah-' + key +
                '" name="jumlah[]" value="' +
                jumlah +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // harga
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control harga" style="font-size:14px" id="diskon-' + key +
                '" name="harga[]" value="' +
                harga +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // total
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control total" style="font-size:14px" id="total-' + key +
                '" name="total[]" value="' +
                total +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);

        }
    </script>

    <script>
        function Hitung(startingElement) {
            $(document).on("input", startingElement, function() {
                var currentRow = $(this).closest('tr');
                var jumlah = parseFloat(currentRow.find(".jumlah").val()) || 0;

                // Remove dots and parse as float for harga
                var harga = parseFloat(currentRow.find(".harga").val().replace(/\./g, '')) || 0;

                var total = jumlah * harga;
                currentRow.find(".total").val(total.toLocaleString('id-ID'));

                updateGrandTotal();
            });
        }


        function updateGrandTotal() {
            var grandTotal = 0;

            // Loop through all elements with name "total"
            $('input[name^="total"]').each(function() {
                // Remove dots and parse as float
                var nominalValue = parseFloat($(this).val().replace(/\./g, '')) || 0;
                grandTotal += nominalValue;
            });

            // Set the grand total without using toLocaleString
            $('#grand_total').val(grandTotal.toLocaleString('id-ID'));
        }


        $(document).ready(function() {
            Hitung(".jumlah");
            Hitung(".harga");
            updateGrandTotal();
        });
    </script>

@endsection
