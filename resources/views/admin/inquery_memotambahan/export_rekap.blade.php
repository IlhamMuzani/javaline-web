<table>
    <thead>
        <tr>
            <th>P</th>

            <th>{{ str_replace('-', '', $memotambahan->first()->tanggal_awal) }}</th>

            <th>1390088880046</th>

            <th>{{ $memotambahan->count() }}</th>

            <th>{{ $memotambahan->sum('grand_total') }}</th>

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
        @foreach ($memotambahan as $index => $detail)
            <tr>
                <td>{{ $detail->memo_ekspedisi->user->karyawan->norek ?? null }}</td>
                <td>{{ $detail->memo_ekspedisi->user->karyawan->nama_lengkap ?? null }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>IDR</td>
                <td>{{ $detail->grand_total }}</td>
                <td></td>
                <td></td>
                <td>{{ $detail->memo_ekspedisi->user->karyawan->nama_bank === 'MANDIRI' ? 'IBU' : 'RBU' }}</td>
                <td></td>
                <td>{{ $detail->memo_ekspedisi->user->karyawan->nama_bank ?? null }}</td>
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
