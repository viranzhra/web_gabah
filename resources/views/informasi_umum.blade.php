@extends('layout.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .table-container { margin: 20px; }
    .status-select {
        width: 150px; padding: 5px; border-radius: 8px; border: 1px solid #DAD9D9;
    }
    .custom-button {
        background-color: #1E3B8A; color: #fff; border-radius: 8px; padding: 5px 10px; border: none;
    }
    .custom-button:hover { background-color: #163075; }
    #notification {
        position: fixed; top: 10px; right: 10px; width: 300px; padding: 15px;
        border-radius: 5px; z-index: 9999; display: none; flex-direction: column; text-align: left;
    }
    #notification.success { background-color: #d4edda; color: #155724; border-left: 5px solid #28a745; }
    #notification.error   { background-color: #f8d7da; color: #721c24; border-left: 5px solid #dc3545; }
</style>

<div id="notification" class="alert position-fixed top-0 end-0 m-4" style="z-index: 9999;">
    <div id="notificationTitle" style="font-weight: bold;"></div>
    <div id="notificationMessage"></div>
</div>

{{-- =======================
     CARD: DATA KONTAK
======================= --}}
<div class="card mt-4 table-container">
    <div class="card-body">
        <h4 class="fw-semibold mb-3">Kontak Info</h4>
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-striped table-bordered" id="contactTable" style="min-width:600px;">
                <thead class="text-center">
                    <tr>
                        <th class="text-center" style="width:40%;">Alamat</th>
                        <th class="text-center" style="width:20%;">Telepon</th>
                        <th class="text-center" style="width:25%;">Email</th>
                        <th class="text-center" style="width:15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Diisi via JS (1 baris) --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Edit Kontak --}}
<div class="modal fade" id="modalEditKontak" tabindex="-1" aria-labelledby="modalEditKontakLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 520px;">
        <form id="formEditKontak" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditKontakLabel">Edit Kontak Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamatKontak" name="alamat" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" class="form-control" id="teleponKontak" name="telepon" required maxlength="20">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" id="emailKontak" name="email" required maxlength="100">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn custom-button">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ==========================
     CARD: DATA PESAN USER
========================== --}}
<div class="card mt-4 table-container">
    <div class="card-body">
        <h4 class="fw-semibold mb-3">Pesan dari Pengguna</h4>
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-striped table-bordered" id="pesanTable" style="min-width:900px;">
                <thead class="text-center">
                    <tr>
                        <th class="text-center" style="width:60px;">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Email</th>
                        <th class="text-center" style="min-width:240px;">Pesan</th>
                        <th class="text-center" style="min-width:140px;">Status</th>
                        <th class="text-center" style="min-width:140px;">Tanggal</th>
                        <th class="text-center" style="min-width:120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <small class="text-muted"><b>Status:</b> <em>pending</em> (belum dibalas), <em>replied</em> (sudah dibalas). || Akan dibalas melalui Email pengguna.</small>
    </div>
</div>

{{-- Modal Konfirmasi Hapus Pesan --}}
<div class="modal fade" id="modalHapusPesan" tabindex="-1" aria-labelledby="modalHapusPesanLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 390px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Pesan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p>Hapus pesan dari <strong id="hapusNama"></strong>?</p>
                <input type="hidden" id="hapusPesanId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnConfirmHapus" class="btn custom-button">Hapus</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Ubah Status Pesan --}}
<div class="modal fade" id="modalStatusPesan" tabindex="-1" aria-labelledby="modalStatusPesanLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 390px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Status Pesan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p>Ubah status pesan <strong id="statusNama"></strong> menjadi <strong id="statusBaruText"></strong>?</p>
                <input type="hidden" id="statusPesanId">
                <input type="hidden" id="statusBaruVal">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnConfirmStatus" class="btn custom-button">Ya</button>
            </div>
        </div>
    </div>
</div>

{{-- DataTables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
{{-- Bootstrap bundle (modal) --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

<script>
(function($) {
    $(document).ready(function() {
        // ===== Helpers Notifikasi =====
        function showNotification(type, title, message) {
            var notification = document.getElementById('notification');
            var titleEl = document.getElementById('notificationTitle');
            var messageEl = document.getElementById('notificationMessage');
            notification.className = 'alert position-fixed top-0 end-0 m-4';
            notification.style.display = 'flex';
            if (type === 'success') notification.classList.add('success');
            else if (type === 'error') notification.classList.add('error');
            titleEl.innerText = title || '';
            messageEl.innerText = message || '';
            setTimeout(function(){ notification.style.display = 'none'; }, 4000);
        }

        // ===== Konfigurasi dasar =====
        const sanctumToken = "{{ session('sanctum_token') ?? '' }}".replace(/[\n\r]+/g, '').trim();
        const API_BASE = @json(config('services.api.base_url'));
        console.log('Sanctum Token:', sanctumToken ? 'Present' : 'Missing');

        // =========================
        //   BAGIAN: KONTAK INFO
        // =========================
        let contactCache = null;

        function renderContactRow(data) {
            const tbody = $('#contactTable tbody');
            tbody.empty();
            const alamat = data?.alamat ?? '-';
            const telepon = data?.telepon ?? '-';
            const email = data?.email ?? '-';
            const row = `
                <tr>
                    <td>${alamat}</td>
                    <td class="text-center">${telepon}</td>
                    <td class="text-center">${email}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm custom-button" id="btnEditKontak">Edit</button>
                    </td>
                </tr>`;
            tbody.append(row);
        }

        function loadContact() {
            $.ajax({
                url: `${API_BASE}/kontak`,
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${sanctumToken}`,
                    'Accept': 'application/json'
                },
                success: function(res) {
                    contactCache = res;
                    renderContactRow(res);
                },
                error: function(xhr) {
                    console.error('Load Contact Error:', xhr);
                    renderContactRow(null);
                    showNotification('error', 'Gagal!', xhr.responseJSON?.message || 'Gagal memuat kontak info.');
                }
            });
        }

        // Open modal edit
        $(document).on('click', '#btnEditKontak', function() {
            if (contactCache) {
                $('#alamatKontak').val(contactCache.alamat || '');
                $('#teleponKontak').val(contactCache.telepon || '');
                $('#emailKontak').val(contactCache.email || '');
            }
            new bootstrap.Modal(document.getElementById('modalEditKontak')).show();
        });

        // Submit edit kontak
        $('#formEditKontak').on('submit', function(e) {
            e.preventDefault();
            const payload = {
                alamat: $('#alamatKontak').val(),
                telepon: $('#teleponKontak').val(),
                email: $('#emailKontak').val()
            };
            $.ajax({
                url: `${API_BASE}/kontak/update`,
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${sanctumToken}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(payload),
                success: function(res) {
                    showNotification('success', 'Berhasil!', res.message || 'Data kontak berhasil diperbarui.');
                    contactCache = res.data || payload;
                    renderContactRow(contactCache);
                    bootstrap.Modal.getInstance(document.getElementById('modalEditKontak')).hide();
                },
                error: function(xhr) {
                    console.error('Update Contact Error:', xhr);
                    showNotification('error', 'Gagal!', xhr.responseJSON?.message || 'Gagal memperbarui kontak.');
                }
            });
        });

        // Init load kontak
        loadContact();

        // =================================
        //   BAGIAN: PESAN USER (DataTable)
        // =================================
        const pesanTable = $('#pesanTable').DataTable({
            processing: true,
            serverSide: true, // karena controller pakai Yajra DataTables
            ajax: {
                url: `${API_BASE}/pesan-user`,
                type: 'GET',
                headers: {
                    'Authorization': `Bearer ${sanctumToken}`,
                    'Accept': 'application/json'
                },
                // Yajra default: DataTables akan auto-baca struktur {data, recordsTotal, recordsFiltered}
                error: function(xhr) {
                    console.error('Load Pesan Error:', xhr);
                    showNotification('error', 'Gagal!', xhr.responseJSON?.message || 'Gagal memuat data pesan.');
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
                { data: 'name', name: 'name', defaultContent: '-' },
                { data: 'email', name: 'email', defaultContent: '-' },
                { data: 'message', name: 'message', defaultContent: '-' },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        // fallback kalau kolom status belum ada di DB
                        const val = data || 'pending';
                        return `
                            <select class="status-select pesan-status" data-id="${row.id}">
                                <option value="pending" ${val === 'pending' ? 'selected' : ''}>pending</option>
                                <option value="replied" ${val === 'replied' ? 'selected' : ''}>replied</option>
                            </select>
                        `;
                    }
                },
                { data: 'created_at', name: 'created_at', className: 'text-center', defaultContent: '-' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-sm btn-danger btnHapusPesan" data-id="${row.id}" data-nama="${row.name}">
                                Hapus
                            </button>
                        `;
                    }
                }
            ],
            order: [[5, 'desc']]
        });

        // Hapus pesan (open modal)
        $(document).on('click', '.btnHapusPesan', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            $('#hapusPesanId').val(id);
            $('#hapusNama').text(nama || '(tanpa nama)');
            new bootstrap.Modal(document.getElementById('modalHapusPesan')).show();
        });

        // Konfirmasi hapus
        $('#btnConfirmHapus').on('click', function() {
            const id = $('#hapusPesanId').val();
            $.ajax({
                url: `${API_BASE}/pesan-user/${id}`,
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${sanctumToken}`,
                    'Accept': 'application/json'
                },
                success: function(res) {
                    showNotification('success', 'Berhasil!', res.message || 'Pesan berhasil dihapus.');
                    bootstrap.Modal.getInstance(document.getElementById('modalHapusPesan')).hide();
                    pesanTable.ajax.reload(null, false);
                },
                error: function(xhr) {
                    console.error('Hapus Pesan Error:', xhr);
                    showNotification('error', 'Gagal!', xhr.responseJSON?.message || 'Gagal menghapus pesan.');
                    bootstrap.Modal.getInstance(document.getElementById('modalHapusPesan')).hide();
                }
            });
        });

        // Ubah status pesan (open modal konfirmasi)
        $(document).on('change', '.pesan-status', function() {
            const id = $(this).data('id');
            const val = $(this).val();
            const rowData = pesanTable.row($(this).closest('tr')).data();
            $('#statusPesanId').val(id);
            $('#statusBaruVal').val(val);
            $('#statusBaruText').text(val);
            $('#statusNama').text(rowData?.name || '(tanpa nama)');
            new bootstrap.Modal(document.getElementById('modalStatusPesan')).show();
        });

        // Konfirmasi ubah status
        $('#btnConfirmStatus').on('click', function() {
            const id = $('#statusPesanId').val();
            const status = $('#statusBaruVal').val();
            $.ajax({
                url: `${API_BASE}/pesan-user/${id}/status`,
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${sanctumToken}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({ status }),
                success: function(res) {
                    showNotification('success', 'Berhasil!', res.message || 'Status pesan diperbarui.');
                    bootstrap.Modal.getInstance(document.getElementById('modalStatusPesan')).hide();
                    pesanTable.ajax.reload(null, false);
                },
                error: function(xhr) {
                    console.error('Update Status Pesan Error:', xhr);
                    showNotification('error', 'Gagal!', xhr.responseJSON?.message || 'Gagal memperbarui status.');
                    bootstrap.Modal.getInstance(document.getElementById('modalStatusPesan')).hide();
                    // rollback tampilan select ke nilai sebelumnya (reload tabel)
                    pesanTable.ajax.reload(null, false);
                }
            });
        });

        // Matikan ping global /api/login jika ada script global
        window.__DISABLE_GLOBAL_LOGIN_PING__ = true;
    });
})(jQuery.noConflict(true));
</script>
@endsection
