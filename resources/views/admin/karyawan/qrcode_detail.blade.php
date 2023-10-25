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
        margin-top: 40px;
        text-align: center;
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
    }

    .table-container {
        flex: 1;
        margin-right: 20px;
    }

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
            text-align: start;
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
            <a href="#">DETAIL KARYAWAN</a>
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
                                        <th>IDENTITAS KARYAWAN</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    {{-- <tr>
                                        <td width="40%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Foto
                                        </td>
                                        <td width="2%">:</td>
                                        <td>
                                            @if ($karyawan->gambar)
                                                <img src="{{ asset('storage/uploads/' . $karyawan->gambar) }}"
                                                    alt="{{ $karyawan->nama_lengkap }}" class="w-100 rounded border">
                                            @else
                                                <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                                                    height="400" width="200" alt="{{ $karyawan->nama_lengkap }}"
                                                    class="w-100 rounded border">
                                            @endif
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td width="40%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Kode Karyawan
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $karyawan->kode_karyawan }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Nama
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $karyawan->nama_lengkap }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Departemen
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $karyawan->departemen->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            No. KTP
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $karyawan->no_ktp }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            No. SIM
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $karyawan->no_sim }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Gender
                                        </td>
                                        <td width="2%">:</td>
                                        @if ($karyawan->gender == 'L')
                                            <td>Laki-Laki</td>
                                        @else
                                            <td>Perempuan</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Telepon
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $karyawan->telp }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Alamat
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $karyawan->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Tanggal Lahir
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $karyawan->tanggal_lahir }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Tanggal Gabung
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $karyawan->tanggal_gabung }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td width="25%" valign="top" class="textt">
                                            <i data-feather="chevrons-right" height="13" width="13"></i>
                                            Jabatan
                                        </td>
                                        <td width="2%">:</td>
                                        <td>{{ $karyawan->jabatan }}</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


</body>

<script>
    feather.replace()
</script>

</html>
