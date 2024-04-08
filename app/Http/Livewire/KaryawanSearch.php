<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Karyawan;

class KaryawanSearch extends Component
{
    public $keyword;

    public function render()
    {
        $karyawans = Karyawan::where('nama_lengkap', 'like', "%$this->keyword%")
            ->orWhere('kode_karyawan', 'like', "%$this->keyword%")
            ->paginate(10);

        return view('livewire.karyawan-search', ['karyawans' => $karyawans]);
    }
}