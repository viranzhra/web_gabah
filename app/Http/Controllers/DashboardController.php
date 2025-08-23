<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('sanctum_token') || !Auth::check()) {
            return redirect()->route('login');
        }

        $token = session('sanctum_token');
        $role  = session('user_role');

        return view('administrator.dashboard', [
            'token' => $token,
            'role'  => $role
        ]);
    }
}
