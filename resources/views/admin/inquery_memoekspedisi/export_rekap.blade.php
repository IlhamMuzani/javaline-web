<table>
    <thead>
        <tr>
            <th>P</th>

            <th>{{ str_replace('-', '', $memo_ekspedisi->first()->tanggal_awal) }}</th>

            <th>1390088880046</th>

            <th>{{ $memo_ekspedisi->count() }}</th>

            <th>{{ $memo_ekspedisi->sum('sub_total') }}</th>

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
        @foreach ($memo_ekspedisi as $index => $detail)
            <tr>
                <td>{{ $detail->user->karyawan->norek ?? null }}</td>
                <td>{{ $detail->user->karyawan->nama_lengkap ?? null }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>IDR</td>
                <td>{{ $detail->sub_total }}</td>
                <td></td>
                <td></td>
                <td>{{ $detail->user->karyawan->nama_bank === 'MANDIRI' ? 'IBU' : 'RBU' }}</td>
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
