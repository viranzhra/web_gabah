<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JenisGabahController extends Controller
{
    public function index(Request $request)
    {
        return view('administrator.data_master.jenis_gabah');
    }
}
