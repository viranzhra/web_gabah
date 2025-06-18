<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    protected $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = config('services.api.base_url') . '/roles';
    }

    public function getRolesData()
    {
        $response = Http::get($this->baseApiUrl);
        $data = $response->json();

        if ($response->failed()) {
            return response()->json(['data' => []]);
        }

        return DataTables::of($data['roles'])
            ->addColumn('action', function ($role) {
                return '
                <button class="btn btn-sm btn-warning btn-edit" data-id="' . $role['id'] . '">Edit</button>
                <form method="POST" action="/roles/' . $role['id'] . '" class="d-inline delete-form">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin?\')">Hapus</button>
                </form>
            ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getUsersData()
    {
        $response = Http::get($this->baseApiUrl);
        $data = $response->json();

        if ($response->failed()) {
            return response()->json(['data' => []]);
        }

        $users = $data['users'] ?? [];

        return DataTables::of($users)
            ->addColumn('roles', function ($user) {
                if (isset($user['roles']) && is_array($user['roles'])) {
                    return implode(', ', array_column($user['roles'], 'name'));
                }
                return '-';
            })
            ->make(true);
    }

    public function index()
    {
        $response = Http::get($this->baseApiUrl);
        $data = $response->json();

        if ($response->failed()) {
            abort(500, 'Gagal mengambil data dari API');
        }

        return view('administrator.role_manage', [
            'roles' => $data['roles'],
            'permissions' => $data['permissions'],
            'users' => $data['users'],
            'rolePermissions' => $data['rolePermissions'],
        ]);
    }

    public function store(Request $request)
    {
        $response = Http::post($this->baseApiUrl, $request->only('name', 'permissions'));

        if ($response->successful()) {
            return redirect()->route('roles.index')->with('success', 'Role created successfully');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan role');
    }

    public function edit($id)
    {
        $response = Http::get($this->baseApiUrl . '/' . $id);

        if ($response->failed()) {
            return response()->json(['error' => 'Gagal mengambil data role'], 500);
        }

        return response()->json($response->json());
    }

    public function update(Request $request, $id)
    {
        $response = Http::put($this->baseApiUrl . '/' . $id, $request->only('name', 'permissions'));

        if ($response->successful()) {
            return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui role');
    }

    public function destroy($id)
    {
        $response = Http::delete($this->baseApiUrl . '/' . $id);

        if ($response->successful()) {
            return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
        }

        return redirect()->back()->with('error', 'Gagal menghapus role');
    }
}
