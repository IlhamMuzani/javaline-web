<table>
    <thead>
        <tr>
            <th>P</th>

            <th>{{ str_replace('-', '', $perhitungan_gaji->tanggal_awal) }}</th>

            <th>1390088880046</th>

            <th>{{ $perhitungan_gaji->detail_gajikaryawan->count() }}</th>

            <th>{{ $perhitungan_gaji->grand_total }}</th>

            <th>
            </th>

            <th>
            </th>
            <th>
            </th>

            <th>
            </th>

            <th>
            </th>
            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>

            <th>
            </th>
        </tr>
    </thead>

    <tbody>
        @foreach ($detail_gaji as $index => $detail)
            <tr>

                <td>{{ $detail->karyawan->norek ?? null }}</td>
                <td>{{ $detail->karyawan->nama_lengkap ?? null }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>IDR</td>
                <td>{{ $detail->gaji_bersih }}</td>
                <td></td>
                <td></td>
                <td>{{ $detail->karyawan->nama_bank === 'MANDIRI' ? 'IBU' : 'LBU' }}</td>
                <td></td>
                <td>{{ $detail->karyawan->nama_bank ?? null }}</td>
                <td>SEMARANG</td>
                <td></td>
                <td></td>
                <td></td>
                <td>N</td>
                <td>
                </td>
                {{-- <td>BEN</td>
                <td>1</td> --}}
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>

</table>
