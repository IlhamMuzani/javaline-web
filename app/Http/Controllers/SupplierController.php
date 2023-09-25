<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function detail($kode)
    {
        // return "hellow word";
        $supplier = Supplier::where('kode_supplier', $kode)->first();
        return view('admin/supplier.qrcode_detail', compact('supplier'));
    }
}