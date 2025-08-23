@extends('layout.app_landingpage')

@section('content')

    <!-- Order Section -->
    <section id="order" class="order-section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Pesan Paket GrainDryer IoT</h2>
            <p>Lengkapi pembelian Anda untuk mulai mengoptimalkan pengeringan gabah dengan teknologi IoT canggih!</p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form action="forms/order.php" method="post" enctype="multipart/form-data" class="order-form">
                        <div class="row gy-4">
                            <div class="col-md-12">
                                <label for="name-field" class="pb-2">Nama Lengkap</label>
                                <input type="text" name="name" id="name-field" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label for="email-field" class="pb-2">Email</label>
                                <input type="email" name="email" id="email-field" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label for="package-field" class="pb-2">Pilih Paket</label>
                                <select name="package" id="package-field" class="form-control" required>
                                    <option value="petani">Paket Petani (Rp 300.000/bulan)</option>
                                    <option value="kelompok-tani">Paket Kelompok Tani (Rp 750.000/bulan)</option>
                                    <option value="agro-premium">Paket Agro Premium (Rp 1.500.000/bulan)</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="payment-proof" class="pb-2">Unggah Bukti Pembayaran</label>
                                <input type="file" name="payment_proof" id="payment-proof" class="form-control" accept="image/*,.pdf" required>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="loading">Memuat</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Pesanan Anda telah dikirim. Tim kami akan menghubungi Anda segera. Terima kasih!</div>
                                <button type="submit" class="btn-submit">Konfirmasi Pesanan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
@endsection