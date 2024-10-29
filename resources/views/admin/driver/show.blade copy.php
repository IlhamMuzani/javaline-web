<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Saldo Deposit Driver</title>
    <style>
    /* * {
            border: 1px solid black;
        } */
    .b {
        border: 1px solid black;
    }

    .table,
    .td {
        /* border: 1px solid black; */
    }

    .table,
    .tdd {
        border: 1px solid white;
    }

    html,
    body {
        margin: 40px;
        padding: 10px;
        font-family: 'DOSVGA', monospace;
        color: black;
    }

    span.h2 {
        font-size: 24px;
        font-weight: 500;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .tdd td {
        border: none;
    }

    .container {
        display: flex;
        justify-content: space-between;
        margin-top: 7rem;
    }

    .blue-button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        text-decoration: none;
        top: 50%;
        border-radius: 5px;
        transform: translateY(-50%);

    }

    .faktur {
        text-align: center
    }

    /* .blue-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 0;
        } */

    .info-container {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        font-size: 16px;
        margin: 5px 0;
    }

    .right-col {
        text-align: right;
    }

    .info-text {
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .info-left {
        text-align: left;
        /* Apply left-align specifically for the info-text class */
    }

    .info-item {
        flex: 1;
    }

    .alamat {
        color: black;
        font-weight: bold;
    }

    .blue-button:hover {
        background-color: #0056b3;
    }

    .nama-pt {
        color: black;
        font-weight: bold;
    }

    .alamat {
        color: black;
        font-weight: bold;
    }

    .info-catatan {
        display: flex;
        flex-direction: row;
        /* Mengatur arah menjadi baris */
        align-items: center;
        /* Posisi elemen secara vertikal di tengah */
        margin-bottom: 2px;
        /* Menambah jarak antara setiap baris */
    }

    .info-catatan2 {
        font-weight: bold;
        margin-right: 5px;
        min-width: 120px;
        /* Menetapkan lebar minimum untuk kolom pertama */
    }

    .tdd1 td {
        text-align: center;
        font-size: 17px;
        position: relative;
        padding-top: 10px;
        /* Sesuaikan dengan kebutuhan Anda */
    }

    .tdd1 td::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        border-top: 1px solid black;
    }

    .info-1 {}

    .label {
        font-size: 17px;
        text-align: center;
        /* Teks menjadi berada di tengah */

    }

    .separator {
        padding-top: 15px;
        /* Atur sesuai kebutuhan Anda */
        text-align: center;
        /* Teks menjadi berada di tengah */

    }

    .separator span {
        display: inline-block;
        border-top: 1px solid black;
        width: 100%;
        position: relative;
        top: -8px;
        /* Sesuaikan posisi vertikal garis tengah */
    }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <div id="logo-container">
        <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="JAVALINE" width="70" height="35">
    </div>
    <br>

    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 23px;">SALDO DEPOSIT SOPIR</span>
        <br>
        <br>
    </div>

    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    </div>
    <?php
    function terbilang($angka)
    {
        $angka = abs($angka); // Pastikan angka selalu positif
        $bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        $hasil = '';
        if ($angka < 12) {
            $hasil = $bilangan[$angka];
        } elseif ($angka < 20) {
            $hasil = terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            $hasil = terbilang($angka / 10) . ' Puluh ' . terbilang($angka % 10);
        } elseif ($angka < 200) {
            $hasil = 'Seratus ' . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $hasil = terbilang($angka / 100) . ' Ratus ' . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $hasil = 'Seribu ' . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $hasil = terbilang($angka / 1000) . ' Ribu ' . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $hasil = terbilang($angka / 1000000) . ' Juta ' . terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $hasil = terbilang($angka / 1000000000) . ' Miliar ' . terbilang($angka % 1000000000);
        } elseif ($angka < 1000000000000000) {
            $hasil = terbilang($angka / 1000000000000) . ' Triliun ' . terbilang($angka % 1000000000000);
        }
        return $hasil;
    }
    ?>
    <table width="100%">
        <tr>
            <td>
                <div class="info-catatan" style="max-width: 230px;">
                    <table>
                        <tr>
                            <td class="info-catatan2">Tanggal</td>
                            <td class="info-item">:</td>
                            <td style="font-weight:bold" class="info-text info-left">
                                <?php echo strftime('%d %B %Y', time()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2">Kode Sopir</td>
                            <td class="info-item">:</td>
                            <td style="font-weight:bold" class="info-text info-left">
                                {{ $cetakpdf->kode_karyawan }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2">Nama Sopir</td>
                            <td class="info-item">:</td>
                            <td style="font-weight:bold" class="info-text info-left">
                                {{ $cetakpdf->nama_lengkap }}

                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2">Nominal</td>
                            <td class="info-item">:</td>
                            <td style="font-weight:bold" class="info-text info-left">
                                Rp.
                                {{ number_format($cetakpdf->tabungan, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2">Terbilang</td>
                            <td class="info-item">:</td>
                            <td style="font-weight:bold" class="info-text info-left">
                                ({{ terbilang($cetakpdf->tabungan) }}
                                Rupiah)</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">

    <br><br><br>
</body>


<div class="container">
    <a href="{{ url('admin/driver') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/driver/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
</div>

</html>@extends('layouts.app')

@section('title', 'Lihat Karyawan')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Karyawan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin/karyawan') }}">Karyawan</a>
                    </li>
                    <li class="breadcrumb-item active">Lihat</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lihat Karyawan</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        {{-- @if ($karyawan->gambar)
                                <img src="{{ asset('storage/uploads/' . $karyawan->gambar) }}"
                        class="w-100 rounded border">
                        @else
                        <img src="{{ asset('storage/uploads/karyawan/user.png') }}" class="w-100 rounded border">
                        @endif --}}
                        {{-- <img src="{{ asset('storage/uploads/' . $karyawan->gambar) }}"
                        alt="{{ $karyawan->nama_lengkap }}" class="w-100 rounded"> --}}
                        @if ($karyawan->gambar)
                        <img src="{{ asset('storage/uploads/' . $karyawan->gambar) }}"
                            alt="{{ $karyawan->nama_lengkap }}" class="w-100 rounded border">
                        @else
                        <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                            alt="{{ $karyawan->nama_lengkap }}" class="w-100 rounded border">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Qr Code</strong>
                            </div>
                            <div class="col-md-4">
                                <div data-toggle="modal" data-target="#modal-qrcode-{{ $karyawan->id }}"
                                    style="display: inline-block;">
                                    {!! DNS2D::getBarcodeHTML("$karyawan->qrcode_karyawan", 'QRCODE', 3, 3) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Kode Karyawan</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->kode_karyawan }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Kode Karyawan</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->nama_lengkap }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Departemen</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->departemen->nama }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>No KTP</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->no_ktp }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>No SIM</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->no_sim }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Gender</strong>
                            </div>
                            <div class="col-md-4">
                                @if ($karyawan->gender == 'L')
                                <td>Laki-Laki</td>
                                @else
                                <td>Perempuan</td>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Telepon</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->telp }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Alamat</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->alamat }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Tanggal Lahir</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->tanggal_lahir }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Tanggal Gabung</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->tanggal_gabung }}
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Jabatan</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->jabatan }}
                    </div>
                </div> --}}
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-qrcode-{{ $karyawan->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Gambar QR Code</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <p>Yakin hapus kendaraan
                                                    <strong>{{ $kendaraan->kode_kendaraan }}</strong>?
                    </p> --}}
                    <div style="text-align: center;">
                        <div style="display: inline-block;">
                            {!! DNS2D::getBarcodeHTML("$karyawan->qrcode_karyawan", 'QRCODE', 15, 15) !!}
                        </div>
                        {{-- <br>
                                                    AE - {{ $karyawan->qrcode_karyawan }} --}}
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        {{-- <form action="{{ url('admin/ban/' . $golongan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Cetak</button>
                        </form> --}}
                        <a href="{{ url('admin/karyawan/cetak-pdf/' . $karyawan->id) }}" class="btn btn-primary btn-sm">
                            <i class=""></i> Cetak
                        </a>
                        {{-- <a href="{{ url('admin/cetak-pdf/' . $golongan->id) }}" target="_blank"
                        class="btn btn-outline-primary btn-sm float-end">
                        <i class="fa-solid fa-print"></i> Cetak PDV
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Dokumen Survei</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    @if ($karyawan->ft_ktp)
                    <img src="{{ asset('storage/uploads/' . $karyawan->ft_ktp) }}" alt="{{ $karyawan->no_ktp }}"
                        height="300px" width="100px" class="w-100 rounded border">
                    @else
                    <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}" alt="{{ $karyawan->no_ktp }}"
                        height="300px" width="100px" class="w-100 rounded border">
                    @endif
                </div>
                <div class="col-md-5">
                    @if ($karyawan->ft_sim)
                    <img src="{{ asset('storage/uploads/' . $karyawan->ft_sim) }}" alt="tidak ada" height="300px"
                        width="100px" class="w-100 rounded border">
                    @else
                    <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}" alt="tidak ada" height="300px"
                        width="100px" class="w-100 rounded border">
                    @endif
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-5">
                    @if ($karyawan->ft_kk)
                    <img src="{{ asset('storage/uploads/' . $karyawan->ft_ktp) }}" alt="tidak ada" height="300px"
                        width="100px" class="w-100 rounded border">
                    @else
                    <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}" alt="tidak ada" height="300px"
                        width="100px" class="w-100 rounded border">
                    @endif
                </div>
                <div class="col-md-5">
                    @if ($karyawan->ft_kk_penjamin)
                    <img src="{{ asset('storage/uploads/' . $karyawan->ft_kk_penjamin) }}" alt="tidak ada"
                        height="300px" width="100px" class="w-100 rounded border">
                    @else
                    <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}" alt="tidak ada" height="300px"
                        width="100px" class="w-100 rounded border">
                    @endif
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-5">
                    @if ($karyawan->ft_skck)
                    <img src="{{ asset('storage/uploads/' . $karyawan->ft_skck) }}" alt="tidak ada" height="300px"
                        width="100px" class="w-100 rounded border">
                    @else
                    <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}" alt="tidak ada" height="300px"
                        width="100px" class="w-100 rounded border">
                    @endif
                </div>
                <div class="col-md-5">
                    @if ($karyawan->ft_surat_pernyataan)
                    <img src="{{ asset('storage/uploads/' . $karyawan->ft_surat_pernyataan) }}" alt="tidak ada"
                        height="300px" width="100px" class="w-100 rounded border">
                    @else
                    <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}" alt="tidak ada" height="300px"
                        width="100px" class="w-100 rounded border">
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    @if ($karyawan->ft_terbaru)
                    <img src="{{ asset('storage/uploads/' . $karyawan->ft_terbaru) }}" alt="tidak ada" height="300px"
                        width="100px" class="w-100 rounded border">
                    @else
                    <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}" alt="tidak ada" height="300px"
                        width="100px" class="w-100 rounded border">
                    @endif
                </div>
                <div class="col-md-5">
                    @if ($karyawan->ft_rumah)
                    <img src="{{ asset('storage/uploads/' . $karyawan->ft_rumah) }}" alt="tidak ada" height="300px"
                        width="100px" class="w-100 rounded border">
                    @else
                    <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}" alt="tidak ada" height="300px"
                        width="100px" class="w-100 rounded border">
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    @if ($karyawan->ft_penjamin)
                    <img src="{{ asset('storage/uploads/' . $karyawan->ft_penjamin) }}" alt="tidak ada" height="300px"
                        width="100px" class="w-100 rounded border">
                    @else
                    <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}" alt="tidak ada" height="300px"
                        width="100px" class="w-100 rounded border">
                    @endif
                </div>
                <div class="col-md-5">

                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-qrcode-{{ $karyawan->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Gambar QR Code</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- <p>Yakin hapus kendaraan
                                                    <strong>{{ $kendaraan->kode_kendaraan }}</strong>?
                        </p> --}}
                        <div style="text-align: center;">
                            <div style="display: inline-block;">
                                {!! DNS2D::getBarcodeHTML("$karyawan->qrcode_karyawan", 'QRCODE', 15, 15) !!}
                            </div>
                            {{-- <br>
                                                    AE - {{ $karyawan->qrcode_karyawan }} --}}
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            {{-- <form action="{{ url('admin/ban/' . $golongan->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Cetak</button>
                            </form> --}}
                            <a href="{{ url('admin/karyawan/cetak-pdf/' . $karyawan->id) }}"
                                class="btn btn-primary btn-sm">
                                <i class=""></i> Cetak
                            </a>
                            {{-- <a href="{{ url('admin/cetak-pdf/' . $golongan->id) }}" target="_blank"
                            class="btn btn-outline-primary btn-sm float-end">
                            <i class="fa-solid fa-print"></i> Cetak PDV
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</section>
@endsection