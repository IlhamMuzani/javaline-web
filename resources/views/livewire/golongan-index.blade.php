<div>
    <input type="text" wire:model="search" placeholder="Search...">
    <table>
        <thead>
            <tr>
                <th>Nama Golongan</th>
                <!-- Tambahkan kolom lain sesuai kebutuhan -->
            </tr>
        </thead>
        <tbody>
            @foreach($golongans as $golongan)
                <tr>
                    <td>{{ $golongan->nama_golongan }}</td>
                    <!-- Tambahkan kolom lain sesuai kebutuhan -->
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $golongans->links() }}
</div>
