<div>
    <div class="mb-3">
        <input type="text" class="form-control" wire:model="search" placeholder="Cari Karyawan">
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karyawans as $index => $item)
                    <tr>
                        <td>{{ $karyawans->firstItem() + $index }}</td>
                        <td>{{ $item->kode_karyawan }}</td>
                        <td>{{ $item->nama_lengkap }}</td>
                    </tr>
            @endforeach
        </tbody>
    </table>
    {{ $karyawans->links() }}
</div>
