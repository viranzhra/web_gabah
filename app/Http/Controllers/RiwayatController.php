<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function data(Request $request)
    {
        // Data dummy
        $dummyData = [
            [
                'id' => 1,
                'jenis_gabah' => 'IR64',
                'tanggal_mulai' => '2025-07-01',
                'tanggal_berakhir' => '2025-07-02',
                'jam_mulai' => '08:00',
                'jam_berakhir' => '16:00',
                'massa_awal' => 1000,
                'massa_akhir' => 950,
                'durasi_iot' => 480, // 8 jam * 60 menit
                'durasi_validasi' => 450, // 7.5 jam * 60 menit
                'durasi_ml' => 420 // 7 jam * 60 menit
            ],
            [
                'id' => 2,
                'jenis_gabah' => 'Ciherang',
                'tanggal_mulai' => '2025-07-03',
                'tanggal_berakhir' => '2025-07-04',
                'jam_mulai' => '09:00',
                'jam_berakhir' => '17:00',
                'massa_awal' => 1200,
                'massa_akhir' => 1150,
                'durasi_iot' => 510, // 8.5 jam * 60 menit
                'durasi_validasi' => 480, // 8 jam * 60 menit
                'durasi_ml' => 468 // 7.8 jam * 60 menit
            ],
            [
                'id' => 3,
                'jenis_gabah' => 'Inpari 32',
                'tanggal_mulai' => '2025-07-05',
                'tanggal_berakhir' => '2025-07-06',
                'jam_mulai' => '07:30',
                'jam_berakhir' => '15:30',
                'massa_awal' => 800,
                'massa_akhir' => 750,
                'durasi_iot' => 450, // 7.5 jam * 60 menit
                'durasi_validasi' => 420, // 7 jam * 60 menit
                'durasi_ml' => 408 // 6.8 jam * 60 menit
            ]
        ];

        // Server-side processing parameters
        $draw = $request->input('draw');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $search = $request->input('search.value');
        $datetime_mulai = $request->input('datetime_mulai');
        $datetime_berakhir = $request->input('datetime_berakhir');

        // Filter data berdasarkan pencarian global
        $filteredData = $dummyData;
        if (!empty($search) && $search !== '') {
            $filteredData = array_filter($dummyData, function ($item) use ($search) {
                return stripos($item['jenis_gabah'], $search) !== false ||
                       stripos($item['tanggal_mulai'], $search) !== false ||
                       stripos($item['tanggal_berakhir'], $search) !== false ||
                       stripos($item['jam_mulai'], $search) !== false ||
                       stripos($item['jam_berakhir'], $search) !== false ||
                       stripos((string)$item['massa_awal'], $search) !== false ||
                       stripos((string)$item['massa_akhir'], $search) !== false ||
                       stripos((string)$item['durasi_iot'], $search) !== false ||
                       stripos((string)$item['durasi_validasi'], $search) !== false ||
                       stripos((string)$item['durasi_ml'], $search) !== false;
            });
            $filteredData = array_values($filteredData);
        }

        // Filter berdasarkan datetime mulai
        if (!empty($datetime_mulai)) {
            $filterStart = strtotime($datetime_mulai);
            $filteredData = array_filter($filteredData, function ($item) use ($filterStart) {
                $itemStart = strtotime($item['tanggal_mulai'] . ' ' . $item['jam_mulai']);
                return $itemStart >= $filterStart;
            });
            $filteredData = array_values($filteredData);
        }

        // Filter berdasarkan datetime berakhir
        if (!empty($datetime_berakhir)) {
            $filterEnd = strtotime($datetime_berakhir);
            $filteredData = array_filter($filteredData, function ($item) use ($filterEnd) {
                $itemEnd = strtotime($item['tanggal_berakhir'] . ' ' . $item['jam_berakhir']);
                return $itemEnd <= $filterEnd;
            });
            $filteredData = array_values($filteredData);
        }

        // Urutkan data
        $order = $request->input('order.0.column', 0);
        $dir = $request->input('order.0.dir', 'asc');
        $columnMap = [
            1 => 'jenis_gabah',
            2 => 'tanggal_mulai',
            3 => 'tanggal_berakhir',
            4 => 'jam_mulai',
            5 => 'jam_berakhir',
            6 => 'massa_awal',
            7 => 'massa_akhir',
            8 => 'durasi_iot',
            9 => 'durasi_validasi',
            10 => 'durasi_ml'
        ];

        if (isset($columnMap[$order])) {
            usort($filteredData, function ($a, $b) use ($columnMap, $order, $dir) {
                $key = $columnMap[$order];
                return $dir === 'asc' ? strcmp($a[$key], $b[$key]) : strcmp($b[$key], $a[$key]);
            });
        }

        // Paginasi
        $totalRecords = count($dummyData);
        $totalFiltered = count($filteredData);
        $paginatedData = array_slice($filteredData, $start, $length);

        // Format respons untuk DataTables
        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $paginatedData
        ]);
    }

    public function detail($id)
    {
        // Data dummy untuk simulasi halaman detail
        $dummyData = [
            1 => [
                'id' => 1,
                'jenis_gabah' => 'IR64',
                'tanggal_mulai' => '2025-07-01',
                'tanggal_berakhir' => '2025-07-02',
                'jam_mulai' => '08:00',
                'jam_berakhir' => '16:00',
                'massa_awal' => 1000,
                'massa_akhir' => 950,
                'durasi_iot' => 480,
                'durasi_validasi' => 450,
                'durasi_ml' => 420
            ],
            2 => [
                'id' => 2,
                'jenis_gabah' => 'Ciherang',
                'tanggal_mulai' => '2025-07-03',
                'tanggal_berakhir' => '2025-07-04',
                'jam_mulai' => '09:00',
                'jam_berakhir' => '17:00',
                'massa_awal' => 1200,
                'massa_akhir' => 1150,
                'durasi_iot' => 510,
                'durasi_validasi' => 480,
                'durasi_ml' => 468
            ],
            3 => [
                'id' => 3,
                'jenis_gabah' => 'Inpari 32',
                'tanggal_mulai' => '2025-07-05',
                'tanggal_berakhir' => '2025-07-06',
                'jam_mulai' => '07:30',
                'jam_berakhir' => '15:30',
                'massa_awal' => 800,
                'massa_akhir' => 750,
                'durasi_iot' => 450,
                'durasi_validasi' => 420,
                'durasi_ml' => 408
            ]
        ];

        // Cari data berdasarkan ID
        $data = $dummyData[$id] ?? null;

        if (!$data) {
            abort(404, 'Data tidak ditemukan');
        }

        // Kembalikan view untuk halaman detail
        return view('administrator.riwayat.detail', compact('data'));
    }
}