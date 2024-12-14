<table>
    <thead>
        <tr>
            <th>P</th>

            <th>{{ str_replace('-', '', $memo_asuransi->first()->tanggal_awal) }}</th>

            <th>1390088880046</th>

            <th>{{ $memo_asuransi->count() }}</th>

            <th>{{ $memo_asuransi->sum('hasil_tarif') }}</th>

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
        @foreach ($memo_asuransi as $index => $detail)
            <tr>
                <td>{{ $detail->user->karyawan->norek ?? null }}</td>
                <td>{{ $detail->user->karyawan->nama_lengkap ?? null }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>IDR</td>
                <td>{{ $detail->hasil_tarif }}</td>
                <td></td>
                <td></td>
                <td>{{ $detail->user->karyawan->nama_bank === 'MANDIRI' ? 'IBU' : 'LBU' }}</td>
                <td></td>
                <td>{{ $detail->user->karyawan->nama_bank ?? null }}</td>
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
