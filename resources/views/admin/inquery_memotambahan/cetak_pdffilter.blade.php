<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Memo Tambahan</title>
    <style>
        html,
        body {
            font-family: Arial, sans-serif;
            color: black;
            /* Gunakan Arial atau font sans-serif lainnya yang mudah dibaca */
            margin-top: 30px;
            margin-left: 40px;
            margin-right: 80px;
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

        .info-column {
            padding-left: 5px;
        }

        .info-titik {
            /* vertical-align: top; */
        }

        /* tanda tangan  */

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .separator {
            padding-top: 13px;
            text-align: center;
        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -8px;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    @for ($i = 0; $i < count($memos); $i += 2)
        @for ($j = $i; $j < $i + 2 && $j < count($memos); $j++)
            @php
                $cetakpdf = $memos[$j];
            @endphp
            <table width="100%">
                <tr>
                    <td style="width:0%;">
                    </td>
                    <td style="width: 70%; text-align: right;">
                    </td>
                </tr>
            </table>
            <div style="text-align: center;">
                <span style="font-weight: bold; font-size: 20px;">PT JAVA LINE LOGISTICS</span>
                <br>
                <span style=" font-size: 13px;">JL. HOS COKRO AMINOTO NO 5 SLAWI TEGAL
                    {{-- <br>Tegal 52411 --}}
                </span>
                <br>
                <span style=" font-size: 13px;">Telp / Fax, 02836195328 02838195187</span>
            </div>
            <hr style="border: 0.5px solid;">
            <div style="text-align: center;">
                <span style="font-weight: bold; font-size: 17px;">MEMO TAMBAHAN</span>
            </div>
            <div style="text-align: left; margin-left:5px">
                <span style="font-weight: bold; font-size: 13px;">{{ $cetakpdf->no_memo }}</span>
            </div>
            <table width="100%">
                <tr>
                    <td style="width:60%;">
                        <table>
                            <tr>
                                <td class="info-column">
                                    <span class="info-item" style="font-size: 13px;">Tanggal</span>
                                </td>
                                <td class="info-column">
                                    <span class="info-titik" style="font-size: 13px;">:</span>
                                </td>
                                <td class="info-column">
                                    <span class="info-item"
                                        style="font-size: 13px;">{{ $cetakpdf->tanggal_awal }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="info-column">
                                    <span class="info-item" style="font-size: 13px;">No. Memo</span>
                                </td>
                                <td class="info-column">
                                    <span class="info-titik" style="font-size: 13px;">:</span>
                                </td>
                                <td class="info-column">
                                    <span class="info-item"
                                        style="font-size: 13px;">{{ $cetakpdf->kode_tambahan }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="info-column">
                                    <span class="info-item" style="font-size: 13px;">No. Kabin</span>
                                </td>
                                <td class="info-column">
                                    <span class="info-titik" style="font-size: 13px;">:</span>
                                </td>
                                <td class="info-column">
                                    <span class="info-item" style="font-size: 13px;"> {{ $cetakpdf->no_kabin }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="info-column">
                                    <span class="info-item" style="font-size: 13px;">Nama
                                        Sopir</span>
                                </td>
                                <td class="info-column">
                                    <span class="info-titik" style="font-size: 13px;">:</span>
                                </td>
                                <td class="info-column">
                                    <span class="info-item" style="font-size: 13px;">{{ $cetakpdf->nama_driver }}</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 70%; text-align: left;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 40%;">
                                    <span class="info-item"
                                        style="font-size: 13px; text-align: left; display: inline-block;">Nama
                                        Bank</span>
                                </td>
                                <td style="width: 60%;">
                                    <span class="info-item"
                                        style="font-size: 13px; text-align: left; display: inline-block;">:
                                        @if ($cetakpdf->memo_ekspedisi->user->karyawan->nama_bank != null)
                                            {{ $cetakpdf->memo_ekspedisi->user->karyawan->nama_bank }}
                                        @else
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">
                                    <span class="info-item"
                                        style="font-size: 13px; text-align: left; display: inline-block;">No
                                        Rekening</span>
                                </td>
                                <td style="width: 60%;">
                                    <span class="info-item"
                                        style="font-size: 13px; text-align: left; display: inline-block;">:
                                        @if ($cetakpdf->memo_ekspedisi->user->karyawan->norek != null)
                                            {{ $cetakpdf->memo_ekspedisi->user->karyawan->norek }}
                                        @else
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">
                                    <span class="info-item"
                                        style="font-size: 13px; text-align: left; display: inline-block;">Atas
                                        Nama</span>
                                </td>
                                <td style="width: 60%;">
                                    <span class="info-item"
                                        style="font-size: 13px; text-align: left; display: inline-block;">:
                                        @if ($cetakpdf->memo_ekspedisi->user->karyawan->atas_nama != null)
                                            {{ $cetakpdf->memo_ekspedisi->user->karyawan->atas_nama }}
                                        @else
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">
                                    <span class="info-item"
                                        style="font-size: 13px; text-align: left; display: inline-block; color:white">a</span>
                                </td>
                                <td style="width: 60%;">
                                    <span class="info-item"
                                        style="font-size: 13px; text-align: left; display: inline-block; color:white">
                                        a</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div style="height: 330px; overflow: hidden;">
                <hr style="border: 0.5px solid;">
                <table style="width: 100%;" cellpadding="2" cellspacing="0">
                    <tr>
                        <td class="td" style="text-align: center; padding: 0px; font-size: 13px; width:4%">No.</td>
                        <td class="td" style="text-align: left; padding: 0px; font-size: 13px; width:50% ">
                            Keterangan</td>
                        <td class="td" style="text-align: left; padding: 0px; font-size: 13px; width:5% ">Qty</td>
                        <td class="td" style="text-align: left; padding: 0px; font-size: 13px; width:7%  ">Satuan
                        </td>
                        <td class="td" style="text-align: right; padding: 0px; font-size: 13px; width:20%  ">Harga
                        </td>
                        <td class="td" style="text-align: right; padding-right: 17px; font-size: 13px;  width:25% ">
                            Total</td>
                    </tr>
                    <!-- Add horizontal line below this row -->
                    <tr>
                        <td colspan="8" style="padding: 0px;">
                            <hr style="border-top: 0.5px solid black; margin: 5px 0;">
                        </td>
                    </tr>
                    @php
                        $totalRuteSum = 0;
                    @endphp
                    @foreach ($cetakpdf->detail_memotambahan as $item)
                        <tr>
                            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                                {{ $loop->iteration }}
                            </td>
                            <td class="td" style="text-align: left; padding: 0px; font-size: 13px;">
                                {{ $item->keterangan_tambahan }}
                            </td>
                            <td class="td" style="text-align: left; padding: 0px; font-size: 13px;">
                                {{ $item->qty }}
                            </td>
                            <td class="td" style="text-align: left; padding: 0px; font-size: 13px;">
                                {{ $item->satuans }}
                            </td>
                            <td class="td" style="text-align: right; padding: 0px; font-size: 13px;">
                                {{ number_format($item->hargasatuan, 0, ',', '.') }}
                            </td>
                            <td class="td" style="text-align: right; padding-right: 17px; font-size: 13px;">
                                {{ number_format($item->nominal_tambahan, 0, ',', '.') }}
                            </td>
                        </tr>
                        @php
                            $totalRuteSum += $item->nominal_tambahan;
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan="5" style="padding: 0px;">
                        </td>
                    </tr>
                </table>
                <table style="width: 100%; border-top: 0.5px solid black; margin-bottom:5px;">
                    <tr>
                        <td style="text-align: right; padding-right: 17px;font-size: 13px;">
                            {{ number_format($totalRuteSum, 0, ',', '.') }}
                        </td>
                    </tr>
                </table>

                <div style=" margin-top:13px; margin-bottom:{{ $j % 2 != 0 && $j != 0 ? 50 : 0 }}px">

                    <table style="width: 100%; padding-top:0px" cellpadding="1" cellspacing="0">
                        <tr>
                            <td>
                                {{-- <table>
                        <tr>
                            <td style="text-align: left; padding-left: 17px;font-size: 13px;">No
                            </td>
                            <td style="text-align: left; padding-left: 17px;font-size: 13px;">Kode Nota Bon</td>
                            <td
                                style="text-align:
                                right; padding-right: 17px;font-size: 13px;">
                                Nominal</td>
                        </tr>
                        @foreach ($detail_nota as $item)
                            <tbody>
                                <td style="text-align: left; padding-left: 17px;font-size: 13px;">
                                    {{ $loop->iteration }}
                                </td>
                                <td style="text-align: left; padding-left: 17px;font-size: 13px;">
                                    {{ $item->kode_nota }}</td>
                                <td
                                    style="text-align:
                                right; padding-right: 17px;font-size: 13px;">
                                    {{ number_format($item->nominal_nota, 0, ',', '.') }}
                                </td>
                            </tbody>
                        @endforeach
                    </table> --}}
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td colspan="4" style="text-align: right; padding: 0px; font-size: 13px;">
                                            Total</td>
                                        <td class="td"
                                            style="text-align: right; padding-right: 16px; font-size: 13px;">
                                            {{ number_format($totalRuteSum, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    {{-- <tr>
                            <td colspan="4" style="text-align: right; padding: 0px; font-size: 13px;">
                                {{ optional($cetakpdf->detail_notabon->first())->kode_nota ?? '' }}
                                Nota Bon 1
                            </td>
                            <td class="td" style="text-align: right; padding-right: 16px; font-size: 13px;">
                                {{ number_format(optional($cetakpdf->detail_notabon->first())->nominal_nota ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                        @php
                            // Ambil dua data terakhir dalam dua bulan terakhir
                            $detail_notabon_last_two = $cetakpdf->detail_notabon
                                ->filter(function ($nota) {
                                    return \Carbon\Carbon::parse($nota->tanggal)->greaterThanOrEqualTo(
                                        now()->subMonths(2),
                                    );
                                })
                                ->sortByDesc('tanggal') // Pastikan data diurutkan dari yang terbaru
                                ->take(2);
                        @endphp --}}

                                    @php
                                        $counter = 1; // Inisialisasi penghitung
                                    @endphp

                                    @foreach ($cetakpdf->detail_notabon as $nota)
                                        <tr>
                                            <td colspan="4"
                                                style="text-align: right; padding: 0px; font-size: 13px;">
                                                {{ $nota->kode_nota ?? '' }}
                                                Nota Bon {{ $counter }} <!-- Tampilkan teks dinamis -->
                                            </td>
                                            <td class="td"
                                                style="text-align: right; padding-right: 9px; font-size: 13px;">
                                                {{ number_format($nota->nominal_nota ?? 0, 0, ',', '.') }} -
                                            </td>
                                        </tr>
                                        @php
                                            $counter++; // Increment penghitung
                                        @endphp
                                    @endforeach

                                    <tr>
                                        <td colspan="4" style="padding: 0px;"></td>
                                        <td style="padding: 0px;">
                                            <hr style="border-top: 0.1px solid black; margin: 1px 0;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right; padding: 0px; font-size: 13px;">
                                            Sisa Transfer
                                        </td>
                                        <td class="td"
                                            style="text-align: right; padding-right: 16px; font-size: 13px;">
                                            {{ number_format($cetakpdf->grand_total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
                        <tr>
                            <td style="text-align: center;">
                                <table style="margin: 0 auto;">
                                    <tr style="text-align: center;">
                                        <td style="font-size: 13px;" class="label">
                                            {{ $cetakpdf->nama_driver }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="separator" colspan="2"><span></span></td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td style="font-size: 13px;" class="label">Sopir</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="text-align: center;">
                                <table style="margin: 0 auto;">
                                    <tr style="text-align: center;">
                                        <td style="font-size: 13px;" class="label">
                                            DJOHAN WAHYUDI
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="separator" colspan="2"><span></span></td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td style="font-size: 13px;" class="label">Finance</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="text-align: center;">
                                <table style="margin: 0 auto;">
                                    <tr style="text-align: center;">
                                        <td style="font-size: 13px;" class="label">
                                            {{-- @if ($cetakpdf->user)
                                {{ $cetakpdf->user->karyawan->nama_lengkap }}
                            @else
                                user tidak ada
                            @endif --}}
                                            {{ auth()->user()->karyawan->nama_lengkap }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="separator" colspan="2"><span></span></td>
                                    </tr>
                                    <tr style="text-align: center; font-size: 13px;">
                                        <td class="label">Admin</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div style="text-align: right; font-size:12px; margin-bottom:10px">
                        <span style="font-style: italic;">Printed Date
                            {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
                    </div>
                </div>
            </div>
        @endfor
    @endfor
</body>

</html>
