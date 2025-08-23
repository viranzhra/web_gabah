<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        return view('administrator.riwayat.index');
    }

    public function detail($process_id)
    {
        return view('administrator.riwayat.detail', compact('process_id'));
    }
}