<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700;900&display=swap" rel="stylesheet" />

    <title>Detail No. Kir </title>

    <style>
        :root {
            --color-primary: #0096cc;
            --color-primary-dark: #127194;
            --color-primary-dark-2: #004159;

            --color-white: #eee;
            --color-black: #0f0f0f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 5%;
            background-color: var(--color-primary-dark);
        }

        .logo {
            font-size: 20px;
            color: var(--color-white);
        }

        nav ul {
            display: flex;
            align-items: center;
        }

        nav ul li {
            list-style: none;
        }

        nav ul li a {
            padding: 0 20px;
            text-decoration: none;
            font-size: 20px;
            text-transform: capitalize;
            color: var(--color-white);
            transition: all .2s ease;
        }

        nav ul li a:hover {
            color: var(--color-primary);
        }


        .btn {
            font-size: 15px;
            color: var(--color-white);
            text-decoration: none;
            text-transform: capitalize;
            padding: 10px 20px;
            border-radius: 10vh;
            transition: all .2s ease;
        }

        .btn-1 {
            margin-right: 10px;
            background-color: var(--color-primary);
            border: 2px solid transparent;
        }

        .btn-1:hover {
            border: 2px solid var(--color-primary);
            background-color: transparent;
        }

        .btn-2 {
            border: 2px solid var(--color-primary);
        }

        .btn-2:hover {
            border: 2px solid transparent;
            background-color: var(--color-primary);
        }

        .judul {
            margin-top: 10px;
            text-align: center;
            color: rgb(126, 123, 123);
            /* text-decoration: underline; */
            font-size: 13px
        }

        .judul2 {
            margin-top: 20px;
            text-align: start;
            margin-left: 5px;
            margin-bottom: 10px;
            color: #2b2a2a
        }

        .judul3 {
            margin-top: 40px;
            text-align: center;
            margin-left: 5px;
            margin-bottom: 10px;
            color: #2b2a2a
        }

        .judul4 {
            margin-top: 70px;
            text-align: start;
            margin-left: 5px;
            margin-bottom: 10px;
            color: #2b2a2a
        }

        .judul5 {
            margin-top: 10px;
            text-align: start;
            margin-left: 5px;
            margin-bottom: 10px;
            color: #706b6b
        }

        .container {
            display: flex;
            margin-top: 10px;
            margin-left: 10px
        }

        .foto {
            text-align: center margin-top: 10px;
        }

        .table-container {
            flex: 1;
            margin-right: 20px;
        }

        .table-container2 {
            flex: 1;
            margin-right: 20px;
            margin-left: 10px
        }

        /*
        table {
            width: 100%;
            border-collapse: collapse;
        } */

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #fffff;
        }

        table,
        td,
        th {
            border: 1px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background: #f4f6f7
        }

        th,
        td {
            padding: 15px;
        }
    </style>
</head>

<body>
    <header>
        {{-- <div class="logo">Javaline</div> --}}

    </header>

    <div class="judul">
        <h1>UJI BERKALA KENDARAAN BERMOTOR</h1>
    </div>

    <div class="container">
        <div class="table-container">
            {{-- <table width="100%" border="0"> --}}
            <tbody>
                <tr>
                    <td valign="top">
                        <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                            <tbody>
                                {{-- <div class="judul2">
                                        <h4>IDENTITAS PEMILIK KENDARAAN</h4>
                                    </div> --}}
                                <tr>
                                    <div class="judul2">
                                        <h4>IDENTITAS PEMILIK KENDARAAN</h4>
                                    </div>
                                </tr>
                                <tr>
                                    <td width="40%" valign="top" class="textt">Nama Pemilik</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->nama_pemilik }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Alamat</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->alamat }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
            {{-- </table> --}}
        </div>
        <div class="table-container">
            {{-- <table width="100%" border="0"> --}}
            <tbody>
                <tr>
                    <td valign="top">
                        <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                            <tbody>
                                {{-- <div class="judul2">
                                        <h4>IDENTITAS PEMILIK KENDARAAN</h4>
                                    </div> --}}
                                <tr>
                                    <div class="judul2">
                                        <h4>IDENTITAS KENDARAAN BERMOTOR</h4>
                                    </div>
                                </tr>
                                <tr>
                                    <td width="40%" valign="top" class="textt">Nomor Uji Kendaraan</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->nomor_uji_kendaraan }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Nomor Sertifikat Registrasi
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->kendaraan->no_kabin }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Tanggal Sertifikat Kendaraan
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->tanggal_sertifikat }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Nomor Registrasi Kendaraan
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->kendaraan->no_pol }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Nomor Rangka Kendaraan
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->kendaraan->no_rangka }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Nomor Motor Penggerak
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->kendaraan->no_mesin }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
            {{-- </table> --}}
        </div>
    </div>


    {{-- <div class="table-container2">
        <tr>
            <div class="judul3">
                <h4>Foto Berwarna 4 Sisi Kendaraan</h4>
            </div>
        </tr>
        <table>
            <tr>
                <th>Foto Depan</th>
                <th>Foto Belakang</th>
                <th>Foto Kanan</th>
                <th>Foto Kiri</th>
            </tr>
            <tr>
                <td>
                    <img class="" src="{{ asset('storage/uploads/' . $nokir->gambar_depan) }}" height="100"
                        width="200">
                </td>
                <td> <img class="" src="{{ asset('storage/uploads/' . $nokir->gambar_belakang) }}" height="100"
                        width="200"></td>
                <td> <img class="" src="{{ asset('storage/uploads/' . $nokir->gambar_kanan) }}" height="100"
                        width="200"></td>
                <td> <img class="" src="{{ asset('storage/uploads/' . $nokir->gambar_kiri) }}" height="100"
                        width="200"></td>

            </tr>
        </table>
    </div> --}}

    <div class="container">
        <div class="table-container">
            <tr>
                <div class="judul3">
                    <h4>Foto Berwarna 4 Sisi Kendaraan</h4>
                </div>
            </tr>
            <table>
                <tr>
                    <th>Foto Depan</th>
                    <th>Foto Belakang</th>
                    <th>Foto Kanan</th>
                    <th>Foto Kiri</th>
                </tr>
                <tr>
                    <td>
                        <img class="" src="{{ asset('storage/uploads/' . $nokir->gambar_depan) }}" height="100"
                            width="200">
                    </td>
                    <td> <img class="" src="{{ asset('storage/uploads/' . $nokir->gambar_belakang) }}"
                            height="100" width="200"></td>
                    <td> <img class="" src="{{ asset('storage/uploads/' . $nokir->gambar_kanan) }}"
                            height="100" width="200"></td>
                    <td> <img class="" src="{{ asset('storage/uploads/' . $nokir->gambar_kiri) }}" height="100"
                            width="200"></td>

                </tr>
            </table>
        </div>
    </div>

    <div class="container">
        <div class="table-container">
            {{-- <table width="100%" border="0"> --}}
            <tbody>
                <tr>
                    <td valign="top">
                        <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                            <tbody>
                                {{-- <div class="judul2">
                                        <h4>IDENTITAS PEMILIK KENDARAAN</h4>
                                    </div> --}}
                                <tr>
                                    <div class="judul4">
                                        <h4>SPESIFIKASI TEKNIS KENDARAAN BERMOTOR</h4>
                                    </div>
                                </tr>
                                <tr>
                                    <td width="40%" valign="top" class="textt">Jenis</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->jenis_kendaraan }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Merek/Type</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->merek_kendaraan }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Tahun Pembuatan</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->tahun_kendaraan }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Bahan Bakar</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->bahan_bakar }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Isi Silinder</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->isi_silinder }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Daya Motor</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->daya_motor }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Ukuran Ban</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->ukuran_ban }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Konfigurasi Sumbu</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->konfigurasi_sumbu }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Berat Kosong Kendaraan</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->bahan_bakar }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Julur Depan</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->bahan_bakar }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Julur Belakang</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->isi_silinder }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                            <tbody>
                                {{-- <div class="judul2">
                                        <h4>IDENTITAS PEMILIK KENDARAAN</h4>
                                    </div> --}}
                                <tr>
                                    <div class="judul5">
                                        <h4>Dimensi Utama Kendaraan Bermotor</h4>
                                    </div>
                                </tr>
                                <tr>
                                    <td width="40%" valign="top" class="textt">Panjang</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->panjang }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Lebar</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->merek_kendaraan }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Tinggi</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->tahun_kendaraan }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Julur Depan</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->bahan_bakar }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Julur Belakang</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->isi_silinder }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                            <tbody>
                                {{-- <div class="judul2">
                                        <h4>IDENTITAS PEMILIK KENDARAAN</h4>
                                    </div> --}}
                                <tr>
                                    <div class="judul5">
                                        <h4>Jarak Sumbu</h4>
                                    </div>
                                </tr>
                                <tr>
                                    <td width="40%" valign="top" class="textt">Sumbu I - II</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->sumbu_1_2 }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Sumbu II - III</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->sumbu_2_3 }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Sumbu III - IV</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->sumbu_3_4 }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Dimensi Bak Muatan</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->dimensi_bakmuatan }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">JBB / JBKB</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->jbb }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">JBI / JBKI</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->jbi }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Daya Angkut(orang/kg)</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->daya_angkutorang }}</td>
                                </tr>

                                <tr>
                                    <td width="25%" valign="top" class="textt">Kelas jalan terendah yang
                                        boleh dilalui</td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->kelas_jalan }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
            {{-- </table> --}}
        </div>
        <div class="table-container">
            {{-- <table width="100%" border="0"> --}}
            <tbody>
                <tr>
                    <td valign="top">
                        <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                            <tbody>
                                {{-- <div class="judul2">
                                        <h4>IDENTITAS PEMILIK KENDARAAN</h4>
                                    </div> --}}
                                <tr>
                                    <div class="judul4">
                                        <h4>KETERANGAN HASIL UJI</h4>
                                    </div>
                                </tr>
                                <tr>
                                    <td width="40%" valign="top" class="textt">Masa Berlaku Uji Berkala
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->masa_berlaku }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Nama Petugas Penguji
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->nama_petugas_penguji }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">NRP Petugas Penguji
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->nrp_petugas_penguji }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Nama Kepala Dinas
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->nama_kepala_dinas }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Pangkat Kepala Dinas
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->pangkat_kepala_dinas }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">NIP Kepala Dinas
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->nip_kepala_dinas }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Unit Pelaksana Teknis Daerah
                                        Pengujian
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->unit_pelaksanaan_teknis }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Nama Direktur
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->nama_direktur }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Pangkat Direktur
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->pangkat_direktur }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">NIP Direktur
                                    </td>
                                    <td width="2%">:</td>
                                    <td>{{ $nokir->nip_direktur }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
            {{-- </table> --}}
        </div>
    </div>
</body>

</html>
