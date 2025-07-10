@extends('layout.app')

@section('content')
    <style>
        .detail-card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 20px;
            background-color: #fff;
        }
        .detail-card h4 {
            color: #1E3B8A;
            margin-bottom: 20px;
        }
        .detail-card .row {
            margin-bottom: 15px;
        }
        .detail-card .label {
            font-weight: 500;
            color: #4F4F4F;
        }
        .detail-card .value {
            color: #333;
        }
        .btn-back {
            border-radius: 8px;
            background-color: #1E3B8A;
            color: white;
            padding: 8px 16px;
            border: none;
        }
        .btn-back:hover {
            background-color: #163075;
        }
    </style>

    <h4 class="fw-semibold mb-3" style="margin-top: 10px;">Detail Riwayat Kegiatan Pengeringan</h4>
    <div class="detail-card">
        <h4>Detail Data Gabah (ID: {{ $data['id'] }})</h4>
        <div class="row">
            <div class="col-md-3 label">Jenis Gabah</div>
            <div class="col-md-9 value">{{ $data['jenis_gabah'] }}</div>
        </div>
        <div class="row">
            <div class="col-md-3 label">Tanggal Mulai</div>
            <div class="col-md-9 value">{{ $data['tanggal_mulai'] }}</div>
        </div>
        <div class="row">
            <div class="col-md-3 label">Tanggal Berakhir</div>
            <div class="col-md-9 value">{{ $data['tanggal_berakhir'] }}</div>
        </div>
        <div class="row">
            <div class="col-md-3 label">Jam Mulai</div>
            <div class="col-md-9 value">{{ $data['jam_mulai'] }}</div>
        </div>
        <div class="row">
            <div class="col-md-3 label">Jam Berakhir</div>
            <div class="col-md-9 value">{{ $data['jam_berakhir'] }}</div>
        </div>
        <div class="row">
            <div class="col-md-3 label">Massa Awal (Kg)</div>
            <div class="col-md-9 value">{{ $data['massa_awal'] }}</div>
        </div>
        <div class="row">
            <div class="col-md-3 label">Massa Akhir (Kg)</div>
            <div class="col-md-9 value">{{ $data['massa_akhir'] }}</div>
        </div>
        <div class="row">
            <div class="col-md-3 label">Durasi IoT (Menit)</div>
            <div class="col-md-9 value">{{ $data['durasi_iot'] }}</div>
        </div>
        <div class="row">
            <div class="col-md-3 label">Durasi Validasi (Menit)</div>
            <div class="col-md-9 value">{{ $data['durasi_validasi'] }}</div>
        </div>
        <div class="row">
            <div class="col-md-3 label">Durasi Model ML (Menit)</div>
            <div class="col-md-9 value">{{ $data['durasi_ml'] }}</div>
        </div>
        <a href="{{ route('riwayat.index') }}" class="btn btn-back mt-3">Kembali</a>
    </div>
@endsection