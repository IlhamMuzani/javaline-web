<table>
    <thead>
        <tr>
            <th>P</th>

            <th>{{ str_replace('-', '', $nota_bon->first()->tanggal_awal) }}</th>

            <th>1390088880046</th>

            <th>{{ $nota_bon->count() }}</th>

            <th>{{ $nota_bon->sum('nominal') }}</th>

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
        @foreach ($nota_bon as $index => $detail)
            <tr>
                <td>{{ $detail->user->karyawan->norek ?? null }}</td>
                <td>{{ $detail->user->karyawan->nama_lengkap ?? null }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>IDR</td>
                <td>{{ $detail->nominal }}</td>
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
