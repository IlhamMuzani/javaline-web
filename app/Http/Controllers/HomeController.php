<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function check_user()
    {
        if (auth()->user()->isAdmin()) {
            return redirect('admin');
        } elseif (auth()->user()->isPelanggan()) {
            return redirect('pelanggan');
        } elseif (auth()->user()->isDriver()) {
            return redirect('driver');
        }
    }
}