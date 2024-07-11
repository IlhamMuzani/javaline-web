<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Potong Pajak</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
            /* font-family: 'DOSVGA', monospace; */
            color: black;

            margin-top: 0px;
            margin-right: 13px;
            margin-left: 13px;
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
            padding: 13px 20px;
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

<body style="margin-top: 0px; padding: 0;">
    @for ($i = 0; $i < count($detail_tagihans); $i += 2)
        @for ($j = $i; $j < $i + 2 && $j < count($detail_tagihans); $j++)
            @php
                $cetakpdf = $detail_tagihans[$j];
            @endphp

            <table style="width: 100%;">
                <tr>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%; text-align: center;">
                                <div style="width: 100%;">
                                    <p>Nomor Bukti Faktur {{ $cetakpdf->nomor_buktifaktur }} </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%; text-align: center;">
                                <div style="width: 100%;">
                                    @if ($cetakpdf->gambar_buktifaktur == null)
                                        <img class="mt-3"
                                            src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                            style="width: 100%; height: auto; max-width: 100%;" alt="Logo Tigerload">
                                    @else
                                        <img src="{{ asset('storage/uploads/' . $cetakpdf->gambar_buktifaktur) }}"
                                            alt="{{ $cetakpdf->gambar_buktifaktur }}"
                                            style="width: 100%; height: auto; max-width: 100%;" alt="Logo Tigerload">
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </tr>
            </table>
        @endfor
    @endfor
    <div style="text-align: right; font-size:13px; margin-bottom:5px;">
        <span style="font-style: italic;">Printed Date
            {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
    </div>
</body>

</html>
