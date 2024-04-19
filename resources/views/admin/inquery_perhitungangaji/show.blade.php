<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GAJI KARYAWAN</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
            /* font-family: 'DOSVGA', monospace; */
            color: black;

            margin-top: 5px;
            margin-right: 11px;
            margin-left: 11px;
            /* Margin kiri sebesar 20 piksel */

            /* font-weight: bold; */
            /* Atur ketebalan huruf menjadi bold */
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin-top: 7rem;
        }

        .blue-button {
            padding: 11px 20px;
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
            /* padding-left: 5px; */
        }

        .info-titik {
            vertical-align: top;
        }

        /* tanda tangan  */

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .separator {
            padding-top: 11px;
            text-align: center;
        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -11px;
        }
    </style>
</head>


<body style="margin-top: 0; padding: 0;">

    <div style="text-align: center; margin-top:11px">
        <span style="font-weight: bold; font-size: 16px;">REKAP GAJI TEKNISI BINA ANUGERAH TRANSINDO(
            {{ \Carbon\Carbon::parse($cetakpdf->tanggal_awal)->locale('id')->isoFormat('D MMMM YYYY') }})</span>
        <div class="text">
            <p style="font-size: 14px">Periode:{{ $cetakpdf->periode_awal }}s/d {{ $cetakpdf->periode_akhir }}</p>
        </div>
    </div>

    <br>
    <table style="width: 100%; border-top: 1px solid #000;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;  font-weight:bold; width:3%">
                NO.</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;  font-weight:bold; width:9%">
                ID KARYAWAN</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;  font-weight:bold; width:10%">
                NAMA LENGKAP</td>
            {{-- <td class="td" style="text-align: right; padding: 0px; font-size: 12px;  font-weight:bold; ">
                GAPOK</td> --}}
            <td class="td" style="text-align: right; padding: 0px; font-size: 12px;  font-weight:bold; ">
                HK</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 12px;  font-weight:bold; ">
                UM</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 12px;  font-weight:bold; ">
                UH</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 12px;  font-weight:bold;">
                LEMBUR</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 12px;  font-weight:bold;">
                STORING</td>
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;  font-weight:bold;">
                GAJI <span> <br>KOTOR</span></td>
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px; font-weight:bold; width:15%">
                KETERLAMBATAN <span> <br>(&lt; 30 MNT) (> 30 MNT)</span></td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 12px;  font-weight:bold; ">
                BPJS</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 12px;  font-weight:bold; ">
                ABSEN
            </td>
            <td class="td" style="text-align: right; font-size: 12px;  font-weight:bold; width:10%">GAJI BERSIH
            </td>
        </tr>
        <!-- Add horizontal line below this row -->
        <tr>
            <td colspan="13" style="padding: 0px;">
                <hr style="border: 0.5px solid; margin-top:3px; margin-bottom: 1px; padding: 0;">
                <hr style="border: 0.5px solid; margin-top:1px; margin-bottom: 1px; padding: 0;">
            </td>
        </tr>
        @php
            $Grandtotal = 0;
        @endphp
        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                    {{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                    @if ($item->karyawan)
                        {{ $item->karyawan->kode_karyawan }}
                    @endif
                </td>
                <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                    <?php
                    $words = array_slice(str_word_count($item->nama_lengkap, 1), 0, 2);
                    $shortened_words = array_map(function ($word) {
                        return substr($word, 0, 5);
                    }, $words);
                    echo implode(' ', $shortened_words);
                    ?>
                </td>
                {{-- <td class="td" style="text-align: right; padding: 0px; font-size: 12px;">
                    {{ number_format($item->gaji, 0, ',', '.') }}
                </td> --}}
                <td class="td" style="text-align: right; padding: 0px; font-size: 12px;">
                    {{ $item->hari_kerja }}
                </td>
                <td class="td" style="text-align: right; padding: 0px; font-size: 12px;">
                    {{ number_format($item->uang_makan, 0, ',', '.') }}

                </td>
                <td class="td" style="text-align: right; padding: 0px; font-size: 12px;">
                    {{ number_format($item->uang_hadir, 0, ',', '.') }}

                </td>
                <td class="td" style="text-align: right; padding: 1px; font-size: 12px;">
                    {{ number_format($item->hasil_lembur, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding: 1px; font-size: 12px;">
                    {{ number_format($item->hasil_storing, 1, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding-right: 7px; font-size: 12px;">
                    {{ number_format($item->gaji_kotor, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: center; padding: 1px; font-size: 12px;">
                    <table style="width: 100%; text-align: right; padding-right:5px">
                        <tr>
                            <td style="width: 50%;">
                                {{ number_format($item->hasilkurang, 0, ',', '.') }}
                            </td>
                            <td style="width: 50%;">
                                {{ number_format($item->hasillebih, 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="td" style="text-align: right; padding-right: 7px; font-size: 12px;">
                    {{ number_format($item->potongan_bpjs, 0, ',', '.') }}
                <td class="td" style="text-align: right; padding-right: 7px; font-size: 12px;">
                    {{ number_format($item->hasil_absen, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; font-size: 12px;">
                    {{ number_format($item->gajinol_pelunasan, 0, ',', '.') }}
                </td>
            </tr>
            @php
                $Grandtotal += $item->gajinol_pelunasan;
            @endphp
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td colspan="12"
                style="text-align: right; font-weight: bold; margin-top:5px; margin-bottom:5px; font-size: 12px;">
                {{-- GRAND
                TOTAL --}}
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 12px;">
                Rp. {{ number_format($Grandtotal, 0, ',', '.') }}
            </td>
        </tr>
    </table>
    <br>
    
    <br>
    <br>

    <table style="width: 50%; border-top: 1px solid #000;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;  font-weight:bold;">
                NO.</td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;  font-weight:bold;">
                ID KARYAWAN</td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;  font-weight:bold;">
                NAMA LENGKAP</td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 12px;  font-weight:bold;">
                DEPOSIT AWAL</td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 12px;  font-weight:bold;">
                PELUNASAN DEPOSIT</td>
            <td class="td" style="text-align: right; font-size: 12px;  font-weight:bold;">SISA DEPOSIT
            </td>
        </tr>
        <!-- Add horizontal line below this row -->
        <tr>
            <td colspan="6" style="padding: 0px;">
                <hr style="border: 0.5px solid; margin-top:0px; margin-bottom: 1px; padding: 0;">
                <hr style="border: 0.5px solid; margin-top:1px; margin-bottom: 1px; padding: 0;">
            </td>
        </tr>
        @php
            $nomor_urut = 1;
            $GrandtotalsaldoAwal = 0;
            $GrandtotalsisaDeposit = 0;
            $Grandtotal = 0;
        @endphp
        @foreach ($details as $item)
            @if ($item->pelunasan_kasbon !== null && $item->pelunasan_kasbon != 0)
                <tr>
                    <td class="td"
                        style="text-align: center; padding: 2px; font-size: 12px; border-bottom: 1px solid black;">
                        {{ $loop->iteration }}
                    </td>
                    <td class="td"
                        style="text-align: left; padding: 2px; font-size: 12px; border-bottom: 1px solid black;">
                        @if ($item->karyawan)
                            {{ $item->karyawan->kode_karyawan }}
                        @endif
                    </td>
                    <td class="td"
                        style="text-align: left; padding: 2px; font-size: 12px; border-bottom: 1px solid black;">
                        {{ $item->nama_lengkap }}
                    </td>
                    <td class="td"
                        style="text-align: center; padding: 1px; font-size: 12px; border-bottom: 1px solid black;">
                        <table style="width: 100%; text-align: right; ">
                            <tr>
                                <td style="width: 30%;">
                                    Rp.
                                </td>
                                <td style="width: 70%;">
                                    - {{ number_format($item->kasbon_awal, 2, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="td"
                        style="text-align: center; padding: 1px; font-size: 12px; border-bottom: 1px solid black;">
                        <table style="width: 100%; text-align: right; padding-right:1px">
                            <tr>
                                <td style="width: 30%;">
                                    Rp.
                                </td>
                                <td style="width: 70%;">
                                    {{ number_format($item->pelunasan_kasbon, 2, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="td"
                        style="text-align: center; padding: 1px; font-size: 12px; border-bottom: 1px solid black;">
                        <table style="width: 100%; text-align: right;">
                            <tr>
                                <td style="width: 30%;">
                                    Rp.
                                </td>
                                <td style="width: 70%;">
                                    {{ number_format($item->sisa_kasbon - $item->pelunasan_kasbon, 2, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @php
                    $GrandtotalsaldoAwal += $item->kasbon_awal;
                    $GrandtotalsisaDeposit += $item->sisa_kasbon;
                    $Grandtotal += $item->pelunasan_kasbon;
                    $nomor_urut++;
                @endphp
            @endif
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6" style="padding: 2px;"></td>
        </tr>
        <tr>
            <td colspan="3"
                style="text-align: right; font-weight: bold; margin-top:5px; margin-bottom:5px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 12px;">
                <table style="width: 100%; text-align: right;">
                    <tr>
                        <td style="width: 30%;">
                            Rp.
                        </td>
                        <td style="width: 70%;">
                            - {{ number_format($GrandtotalsaldoAwal, 2, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 12px;">
                <table style="width: 100%; text-align: right;">
                    <tr>
                        <td style="width: 30%;">
                            Rp.
                        </td>
                        <td style="width: 70%;">
                            {{ number_format($Grandtotal, 2, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 12px;">
                <table style="width: 100%; text-align: right;">
                    <tr>
                        <td style="width: 30%;">
                            Rp.
                        </td>
                        <td style="width: 70%;">
                            - {{ number_format($GrandtotalsisaDeposit - $Grandtotal, 2, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <br>
</body>

<div class="container">
    <a href="{{ url('admin/inquery_perhitungangaji') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/perhitungan_gaji/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
</div>

</html>
