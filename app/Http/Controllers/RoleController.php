<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Menampilkan halaman manajemen roles dan users.
     */
    public function index()
    {
        return view('administrator.role_manage.index');
    }
}