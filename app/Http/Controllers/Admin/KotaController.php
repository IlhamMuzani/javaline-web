<?php

namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kota;
use Illuminate\Support\Facades\Validator;

class KotaController extends Controller
{
    public function store(Request  $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
            ],
            [
                'nama.required' => 'Masukan nama',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }
        Kota::create(array_merge($request->all()));
        return redirect('admin/status_perjalanan')->with('success', 'Berhasil menambahkan tujuan');
    }
}