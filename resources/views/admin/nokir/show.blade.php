<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail No. Kir</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
        rel="stylesheet">
    <!-- Feather Icon -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<style>
    :root {
        --primary: #4d70a1;
        --bg: #ffffff;
        --hitam-pudar: #635f5f;
        --black: #000000;
        --abu-abu: #ece6e6;
    }

    .container {
        display: flex;
        justify-content: space-between;
        margin-top: 7rem;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        outline: none;
        border: none;
        text-decoration: none
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: var(--bg);
        color: #000000;
    }

    /* Navbar  */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.4rem 7%;
        background-color: var(--primary);
        border-bottom: 3px solid var(--black);
        position: fixed;
        left: 0;
        right: 0;
        z-index: 999;
    }

    .judul .judul-pertama {
        color: var(--hitam-pudar);
        display: block;
        padding: 0.5rem;
        font-size: 2rem;
        text-align: center
    }

    .cobajudul .judul-pertama1 a {
        color: var(--hitam-pudar);
        display: block;
        padding: 0.5rem;
        font-size: 2rem;
        text-align: center;
        margin-top: 2px
    }

    hr {
        border: none;
        height: 0.2rem;
        margin: 1px 10px;
        background-color: var(--abu-abu);
        width: 98%;
    }

    .judul3 {
        text-align: start;
        margin-left: 5px;
        margin-bottom: 10px;
        font-size: 20px;
        color: #413d3d
    }

    .container {
        display: flex;
        margin-top: 15px;
        margin-left: 10px
    }

    .container11 {
        margin-top: 15px;
        margin-left: 10px
    }

    .container2 {
        display: flex;
        margin-top: 3rem;
        margin-left: 10px
    }

    .container3 {
        display: flex;
        margin-top: 3rem;
    }

    .container4 {
        display: flex;
        margin-top: 0.5rem;
        padding-left: 10px;
        padding-left: 10px;
        text-align: center;

    }

    /* .table-container {
        flex: 1;
        margin-right: 20px;
    } */

    .table-container2 {
        flex: 1;
        margin-right: 20px;
    }

    .gambar {
        justify-content: center;
        align-items: center;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table,
    td,
    th {
        text-align: left;
    }

    .tablee {
        border: 1px solid #ddd;
    }

    .tablee1 {
        border: 1px solid #ddd;
        /* margin-left: 45px */
    }

    table {
        border-collapse: collapse;
        width: 100%;
        background: rgb(249, 250, 252)
    }

    .hasil {
        color: rgb(19, 133, 63)
    }

    .nama {
        text-align: center
    }

    .gambardepan {
        text-align: center;
        justify-content: center;
        align-items: center
    }

    /* Media Queries  */

    /* Laptop  */
    @media (max-width: 1366px) {
        html {
            font-size: 75%;
        }
    }

    /* Table  */

    @media (max-width: 768px) {
        html {
            font-size: 62.5%;
        }

        .judul3 {
            text-align: center;
        }

        .container4 {
            display: flex;
            margin-top: 0.5rem;
            padding-left: 10px;
        }
    }

    /* Handpone  */

    @media (max-width: 450px) {
        html {
            font-size: 55.5%;
        }
    }

    @media (max-width: 768px) {

        .gambardepan img {
            width: 100%;
            /* Mengisi lebar container */
            height: auto;
            /* Menjaga aspek rasio gambar */
        }
    }

    @media screen and (max-width: 600px) {
        .gambardepan img {
            width: 100%;
            /* Agar gambar meresponsif ketika layar diperkecil */
            height: auto;
            /* Biarkan tinggi gambar menyesuaikan agar tidak terdistorsi */
        }
    }

    .container2 {
        display: flex;
        flex-wrap: wrap;
    }

    .table-container {
        width: 50%;
        padding: 10px;
        box-sizing: border-box;
    }

    /* Media Query untuk layar kecil */
    @media screen and (max-width: 768px) {
        .table-container {
            width: 100%;
        }
    }

    .tabelfoto {
        display: flex;
        justify-content: center;
        /* Mengatur perataan horizontal ke tengah */
        align-items: center;
        /* Mengatur perataan vertikal ke tengah */
        margin-top: 15px;
        margin-left: 10px;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .table-container {
        /* width: 48%; */
        /* Menyesuaikan lebar container */
        margin-bottom: 20px;
    }

    /* Media Query untuk layar kecil */
    @media screen and (max-width: 768px) {
        .container {
            flex-direction: column;
            /* Menampilkan elemen dalam satu kolom */
            align-items: center;
            /* Pusatkan elemen secara horizontal */
        }

        .textt {
            padding-left: 5px;
            padding-right: 5px;
        }

        .table-container {
            width: 100%;
            /* Memenuhi lebar layar */
        }
    }

    .responsive-img {
        max-width: 100%;
        height: auto;
    }
</style>

<body>

    {{-- Nabar start  --}}

    <nav class="navbar">

        {{-- Navbar end --}}
    </nav>

    <nav class="judul">
        <div class="judul-pertama">
            <a href="#">.</a>
        </div>
    </nav>

    <div class="cobajudul">
        <div class="judul-pertama1">
            <a href="#">UJI BERKALA KENDARAAN BERMOTOR</a>
        </div>
    </div>

    <hr>

    {{-- Baris Pertama  --}}

    <div class="container">
        <div class="table-container">
            <table class="tablee" width="100%" border="0">
                <tbody>
                    <tr>
                        <td valign="top">
                            <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                                <tbody>
                                    <tr>
                                        <th>IDENTITAS PEMILIK KENDARAAN</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td width="40%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Nama
                                            Pemilik
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->nama_pemilik }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Alamat
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                        </td>
                                        <td width="2%">.</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                        </td>
                                        <td width="2%">.</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                        </td>
                                        <td width="2%">.</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                        </td>
                                        <td width="2%">.</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-container">
            <table class="tablee" width="100%" border="0">
                <tbody>
                    <tr>
                        <td valign="top">
                            <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                                <tbody>
                                    <tr>
                                        <th>IDENTITAS KENDARAAN BERMOTOR</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td width="50%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Nomor Uji Kendaraan
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->nomor_uji_kendaraan }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Nomor Sertifikat Registrasi
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->nomor_sertifikat_kendaraan }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Tanggal Sertifikat Kendaraan
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->tanggal_sertifikat }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Nomor Registrasi Kendaraan
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->kendaraan->no_pol }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Nomor Rangka Kendaraan
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->kendaraan->no_rangka }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Nomor Motor Penggerak
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->kendaraan->no_mesin }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Baris Ke Dua  --}}

    <div class="container4">
        <div class="container11">
            <div class="judul3">
                <h4>Foto Berwarna 4 Sisi Kendaraan</h4>
            </div>
            <hr>
            <table class="tabelfoto" width="100%" border="0">
                <tbody>
                    <tr>
                        <td valign="top">
                            <table>
                                <tbody>
                                    <tr>
                                        <th class="nama">FOTO DEPAN</th>
                                        <th class="nama">FOTO BELAKANG</th>
                                        <th class="nama">FOTO KANAN</th>
                                        <th class="nama">FOTO KIRI</th>
                                    </tr>
                                    <tr>
                                        <td class="gambardepan">
                                            <img src="{{ asset('storage/uploads/' . $nokir->gambar_depan) }}"
                                                height="150" width="300">
                                        </td>
                                        <td class="gambardepan">
                                            <img src="{{ asset('storage/uploads/' . $nokir->gambar_belakang) }}"
                                                height="150" width="300">
                                        </td>
                                        <td class="gambardepan">
                                            <img src="{{ asset('storage/uploads/' . $nokir->gambar_kanan) }}"
                                                height="150" width="300">
                                        </td>
                                        <td class="gambardepan">
                                            <img src="{{ asset('storage/uploads/' . $nokir->gambar_kiri) }}"
                                                height="150" width="300">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Baris Ke 3  --}}

    <div class="container2">
        <div class="table-container">
            <table class="tablee" width="100%" border="0">
                <tbody>
                    <tr>
                        <td valign="top">
                            <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                                <tbody>
                                    <tr>
                                        <th>SPESIFIKASI TEKNIS KENDARAAN</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td width="50%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Jenis
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->jenis_kendaraan }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Merek / Type
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->merek_kendaraan }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Tahun Pembuatan / Perakitan
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->tahun_kendaraan }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Bahan Bakar / Sumber Energi
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->bahan_bakar }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Isi Silinder
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->isi_silinder }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Daya Motor
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->daya_motor }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Ukuran Ban
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->ukuran_ban }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Konfigurasi Sumbu
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->konfigurasi_sumbu }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Berat Kosong Kendaraan
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->berat_kosongkendaraan }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Dimensi utama kendaraan bermotor
                                        </td>
                                        <td width="2%"></td>
                                        <td></td>
                                    </tr>
                            </table>
                            <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                                <tbody>
                                    <tr>
                                        <td width="10%" valign="top" class="textt">
                                            <i data-feather="check-square" height="13" width="13"></i>
                                            Panjang
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->panjang }}</td>
                                        <td valign="top" class="textt">
                                            <i data-feather="check-square" height="13" width="13"></i>
                                            Julur Depan
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->julur_depan }}</td>
                                    </tr>
                                    <tr>
                                        <td width="10%" valign="top">
                                            <i data-feather="check-square" height="13" width="13"></i>
                                            Lebar
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->lebar }}</td>
                                        <td valign="top">
                                            <i data-feather="check-square" height="13" width="13"></i>
                                            Julur Belakang
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->julur_belakang }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="check-square" height="13" width="13"></i>
                                            Tinggi
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->tinggi }}</td>
                                        <td valign="top">
                                        </td>
                                        <td width="2%"></td>
                                        <td></td>
                                    </tr>
                            </table>
                            <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                                <tbody>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Jarak Sumbu
                                        </td>
                                        <td width="2%"></td>
                                        <td></td>
                                    </tr>
                            </table>
                            <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                                <tbody>
                                    <tr>
                                        <td width="50%" valign="top" class="textt">
                                            <i data-feather="check-square" height="13" width="13"></i>
                                            Sumbu I - II
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->sumbu_1_2 }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top">
                                            <i data-feather="check-square" height="13" width="13"></i>
                                            Sumbu II - III
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->sumbu_2_3 }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top">
                                            <i data-feather="check-square" height="13" width="13"></i>
                                            Sumbu III - IV
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->sumbu_3_4 }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Dimensi bak muatan/tangki
                                        </td>
                                        <td width="2%"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top">
                                            <i data-feather="check-square" height="13" width="13"></i>
                                            Panjang x Lebar x Tinggi
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->dimensi_bakmuatan }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            JBB/JBKB
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->jbb }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            JBI/JBKI
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->jbi }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Daya angkut(orang/kg)
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->daya_angkutorang }}</td>
                                    </tr>

                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Kelas jalan terendah yang boleh dilalui
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $nokir->kelas_jalan }}</td>
                                    </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-container">
            <table class="tablee1" width="100%" border="0">
                <tbody>
                    <tr>
                        <td valign="top">
                            <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                                <tbody>
                                    <tr>
                                        <th>Item Uji</th>
                                        <th width="65%">Ambang Batas</th>
                                        <th>Hasil Uji</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            Rem Utama
                                        </td>
                                        <td>Total gaya pengereman >= 50% X total berat sumbu(kg)</td>
                                        <td>6922 kg</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>Selisih gaya pengereman roda kiri dan roda kanan dalam satu
                                            sumbu maksimum 8%</td>
                                        <td>I 0.46% II 0.52 % III 0.27 % IV 0 %</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                        </td>
                                        <td>.</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            Lampu Utama
                                        </td>
                                        <td>Kekuatan pancar lampu utama kanan 12000 cd(lampu jauh) </td>
                                        <td>32000 cd</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                        </td>
                                        <td>Kekuatan pancar lampu utama kiri 12000 cd(lampu jauh) </td>
                                        <td>28300 cd</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                        </td>
                                        <td>Penyimpangan ke kanan 0&deg;34'(lampu jauh) </td>
                                        <td>0'</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                        </td>
                                        <td>Penyimpangan ke kiri 1&deg;09'(lampu jauh)</td>
                                        <td>1'</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                        </td>
                                        <td>.</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            Emisi
                                        </td>
                                        <td>Bahan bakar SOLAR</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                        </td>
                                        <td>Tahun pembuatan >=2010</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                        </td>
                                        <td>JBB>3500kg</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                        </td>
                                        <td>Asap : 50%</td>
                                        <td>39 %</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- Keterangan UJI --}}

            <div class="container3">
                <table class="tablee" width="100%" border="0">
                    <tbody>
                        <tr>
                            <td valign="top">
                                <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                                    <tbody>
                                        <tr>
                                            <th>KETERANGAN HASIL UJI</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td width="55%" valign="top" class="textt">
                                                <i data-feather="chevrons-right" height="13" width="13"></i>
                                                KETERANGAN
                                            </td>
                                            <td width="2%">:</td>
                                            <th class="hasil">{{ $nokir->keterangan }}</th>
                                        </tr>
                                        <tr>
                                            <td width="25%" valign="top" class="textt">
                                                <i data-feather="chevrons-right" height="13" width="13"></i>
                                                Masa berlaku uji berkala
                                            </td>
                                            <td width="2%">:</td>
                                            <td>{{ $nokir->masa_berlaku }}</td>
                                        </tr>
                                        <tr>
                                            <td width="25%" valign="top" class="textt">
                                                <i data-feather="chevrons-right" height="13" width="13"></i>
                                                Nama Petugas Penguji
                                            </td>
                                            <td width="2%">:</td>
                                            <td>{{ $nokir->nama_petugas_penguji }}</td>
                                        </tr>
                                        <tr>
                                            <td width="25%" valign="top" class="textt">
                                                <i data-feather="chevrons-right" height="13" width="13"></i>
                                                NRP Petugas Penguji
                                            </td>
                                            <td width="2%">:</td>
                                            <td>{{ $nokir->nrp_petugas_penguji }}</td>
                                        </tr>
                                        <tr>
                                            <td width="25%" valign="top" class="textt">
                                                <i data-feather="chevrons-right" height="13" width="13"></i>
                                                Nama Kepala Dinas
                                            </td>
                                            <td width="2%">:</td>
                                            <td>{{ $nokir->nama_kepala_dinas }}</td>
                                        </tr>
                                        <tr>
                                            <td width="25%" valign="top" class="textt">
                                                <i data-feather="chevrons-right" height="13" width="13"></i>
                                                Pangkat Kepala Dinas
                                            </td>
                                            <td width="2%">:</td>
                                            <td>{{ $nokir->pangkat_kepala_dinas }}</td>
                                        </tr>
                                        <tr>
                                            <td width="25%" valign="top" class="textt">
                                                <i data-feather="chevrons-right" height="13" width="13"></i>
                                                NIP Kepala Dinas
                                            </td>
                                            <td width="2%">:</td>
                                            <td>{{ $nokir->nip_kepala_dinas }}</td>
                                        </tr>
                                        <tr>
                                            <td width="25%" valign="top" class="textt">
                                                <i data-feather="chevrons-right" height="13" width="13"></i>
                                                Unit Pelaksanaan Teknis Daerah Pengujian
                                            </td>
                                            <td width="2%">:</td>
                                            <td>{{ $nokir->unit_pelaksanaan_teknis }}</td>
                                        </tr>
                                        <tr>
                                            <td width="25%" valign="top" class="textt">
                                                <i data-feather="chevrons-right" height="13" width="13"></i>
                                                Nama Direktur
                                            </td>
                                            <td width="2%">:</td>
                                            <td>{{ $nokir->nama_direktur }}</td>
                                        </tr>
                                        <tr>
                                            <td width="25%" valign="top" class="textt">
                                                <i data-feather="chevrons-right" height="13" width="13"></i>
                                                Pangkat Direktur
                                            </td>
                                            <td width="2%">:</td>
                                            <td>{{ $nokir->pangkat_direktur }}</td>
                                        </tr>
                                        <tr>
                                            <td width="25%" valign="top" class="textt">
                                                <i data-feather="chevrons-right" height="13" width="13"></i>
                                                NIP Direktur
                                            </td>
                                            <td width="2%">:</td>
                                            <td>{{ $nokir->nip_direktur }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</body>

{{-- <div class="container">
    <a href="#" class="blue-button">Kembali</a>
    <a href="{{ url('admin/nokir/cetak-pdfnokir/' . $nokir->id) }}" class="blue-button">Cetak</a>
</div> --}}
<script>
    feather.replace()
</script>

</html>
