<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <link rel="stylesheet" href="{{ asset('falcon/style.css') }}"> --}}
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
            margin-left: 20px;
            margin-top: 130px
        }

        .box {
            margin-left: 27px;
            margin-top: 1px;
        }

        .box3 {
            margin-left: 27px;
            margin-top: 4px;
        }


        .text-container {
            position: relative;
            width: 200px;
            /* Set an appropriate width */
            height: 68px;
            /* Set an appropriate height */
            transform: rotate(90deg);
        }

        .text {
            white-space: nowrap;
            position: absolute;
            margin-left: 60px;
            margin-top: 56px;
            font-size: 10px;
            top: 0;
            /* Adjust the top position as needed */
            left: 0;
            /* Adjust the left position as needed */
        }
    </style>

</head>

<body>
    <div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="box1">
            <img src="{{ asset('storage/uploads/' . $karyawans->gambar) }}" width="150" height="150"
                class="w-100 rounded border">
        </div>
        {{-- <div class="box1">
            {!! DNS2D::getBarcodeHTML("$karyawans->qrcode_karyawan", 'QRCODE', 10, 10) !!}

        </div> --}}


    </div>
</body>

</html>
