@extends('layouts.app')

@section('title', 'Nota Bon Uang Jalan')

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
    <!-- Content Header (Page header) -->
    <div class="content-header" style="display: none;" id="mainContent">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Nota Bon Uang Jalan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/nota-bon') }}">Nota Bon Uang Jalan</a>
                        </li>
                        <li class="breadcrumb-item active">Perbarui</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content" style="display: none;" id="mainContentSection">
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    @if (is_array(session('error')))
                        @foreach (session('error') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @else
                        - {{ session('error') }} <br>
                    @endif
                </div>
            @endif

            <form action="{{ url('admin/nota-bon') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui</h3>
                    </div>
                    <div class="card-body">

                        {{-- <div class="form-group">
                            <label class="form-label" for="kategori">Pilih Kategori</label>
                            <select class="form-control" id="kategori" name="kategori">
                                <option value="">- Pilih -</option>
                                <option value="Pengambilan Kasbon"
                                    {{ old('kategori') == 'Pengambilan Kasbon' ? 'selected' : null }}>
                                    Pengambilan Kasbon</option>
                                <option value="Pengembalian Kasbon"
                                    {{ old('kategori') == 'Pengembalian Kasbon' ? 'selected' : null }}>
                                    Pengembalian Kasbon</option>
                            </select>
                        </div> --}}

                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary btn-sm" type="button" onclick="showKaryawan(this.value)">
                                <i class="fas fa-plus mr-2"></i> Pilih Driver
                            </button>
                        </div>

                        <div class="form-group" hidden>
                            <label for="nopol">Id Driver</label>
                            <input type="text" class="form-control" id="karyawan_id" name="karyawan_id"
                                value="{{ old('karyawan_id') }}" readonly placeholder="" value="">
                        </div>
                        <div class="form-group" hidden>
                            <label for="nopol">Id User</label>
                            <input type="text" class="form-control" id="user_id" name="user_id"
                                value="{{ old('user_id') }}" readonly placeholder="" value="">
                        </div>
                        <div class="form-group">
                            <label for="nopol">Kode Driver</label>
                            <input type="text" class="form-control" id="kode_karyawan" name="kode_driver"
                                onclick="showKaryawan(this.value)" readonly placeholder="" value="{{ old('kode_driver') }}">
                        </div>
                        <div class="form-group">
                            <label for="nopol">Nama Driver</label>
                            <input type="text" class="form-control" name="nama_driver" id="nama_lengkap"
                                onclick="showKaryawan(this.value)" readonly placeholder="" value="{{ old('nama_driver') }}">
                        </div>
                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="text" class="form-control format-rupiah" name="nominal" id="nominal"
                                placeholder="" value="{{ old('nominal') }}">
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="alamat">Keterangan</label>
                                <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan') }}</textarea>
                            </div>
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

            </form>
        </div>
        {{-- </div> --}}
        </div>
        <div class="modal fade" id="tableSopir" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Karyawan</h4>
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
                                        <th>Kode Karyawan</th>
                                        <th>Nama Nama Karyawan</th>
                                        <th>Tanggal</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr
                                            onclick="getSelectedData('{{ $sopir->id }}',
                                                    '{{ $sopir->user->first()->id ?? null }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    )">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData('{{ $sopir->id }}',
                                                    '{{ $sopir->user->first()->id ?? null }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
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
        function showKaryawan(selectedCategory) {
            $('#tableSopir').modal('show');
        }

        function getSelectedData(Sopir_id, User_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id').value = Sopir_id;
            document.getElementById('user_id').value = User_id;
            document.getElementById('kode_karyawan').value = KodeSopir;
            document.getElementById('nama_lengkap').value = NamaSopir;
            // Close the modal (if needed)
            $('#tableSopir').modal('hide');
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

    {{-- <script>
        // Fungsi untuk memformat nilai menjadi format Rupiah
        function formatRupiah(value) {
            if (!value) return ''; // Jika nilai kosong, kembalikan string kosong
            return parseInt(value).toLocaleString('id-ID'); // Format ke Rupiah dengan pemisah ribuan
        }

        // Fungsi yang dipanggil saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua elemen dengan kelas 'format-rupiah'
            const inputs = document.querySelectorAll('.format-rupiah');

            inputs.forEach(input => {
                if (input.value) {
                    // Format nilai yang ada di input ke format Rupiah
                    input.value = formatRupiah(input.value);
                }
            });
        });
    </script> --}}

    <script>
        document.getElementById('nominal').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Hapus karakter selain angka
            if (value) {
                e.target.value = new Intl.NumberFormat('id-ID').format(value); // Format angka sesuai format ID
            } else {
                e.target.value = ''; // Kosongkan input jika tidak ada angka
            }
        });
    </script>
@endsection
