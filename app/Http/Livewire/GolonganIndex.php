<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Golongan;

class GolonganIndex extends Component
{
    use WithPagination;

    public $search;

    public function render()
    {
        $golongans = Golongan::where('nama_golongan', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.golongan-index', compact('golongans'));
    }
}