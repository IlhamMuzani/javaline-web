@foreach ($tagihan_ekspedisis as $tagihan)
    <img src="{{ asset('storage/uploads/' . $tagihan->gambar_bukti) }}" alt="Bukti">
@endforeach
