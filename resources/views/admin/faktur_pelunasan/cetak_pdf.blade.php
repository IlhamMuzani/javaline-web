<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktur Pelunasan</title>
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
            font-size: 13px;
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
            font-size: 13px;
            text-align: center;
            /* Teks menjadi berada di tengah */

        }

        .separator {
            padding-top: 13px;
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
            <td class="info-catatan2" style="font-size: 13px;">PT. JAVA LINE LOGISTICS</td>
            <td class="info-catatan2" style="font-size: 13px; margin-left: 40px; display: block;">Nama Pelanggan</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">
                    {{ $cetakpdf->nama_pelanggan }}
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="font-size: 13px;">JL. HOS COKRO AMINOTO NO. 5
                {{-- <br>
                SLAWI TEGAL <br>
                Telp/ Fax 02836195326 02836195187 --}}
            </td>
            </td>
            <td class="info-catatan2" style="font-size: 13px; margin-left: 40px; display: block;">Alamat</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">
                    {{ $cetakpdf->alamat_pelanggan }}
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="font-size: 13px;">SLAWI TEGAL
            </td>
            <td class="info-catatan2" style="font-size: 13px; margin-left: 40px; display: block;">Telp</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">
                    {{ $cetakpdf->telp }}
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="font-size: 13px;">Telp/ Fax 02836195326 02836195187
            </td>
            <td class="info-catatan2" style="font-size: 13px; margin-left: 40px; display: block;">ID Pelanggan</td>

            <td style="text-align: left; font-size: 13px;">
                <span class="content2">
                    {{ $cetakpdf->kode_pelanggan }}
                </span>
                <br>
            </td>
        </tr>
    </table>
    <br>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 20px;">FAKTUR PELUNASAN EKSPEDISI</span>
        <br>
    </div>
    <hr style="border-top: 0.1px solid black;">
    <table style="width: 100%; margin-bottom:5px" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">No.
                Faktur:{{ $cetakpdf->kode_pelunasan }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                Tanggal:{{ \Carbon\Carbon::parse($cetakpdf->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                Status: @if ($cetakpdf->selisih == 0)
                    <span style="font-weight: bold;">LUNAS</span>
                @else
                    Belum Lunas
                @endif
            </td>
        </tr>
    </table>
    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">No.</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">F. Ekspedisi</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 13px;">Total Ongkos Ekspedisi</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">F. Return</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 13px;">Total Return</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 13px;">Sub Total</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;"></td>
        </tr>
        @php
            $totalQuantity = 0;
            $totalHarga = 0;

            $diskonquantity = 0;
            $totalDiskon = 0;
        @endphp
        @foreach ($details as $item)
            @php
                // Mendapatkan nilai nominal_potongan
                $detail_pelunasan_return = $item->faktur_pelunasan->detail_pelunasanreturn
                    ->where('faktur_ekspedisi_id', $item->faktur_ekspedisi_id)
                    ->first();
                $nominal_potongan = $detail_pelunasan_return ? $detail_pelunasan_return->nominal_potongan : 0;

                // Mengurangi nilai total dengan nilai nominal_potongan
                $total_dengan_potongan = $item->total - $nominal_potongan;
            @endphp

            <tr>
                <td class="td" style="text-align: center;  font-size: 13px;">{{ $loop->iteration }}</td>
                <td class="td" style="text-align: center;  font-size: 13px;">{{ $item->kode_faktur }}</td>
                <td class="info-text info-left" style="font-size: 13px; text-align: right;">
                    {{ number_format($item->total, 2, ',', '.') }}
                </td>
                <td class="td" style="text-align: center; font-size: 13px;">
                    @if ($detail_pelunasan_return)
                        {{ $detail_pelunasan_return->kode_potongan }}
                    @else
                    @endif
                </td>
                <td class="td" style="text-align: right;  font-size: 13px;">
                    @if ($detail_pelunasan_return)
                        {{ number_format($nominal_potongan, 2, ',', '.') }}
                    @else
                        0,00
                    @endif
                </td>
                <td class="td" style="text-align: right;  font-size: 13px;">
                    {{ number_format($total_dengan_potongan, 2, ',', '.') }}
                </td>
            </tr>

            @php
                $totalQuantity += 1;
                $totalHarga += $total_dengan_potongan;

                $diskonquantity = 1;
                $totalDiskon += $nominal_potongan;
            @endphp
        @endforeach

        <tr style="border-bottom: 1px solid black;">
            <td colspan="6" style="padding: 0px;"></td>
        </tr>
        {{-- <tr>
            <td colspan="5"
                style="text-align: right; font-weight: bold; margin-top:5px; margin-bottom:5px; font-size: 13px;">
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 13px;">
                {{ number_format($totalHarga, 0, ',', '.') }}
            </td>
        </tr> --}}
    </table>
    <table style="width: 100%; margin-bottom:0px;">
        <tr>
            <td>
                <span class="info-item" style="font-size: 13px; font-weight:bold">Rincian Pembayaran :</span>
                <br>
            </td>
            <td style="text-align: right; font-size: 13px; font-weight:bold">
                {{ number_format($totalHarga, 2, ',', '.') }}
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td style="width:60%;">
                <table>
                    @if ($cetakpdf->kategori == 'Bilyet Giro')
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">No. BG / Tanggal</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item"
                                    style="font-size: 13px;">{{ $cetakpdf->tanggal_transfer }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">Jumlah Nominal</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item"
                                    style="font-size: 13px;">{{ number_format($cetakpdf->nominal, 2, ',', '.') }}</span>
                            </td>
                        </tr>
                    @endif
                    @if ($cetakpdf->kategori == 'Transfer')
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">No Transfer / Tanggal</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item"
                                    style="font-size: 13px;">{{ $cetakpdf->tanggal_transfer }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">Jumlah Nominal</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item"
                                    style="font-size: 13px;">{{ number_format($cetakpdf->nominal, 2, ',', '.') }}</span>
                            </td>
                        </tr>
                    @endif
                    @if ($cetakpdf->kategori == 'Tunai')
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">Tanggal</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item"
                                    style="font-size: 13px;">{{ $cetakpdf->tanggal_transfer }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">Nominal Tunai</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item"
                                    style="font-size: 13px;">{{ number_format($cetakpdf->nominal, 2, ',', '.') }}</span>
                            </td>
                        </tr>
                    @endif
                </table>
            </td>
            <td style="width: 70%;">
                <table style="width: 100%;" cellpadding="2" cellspacing="0">
                    {{-- <tr>
                        <td colspan="5" style="text-align: left; padding: 0px; font-size: 13px;width: 30%;">
                            Potongan Penjualan</td>
                        <td class="td" style="text-align: right; font-size: 13px;">
                            {{ number_format($cetakpdf->potonganselisih, 2, ',', '.') }}
                        </td>
                    </tr> --}}
                    @foreach ($cetakpdf->detail_pelunasanpotongan as $item)
                        <tr>
                            <td colspan="5" style="text-align: left; padding: 0px; font-size: 13px;width: 30%;">
                                {{ $item->keterangan_potonganlain }} </td>
                            <td class="td" style="text-align: right; font-size: 13px;">
                                {{ number_format($item->nominallain, 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" style="text-align: left; padding: 0px; font-size: 13px;">Ongkos Bongkar
                        </td>
                        <td class="td" style="text-align: right; font-size: 13px;">
                            0,00
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="padding: 0px; position: relative;">
                            <hr style="border-top: 0.1px solid black; ">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding: 0px; font-size: 13px;width: 30%;">
                            Total Tagihan</td>
                        <td class="td" style="text-align: right; font-size: 13px;">
                            {{ number_format($cetakpdf->totalpembayaran, 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding: 0px; font-size: 13px;">Total Bayar
                        </td>
                        <td class="td" style="text-align: right; font-size: 13px;">
                            {{ number_format($cetakpdf->nominal, 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="padding: 0px; position: relative;">
                            <hr style="border-top: 0.1px solid black; ">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding: 0px; font-size: 13px;width: 30%;">
                            Kekurangan Bayar</td>
                        <td class="td" style="text-align: right; font-size: 13px;">
                            {{ number_format($cetakpdf->selisih, 2, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </td>

        </tr>

    </table>

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">{{ $cetakpdf->nama_pelanggan }}</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">PELANGGAN</td>
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
                        <td class="label">ADMIN</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    {{-- <div style="text-align: right; font-size:12px; margin-top:5px">
        <span style="font-style: italic;">Printed Date {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
    </div> --}}
</body>

</html>
