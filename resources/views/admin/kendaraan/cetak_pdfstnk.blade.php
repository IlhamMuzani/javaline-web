<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <link rel="stylesheet" href="{{ asset('falcon/style.css') }}"> --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>

    <style type="text/css">
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: Arial, sans-serif;
        }


        .invoice-box table {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: Arial, sans-serif;
        }
    </style>

</head>

<body>

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <td>
                <div style="display: inline-block;">
                    @if ($cetakpdf->gambar_stnk)
                        <img src="{{ public_path('storage/uploads/' . $cetakpdf->gambar_stnk) }}"
                            alt="{{ $cetakpdf->kode_kendaraan }}" width="400" height="220">
                    @else
                        <img src="{{ public_path('adminlte/dist/img/img-placeholder.jpg') }}"
                            alt="{{ $cetakpdf->kode_kendaraan }}" width="200" height="200">
                    @endif
                </div>
            </td>
        </table>
    </div>

</body>

</html>
