<table>
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th>No Memo</th>
            <th>Tanggal</th>
            <th>Sopir</th>
            <th>No Kabin</th>
            <th>Rute</th>
            <th>U. Jalan</th>
            <th>U. Tambah</th>
            <th>Deposit</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inquery as $memoekspedisi)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $memoekspedisi->kode_memo }}</td>
                <td>{{ $memoekspedisi->tanggal }}</td>
                <td>{{ substr($memoekspedisi->nama_driver, 0, 10) }} ..</td>
                <td>{{ $memoekspedisi->no_kabin }}</td>
                <td>
                    @if ($memoekspedisi->nama_rute == null)
                        rute tidak ada
                    @else
                        {{ $memoekspedisi->nama_rute }}
                    @endif
                </td>
                <td class="text-right">{{ number_format($memoekspedisi->uang_jalan, 0, '', '') }}</td>
                <td class="text-right">
                    @if ($memoekspedisi->biaya_tambahan == null)
                        0
                    @else
                        {{ number_format($memoekspedisi->biaya_tambahan, 0, '', '') }}
                    @endif
                </td>
                <td class="text-right">
                    @if ($memoekspedisi->deposit_driver == null)
                        0
                    @else
                        {{ number_format($memoekspedisi->deposit_driver, 0, '', '') }}
                    @endif
                </td>
                <td class="text-right">{{ number_format($memoekspedisi->sub_total, 0, '', '') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
