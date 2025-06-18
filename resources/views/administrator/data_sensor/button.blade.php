<!-- Tambahkan di bagian head -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .btn-link {
        text-decoration: none;
        color: #000;
        font-weight: 500;
        padding: 10px 15px;
        display: inline-flex;
        margin-right: 10px;
        position: relative;
        justify-content: center;
    }

    .btn-link.active {
        color: #1E3B8A;
        font-weight: bold;
    }

    .btn-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #1E3B8A;
    }
</style>

<!-- Dropdown Device -->
<div class="btn-group mt-3" role="group" aria-label="Data Sensor Device Buttons">
    @if ($deviceNames->isEmpty())
        <div class="alert alert-warning">Tidak ada device yang ditemukan.</div>
    @else
        <select name="device_id" id="device_id" class="form-select select2" style="width: 300px;">
            <option value="">-- Pilih Device --</option>
            @foreach ($deviceNames as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    @endif
</div>

<!-- Tambahkan di bagian bawah sebelum </body> -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('#device_id').select2({
            placeholder: "-- Pilih Device --",
            allowClear: true,
            width: 'resolve' // penting agar width-nya sesuai style
        });
    });
</script>
