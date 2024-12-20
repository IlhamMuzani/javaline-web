<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktur Sewa Kendaraan</title>
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
            margin-top: 10px;
            margin-right: 20px;
            margin-left: 20px;
            font-family: Arial, sans-serif;
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
            font-size: 12px;
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
            font-size: 12px;
            text-align: center;
            /* Teks menjadi berada di tengah */

        }

        .label2 {
            font-size: 12px;
            text-align: left;
            /* Teks menjadi berada di tengah */

        }

        .separator {
            padding-top: 12px;
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

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            {{-- pemilik pt  --}}
            <td style="text-align: left; width: 30%;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: left;">
                        <td style="font-size: 15px; font-weight:bold" class="label2">PT. JAVA LINE LOGISTICS
                        </td>
                    </tr>
                    <tr>
                        <td class="label2">JL. HOS COKRO AMINOTO NO. 5</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td class="label2">SLAWI TEGAL</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td class="label2">Telp/ Fax 02836195326 02836195187</td>
                    </tr>
                    <tr style="text-align: left; background:whi">
                        <td class="label2">.</td>
                    </tr>
                </table>
            </td>
            {{-- pelanggan --}}
            <td style="text-align: left; width: 50%;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: left;">
                        <td class="label2" style="width: 23%; font-weight:bold">Nama Rekanan</td>
                        <td class="label2" style="width: 5%;">:</td>
                        <td class="label2" style="width: 67%;">{{ $cetakpdf->vendor->nama_vendor ?? null }}</td>
                    </tr>
                    <tr>
                        <td class="label2" style="font-weight:bold">Alamat</td>
                        <td class="label2">:</td>
                        <td class="label2"> {{ $cetakpdf->vendor->alamat ?? null }}</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td class="label2" style="font-weight:bold">Telp</td>
                        <td class="label2">:</td>
                        <td class="label2">{{ $cetakpdf->vendor->telp ?? null }}</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td class="label2" style="font-weight:bold">Id Rekanan</td>
                        <td class="label2">:</td>
                        <td class="label2"> {{ $cetakpdf->vendor->kode_vendor ?? null }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 19px;">FAKTUR SEWA KENDARAAN</span>

    </div>
    <table style="border-top: 1px solid black; margin: 5px 0;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="text-align: left" style="font-size: 12px; display: block;">No. Faktur</td>
            <td style="text-align: left; font-size: 12px;">
                <span class="content2">
                    : <span>{{ $cetakpdf->kode_sewa }}</span></span>
                <br>
            </td>
            <td class="text-align: left" style="font-size: 12px; margin-left: 5px; display: block;">No. Mobil
            </td>
            <td style="text-align: left; font-size: 12px;">
                <span class="content2">
                    : {{ $cetakpdf->no_pol }}</span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="text-align: left" style="font-size: 12px; display: block;">Tanggal</td>
            <td style="text-align: left; font-size: 12px;">
                <span class="content2">
                    :
                    <span>{{ \Carbon\Carbon::parse($cetakpdf->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</span></span>
                <br>
            </td>
            <td class="info-text-align: left" style="font-size: 12px; margin-left: 5px; display: block;">Nama Driver
            </td>
            <td style="text-align: left; font-size: 12px;">
                <span class="content2">
                    : {{ $cetakpdf->nama_driver }}</span>
                <br>
            </td>
        </tr>
    </table>
    <hr style="border-top: 0.1px solid black; margin: 5px 0;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">No.</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Nama Tarif</td>
            <td class="td" style="text-align: right; padding-right: 90px; font-size: 12px;">Harga</td>
            <td class="td" style="text-align: right; padding-right: 10px; font-size: 12px;">Qty</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">Satuan</td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">Total</td>
        </tr>
        <!-- Add horizontal line below this row -->
        <tr>
            <td colspan="6" style="padding: 0px;">
                <hr style="border-top: 0.1px solid black; margin: 5px 0;">
            </td>
        </tr>
        {{-- @foreach ($detail_memo as $item) --}}
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                1
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                {{ $cetakpdf->nama_rute }}
            </td>

            <td class="td" style="text-align: right; padding-right: 90px; font-size: 12px;">
                {{ number_format($cetakpdf->harga_tarif, 2, ',', '.') }}
            </td>
            <td class="td" style="text-align: right; padding-right: 10px; font-size: 12px;">
                {{ number_format($cetakpdf->jumlah, 2, ',', '.') }}
            </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                {{ $cetakpdf->satuan }}

            </td>
            {{-- @php
                $formattedGrandTotaltotal_tarif = number_format($cetakpdf->total_tarif, $cetakpdf->total_tarif - floor($cetakpdf->total_tarif) > 0 ? 1 : 0, ',', '.');
            @endphp --}}
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">
                {{ number_format($cetakpdf->total_tarif, 2, ',', '.') }}
            </td>
        </tr>



        <tr style="border-bottom: 1px solid black;">
            <td colspan="6"></td>
        </tr>
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
            </td>

            <td class="td" style="text-align: right; padding-right: 10px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">
                {{ number_format($cetakpdf->total_tarif, 2, ',', '.') }}
            </td>
        </tr>

        <tr>
        </tr>
    </table>

    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr style="color: white">
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">No.</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Nama Tarif</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Harga</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Qty</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Satuan</td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">Total</td>
        </tr>
        <!-- Add horizontal line below this row -->

        @if ($cetakpdf->kategori == 'PPH')
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                    DPP :
                </td>

                <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">
                    {{ number_format($cetakpdf->total_tarif, 2, ',', '.') }}

                </td>
            </tr>

            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                    PPH23 = 2% :
                </td>


                <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">
                    {{ number_format($cetakpdf->pph, 2, ',', '.') }}
                </td>
            </tr>
        @endif
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                Potongan = Potongan = @if ($cetakpdf->nominal_potongan == null)
                    0% :
                @else
                    {{ $cetakpdf->nominal_potongan }}% :
                @endif
            </td>


            <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">
                {{ number_format($cetakpdf->hasil_potongan, 2, ',', '.') }}
            </td>
        </tr>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6"></td>
        </tr>
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                Grand Total :
            </td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">
                {{ number_format($cetakpdf->total_tarif - ($cetakpdf->pph ?? null) - $cetakpdf->hasil_potongan, 2, ',', '.') }}
            </td>
        </tr>

        <tr>
        </tr>
    </table>
    <div style="font-size: 12px; margin-right:300px">Keterangan : {{ $cetakpdf->keterangan }}</div>
    <div style=" margin-top:13px; margin-bottom:27px">
        <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
            <tr>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center;">
                            <td class="label">{{ $cetakpdf->vendor->nama_vendor ?? null }}</td>
                        </tr>
                        <tr>
                            <td class="separator" colspan="2"><span></span></td>
                        </tr>
                        <tr style="text-align: center;">
                            <td class="label">Rekanan</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center;">
                            <td class="label">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="separator" colspan="2"><span></span></td>
                        </tr>
                        <tr style="text-align: center;">
                            <td class="label">Finance</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center;">
                            <td class="label">{{ auth()->user()->karyawan->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="separator" colspan="2"><span></span></td>
                        </tr>
                        <tr style="text-align: center;">
                            <td class="label">Admin</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div style="text-align: right; font-size:11px">
            <span style="font-style: italic;">Printed Date
                {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
        </div>
    </div>
</body>


<div class="container">
    {{-- <a href="{{ url('admin/inquery_sewakendaraan') }}" class="blue-button">Kembali</a> --}}
    <a href="{{ url('admin/inquery_sewakendaraan') . '?status=&tanggal_awal=' . $cetakpdf->tanggal_awal . '&tanggal_akhir=' . $cetakpdf->tanggal_awal . '&ids=' }}"
        class="blue-button">
        Kembali
    </a>
    <a href="{{ url('admin/sewa_kendaraan/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
</div>

</html>
