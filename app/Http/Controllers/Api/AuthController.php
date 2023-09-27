<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_user' => 'required',
            'password' => 'required',
        ], [
            'kode_user.required' => 'Kode tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return $this->response(FALSE, $error);
        }

        $kode_user = $request->kode_user;
        $password = $request->password;

        $user = User::where('kode_user', $kode_user)
            ->whereHas('karyawan', function ($query) {
                $query->where('departemen_id', 2);
            })
            ->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                return $this->response(TRUE, array('Berhasil login, Selamat Datang ' . $user->name), array($user));
            } else {
                return $this->response(FALSE, array('Kode atau password tidak sesuai!'));
            }
        } else {
            return $this->response(FALSE, array('Pengguna tidak ditemukan!'));
        }
    }

    public function detail($id)
    {
        $user = User::where('id', $id)->with('karyawan')->first();

        if ($user) {
            return $this->response(TRUE, array('Berhasil menampilkan data'), array($user));
        } else {
            return $this->response(FALSE, array('Gagal menampilkan detail!'));
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode_user' => 'required',
                'password' => 'required|min:6|confirmed',
            ],
            [
                'kode_user.required' => 'kode tidak boleh kosong',
                'password.required' => 'Password tidak boleh kosong',
                'password.min' => 'Password minimum 6 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sesuai!',
            ]
        );

        // if (is_null($user)) {
        //     return $this->response(FALSE, 'Pendaftaran gagal, kode tidak ditemukan');
        // }
        $user = User::where('kode_user', $request->kode_user)->first();

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }


        User::where('kode_user', $request->kode_user)->update([
            'password' => bcrypt($request->password),
            'level' => 'admin',
        ]);

        if ($user) {
            return $this->response(TRUE, array('Berhasil melakukan pendaftaran'), array($user));
        } else {
            return $this->response(FALSE, 'Pendaftaran gagal, ' + $validator->errors()->all()[0]);
        }
    }



    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'kode_user' => 'required|exists:users,kode_user',
    //         'password' => 'required|min:6|confirmed',
    //     ], [
    //         'kode_user.required' => 'Kode user harus diisi!',
    //         'kode_user.exists' => 'Kode user tidak ditemukan!',
    //         'password.required' => 'Password tidak boleh kosong!',
    //         'password.min' => 'Password minimal 6 karakter!',
    //         'password.confirmed' => 'Konfirmasi password tidak sesuai!',
    //     ]);

    //     if ($validator->fails()) {
    //         $errors = $validator->errors()->all();
    //         return $this->response(FALSE, $errors);
    //     }


    //     $user = User::where('kode_user', $request->kode_user)->update([
    //         'kode_user' => $request->kode_user,
    //         'password' => bcrypt($request->password),
    //         'level' => 'admin'
    //     ]);

    //     // ini sudah benar tpi tidak menggunakan update kode user
    //     // $user = User::where('kode_user', $request->kode_user)->update([
    //     //     'password' => bcrypt($request->password),
    //     //     'level' => 'admin'
    //     // ]);


    //     if ($user) {
    //         return $this->response(TRUE, array('Berhasil melakukan pendaftaran'), array($user));
    //     } else {
    //         return $this->response(FALSE, 'Pendaftaran gagal');
    //     }
    // }

    public function response($status, $message, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
}