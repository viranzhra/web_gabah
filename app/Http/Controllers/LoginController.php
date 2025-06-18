<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Cek apakah token sudah ada di session
        if (session()->has('sanctum_token')) {
            $role = session('user_role');

            // Arahkan langsung ke dashboard sesuai role
            if ($role === 'Operator') {
                return redirect()->route('operator.dashboard');
            } elseif ($role === 'Administrator') {
                return redirect()->route('admin.dashboard');
            }
        }

        // Kalau belum login, tampilkan form login
        return view('login');
    }


    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ambil base URL dari config
        $baseUrl = config('services.api.base_url');

        // Kirim permintaan login ke API
        $response = Http::post("{$baseUrl}/login", [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Log respons API untuk debugging
        Log::info('API Login Response: ' . json_encode($response->json()));

        // Cek apakah respons berhasil
        if ($response->successful()) {
            $data = $response->json();

            // Periksa apakah kunci 'data', 'data.token', dan 'data.role' ada
            if (isset($data['data']['token']) && isset($data['data']['role'])) {
                // Simpan token dan role di session
                session(['sanctum_token' => $data['data']['token']]);
                session(['user_role' => $data['data']['role']]);

                // Log session untuk debugging
                Log::info('Session Data: ', [
                    'token' => session('sanctum_token'),
                    'role' => session('user_role'),
                ]);

                // Redirect berdasarkan role
                if ($data['data']['role'] === 'Operator') {
                    Log::info('Redirecting to operator.dashboard');
                    return redirect()->route('operator.dashboard');
                } elseif ($data['data']['role'] === 'Administrator') {
                    Log::info('Redirecting to admin.dashboard');
                    return redirect()->route('admin.dashboard');
                } else {
                    Log::info('Unrecognized role: ' . $data['data']['role']);
                    return back()->with('error', 'Role tidak dikenali.');
                }
            } else {
                Log::error('Missing token or role in API response');
                return back()->with('error', 'Respons API tidak valid: Token atau role tidak ditemukan.');
            }
        } else {
            // Tangani error dari API
            $errorMessage = $response->json()['message'] ?? 'Gagal login. Periksa email atau kata sandi.';
            Log::error('Login failed: ' . $errorMessage);
            return back()->with('error', $errorMessage);
        }
    }
}
