@extends('layout.app')

@section('content')
    <style>
        #notification {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 300px;
            padding: 15px;
            border-radius: 5px;
            z-index: 9999;
            display: none;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        #notification.success {
            background-color: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }

        #notification.error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545;
        }

        #notificationTitle {
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>

    <div class="container mt-5">
        <div id="notification">
            <div id="notificationTitle"></div>
            <div id="notificationMessage"></div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- Card --}}
                <div class="card shadow-lg border-0">
                    <div class="card-header text-black bg-white border-bottom-0">
                        <h5 style="text-align: center; font-size: 20px; font-weight: 700;" class="mb-0">Edit Profil</h5>
                    </div>
                    <div style="padding-top: 15px;" class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form id="updateProfileForm">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ auth()->user()->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email (tidak dapat diubah)</label>
                                <input type="email" id="email" class="form-control"
                                    value="{{ auth()->user()->email }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru (opsional)</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Minimal 8 karakter">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn" style="background-color: #1E3B8A; color: #ffff">Perbarui</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $('#updateProfileForm').on('submit', function(e) {
            e.preventDefault();

            const sanctumToken = "{{ session('sanctum_token') ?? '' }}".replace(/[\n\r]+/g, '').trim();

            $.ajax({
                url: '{{ config('services.api.base_url') }}/profile/update',
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${sanctumToken}`,
                    'Accept': 'application/json'
                },
                data: $(this).serialize(),
                success: function(response) {
                    showNotification('success', 'Berhasil!', response.message ||
                        'Profil berhasil diperbarui.');
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr) {
                    console.log("Response error:", xhr);
                    showNotification('error', 'Gagal!', 'Terjadi kesalahan saat mengupdate profil.');
                }
            });
        });

        function showNotification(type, title, message) {
            const notification = $('#notification');
            notification.removeClass('success error').addClass(type);
            $('#notificationTitle').text(title);
            $('#notificationMessage').text(message);
            notification.fadeIn();

            setTimeout(() => {
                notification.fadeOut();
            }, 4000);
        }
    </script>
@endsection
