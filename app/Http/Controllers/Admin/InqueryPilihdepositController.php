<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InqueryPilihdepositController extends Controller
{
    public function index()
    {
        return view('admin/inquery_pilihdeposit.index');
        
    }
}