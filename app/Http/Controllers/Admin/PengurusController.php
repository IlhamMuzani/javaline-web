<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Validator;

class PengurusController extends Controller
{
    public function index()
    {
        $posts = Post::get();
        $karyawans = Karyawan::where('departemen_id', 5)->get();
        return view('admin/pengurus.index', compact('karyawans', 'posts'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'post_id' => 'required',
            ],
            [
                'post_id.required' => 'Pilih Post',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $karyawan = Karyawan::findOrFail($id);

        $karyawan->post_id = $request->post_id;
        $karyawan->save();

        return redirect('admin/pengurus')->with('success', 'Berhasil mengubah post');
    }
}