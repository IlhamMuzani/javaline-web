<table>
    <thead>
        <tr>
            <th class="text-center" style="font-weight: bold;">No</th>
            <th style="font-weight: bold;">Id Karyawan</th>
            <th style="font-weight: bold;">Nama Lengkap</th>
            <th style="font-weight: bold;">HK</th>
            <th style="font-weight: bold;">UM</th>
            <th style="font-weight: bold;">UH</th>
            <th style="font-weight: bold;">Lembur Jam</th>
            <th style="font-weight: bold;">Lembur Hari</th>
            <th style="font-weight: bold;">Gaji Kotor</th>
            <th style="font-weight: bold;">Terlambat &lt; 30 mnt</th>
            <th style="font-weight: bold;">Terlambat &gt; 30 mnt</th>
            <th style="font-weight: bold;">BPJS</th>
            <th style="font-weight: bold;">Tidak Absen</th>
            <th style="font-weight: bold;">Pelunasan Kasbon</th>
            <th style="font-weight: bold;">Gaji Bersih</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalGajiBersih = 0;
        @endphp
        @foreach ($detail_gaji as $detail)
            <tr>
                <td colspan="1">{{ $loop->iteration }}</td>
                <td>{{ $detail->karyawan->kode_karyawan ?? null }}</td>
                <td>{{ $detail->karyawan->nama_lengkap ?? null }}</td>
                <td>{{ $detail->hari_kerja }}</td>
                <td>{{ $detail->uang_makan }}</td>
                <td>{{ $detail->uang_hadir }}</td>
                <td>{{ $detail->hasil_lembur }}</td>
                <td>{{ $detail->hasil_storing }}</td>
                <td>{{ $detail->gaji_kotor }}</td>
                <td>{{ $detail->hasilkurang }}</td>
                <td>{{ $detail->hasillebih }}</td>
                <td>{{ $detail->potongan_bpjs }}</td>
                <td>{{ $detail->hasil_absen }}</td>
                <td>{{ $detail->pelunasan_kasbon }}</td>
                <td>{{ $detail->gaji_bersih }}</td>
            </tr>
            @php
                $totalGajiBersih += $detail->gaji_bersih; // Tambahkan Gaji Bersih ke Total
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="14" class="text-right"><strong>Total Gaji Bersih:</strong></td>
            <td><strong>{{ $totalGajiBersih }}</strong></td>
        </tr>
    </tfoot>
</table>


{{-- <table>
    <thead>
        <tr>
            <th>Nama Karyawan</th>
            <th>Jabatan</th>
            <th>Gaji Pokok</th>
            <th>Detail Lainnya</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $perhitungan_gaji->id }}</td>
            <td>{{ $perhitungan_gaji->id }}</td>
            <td>{{ $perhitungan_gaji->id }}</td>
            <td>{{ $perhitungan_gaji->id }}</td>
        </tr>
        @foreach ($detail_gaji as $detail)
            <tr>
                <td colspan="3">Detail {{ $loop->iteration }}</td>
                <td>{{ $detail->total }}</td>
            </tr>
        @endforeach
    </tbody>
</table> --}}
