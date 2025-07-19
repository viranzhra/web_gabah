<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ValidasiPengeringanContoller extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Data dummy untuk validasi pengeringan
            $data = collect([
                [
                    'id' => 1,
                    'durasi_iot' => '360', // in minutes (6 jam)
                    'tanggal' => '2025-05-01',
                    'jam' => '14:30',
                    'durasi_validasi' => '350', // in minutes
                    'is_validated' => false
                ],
                [
                    'id' => 2,
                    'durasi_iot' => '330', // in minutes (5.5 jam)
                    'tanggal' => '2025-05-02',
                    'jam' => '15:00',
                    'durasi_validasi' => '340', // in minutes
                    'is_validated' => true
                ],
                [
                    'id' => 3,
                    'durasi_iot' => '372', // in minutes (6.2 jam)
                    'tanggal' => '2025-05-03',
                    'jam' => '16:15',
                    'durasi_validasi' => '360', // in minutes
                    'is_validated' => false
                ],
            ]);

            // Filter data based on is_validated if requested
            if ($request->has('is_validated')) {
                $isValidated = filter_var($request->input('is_validated'), FILTER_VALIDATE_BOOLEAN);
                $data = $data->filter(function ($item) use ($isValidated) {
                    return $item['is_validated'] === $isValidated;
                });
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return ''; // Aksi rendered by JavaScript
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('administrator.validasi.index');
    }
}
