<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700;900&display=swap" rel="stylesheet" />

    <title>Detail Supplier</title>

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
        <h1>DETAIL SUPPLIER</h1>
    </div>
    <div class="container">
        <div class="table-container">
            {{-- <table width="100%" border="0"> --}}
            <tbody>
                <tr>
                    <td valign="top">
                        <table border="0" width="100%" style="padding-left: 2px; padding-right: 13px;">
                            <tbody>
                                <tr>
                                    {{-- <div class="judul2">
                                        <h4>DETAIL KENDARAAN</h4>
                                    </div> --}}
                                </tr>
                                <tr>
                                    <td width="40%" valign="top" class="textt">Kode Supplier</td>
                                    <td width="2%">:</td>
                                    <td>{{ $supplier->kode_supplier }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Nama Supplier</td>
                                    <td width="2%">:</td>
                                    <td>{{ $supplier->nama_supp }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Alamat</td>
                                    <td width="2%">:</td>
                                    <td>{{ $supplier->alamat }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Nama</td>
                                    <td width="2%">:</td>
                                    <td>{{ $supplier->nama_person }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Jabatan</td>
                                    <td width="2%">:</td>
                                    <td>{{ $supplier->jabatan }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Telepon</td>
                                    <td width="2%">:</td>
                                    <td>{{ $supplier->telp }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Fax</td>
                                    <td width="2%">:</td>
                                    <td>{{ $supplier->fax }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">HP</td>
                                    <td width="2%">:</td>
                                    <td>+62{{ $supplier->hp }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Email</td>
                                    <td width="2%">:</td>
                                    <td>{{ $supplier->email }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Nama Bank</td>
                                    <td width="2%">:</td>
                                    <td>{{ $supplier->nama_bank }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">Atas Nama</td>
                                    <td width="2%">:</td>
                                    <td>{{ $supplier->atas_nama }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" valign="top" class="textt">No. Rekening</td>
                                    <td width="2%">:</td>
                                    <td>{{ $supplier->norek }}</td>
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
