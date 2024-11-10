@extends('layouts.app')

@section('title', 'Perbaru Pelanggan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pelanggan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pelanggan') }}">Pelanggan</a></li>
                        <li class="breadcrumb-item active">Perbarui</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

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
            <form action="{{ url('admin/pelanggan/' . $pelanggan->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Pelanggan</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="nama_pell">Nama Pelanggan</label>
                                    <input type="text" class="form-control" id="nama_pell" name="nama_pell"
                                        placeholder="Masukan nama pelanggan"
                                        value="{{ old('nama_pell', $pelanggan->nama_pell) }}">
                                </div>
                                <div class="form-group">
                                    <label for="telp">Telp</label>
                                    <input type="text" class="form-control" id="telp" name="telp"
                                        placeholder="Masukan telp" value="{{ old('telp', $pelanggan->telp) }}">

                                </div>
                                <div class="form-group">
                                    <label for="npwp">No. NPWP</label>
                                    <input type="number" class="form-control" id="npwp" name="npwp"
                                        placeholder="Masukan no npwp" value="{{ old('npwp', $pelanggan->npwp) }}">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat" value="">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div hidden class="form-group">
                                    <label for="karyawan_id">Marketing Id</label>
                                    <input type="text" class="form-control" id="karyawan_id" readonly name="karyawan_id"
                                        placeholder="" value="{{ old('karyawan_id', $pelanggan->karyawan_id) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" class="form-label" for="kode_karyawan">Kode
                                        Marketing</label>
                                    <div class="form-group d-flex">
                                        <input onclick="showCategoryModalMarketing(this.value)" class="form-control"
                                            id="kode_karyawan" name="kode_karyawan" type="text" placeholder=""
                                            value="{{ old('kode_karyawan', $pelanggan->karyawan->kode_karyawan ?? null) }}"
                                            readonly style="margin-right: 10px; font-size:14px" />
                                        <button class="btn btn-primary" type="button"
                                            onclick="showCategoryModalMarketing(this.value)">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="nama_lengkap">Kode Marketing</label>
                                    <input onclick="showCategoryModalMarketing(this.value)" style="font-size:14px"
                                        type="text" class="form-control" id="nama_lengkap" readonly name="nama_lengkap"
                                        placeholder=""
                                        value="{{ old('nama_lengkap', $pelanggan->karyawan->nama_lengkap ?? null) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="telp_karyawan">No. Telp</label>
                                    <input onclick="showCategoryModalMarketing(this.value)" style="font-size:14px"
                                        type="text" class="form-control" id="telp_karyawan" readonly
                                        name="telp_karyawan" placeholder=""
                                        value="{{ old('telp_karyawan', $pelanggan->karyawan->telp ?? null) }}">
                                </div>
                                <div hidden class="form-group">
                                    <label style="font-size:14px" for="alamat_karyawan">Alamat</label>
                                    <input onclick="showCategoryModalMarketing(this.value)" style="font-size:14px"
                                        type="text" class="form-control" id="alamat_karyawan" readonly
                                        name="alamat_karyawan" placeholder=""
                                        value="{{ old('alamat_karyawan', $pelanggan->karyawan->alamat ?? null) }}">
                                </div>
                                <div class="form-group"> <!-- Adjusted flex value -->
                                    <label style="font-size:14px" for="kelompok_pelanggan_id">Kelompok pelanggan</label>
                                    <select class="select2bs4 select2-hidden-accessible" name="kelompok_pelanggan_id"
                                        data-placeholder="Cari Kelompok.." style="width: 100%;" data-select2-id="23"
                                        tabindex="-1" aria-hidden="true" id="kelompok_pelanggan_id">
                                        <option value="">- Pilih -</option>
                                        @foreach ($kelompok_pelanggans as $kelompok_pelanggan)
                                            <option value="{{ $kelompok_pelanggan->id }}"
                                                {{ old('kelompok_pelanggan_id', $pelanggan->kelompok_pelanggan_id) == $kelompok_pelanggan->id ? 'selected' : '' }}>
                                                {{ $kelompok_pelanggan->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- </div> --}}
                </div>
                {{-- <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kotak Person</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama_person" name="nama_person"
                                placeholder="Masukan nama" value="{{ old('nama_person', $pelanggan->nama_person) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan"
                                placeholder="Masukan jabatan" value="{{ old('jabatan', $pelanggan->jabatan) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">No. Telepon</label>
                            <input type="number" class="form-control" id="telp" name="telp"
                                placeholder="Masukan no telepon" value="{{ old('telp', $pelanggan->telp) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Fax</label>
                            <input type="number" class="form-control" id="fax" name="fax"
                                placeholder="Masukan no fax" value="{{ old('fax', $pelanggan->fax) }}">
                        </div>
                        <div class="form-group">
                            <label for="telp">Hp</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                </div>
                                <input type="number" id="hp" name="hp" class="form-control"
                                    placeholder="Masukan nomor hp" value="{{ old('hp', $pelanggan->hp) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama">Email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Masukan email" value="{{ old('email', $pelanggan->email) }}">
                        </div>
                    </div>
                </div> --}}

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Divisi</h3>
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
                                    <th class="text-center">No</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>No. Telp</th>
                                    <th>Fax</th>
                                    <th>Hp</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                @foreach ($details as $detail)
                                    <tr id="pembelian-{{ $loop->index }}">
                                        <td class="text-center" id="urutan"> {{ $loop->index + 1 }}</td>
                                        <td hidden>
                                            <div class="form-group" hidden>
                                                <input type="text" class="form-control" name="detail_ids[]"
                                                    value="{{ $detail['id'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    id="nama_divisi-{{ $loop->index }}" name="nama_divisi[]"
                                                    value="{{ $detail['nama_divisi'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    id="jabatan_divisi-{{ $loop->index }}" name="jabatan_divisi[]"
                                                    value="{{ $detail['jabatan_divisi'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    id="telp_divisi-{{ $loop->index }}" name="telp_divisi[]"
                                                    value="{{ $detail['telp_divisi'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    id="fax_divisi-{{ $loop->index }}" name="fax_divisi[]"
                                                    value="{{ $detail['fax_divisi'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    id="hp_divisi-{{ $loop->index }}" name="hp_divisi[]"
                                                    value="{{ $detail['hp_divisi'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="removePesanan({{ $loop->index }}, {{ $detail['id'] }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr id="alamat-{{ $loop->index }}">
                                        <td colspan="7"> <!-- kolom yang mencakup seluruh baris -->
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <input type="text" class="form-control"
                                                    id="alamat_divisi-{{ $loop->index }}" name="alamat_divisi[]"
                                                    value="{{ $detail['alamat_divisi'] }}">
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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

            <div class="modal fade" id="tableKaryawan" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Data Marketing</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive scrollbar m-2">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead class="bg-200 text-900">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Kode Marketing</th>
                                            <th>Nama Lengkap</th>
                                            <th>Telp</th>
                                            <th>Alamat</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($karyawans as $karyawan)
                                            <tr
                                                onclick="getSelectedDataMarketing('{{ $karyawan->id }}', '{{ $karyawan->kode_karyawan }}', '{{ $karyawan->nama_lengkap }}', '{{ $karyawan->telp }}', '{{ $karyawan->alamat }}')">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $karyawan->kode_karyawan }}</td>
                                                <td>{{ $karyawan->nama_lengkap }}</td>
                                                <td>{{ $karyawan->telp }}</td>
                                                <td>{{ $karyawan->alamat }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="getSelectedDataMarketing('{{ $karyawan->id }}', '{{ $karyawan->kode_karyawan }}', '{{ $karyawan->nama_lengkap }}', '{{ $karyawan->telp }}', '{{ $karyawan->alamat }}')">
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
        function showCategoryModalMarketing(selectedCategory) {
            $('#tableKaryawan').modal('show');
        }

        function getSelectedDataMarketing(Karyawan_id, KodeKaryawan, NamaKaryawan, Telp, Alamat) {

            // Assign the values to the corresponding input fields
            document.getElementById('karyawan_id').value = Karyawan_id;
            document.getElementById('kode_karyawan').value = KodeKaryawan;
            document.getElementById('nama_lengkap').value = NamaKaryawan;
            document.getElementById('telp_karyawan').value = Telp;
            document.getElementById('alamat_karyawan').value = Alamat;

            $('#tableKaryawan').modal('hide');
        }
    </script>

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
            } else {
                // Find the last row and get its index to continue the numbering
                var lastRow = $('#tabel-pembelian tr:last');
                var lastRowIndex = lastRow.find('#urutan').text();
                jumlah_ban = parseInt(lastRowIndex) + 1;
            }

            console.log('Current jumlah_ban:', jumlah_ban);
            itemPembelian(jumlah_ban, jumlah_ban - 1);
            updateUrutan();
        }

        function removePesanan(identifier) {
            var rowData = $('#pembelian-' + identifier); // Baris utama data
            var rowAddress = $('#alamat-' + identifier); // Baris alamat
            var detailId = rowData.find("input[name='detail_ids[]']").val();

            // Hapus kedua baris
            rowData.remove();
            rowAddress.remove();

            // Jika ada detailId, hapus data dari server
            if (detailId) {
                $.ajax({
                    url: "{{ url('admin/pelanggan/delete_detailpelanggan/') }}/" + detailId,
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
            }
        }

        function itemPembelian(identifier, key, value = null) {
            var nama_divisi = '';
            var jabatan_divisi = '';
            var telp_divisi = '';
            var fax_divisi = '';
            var hp_divisi = '';
            var alamat_divisi = '';

            if (value !== null) {
                nama_divisi = value.nama_divisi;
                jabatan_divisi = value.jabatan_divisi;
                telp_divisi = value.telp_divisi;
                fax_divisi = value.fax_divisi;
                hp_divisi = value.hp_divisi;
                alamat_divisi = value.alamat_divisi;
            }


            // urutan 
            var item_pembelian = '<tr id="pembelian-' + key + '">';
            item_pembelian += '<td class="text-center" id="urutan">' + key + '</td>';

            // nama_divisi 
            item_pembelian +=
                '<td><div class="form-group"><input type="text" class="form-control" style="font-size:14px" id="nama_divisi-' +
                key + '" name="nama_divisi[]" value="' + nama_divisi + '"></div></td>';

            // jabatan_divisi 
            item_pembelian +=
                '<td><div class="form-group"><input type="text" class="form-control" style="font-size:14px" id="jabatan_divisi-' +
                key + '" name="jabatan_divisi[]" value="' + jabatan_divisi + '"></div></td>';

            // telp_divisi 
            item_pembelian +=
                '<td><div class="form-group"><input type="text" class="form-control" style="font-size:14px" id="telp_divisi-' +
                key + '" name="telp_divisi[]" value="' + telp_divisi + '"></div></td>';

            // fax_divisi 
            item_pembelian +=
                '<td><div class="form-group"><input type="text" class="form-control" style="font-size:14px" id="fax_divisi-' +
                key + '" name="fax_divisi[]" value="' + fax_divisi + '"></div></td>';

            // hp_divisi  
            item_pembelian +=
                '<td><div class="form-group"><input type="text" class="form-control" style="font-size:14px" id="hp_divisi-' +
                key + '" name="hp_divisi[]" value="' + hp_divisi + '"></div></td>';

            // tombol hapus
            item_pembelian += '<td><button type="button" class="btn btn-danger btn-sm" onclick="removePesanan(' + key +
                ')"><i class="fas fa-trash"></i></button></td>';
            item_pembelian += '</tr>';

            // Alamat divisi
            item_pembelian +=
                '<tr id="alamat-' + key +
                '"><td colspan="7"><div class="form-group"><label>Alamat</label><input type="text" class="form-control" style="font-size:14px" id="alamat_divisi-' +
                key + '" name="alamat_divisi[]" value="' + alamat_divisi + '"></div></td></tr>';


            $('#tabel-pembelian').append(item_pembelian);
        }
    </script>
@endsection
