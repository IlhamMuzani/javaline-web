<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'password' => 'nullable|confirmed'
        ], [
            'gambar.image' => 'Foto harus berformat jpeg, jpg, png!',
            'password.confirmed' => 'Konfirmasi password tidak sesuai!'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        if ($request->password) {
            $password = bcrypt($request->password);
        } else {
            $password = $user->password;
        }

        if ($request->gambar) {
            Storage::disk('local')->delete('public/uploads/' . $user->gambar);
            $gambar = str_replace(' ', '', $request->gambar->getClientOriginalName());
            $namaGambar = 'karyawan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = $user->gambar;
        }

        Karyawan::where('id', $user->id)
            ->update([
                'gambar' => $namaGambar,
            ]);

        User::where('id', $user->id)->update([
            'password' => $password
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui Profile');
    }
}