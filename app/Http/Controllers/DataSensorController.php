<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class DataSensorController extends Controller
{
    public function index(Request $request)
    {
        $baseUrl = config('services.api.base_url');
        $response = Http::get("{$baseUrl}/devices");

        $deviceNames = collect(); // default kosong
        if ($response->successful()) {
            $devices = $response->json('data'); // Ambil hanya bagian 'data'
            $deviceNames = collect($devices)->pluck('device_name', 'device_id');
        }

        return view('administrator.data_sensor.data_sensor', compact('deviceNames'));
    }
}
