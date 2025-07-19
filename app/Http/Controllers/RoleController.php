<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Static arrays to store dummy data
    private static $roles = [];
    private static $users = [];
    private static $nextRoleId = 1;
    private static $nextUserId = 1;

    // Predefined permissions for toggle switches
    private static $availablePermissions = [
        ['id' => 'view_dashboard', 'description' => 'Lihat Dasbor'],
        ['id' => 'edit_content', 'description' => 'Ubah Konten'],
        ['id' => 'manage_users', 'description' => 'Kelola Pengguna'],
        ['id' => 'delete_records', 'description' => 'Hapus Rekaman'],
        ['id' => 'create_reports', 'description' => 'Buat Laporan']
    ];

    public function index()
    {
        return view('administrator.role_manage.index');
    }

    // Initialize dummy data if arrays are empty
    private function initializeDummyData()
    {
        if (empty(self::$roles)) {
            self::$roles = [
                ['id' => self::$nextRoleId++, 'name' => 'Admin', 'permissions' => ['view_dashboard', 'edit_content', 'manage_users', 'delete_records', 'create_reports']],
                ['id' => self::$nextRoleId++, 'name' => 'Operator', 'permissions' => ['view_dashboard', 'edit_content']]
            ];
        }

        if (empty(self::$users)) {
            self::$users = [
                ['id' => self::$nextUserId++, 'name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'user123', 'role_id' => 1],
                ['id' => self::$nextUserId++, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'password' => 'user123', 'role_id' => 2]
            ];
        }
    }

    // Get available permissions for UI
    public function getPermissions()
    {
        try {
            return response()->json(['data' => self::$availablePermissions], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data hak akses'], 500);
        }
    }

    // Roles API endpoints
    public function getRoles()
    {
        try {
            $this->initializeDummyData();
            // Map permissions to their descriptions for display
            $roles = array_map(function ($role) {
                $role['permissions_display'] = array_map(function ($permId) {
                    $perm = array_filter(self::$availablePermissions, fn($p) => $p['id'] === $permId);
                    return !empty($perm) ? reset($perm)['description'] : $permId;
                }, $role['permissions']);
                return $role;
            }, self::$roles);
            return response()->json(['data' => $roles], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data role'], 500);
        }
    }

    public function storeRole(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'permissions' => 'array',
                'permissions.*' => 'in:' . implode(',', array_column(self::$availablePermissions, 'id'))
            ]);

            $this->initializeDummyData();
            $role = [
                'id' => self::$nextRoleId++,
                'name' => $validated['name'],
                'permissions' => $validated['permissions'] ?? []
            ];
            self::$roles[] = $role;

            return response()->json(['data' => $role], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal membuat role'], 500);
        }
    }

    public function showRole($id)
    {
        try {
            $this->initializeDummyData();
            $role = array_filter(self::$roles, fn($role) => $role['id'] == $id);
            if (empty($role)) {
                return response()->json(['message' => 'Role tidak ditemukan'], 404);
            }
            return response()->json(['data' => reset($role)], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Role tidak ditemukan'], 404);
        }
    }

    public function updateRole(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'permissions' => 'array',
                'permissions.*' => 'in:' . implode(',', array_column(self::$availablePermissions, 'id'))
            ]);

            $this->initializeDummyData();
            $index = array_search($id, array_column(self::$roles, 'id'));
            if ($index === false) {
                return response()->json(['message' => 'Role tidak ditemukan'], 404);
            }

            self::$roles[$index] = [
                'id' => $id,
                'name' => $validated['name'],
                'permissions' => $validated['permissions'] ?? []
            ];

            return response()->json(['data' => self::$roles[$index]], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui role'], 500);
        }
    }

    public function destroyRole($id)
    {
        try {
            $this->initializeDummyData();
            $index = array_search($id, array_column(self::$roles, 'id'));
            if ($index === false) {
                return response()->json(['message' => 'Role tidak ditemukan'], 404);
            }

            array_splice(self::$roles, $index, 1);
            return response()->json(['message' => 'Role berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus role'], 500);
        }
    }

    // Users API endpoints
    public function getUsers()
    {
        try {
            $this->initializeDummyData();
            $users = array_map(function ($user) {
                $role = array_filter(self::$roles, fn($role) => $role['id'] == $user['role_id']);
                $user['role'] = !empty($role) ? reset($role) : null;
                unset($user['password']); // Don't expose password in response
                return $user;
            }, self::$users);
            return response()->json(['data' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data pengguna'], 500);
        }
    }

    public function storeUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'password' => 'required|string|min:6',
                'role_id' => 'required|integer'
            ]);

            $this->initializeDummyData();
            // Check if email already exists
            if (array_filter(self::$users, fn($user) => $user['email'] === $validated['email'])) {
                return response()->json(['message' => 'Email sudah ada'], 422);
            }

            // Check if role_id exists
            if (!array_filter(self::$roles, fn($role) => $role['id'] == $validated['role_id'])) {
                return response()->json(['message' => 'Role tidak ditemukan'], 422);
            }

            $user = [
                'id' => self::$nextUserId++,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role_id' => $validated['role_id']
            ];
            self::$users[] = $user;

            $user['role'] = array_filter(self::$roles, fn($role) => $role['id'] == $user['role_id']);
            $user['role'] = !empty($user['role']) ? reset($user['role']) : null;
            unset($user['password']); // Don't expose password in response

            return response()->json(['data' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal membuat pengguna'], 500);
        }
    }

    public function showUser($id)
    {
        try {
            $this->initializeDummyData();
            $user = array_filter(self::$users, fn($user) => $user['id'] == $id);
            if (empty($user)) {
                return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
            }
            $user = reset($user);
            $user['role'] = array_filter(self::$roles, fn($role) => $role['id'] == $user['role_id']);
            $user['role'] = !empty($user['role']) ? reset($user['role']) : null;
            unset($user['password']); // Don't expose password in response
            return response()->json(['data' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'role_id' => 'required|integer'
            ]);

            $this->initializeDummyData();
            $index = array_search($id, array_column(self::$users, 'id'));
            if ($index === false) {
                return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
            }

            // Check if role_id exists
            if (!array_filter(self::$roles, fn($role) => $role['id'] == $validated['role_id'])) {
                return response()->json(['message' => 'Role tidak ditemukan'], 422);
            }

            self::$users[$index] = [
                'id' => $id,
                'name' => $validated['name'],
                'email' => self::$users[$index]['email'], // Preserve existing email
                'password' => self::$users[$index]['password'], // Preserve existing password
                'role_id' => $validated['role_id']
            ];

            $user = self::$users[$index];
            $user['role'] = array_filter(self::$roles, fn($role) => $role['id'] == $user['role_id']);
            $user['role'] = !empty($user['role']) ? reset($user['role']) : null;
            unset($user['password']); // Don't expose password in response

            return response()->json(['data' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui pengguna'], 500);
        }
    }

    public function destroyUser($id)
    {
        try {
            $this->initializeDummyData();
            $index = array_search($id, array_column(self::$users, 'id'));
            if ($index === false) {
                return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
            }

            array_splice(self::$users, $index, 1);
            return response()->json(['message' => 'Pengguna berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus pengguna'], 500);
        }
    }
}
?>