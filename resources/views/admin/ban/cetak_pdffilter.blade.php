<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>

    <style type="text/css">
        /* Reset all margins and padding */
        * {
            margin: 0;
            padding: 0;
        }

        .box1 {
            margin-left: 6px;
            margin-top: 6px;
        }

        .text-container {
            position: relative;

        }

        .text {
            font-size: 13px;
            margin-left: 2px;
            /* margin-top: 5px */
        }

        .bold-text {
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif
        }
    </style>

</head>

<body>
    <div>
        @foreach ($bans as $ban)
            {{-- <div class="text-container" style="page-break-after: always;"> --}}
            <div class="text-container">
                <table>
                    <td>
                        <div class="box1">
                            <table>
                                <td>
                                    <div style="display: inline-block;">
                                        {!! DNS2D::getBarcodeHTML("$ban->qrcode_ban", 'QRCODE', 2, 2) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="text">
                                        <p class="bold-text">{{ $ban->kode_ban }}</p>
                                        <p class="bold-text">{{ $ban->typeban->nama_type }}</p>
                                        <p class="bold-text">{{ $ban->ukuran->ukuran }}</p>
                                    </div>
                                </td>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div class="box1">
                            <table>
                                <td>
                                    <div style="display: inline-block;">
                                        {!! DNS2D::getBarcodeHTML("$ban->qrcode_ban", 'QRCODE', 2, 2) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="text">
                                        <p class="bold-text">{{ $ban->kode_ban }}</p>
                                        <p class="bold-text">{{ $ban->typeban->nama_type }}</p>
                                        <p class="bold-text">{{ $ban->ukuran->ukuran }}</p>
                                    </div>
                                </td>
                            </table>
                        </div>
                    </td>
                </table>
            </div>
        @endforeach
    </div>
</body>


</html>
