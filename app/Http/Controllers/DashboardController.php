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
        $baseUrl = config('services.api.base_url');
        $sanctumToken = session('sanctum_token');
        $userId = auth()->id();

        // Fetch grain types
        $grainTypes = [];
        $grainTypeResponse = Http::withToken($sanctumToken)
            ->get(url("{$baseUrl}/jenis-gabah"));

        if ($grainTypeResponse->successful()) {
            $grainTypes = $grainTypeResponse->json()['data'] ?? [];
        }

        // Fetch latest sensor data
    $sensorData = [];
    $sensorResponse = Http::withToken($sanctumToken)
        ->get(url("{$baseUrl}/sensor-data?user_id={$userId}"));

    if ($sensorResponse->successful()) {
        $sensorData = $sensorResponse->json()['data'] ?? [];
    }

        if ($request->ajax()) {
            $response = Http::withToken($sanctumToken)
                ->get(url("{$baseUrl}/operator/prediksi?user_id={$userId}"));

            if (!$response->successful()) {
                return response()->json(['message' => 'Gagal mengambil data prediksi'], 500);
            }

            $data = $response->json()['data'] ?? [];

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_jenis', fn($row) => $row['grain_type']['nama_jenis'] ?? '-')
                ->addColumn('timestamp_mulai', fn($row) => isset($row['timestamp_mulai'])
                    ? date('d-m-Y H:i', strtotime($row['timestamp_mulai']))
                    : '-')
                ->addColumn('aksi', fn($row) => $row['status'] === 'ongoing'
                    ? '<button class="btn btn-sm btn-danger btn-selesai" onclick="completeProcess(' . ($row['id'] ?? '') . ')">Selesai</button>'
                    : '<button class="btn btn-sm btn-primary btn-detail" data-id="' . ($row['id'] ?? '') . '">Detail</button>')
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('operator.dashboard', compact('grainTypes'));
    }
}