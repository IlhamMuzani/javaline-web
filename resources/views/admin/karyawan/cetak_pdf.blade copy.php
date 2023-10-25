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
            /* margin-left: 27px; */
            margin-top: 5px;
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
            margin-left: 66px;
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
        <div class="box1">
            <img src="{{ asset('storage/uploads/' . $karyawans->gambar) }}" width="55" height="55"
                class="w-100 rounded border">
        </div>
        <div class="text-container">
            <div class="text">
                <p>Kode Ban</p>
                <p>Type Ban</p>
                <p>Ukuran Ban</p>
            </div>
        </div>
        <div class="box">
            <img src="{{ asset('storage/uploads/' . $karyawans->gambar) }}" width="55" height="55"
                class="w-100 rounded border">
        </div>
        <div class="text-container">
            <div class="text">
                <p>Kode Ban</p>
                <p>Type Ban</p>
                <p>Ukuran Ban</p>
            </div>
        </div>
        <div class="box3">
            <img src="{{ asset('storage/uploads/' . $karyawans->gambar) }}" width="55" height="55"
                class="w-100 rounded border">
        </div>
        <div class="text-container">
            <div class="text">
                <p>Kode Ban</p>
                <p>Type Ban</p>
                <p>Ukuran Ban</p>
            </div>
        </div>
    </div>
</body>

</html>
