<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ValidasiDatasetContoller extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Data dummy untuk jenis gabah sesuai kolom yang diminta
            $data = collect([
                [
                    'id' => 1,
                    'berat_gabah' => '1000 kg',
                    'suhu_gabah' => '35°C',
                    'suhu_ruangan' => '30°C',
                    'kadar_air_awal' => '25%',
                    'kadar_air_akhir' => '14%',
                    'durasi_nyata' => '6 jam',
                    'tanggal' => '2025-05-01',
                ],
                [
                    'id' => 2,
                    'berat_gabah' => '1200 kg',
                    'suhu_gabah' => '36°C',
                    'suhu_ruangan' => '31°C',
                    'kadar_air_awal' => '24%',
                    'kadar_air_akhir' => '13.5%',
                    'durasi_nyata' => '5.5 jam',
                    'tanggal' => '2025-05-02',
                ],
                [
                    'id' => 3,
                    'berat_gabah' => '950 kg',
                    'suhu_gabah' => '34°C',
                    'suhu_ruangan' => '29°C',
                    'kadar_air_awal' => '23%',
                    'kadar_air_akhir' => '14.2%',
                    'durasi_nyata' => '6.2 jam',
                    'tanggal' => '2025-05-03',
                ],
            ]);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return ''; // Akan di-render oleh JavaScript (frontend)
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('administrator.validasi.index');
    }
}
