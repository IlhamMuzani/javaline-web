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
            margin-left: 10px;
            margin-top: 5px;
        }

        .box {
            margin-left: 10px;
            margin-top: 13px;
        }

        .text-container {
            position: relative;
            margin-right: 760px;
            margin-left: 15px;
            /* width: 200px; */
            /* Set an appropriate width */
            transform: rotate(90deg);
        }

        .text {
            font-size: 10px
        }

        .bold-text {
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif
        }
    </style>

</head>

<body>
    <div>
        <div class="box1">
            <?php
            use BaconQrCode\Renderer\ImageRenderer;
            use BaconQrCode\Writer;
            
            // Ubah tautan menjadi QR code
            $qrcode = new Writer(new ImageRenderer(new \BaconQrCode\Renderer\RendererStyle\RendererStyle(50), new \BaconQrCode\Renderer\Image\SvgImageBackEnd()));
            $qrcodeData = $qrcode->writeString($bans->qrcode_ban);
            
            // Tampilkan gambar QR code
            echo '<img src="data:image/png;base64,' . base64_encode($qrcodeData) . '" />';
            ?>
        </div>
        <div class="text-container">
            <div class="text">
                <p class="bold-text">{{ $bans->kode_ban }}</p>
                <p class="bold-text">{{ $bans->typeban->nama_type }}</p>
                <p class="bold-text">{{ $bans->ukuran->ukuran }}</p>
            </div>
        </div>
        <div class="box">
            <?php
            
            // Ubah tautan menjadi QR code
            $qrcode = new Writer(new ImageRenderer(new \BaconQrCode\Renderer\RendererStyle\RendererStyle(50), new \BaconQrCode\Renderer\Image\SvgImageBackEnd()));
            $qrcodeData = $qrcode->writeString($bans->qrcode_ban);
            
            // Tampilkan gambar QR code
            echo '<img src="data:image/png;base64,' . base64_encode($qrcodeData) . '" />';
            ?>
        </div>

        <div class="text-container">
            <div class="text">
                <p class="bold-text">{{ $bans->kode_ban }}</p>
                <p class="bold-text">{{ $bans->typeban->nama_type }}</p>
                <p class="bold-text">{{ $bans->ukuran->ukuran }}</p>
            </div>
        </div>
    </div>
</body>

</html>
