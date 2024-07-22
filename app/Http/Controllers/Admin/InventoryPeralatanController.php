<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_inventory;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\Validator;

class InventoryPeralatanController extends Controller
{
    public function index(Request $request)
    {
        $kendaraans = Kendaraan::all();
        $kendaraan = $request->kendaraan_id;

        $detail_inventorys = collect(); // Initialize an empty collection

        if ($kendaraan) {
            $inquery = Detail_inventory::query();
            $inquery->where('kendaraan_id', $kendaraan);
            $inquery->orderBy('id', 'DESC');
            $detail_inventorys = $inquery->get();
        }

        return view('admin.inventory_peralatan.index', compact('detail_inventorys', 'kendaraans'));
    }
}