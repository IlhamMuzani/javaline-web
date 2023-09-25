<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect('check-user');
        } else {
            return view('layouts.login');
        }
    }

    public function tologin()
    {
        return view('layouts.login');
    }

    public function toregister()
    {
        return view('layouts.register');
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_user' => 'required',
            'password' => 'required'
        ], [
            'kode_user.required' => 'Kode tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $user = User::where('kode_user', $request->kode_user)->first();

        if (!$user) {
            return redirect('login')->with('error', array('User tidak ditemukan'));
        }

        $auth = Auth::attempt([
            'kode_user' => $request->kode_user,
            'password' => $request->password
        ]);

        if ($auth) {
            return redirect('check-user');
        } else {
            return back()->with('error', array('Kode dan password tidak cocok'));
        }
    }

    public function registeruser(Request $request)
    {
        $user = User::where('kode_user', $request->kode_user)->first();
        if (!is_null($user->password)) {
            return redirect('register')->with('error', array('Anda tidak dapat registrasi 2 kali'));
        }

        $validator = Validator::make(
            $request->all(),
            [
                'kode_user' => 'required',
                'password' => 'required|min:6|confirmed',
            ],
            [
                'kode_user.required' => 'Kode tidak boleh kosong',
                'password.required' => 'Password tidak boleh kosong',
                'password.min' => 'Password minimum 6 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sesuai!',
            ]
        );

        $user = User::where('kode_user', $request->kode_user)->first();
        if (is_null($user)) {
            return redirect('register')->with('error', array('Kode tidak ditemukan'));
        }

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        User::where('kode_user', $request->kode_user)->update([
            'password' => bcrypt($request->password),
            'level' => 'admin',
        ]);

        return redirect('login')->with('success', 'Berhasil mendaftar');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('login')->with('success', 'Berhasil logout');
    }
}