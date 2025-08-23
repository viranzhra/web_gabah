<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Avoid redirect loop by checking if already authenticated
        if (session()->has('sanctum_token') && Auth::check()) {
            Log::info('User already authenticated, redirecting to dashboard', [
                'session' => session()->only(['sanctum_token', 'user_role', 'user_permissions']),
                'user' => Auth::user() ? Auth::user()->toArray() : null,
            ]);
            return redirect()->route('dashboard')->with('success', 'Anda sudah login.');
        }

        Log::info('Showing login form');
        return view('login');
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $baseUrl = rtrim(config('services.api.base_url'), '/'); // Pastikan base URL tidak ada trailing slash
        Log::info('Attempting API login', ['email' => $request->email, 'base_url' => $baseUrl]);

        try {
            // Make API login request
            $response = Http::timeout(10)->post("{$baseUrl}/login", [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            Log::info('API Login Response', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['status']) && $data['status'] === 'success' && isset($data['data']['token']) && isset($data['data']['role'])) {
                    // Store token and role in session
                    session([
                        'sanctum_token' => $data['data']['token'],
                        'user_role' => $data['data']['role'],
                    ]);

                    // Ambil data user dan permissions dari API /user
                    try {
                        $userResponse = Http::timeout(10)
                            ->withHeaders(['Authorization' => 'Bearer ' . $data['data']['token']])
                            ->get("{$baseUrl}/user");

                        Log::info('API User Response', [
                            'status' => $userResponse->status(),
                            'body' => $userResponse->json(),
                        ]);

                        if ($userResponse->successful()) {
                            $userData = $userResponse->json();
                            if (isset($userData['status']) && $userData['status'] === 'success' && isset($userData['data']['permissions'])) {
                                // Simpan permission ke session
                                $permissions = $userData['data']['permissions'];
                                session(['user_permissions' => $permissions]);
                                Log::info('User permissions stored in session', ['permissions' => $permissions]);
                            } else {
                                Log::error('Invalid user API response structure', ['response' => $userData]);
                                // Fallback: Gunakan permissions default berdasarkan role
                                $fallbackPermissions = $this->getFallbackPermissions($data['data']['role']);
                                session(['user_permissions' => $fallbackPermissions]);
                                Log::warning('Using fallback permissions', ['role' => $data['data']['role'], 'permissions' => $fallbackPermissions]);
                            }
                        } else {
                            Log::error('Failed to fetch user data', [
                                'status' => $userResponse->status(),
                                'response' => $userResponse->json() ?? 'No response body',
                            ]);
                            // Fallback: Gunakan permissions default berdasarkan role
                            $fallbackPermissions = $this->getFallbackPermissions($data['data']['role']);
                            session(['user_permissions' => $fallbackPermissions]);
                            Log::warning('Using fallback permissions due to failed user data fetch', [
                                'role' => $data['data']['role'],
                                'permissions' => $fallbackPermissions,
                            ]);
                        }
                    } catch (\Illuminate\Http\Client\ConnectionException $e) {
                        Log::error('API /user connection failed', ['error' => $e->getMessage(), 'base_url' => $baseUrl]);
                        // Fallback: Gunakan permissions default berdasarkan role
                        $fallbackPermissions = $this->getFallbackPermissions($data['data']['role']);
                        session(['user_permissions' => $fallbackPermissions]);
                        Log::warning('Using fallback permissions due to connection failure', [
                            'role' => $data['data']['role'],
                            'permissions' => $fallbackPermissions,
                        ]);
                    }

                    // Log in the user for Laravel's auth middleware
                    $user = \App\Models\User::where('email', $request->email)->first();
                    if ($user) {
                        Auth::login($user);
                        Log::info('User logged in via Auth', ['user' => $user->toArray()]);
                    } else {
                        Log::error('User not found in local database', ['email' => $request->email]);
                        return back()->with('error', 'Pengguna tidak ditemukan di sistem.');
                    }

                    Log::info('Login successful, session updated', [
                        'session' => session()->only(['sanctum_token', 'user_role', 'user_permissions']),
                    ]);

                    return redirect()
                        ->route('dashboard')
                        ->with('success', 'Login berhasil.')
                        ->with('token', $data['data']['token']); // kirim token ke view

                } else {
                    Log::error('Invalid API response structure', ['response' => $data]);
                    return back()->with('error', 'Token atau peran tidak ditemukan.');
                }
            } else {
                $errorMessage = $response->json()['error'] ?? 'Gagal login. Periksa email atau kata sandi.';
                Log::error('Login failed', ['status' => $response->status(), 'error' => $errorMessage]);
                return back()->with('error', $errorMessage);
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('API login connection failed', ['error' => $e->getMessage(), 'base_url' => $baseUrl]);
            return back()->with('error', 'Tidak dapat terhubung ke server. Silakan coba lagi.');
        } catch (\Exception $e) {
            Log::error('Unexpected error during login', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat login. Silakan coba lagi.');
        }
    }

    public function logout(Request $request)
    {
        $baseUrl = rtrim(config('services.api.base_url'), '/');
        $token = session('sanctum_token');

        Log::info('Attempting logout', ['token' => $token ? 'exists' : 'missing']);

        if ($token) {
            try {
                $response = Http::timeout(10)
                    ->withHeaders(['Authorization' => 'Bearer ' . $token])
                    ->post("{$baseUrl}/logout");
                Log::info('API Logout Response', [
                    'status' => $response->status(),
                    'body' => $response->json() ?? 'No response body',
                ]);
            } catch (\Exception $e) {
                Log::error('Logout request failed', ['error' => $e->getMessage()]);
            }
        }

        // Log out from Laravel's auth
        Auth::logout();
        session()->flush();
        Log::info('Session cleared and user logged out');

        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }

    /**
     * Get fallback permissions based on role
     *
     * @param string $role
     * @return array
     */
    protected function getFallbackPermissions(string $role): array
    {
        // Map role ke permissions default berdasarkan RolePermissionSeeder
        $permissionMap = [
            'Administrator' => ['view dashboard', 'view role', 'view informasi umum'],
            'Admin Mitra' => [
                'view dashboard',
                'view proses pengeringan',
                'view validasi',
                'view data jenis gabah',
                'view data perangkat',
                'view role',
                'view riwayat pengeringan',
            ],
            // Tambahkan role lain jika diperlukan
        ];

        return $permissionMap[$role] ?? ['view dashboard']; // Default ke view dashboard jika role tidak ditemukan
    }
}
