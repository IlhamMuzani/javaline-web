@for ($i = 0; $i < count($tagihan_ekspedisis); $i += 2)
    @for ($j = $i; $j < $i + 2 && $j < count($tagihan_ekspedisis); $j++)
        @php
            $cetakpdf = $tagihan_ekspedisis[$j];
        @endphp
        @if ($cetakpdf->gambar_bukti == null)
            @if ($cetakpdf->detail_tagihan->first()->gambar_buktifaktur == null)
                <span class="text-muted">Tidak ada PDF yang diunggah.</span>
            @else
                <a style="margin-left:15px; margin-right:15px;"
                    href="{{ asset('storage/uploads/' . $cetakpdf->detail_tagihan->first()->gambar_buktifaktur) }}"
                    target="_blank" class="text-bold">Lihat Bukti Potong
                    Pajak</a>
            @endif
            {{-- <span class="text-muted">Tidak ada PDF yang diunggah.</span> --}}
        @else
            <a style="margin-left:15px; margin-right:15px;"
                href="{{ asset('storage/uploads/' . $cetakpdf->gambar_bukti) }}"
                target="_blank" class="text-bold">Lihat Bukti Potong Pajak</a>
        @endif
    @endfor
@endfor
