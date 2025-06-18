<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        return view('administrator.data_master.data_device');
    }
    
    public function getDeviceNames()
    {
        $baseUrl = config('services.api.base_url');
        $response = Http::get("{$baseUrl}/devices");

        if ($response->successful()) {
            $devices = $response->json();
            $deviceNames = collect($devices)->pluck('device_name', 'device_id');
            return view('administrator.data_sensor.button', compact('deviceNames'));
        } else {
            return back()->with('error', 'Gagal mengambil nama device dari API.');
        }
    }
}
