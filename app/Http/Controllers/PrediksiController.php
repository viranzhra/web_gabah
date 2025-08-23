<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;

class PrediksiController extends Controller
{
    public function index(Request $request)
{
    $baseUrl = config('services.api.base_url');
    $token   = session('sanctum_token');
    $userId  = auth()->id();

    if ($request->ajax()) {
        // Pastikan hanya data milik user login yang diambil
        $response = Http::withToken($token)
            ->get("{$baseUrl}/prediksi", [
                'user_id' => $userId, // opsional, kalau endpoint dukung
                'me'      => 1        // pola umum: parameter 'me' untuk paksa scope ke user token
            ]);

        if (!$response->successful()) {
            return response()->json(['message' => 'Gagal mengambil data prediksi'], 500);
        }

        $data = $response->json('data', []);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama_jenis', fn($row) => $row['grain_type']['nama_jenis'] ?? '-')
            ->addColumn('timestamp_mulai', fn($row) => isset($row['timestamp_mulai'])
                ? date('d-m-Y H:i', strtotime($row['timestamp_mulai'])) : '-')
            ->addColumn('aksi', fn($row) => '<button class="btn btn-sm btn-primary btn-detail" data-id="' . ($row['process_id'] ?? $row['id'] ?? '') . '">Detail</button>')
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // === Jenis gabah ===
    $grainTypes = [];
    $grainTypeResponse = Http::withToken($token)->get("{$baseUrl}/jenis-gabah");
    if ($grainTypeResponse->successful()) {
        $grainTypes = $grainTypeResponse->json('data', []);
    }

    // === Sensor realtime per user yang login ===
    $sensorResponse = Http::withToken($token)->get("{$baseUrl}/get_sensor/realtime", [
        'user_id' => $userId // banyak endpoint kamu memang butuh ini
    ]);
    $sensorData = $sensorResponse->successful() ? $sensorResponse->json('data', []) : [];

    return view('administrator.prediksi.index', compact('grainTypes', 'sensorData'));
}

    public function store(Request $request)
    {
        $baseUrl = config('services.api.base_url');

        $response = Http::withToken(session('sanctum_token'))
            ->post(url("{$baseUrl}/prediksi/store"), $request->all());

        if ($response->successful()) {
            return response()->json([
                'message' => 'Prediksi berhasil disimpan',
                'data' => $response->json()['data'] ?? null
            ]);
        }

        return response()->json([
            'message' => 'Gagal melakukan prediksi',
            'errors' => $response->json()['errors'] ?? [],
        ], 400);
    }
}
