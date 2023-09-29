<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail No. Kir</title>
</head>

<style>
    body {
        background: #ffffff;
        color: #000000;
    }

    /* Tambahkan CSS untuk row-container */
    .row-container {
        display: flex;
        justify-content: space-between;
    }


    .cobajudul .judul-pertama1 a {
        color: #000000;
        display: block;
        padding: 0.5rem;
        font-size: 10px;
        text-align: center;
        font-weight: bold;
        text-decoration: none;
        /* Menjadikan teks menjadi bold */
    }

    /* CSS untuk container */
    /* CSS untuk container */
    .container {
        display: flex;
        justify-content: space-between;
    }

    /* CSS untuk setiap table-container */
    .table-container {
        width: 48%;
        /* Set the width to 48% to fit two tables side by side with some spacing */
        box-sizing: border-box;
        /* Include padding and border in the width calculation */
        /* border: 1px solid #000; */
        /* Add a border for spacing between tables */
        /* Add padding for spacing within the table container */
    }


    /* CSS untuk menghilangkan border pada sel-sel dengan kelas "no-border" */
    .table-container .tablee .no-border {
        border: none;
    }

    /* CSS untuk sel dengan kelas "textt" */
    .table-container .tablee td.textt {
        border: none;
        /* Menghilangkan border pada sel dengan kelas "textt" */
    }


    .alamat,
    .nama-pt {
        color: black;
        font-weight: bold;
    }

    .label {
        color: black;
        /* Atur warna sesuai kebutuhan Anda */
    }


    .info-catatan {
        border: 1px solid #000;
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

    .judul-pertama2 a {
        color: #000000;
        display: block;
        padding: 0.5rem;
        font-size: 9px;
        text-align: center;
        font-weight: bold;
        /* Menjadikan teks menjadi bold */
        text-decoration: none;
        /* Menghilangkan garis bawah pada tautan */
    }

    .boxed-div {
        border: 1px solid #000;
        text-align: center;

        /* Warna dan ketebalan garis */
        padding: 2px;
        margin-left: 3px;
        margin-right: 3px
            /* Padding untuk memberikan ruang di dalam kotak */
    }

    .image-cell {}

    .gambar {
        text-align: center;
        margin: 0 auto;
        /* Ini akan mengatur margin horizontal otomatis, yang akan membuat tabel berada di tengah */
    }

    .gambar1 {
        text-align: center;
        margin: 0 auto;
        /* Ini akan mengatur margin horizontal otomatis, yang akan membuat tabel berada di tengah */
    }

    .gambar2 {
        text-align: center;
        margin: 0 auto;
        table-layout: auto
            /* Ini akan mengatur margin horizontal otomatis, yang akan membuat tabel berada di tengah */
    }

    .container3 {
        display: flex;
        margin-top: 1rem;
    }

    .tanda {
        text-align: center;
        /* Mengatur tabel agar berada di tengah */
        margin: 0 auto;
        /* Untuk memastikan tabel berada di tengah secara horizontal */
    }

    .judulll {
        font-size: 7px;
        text-align: center;
        color: black;
        margin-left: 40px
            /* Atur warna teks menjadi hitam */
    }

    /* CSS untuk menghilangkan border pada sel-sel dengan kelas "no-border" */
    .judulll .no-border {
        border: none;
    }
</style>

<body>

    <table class="gambar2">
        <tr>
            <td class="image-cell1">
                <img src="{{ asset('storage/uploads/gambar_logo/dinas_perhubungan.jpg') }}" height="40" width="35">
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            {{-- tabel 1 --}}
            <td style="width: 100%">
                <div class="judul1">
                    <table class="judulll">
                        <tr>
                            <td style="font-size: 9px;">
                                <p> <span
                                        style="text-decoration: underline; color: #000000; font-weight: bold; font-family: Arial, sans-serif;">
                                        KARTU UJI BERKALA KENDARAAN BERMOTOR <br>
                                    </span>
                                    <span
                                        style="font-style: italic; color: #000000; font-weight: bold; font-family: Arial, sans-serif;">
                                        VEHICLE PERIODICAL INSPECTION CARD <br>
                                    </span>
                                    <span style="color: #000000; font-weight: bold; font-family: Arial, sans-serif;">
                                        a.n, DIREKTUR JENDRAL PERHUBUNGAN DARAT
                                    </span>
                                    <br>
                                    <span
                                        style="text-decoration: underline; color: #000000; font-weight: bold; font-family: Arial, sans-serif;">
                                        DIREKTUR SARANA TRANSPORTASI JALAN
                                    </span>
                                    <br>
                                    <span
                                        style="font-style: italic; color: #000000; font-weight: bold; font-family: Arial, sans-serif;">
                                        ON BEHALF OF
                                    </span>
                                    <br>
                                    <span
                                        style="font-style: italic; color: #000000; font-weight: bold; font-family: Arial, sans-serif;">
                                        DIRETOR GENERAL OF LAND TRANSPORTATION
                                    </span>
                                    <br>
                                    <span
                                        style="font-style: italic; color: #000000; font-weight: bold; font-family: Arial, sans-serif;">
                                        DIRECTOR OF ROAD TRANSPORT FACILITIES
                                    </span>
                                    <br>
                                    <br>
                                    <span style="text-decoration: underline; color: #000000; font-weight: bold;">
                                        Ir. Danto Restyawan, MT
                                    </span>
                                    <br>
                                    <span style="color: #000000; font-weight: bold;">
                                        Pembina Utama Madya - IV/d
                                    </span>
                                    <br>
                                    <span style="color: #313131; font-weight: bold;">
                                        NIP 19940829 199403 1 003
                                    </span>
                                </p>
                            </td>
                        </tr>
                    </table>

                </div>
            </td>

            {{-- tabel 2 --}}
            <td style="width: 5%;" style="max-width: 230px;">
                <div class="">
                    <table>
                        <tr>
                            <td data-toggle="modal" data-target="#modal-qrcode-{{ $nokir->id }}"
                                style="display: inline-block;">
                                {!! DNS2D::getBarcodeHTML("$nokir->qrcode_kir", 'QRCODE', 2.5, 2.5) !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    {{-- <div class="cobajudul">
        <div class="judul-pertama1">
            <a href="#"> <span style="text-decoration: underline;">
                    KARTU UJI BERKALA KENDARAAN BERMOTOR <br>
                </span>
                <span style="font-style: italic;">
                    VEHICLE PERIODICAL INSPECTION CARD <br>
                </span>
                a.n, DIREKTUR JENDRAL PERHUBUNGAN DARAT <br>
                <span style="text-decoration: underline;">
                    DIREKTUR SARANA TRANSPORTASI JALAN
                </span>
                <br>
                <span style="font-style: italic;">
                    ON BEHALF OF
                </span>
                <br>
                <span style="font-style: italic;">
                    DIRETOR GENERAL OF LAND TRANSPORTATION
                </span>
                <br>
                <span style="font-style: italic;">
                    DIRECTOR OF ROAD TRANSPORT FACILITIES
                </span>
                <br>
                <br>
                <span style="text-decoration: underline;">
                    Ir. Danto Restyawan, MT
                </span>
                <br>
                <span>
                    Pembina Utama Madya - IV/d
                </span>
                <br>
                <span>
                    NIP 19940829 199403 1 003
                </span>
            </a>
        </div>
    </div> --}}
    <table width="100%">
        <tr>
            {{-- tabel 1 --}}
            <td style="width: 55%; max-width: 230px;">
                <div class="info-catatan">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 8px;">
                                IDENTITAS PEMILIK KENDARAAN BERMOTOR<br>
                                <span
                                    style="font-size: 8px; font-style: italic; color: #666; font-weight: normal; text-align: left;">VEHICLE
                                    OWNER IDENTIFICATION</span>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 8px;">
                                Nama Pemilik <br>
                                <span
                                    style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">Owner's
                                    name</span>
                            </td>
                            <td class="info-item" style="font-size: 8px; font-weight: bold;">:</td>
                            <td class="info-text info-left" style="font-size: 8px; font-weight: bold;">
                                PT JAVALINE LOGISTICS
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 8px;">
                                Alamat Pemilik <br>
                                <span
                                    style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">Owner's
                                    address</span>
                            </td>
                            <td class="info-item" style="font-size: 8px; font-weight: bold;">:</td>
                            <td class="info-text info-left"
                                style="font-size: 8px; font-weight: bold; margin-bottom: 8px;">
                                JL HOS COKROAMINOTO NO 5 06/03 <br>
                                SLAWI WETAN KAB. TEGAL
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 8px;">
                                <br>
                                <span
                                    style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;"></span>
                            </td>
                            <td class="info-item" style="font-size: 8px; font-weight: bold;"></td>
                            <td class="info-text info-left"
                                style="font-size: 8px; font-weight: bold; margin-bottom: 8px;">

                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 8px;">
                                <br>
                                <span
                                    style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;"></span>
                            </td>
                            <td class="info-item" style="font-size: 8px; font-weight: bold;"></td>
                            <td class="info-text info-left"
                                style="font-size: 8px; font-weight: bold; margin-bottom: 8px;">

                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 8px;">
                                <br>
                                <span
                                    style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;"></span>
                            </td>
                            <td class="info-item" style="font-size: 8px; font-weight: bold;"></td>
                            <td class="info-text info-left"
                                style="font-size: 8px; font-weight: bold; margin-bottom: 8px;">

                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 8px;">
                                <br>
                                <span
                                    style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;"></span>
                            </td>
                            <td class="info-item" style="font-size: 8px; font-weight: bold;"></td>
                            <td class="info-text info-left"
                                style="font-size: 8px; font-weight: bold; margin-bottom: 8px;">

                            </td>
                        </tr>

                        <tr>
                            <td class="info-catatan2" style="font-size: 8px;">
                                <br> <br><span
                                    style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">
                                    <br>

                                </span>
                            </td>
                            <td class="info-item" style="font-size: 8px;"></td>
                            <td class="info-text info-left" style="font-size: 8px; font-weight: bold;">

                            </td>
                        </tr>
                    </table>
                </div>
            </td>

            {{-- tabel 2 --}}
            <td style="width: 70%;" style="max-width: 230px;">
                <div class="info-catatan">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 8px;">IDENTITAS KENDARAAN BERMOTOR<br> <span
                                    style="font-size: 8px; font-style: italic; color: #666; font-weight: normal; text-align: left;">VEHICLE
                                    OWNER
                                    IDENTIFICATION</span></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 8px;">Nomor dan tanggal Sertifikat
                                <br> registrasi uji tipe <br><span
                                    style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">
                                    Number and date of vehicle type approval <br>
                                    registration certificate
                                </span>
                            </td>
                            <td class="info-item" style="font-size: 8px;">:</td>
                            <td class="info-text info-left" style="font-size: 8px; font-weight: bold;">
                                {{ $nokir->nomor_sertifikat_kendaraan }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 8px;">Nomor registrasi kendaraan
                                <br><span
                                    style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">Vehicle
                                    registation number</span>
                            </td>
                            <td class="info-item" style="font-size: 8px;">:</td>
                            <td class="info-text info-left" style="font-size: 8px; font-weight: bold;">
                                {{ $nokir->kendaraan->no_pol }}
                            </td>
                        </tr>

                        <tr>
                            <td class="info-catatan2" style="font-size: 8px;">Nomor rangka kendaraan
                                <br><span
                                    style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">Chassis
                                    member
                                </span>
                            </td>
                            <td class="info-item" style="font-size: 8px;">:</td>
                            <td class="info-text info-left" style="font-size: 8px; font-weight: bold;">
                                {{ $nokir->no_rangka }}
                            </td>
                        </tr>

                        <tr>
                            <td class="info-catatan2" style="font-size: 8px;">Nomor motor penggerak
                                <br><span
                                    style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">Engine
                                    member</span>
                            </td>
                            <td class="info-item" style="font-size: 8px;">:</td>
                            <td class="info-text info-left" style="font-size: 8px; font-weight: bold;">
                                {{ $nokir->no_mesin }}
                            </td>
                        </tr>

                        <tr>
                            <td class="info-catatan2" style="font-size: 8px;">Nomor uji kendaraan
                                <br><span
                                    style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">Vehicle
                                    inspection number</span>
                            </td>
                            <td class="info-item" style="font-size: 8px;">:</td>
                            <td class="info-text info-left" style="font-size: 8px; font-weight: bold;">
                                {{ $nokir->nomor_uji_kendaraan }}
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <div class="cobajudul">
        <div class="judul-pertama2">
            <a href="#">Foto Berwarna kendaraan :</a>
        </div>
    </div>
    <div class="boxed-div">
        <table class="gambar">
            <tr>
                <td class="image-cell">
                    <p style="font-size: 8px; font-weight: bold;">Foto Depan <br> <span
                            style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">
                            Image Front</span></p>
                    </p>
                    <img src="{{ asset('storage/uploads/' . $nokir->gambar_depan) }}" height="50" width="100">
                </td>
                <td class="image-cell">
                    <p style="font-size: 8px; font-weight: bold;">Foto Belakang <br> <span
                            style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">
                            Image Rear</span></p>
                    </p>
                    <img src="{{ asset('storage/uploads/' . $nokir->gambar_belakang) }}" height="50"
                        width="100">
                </td>
                <td class="image-cell">
                    <p style="font-size: 8px; font-weight: bold;">Foto Kanan <br> <span
                            style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">
                            Image Right</span></p>
                    </p>
                    <img src="{{ asset('storage/uploads/' . $nokir->gambar_kanan) }}" height="50" width="100">
                </td>
                <td class="image-cell">
                    <p style="font-size: 8px; font-weight: bold;">Foto Kiri <br> <span
                            style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">
                            Image Left</span></p>
                    <img src="{{ asset('storage/uploads/' . $nokir->gambar_kiri) }}" height="50" width="100">
                </td>
            </tr>
        </table>
    </div>

    <table width="100%">
        <tr>
            {{-- tabel 1 --}}
            <td style="width: 55%; max-width: 230px;">
                <div class="info-catatan">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                SPESIFIKASI TEKNIS KENDARAAN<br>
                                <span
                                    style="font-size: 6px; font-style: italic; color: #666; font-weight: normal; text-align: left;">VEHICLE
                                    TECHNICAL SPECIFICATIONS</span>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Jenis <br>
                                <span
                                    style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">Purpase
                                    of vehicle
                                </span>
                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left" style="font-size: 7px; font-weight: bold;">
                                {{ $nokir->jenis_kendaraan }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Merek/tipe <br>
                                <span
                                    style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">Brand/type
                                </span>
                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left" style="font-size: 7px; font-weight: bold;">
                                {{ $nokir->merek_kendaraan }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Tahun pembuatan/perakitan <br>
                                <span
                                    style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">Year
                                    manufactured assembled
                                </span>
                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left" style="font-size: 7px; font-weight: bold;">
                                {{ $nokir->tahun_kendaraan }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Bahan bakar/sumber energi <br>
                                <span style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">
                                    Fuel/energy source
                                </span>
                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left" style="font-size: 7px; font-weight: bold;">
                                {{ $nokir->bahan_bakar }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Isi silinder <br>
                                <span style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">
                                    Engine capacity
                                </span>
                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left" style="font-size: 7px; font-weight: bold;">
                                {{ $nokir->isi_silinder }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Daya motor <br>
                                <span style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">
                                    Engine Power
                                </span>
                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left" style="font-size: 7px; font-weight: bold;">
                                {{ $nokir->daya_motor }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Ukuran ban <br>
                                <span style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">
                                    Tyre size
                                </span>
                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left" style="font-size: 7px; font-weight: bold;">
                                {{ $nokir->ukuran_ban }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Konfigurasi sumbu<br>
                                <span style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">
                                    Axle configuration
                                </span>
                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left" style="font-size: 7px; font-weight: bold;">
                                {{ $nokir->konfigurasi_sumbu }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Berat kosong kendaraan<br>
                                <span style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">
                                    Curb weight
                                </span>
                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left" style="font-size: 7px; font-weight: bold;">
                                {{ $nokir->berat_kosongkendaraan }}
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Dimensi utama kendaraan bermotor(Vechicle main dimension)
                            </td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <!-- First column (Nama PT) -->
                            <td style="width: 48%; max-width: 230px;">
                                <div>
                                    <table>
                                        <tr>
                                            <td class="info-catatan2" style="font-size: 7px;">
                                                Panjang <br>
                                                <span
                                                    style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">
                                                    Length</span>
                                            </td>
                                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                                            <td class="info-text info-left"
                                                style="font-size: 7px; font-weight: bold;">
                                                {{ $nokir->panjang }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="info-catatan2" style="font-size: 7px;">
                                                Lebar <br>
                                                <span
                                                    style="font-size: 10p8pxx; font-style: italic; color: #666; font-weight: normal;">Width</span>
                                            </td>
                                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                                            <td class="info-text info-left"
                                                style="font-size: 7px; font-weight: bold;">
                                                {{ $nokir->lebar }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="info-catatan2" style="font-size: 7px;">
                                                Tinggi <br>
                                                <span
                                                    style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">Height</span>
                                            </td>
                                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                                            <td class="info-text info-left"
                                                style="font-size: 7px; font-weight: bold;">
                                                {{ $nokir->tinggi }}
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </td>

                            <!-- Second column (Nama Supplier) -->
                            <td style="width: 70%;" style="max-width: 230px;">
                                <div>
                                    <table>
                                        <tr>
                                            <td class="info-catatan2" style="font-size: 7px;">
                                                Julur depan <br>
                                                <span
                                                    style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">
                                                    Front overhang</span>
                                            </td>
                                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                                            <td class="info-text info-left"
                                                style="font-size: 7px; font-weight: bold;">
                                                {{ $nokir->julur_depan }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="info-catatan2" style="font-size: 7px;">
                                                Julur belakang <br>
                                                <span
                                                    style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">Rear
                                                    overhang</span>
                                            </td>
                                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                                            <td class="info-text info-left"
                                                style="font-size: 7px; font-weight: bold; margin-bottom: 6px;">
                                                {{ $nokir->julur_belakang }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="info-catatan2" style="font-size: 7px;">
                                                <br>
                                                <span
                                                    style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;"></span>
                                            </td>
                                            <td class="info-item" style="font-size: 7px; font-weight: bold;"></td>
                                            <td class="info-text info-left"
                                                style="font-size: 7px; font-weight: bold; margin-bottom: 6px;">

                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Jarak sumbu <span
                                    style="font-size: 6px; font-style: italic; color: #666; font-weight: normal; text-align: left;">
                                    Wheel base</span>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Sumbu I-II <br>
                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left" style="font-size: 7px; font-weight: bold;">
                                {{ $nokir->sumbu_1_2 }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Sumbu II-III <br>

                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left"
                                style="font-size: 7px; font-weight: bold; margin-bottom: 6px;">
                                {{ $nokir->sumbu_2_3 }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Sumbu III-IV <br>
                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left"
                                style="font-size: 7px; font-weight: bold; margin-bottom: 6px;">
                                {{ $nokir->sumbu_3_4 }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Dimensi bak muatan/tangki<br>
                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left"
                                style="font-size: 7px; font-weight: bold; margin-bottom: 6px;">
                                {{ $nokir->dimensi_bakmuatan }}
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Dimensi of cargo tub(lenght x width height)
                            </td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <!-- First column (Nama PT) -->
                            <td style="width: 48%; max-width: 230px;">
                                <div>
                                    <table>
                                        <tr>
                                            <td class="info-catatan2" style="font-size: 7px;">
                                                JBB/JBKB <br>
                                                <span
                                                    style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">GVWGVCW</span>
                                            </td>
                                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                                            <td class="info-text info-left"
                                                style="font-size: 7px; font-weight: bold;">
                                                {{ $nokir->jbb }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>

                            <!-- Second column (Nama Supplier) -->
                            <td style="width: 70%;" style="max-width: 230px;">
                                <div>
                                    <table>
                                        <tr>
                                            <td class="info-catatan2" style="font-size: 7px;">
                                                JBI/JBKI<br>
                                                <span
                                                    style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">
                                                    PVW/PVCW</span>
                                            </td>
                                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                                            <td class="info-text info-left"
                                                style="font-size: 7px; font-weight: bold;">
                                                {{ $nokir->jbi }}
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Daya angkut(orang/kg) <br>
                                <span
                                    style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">Purpase
                                    Payload (person(s)/kg(s))
                                </span>
                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left" style="font-size: 7px; font-weight: bold;">
                                {{ $nokir->daya_angkutorang }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                Kelas jalan terendah yang boleh dilalui <br>
                                <span
                                    style="font-size: 6px; font-style: italic; color: #666; font-weight: normal;">Purpase
                                    Lowers road class permitted
                                </span>
                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;">:</td>
                            <td class="info-text info-left"
                                style="font-size: 7px; font-weight: bold; margin-bottom: 6px;">
                                {{ $nokir->kelas_jalan }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 7px;">
                                <br>

                            </td>
                            <td class="info-item" style="font-size: 7px; font-weight: bold;"></td>
                            <td class="info-text info-left"
                                style="font-size: 7px; font-weight: bold; margin-bottom: 6px;">

                            </td>
                        </tr>
                    </table>
                </div>
            </td>

            {{-- tabel 2 --}}
            <td style="width: 70%;" style="max-width: 230px;">
                <div class="info-catatan">
                    <div class="table-container">
                        <table class="tablee" width="100%" border="0">
                            <tbody>
                                <tr>
                                    <td valign="top">
                                        <table border="0" width="100%"
                                            style="padding-left: 2px; padding-right: 6px;">
                                            <tbody>
                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 9px;">
                                                        Item Uji <br>
                                                        <span
                                                            style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">
                                                            Testing
                                                        </span>
                                                    </td> hr
                                                    <td class="info-catatan2" style="font-size: 9px;">
                                                        Ambang batas <br>
                                                        <span
                                                            style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">
                                                            Thresshold
                                                        </span>
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 9px;">
                                                        Hasil Uji <br>
                                                        <span
                                                            style="font-size: 8px; font-style: italic; color: #666; font-weight: normal;">
                                                            Test result
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 8px;">
                                                        Rem Utama <br>
                                                        <span
                                                            style="font-size: 7px; font-style: italic; color: #666; font-weight: normal;">
                                                            Brake
                                                        </span>
                                                    </td>
                                                    <td class="info-catatan2"
                                                        style="font-size: 9px; color: #666; font-weight: normal;">
                                                        Total gaya pengereman >= 50%<br>
                                                        x total berat sumbu(kg)
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 8px;">
                                                        : 6922 kg <br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 8px;">
                                                        Lampu Utama <br>
                                                        <span
                                                            style="font-size: 7px; font-style: italic; color: #666; font-weight: normal;">
                                                            Head Lamp
                                                        </span>
                                                    </td>
                                                    <td class="info-catatan2"
                                                        style="font-size: 9px; color: #666; font-weight: normal;">
                                                        Kekuatan pancar lampu utama <br>
                                                        kanan 1200cd(lampu jauh)
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 8px;">
                                                        : 25,500 cd <br>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                    <td class="info-catatan2"
                                                        style="font-size: 9px; color: #666; font-weight: normal;">
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                    <td class="info-catatan2"
                                                        style="font-size: 9px; color: #666; font-weight: normal;">
                                                        Kekuatan pancar lampu utama <br>
                                                        kiri 1200cd(lampu jauh)
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 8px;">
                                                        : 31,600 cd <br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                    <td class="info-catatan2"
                                                        style="font-size: 9px; color: #666; font-weight: normal;">
                                                        Penyimpangan ke kanan 0&deg;34' <br>
                                                        (lampu jauh)
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 8px;">
                                                        : 0.00 <br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                    <td class="info-catatan2"
                                                        style="font-size: 9px; color: #666; font-weight: normal;">
                                                        Penyimpangan ke kiri 1&deg;09'(lampu <br>
                                                        jauh)
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 8px;">
                                                        : 1.00 <br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 8px;">
                                                        Emisi <br>
                                                        <span
                                                            style="font-size: 7px; font-style: italic; color: #666; font-weight: normal;">
                                                            Emission
                                                        </span>
                                                    </td>
                                                    <td class="info-catatan2"
                                                        style="font-size: 9px; color: #666; font-weight: normal;">
                                                        Bahan bakar solar <br>
                                                        tahun pembuatan >= 2010
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                    <td class="info-catatan2"
                                                        style="font-size: 9px; color: #666; font-weight: normal;">
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                    <td class="info-catatan2"
                                                        style="font-size: 9px; color: #666; font-weight: normal;">
                                                        Opasitas :35%HSU
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                    <td class="info-catatan2"
                                                        style="font-size: 9px; color: #666; font-weight: normal;">
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 8px;">
                                                        Keterangan <br>
                                                        <span
                                                            style="font-size: 7px; font-style: italic; color: #666; font-weight: normal;">
                                                            Impection result
                                                        </span>
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                        :{{ $nokir->keterangan }}
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 8px;">
                                                        Masa berlaku uji <br>
                                                        Berkala <br>
                                                        <span
                                                            style="font-size: 7px; font-style: italic; color: #666; font-weight: normal;">
                                                            Periodical inspection expiry <br>
                                                            date
                                                        </span>
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                        :{{ $nokir->masa_berlaku }}
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 8px;">
                                                        Nama petugas <br>
                                                        penguji <br>
                                                        <span
                                                            style="font-size: 7px; font-style: italic; color: #666; font-weight: normal;">
                                                            Name of inspector/grade <br>
                                                            date
                                                        </span>
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                        :{{ $nokir->nama_petugas_penguji }}
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="info-catatan2" style="font-size: 8px;">
                                                        Tanda tangan<br>
                                                        petugas penguji <br>
                                                        <span
                                                            style="font-size: 7px; font-style: italic; color: #666; font-weight: normal;">
                                                            Inspector authorization <br>
                                                        </span>
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                        <span
                                                            style="text-decoration: underline;">{{ $nokir->nama_petugas_penguji }}</span>
                                                        <br>
                                                        <span>Penguji Tingkat Lima</span>
                                                        <br>
                                                        <span>{{ $nokir->nrp_petugas_penguji }}</span>
                                                    </td>
                                                    <td class="info-catatan2" style="font-size: 7px;">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table>
                                            <tr>
                                                <td class="info-catatan2" style="font-size: 7px;">
                                                    Nama unit utama pelaksanaan uji berkala kendaraan bermotor <br>
                                                    <span
                                                        style="font-size: 7px; font-style: italic; color: #666; font-weight: normal;">
                                                        Name of vehicle periodical inspection agency <br>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                        <table>
                                            <tr>
                                                <td class="info-catatan2" style="font-size: 7px;">
                                                    UNIT PELAKSANAAN TEKNIS DAERAH PENGUJIAN <br>
                                                    DINAS PERHUBUNGAN KABUPATEN TEGAL
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="tanda">
                                            <tr>
                                                <td class="info-catatan2" style="font-size: 8px;">
                                                    <span style="text-decoration: underline;">
                                                        MUHAMMAD BUDI EKO SETIAWAN, ST,<br>
                                                    </span
                                                        style="font-size: 8px; color: #66rgb(28, 28, 28)ont-weight: normal;">
                                                    Pembina Tingkat I-IV/b <br>
                                                    <br>
                                                    <span
                                                        style="font-size: 8px; color: #66rgb(28, 28, 28)ont-weight: normal;">
                                                        {{ $nokir->nip_kepala_dinas }}
                                                        <br>
                                                        <br>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>



</html>
