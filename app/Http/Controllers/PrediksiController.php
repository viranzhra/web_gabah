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
        $baseUrl = config('services.api.base_url'); // Ambil base URL dari config/services.php

        if ($request->ajax()) {
            $response = Http::withToken(session('sanctum_token'))
                ->get(url("{$baseUrl}/prediksi"));

            if (!$response->successful()) {
                return response()->json(['message' => 'Gagal mengambil data prediksi'], 500);
            }

            $data = $response->json()['data'];

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_jenis', fn($row) => $row['grain_type']['nama_jenis'] ?? '-')
                ->addColumn('timestamp_mulai', fn($row) => isset($row['timestamp_mulai'])
                    ? date('d-m-Y H:i', strtotime($row['timestamp_mulai']))
                    : '-')
                ->addColumn('aksi', fn($row) => '<button class="btn btn-sm btn-primary btn-detail" data-id="' . ($row['id'] ?? '') . '">Detail</button>')
                ->rawColumns(['aksi'])
                ->make(true);
        }

        // Ambil jenis gabah dari API untuk form modal
        $grainTypes = [];
        $grainTypeResponse = Http::withToken(session('sanctum_token'))
            ->get(url("{$baseUrl}/jenis-gabah"));

        if ($grainTypeResponse->successful()) {
            $grainTypes = $grainTypeResponse->json()['data'] ?? [];
        }

        // Ambil data sensor terbaru dari API (pakai token juga)
        $sensorResponse = Http::withToken(session('sanctum_token'))
            ->get(url("{$baseUrl}/sensor-data"));

        $sensorData = [];
        if ($sensorResponse->successful()) {
            $sensorData = $sensorResponse->json('data', []);
        }

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
