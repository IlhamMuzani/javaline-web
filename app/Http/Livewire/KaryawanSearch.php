<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Karyawan;
use Livewire\WithPagination;

class KaryawanSearch extends Component
{
    public $keyword;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        return view('livewire.karyawan-search', ['karyawans' => Karyawan::paginate(5)]);
    }

}