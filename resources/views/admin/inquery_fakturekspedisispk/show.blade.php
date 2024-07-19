<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktur Ekspedisi</title>
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
            padding-top: 17px;
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
    <table cellpadding="2" cellspacing="0">
        <tr>
            <td class="info-catatan2" style="font-size: 17px;">PT. BINA ANUGERAH TRANSINDO</td>
            <td class="text-align: left" style="font-size: 17px; margin-left: 40px; display: block;">Nama Pelanggan</td>
            <td style="text-align: left; font-size: 17px;">
                <span class="content2">
                    :{{ $cetakpdf->nama_pelanggan }} </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="font-size: 17px;">JL. HOS COKRO AMINOTO NO. 5
                {{-- <br>
                SLAWI TEGAL <br>
                Telp/ Fax 02836195326 02836195187 --}}
            </td>
            </td>
            <td style="font-size: 17px; margin-left: 40px; display: block;">Alamat</td>
            <td style="text-align: left; font-size: 17px;">
                <span class="content2">
                    :{{ $cetakpdf->alamat_pelanggan }}</span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="font-size: 17px;">SLAWI TEGAL
            </td>
            <td style="font-size: 17px; margin-left: 40px; display: block;">Telp / Hp</td>
            <td style="text-align: left; font-size: 17px;">
                <span class="content2">
                    :{{ $cetakpdf->telp_pelanggan }}
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="font-size: 17px;">Telp/ Fax 02836195326 02836195187
            </td>
            <td style="font-size: 17px; margin-left: 40px; display: block;">ID Pelanggan</td>

            <td style="text-align: left; font-size: 17px;">
                <span class="content2">
                    :{{ $cetakpdf->kode_pelanggan }}
                </span>
                <br>
            </td>
        </tr>
    </table>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 23px;">FAKTUR EKSPEDISI</span>
        <br>
    </div>
    <hr>
    <table cellpadding="2" cellspacing="0">
        <tr>
            <td class="text-align: left" style="font-size: 17px; display: block;">No. Faktur</td>
            <td style="text-align: left; font-size: 17px;">
                <span class="content2">
                    : <span>{{ $cetakpdf->kode_faktur }}</span></span>
                <br>
            </td>
            <td class="text-align: left" style="font-size: 17px; margin-left: 40px; display: block;">No. Kabin</td>
            <td style="text-align: left; font-size: 17px;">
                <span class="content2">
                    : @if ($cetakpdf->detail_faktur->first())
                        {{ $cetakpdf->detail_faktur->first()->no_kabin }}
                    @else
                        {{ $cetakpdf->no_kabin }}
                    @endif </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="text-align: left" style="font-size: 17px; display: block;">Tanggal</td>
            <td style="text-align: left; font-size: 17px;">
                <span class="content2">
                    : <span>{{ $cetakpdf->tanggal }}</span></span>
                <br>
            </td>
            <td class="info-text-align: left" style="font-size: 17px; margin-left: 40px; display: block;">No. Mobil
            </td>
            <td style="text-align: left; font-size: 17px;">
                <span class="content2">
                    : @if ($cetakpdf->detail_faktur->first())
                        {{ $cetakpdf->detail_faktur->first()->kendaraan->no_pol }}
                    @else
                        {{ $cetakpdf->no_pol }}
                    @endif </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="text-align: left" style="font-size: 17px; display: block;">Kota Tujuan</td>
            <td style="text-align: left; font-size: 17px;">
                <span class="content2">
                    :@foreach ($details as $item)
                        {{ $item->nama_rute }}, {{ $item->nama_rutetambahan }}
                    @endforeach
                </span>
                <br>
            </td>
            <td class="text-align: left" style="font-size: 17px; margin-left: 40px; display: block;">Jenis Kendaraan
            </td>
            <td style="text-align: left; font-size: 17px;">
                <span class="content2">
                    : @if ($cetakpdf->detail_faktur->first())
                        {{ $cetakpdf->detail_faktur->first()->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}
                    @else
                        @if ($cetakpdf->kendaraan)
                            {{ $cetakpdf->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}
                        @endif
                    @endif </span>
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="text-align: left" style="font-size: 17px; display: block;">No. Memo</td>
            <td style="text-align: left; font-size: 17px;">
                <span class="content2">
                    :@foreach ($details as $item)
                        {{ $item->kode_memo }}, {{ $item->kode_memotambahan }} {{ $item->kode_memotambahans }}
                    @endforeach
                </span>
                <br>
            </td>
            <td class="text-align: left" style="font-size: 17px; margin-left: 40px; display: block;">Nama Driver</td>

            <td style="text-align: left; font-size: 17px;">
                <span class="content2">
                    : @if ($cetakpdf->detail_faktur->first())
                        {{ $cetakpdf->detail_faktur->first()->nama_driver }}
                    @else
                        @if ($cetakpdf->kendaraan)
                             @if ($cetakpdf->kendaraan->user)
                                {{ $cetakpdf->kendaraan->user->karyawan->nama_lengkap }}
                            @else
                                tidak ada
                            @endif
                        @else
                            {{ $cetakpdf->nama_sopir }}
                        @endif
                    @endif </span>
                </span>
                <br>
            </td>
        </tr>
    </table>
    <hr>
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">No.</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">Nama Tarif</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 17px;">Harga</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">Qty</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">Satuan</td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 17px;">Total</td>
        </tr>
        <!-- Add horizontal line below this row -->
        <tr>
            <td colspan="6" style="padding: 0px;">
                <hr style="border-top: 1px solid black; margin: 5px 0;">
            </td>
        </tr>
        {{-- @foreach ($detail_memo as $item) --}}
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">
                1
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">
                {{ $cetakpdf->nama_tarif }}
            </td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 17px;">
                {{ number_format($cetakpdf->harga_tarif, 2, ',', '.') }}
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">
                {{ $cetakpdf->jumlah }}
            </td>
            <td class="td" style="text-align: center; padding: 2px; font-size: 17px;">
                @if ($cetakpdf->satuan == 'M3')
                    M&sup3;
                @else
                    {{ $cetakpdf->satuan }}
                @endif
            </td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 17px;">
                {{ number_format($cetakpdf->total_tarif, 2, ',', '.') }}
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6"></td>
        </tr>
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

            </td>
            <td class="td" style="text-align: center; padding: 2px; font-size: 17px;">

            </td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 17px;">
                {{ number_format($cetakpdf->total_tarif, 2, ',', '.') }}
            </td>
        </tr>
        {{-- @php
                $totalRuteSum += $item->totalrute;
            @endphp
        @endforeach --}}
        <tr>
        </tr>
    </table>

    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr style="color: white">
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">No.</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">Nama Tarif</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">Harga</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">Qty</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">Satuan</td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 17px;">Total</td>
        </tr>
        <!-- Add horizontal line below this row -->

        @if ($cetakpdf->kategori == 'PPH')
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 17px;">
                    DPP :
                </td>
                <td class="td" style="text-align: right; padding-right: 23px; font-size: 17px;">
                    {{ number_format($cetakpdf->total_tarif, 2, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 17px;">
                    PPH23 = 2% :
                </td>
                <td class="td" style="text-align: right; padding-right: 23px; font-size: 17px;">
                    {{ number_format($cetakpdf->pph, 2, ',', '.') }}
                </td>
            </tr>

            <tr style="color: white">
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">
                    .
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">
                    .
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">
                    .
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">
                    .
                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 17px;">
                    .
                </td>
                <td class="td" style="text-align: right; padding-right: 23px; font-size: 17px;">
                    .
                </td>
            </tr>
        @endif

        @if (!$detailtarifs == null)
            @php
                $totalRuteSum = 0;
            @endphp
            @foreach ($detailtarifs as $item)
                <tr>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                    </td>
                    <td class="td" style="text-align: right; padding: 2px; font-size: 17px;">
                        {{ $item->keterangan_tambahan }} :
                    </td>
                    <td class="td" style="text-align: right; padding-right: 23px; font-size: 17px;">
                        {{ number_format($item->nominal_tambahan, 2, ',', '.') }}
                    </td>
                    @php
                        $totalRuteSum += $item->totalrute;
                    @endphp
            @endforeach
        @endif
        @if ($detailtarifs->isEmpty())
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 17px;">
                    Ongkos Bongkar :
                </td>
                <td class="td" style="text-align: right; padding-right: 23px; font-size: 17px;">
                    0
                </td>
            </tr>
        @endif


        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6"></td>
        </tr>
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 17px;">

            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 17px;">
                Grand Total :
            </td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 17px;">
                {{ number_format($cetakpdf->grand_total, 2, ',', '.') }}
            </td>
        </tr>
        <tr>
        </tr>
    </table>
    <div style="font-size: 17px; margin-right:500px">Keterangan : {{ $cetakpdf->keterangan }}</div>



    <br><br><br>

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">{{ auth()->user()->karyawan->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Accounting</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label" style="min-height: 16px;">&nbsp;</td>
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
                        <td class="label" style="min-height: 16px;">&nbsp;</td>
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
</body>


<div class="container">
    <a href="{{ url('admin/inquery_fakturekspedisi') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/faktur_ekspedisi/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
</div>

</html>
