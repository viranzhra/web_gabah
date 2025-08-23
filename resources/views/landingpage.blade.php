<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Landing Page</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo_gabah.png" />
    <link href="assets_landingpage2/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets_landingpage2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets_landingpage2/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets_landingpage2/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets_landingpage2/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets_landingpage2/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets_landingpage2/css/main.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .download-btn-img {
            height: 45px;
            border-radius: 50px;
            transition: transform 0.2s ease;
            margin-left: 10px;
        }

        .download-btn-img:hover {
            transform: scale(1.05);
        }

        @media (max-width: 576px) {
            .download-btn-img {
                height: 40px;
            }
        }

        .hero-img img {
            margin-left: 250px;
        }

        @media (max-width: 991px) {
            .hero-img img {
                margin-left: auto;
                margin-right: auto;
                max-width: 100%;
            }
        }

        @media (max-width: 576px) {
            .hero-img img {
                margin-left: auto;
                margin-right: auto;
                width: 80%;
            }
        }

        #orderModal .modal-dialog {
            max-width: 400px;
        }

        #orderModal .receipt-header {
            background: linear-gradient(135deg, #1e3a8a, #47b2e4);
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }

        #orderModal .modal-body {
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            line-height: 1.3;
            background-color: #fff;
            padding: 20px;
        }

        #orderModal .dashed-hr {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        #orderModal .receipt-content p {
            margin-bottom: 4px;
        }

        #orderModal .form-control {
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            padding: 6px;
        }

        #orderModal .form-control:focus {
            border-color: #47b2e4;
            box-shadow: 0 0 0 0.2rem rgba(71, 178, 228, 0.25);
        }

        #orderModal .btn-success {
            background-color: #28a745;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            padding: 8px;
        }

        #orderModal .btn-success:hover {
            background-color: #218838;
            transform: scale(1.02);
        }

        #orderModal .animate-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top" style="height: 70px;">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="/" class="logo d-flex align-items-center me-auto">
                <h1 class="sitename">GrainDryer</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Beranda</a></li>
                    <li><a href="#about">Tentang Kami</a></li>
                    <li><a href="#services">Layanan</a></li>
                    <li><a href="#work-process">Proses Pemasangan</a></li>
                    <li><a href="#pricing">Harga</a></li>
                    <li><a href="#contact">Kontak</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            @auth
                <a class="btn-getstarted" href="/dashboard"
                    style="font-weight: 700; letter-spacing: 2px; font-size: 14px;">Dashboard</a>
            @else
                <a class="btn-getstarted" href="/login"
                    style="font-weight: 700; letter-spacing: 2px; font-size: 14px;">Login</a>
            @endauth

        </div>
    </header>

    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background"
            style="background: url('assets_landingpage/img/bg_gabah.png') no-repeat center center; background-size: cover;">

            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center"
                        data-aos="zoom-out">
                        <h1>Selamat Datang di GrainDryer IoT</h1>
                        <p>Solusi Digital untuk Pengeringan Gabah — Cepat, Efisien, dan Terintegrasi</p>
                        <div class="d-flex">
                            <!-- Tombol Download Play Store -->
                            <a href="#">
                                <img src="https://s1.designmodo.com/postcards/image-173330540870913.png"
                                    alt="Google Play" class="download-btn-img">
                            </a>

                            <!-- Tombol Download App Store -->
                            <a href="#">
                                <img src="https://d2kh7o38xye1vj.cloudfront.net/wp-content/uploads/2023/04/downloadApp1.png"
                                    alt="App Store" class="download-btn-img">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="200">
                        <img src="assets_landingpage/img/gambar_mobile.png" class="img-fluid animated" alt="">
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Tentang Kami</h2>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                        <p>
                            Kami adalah tim inovator yang mengembangkan solusi berbasis IoT untuk meningkatkan efisiensi
                            pengeringan gabah di Kabupaten Indramayu.
                            Dengan mengintegrasikan teknologi IoT dan model prediksi, kami membantu petani mencapai
                            kadar air ideal 13–14% secara akurat dan efisien.
                        </p>
                        <ul>
                            <li><i class="bi bi-check2-circle"></i> <span>Pemantauan real-time kadar air gabah
                                    menggunakan sensor IoT.</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Integrasi data dari beberapa perangkat IoT
                                    untuk analisis terpusat.</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Prediksi durasi pengeringan dengan model yang
                                    akurat.</span></li>
                        </ul>
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <p>Melalui platform kami, petani dapat mengurangi ketergantungan pada metode pengeringan
                            tradisional, mencegah kerugian akibat pembusukan,
                            dan meningkatkan kualitas serta nilai jual gabah. Kami berkomitmen mendukung petani di
                            sentra produksi padi seperti Indramayu untuk mengelola
                            surplus gabah secara optimal.</p>
                    </div>

                </div>

            </div>

        </section><!-- /About Section -->

        <!-- Services Section -->
        <section id="services" class="services section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Layanan</h2>
                <p>Kami menyediakan solusi berbasis teknologi untuk mendukung proses pengeringan gabah yang efisien dan
                    terjangkau</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-activity icon"></i></div>
                            <h4><a href="" class="stretched-link">Pemantauan Real-Time</a></h4>
                            <p>Menggunakan sensor IoT seperti BME280 dan NTC untuk memantau suhu dan kadar air gabah
                                secara akurat.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-bounding-box-circles icon"></i></div>
                            <h4><a href="" class="stretched-link">Integrasi Data IoT</a></h4>
                            <p>Mengumpulkan dan mengintegrasikan data dari beberapa perangkat IoT pada bed dryer untuk
                                analisis terpusat.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-calendar4-week icon"></i></div>
                            <h4><a href="" class="stretched-link">Prediksi Durasi</a></h4>
                            <p>Model yang digunakan dapat memperkirakan waktu pengeringan secara akurat berdasarkan data
                                sensor.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                            <h4><a href="" class="stretched-link">Aplikasi Web & Mobile</a></h4>
                            <p>Akses data pengeringan secara real-time melalui aplikasi web dan mobile untuk kemudahan
                                pengguna.</p>
                        </div>
                    </div><!-- End Service Item -->

                </div>

            </div>

        </section><!-- /Services Section -->

        <section id="work-process" class="work-process section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Mulai Perjalanan Anda dengan GrainDryer IoT</h2>
                <p>Ikuti langkah sederhana untuk memasang teknologi IoT canggih dan optimalkan pengeringan gabah Anda
                    dengan mudah!</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-5">

                    <!-- Step 1 -->
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="steps-item">
                            <div class="steps-image">
                                <img src="https://www.pymnts.com/wp-content/uploads/2023/07/A2A-payments.jpg"
                                    alt="Step 1 Pemesanan & Konfirmasi" class="img-fluid" loading="lazy">
                            </div>
                            <div class="steps-content">
                                <div class="steps-number">01</div>
                                <h3>Pemesanan & Konfirmasi</h3>
                                <p>Pesan perangkat IoT Anda melalui platform kami dengan mudah. Setelah melakukan
                                    pembayaran, unggah bukti transfer, dan tim kami akan segera menghubungi Anda untuk
                                    konfirmasi.</p>
                                <div class="steps-features">
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Pemesanan Mudah</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Konfirmasi Cepat</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Dukungan Pelanggan</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Steps Item -->
                    </div>

                    <!-- Step 2 -->
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="steps-item">
                            <div class="steps-image">
                                <img src="https://www.areusdev.com/wp-content/uploads/IoT-1-1024x585.jpg"
                                    alt="Step 2 Pemasangan Profesional" class="img-fluid" loading="lazy">
                            </div>
                            <div class="steps-content">
                                <div class="steps-number">02</div>
                                <h3>Pemasangan Profesional</h3>
                                <p>Tim ahli kami akan datang langsung ke lokasi Anda untuk memasang perangkat IoT pada
                                    bed dryer. Kami memastikan instalasi cepat, akurat, dan siap digunakan untuk
                                    pengeringan gabah.</p>
                                <div class="steps-features">
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Pemasangan di Lokasi</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Teknisi Berpengalaman</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Konfigurasi Optimal</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Steps Item -->
                    </div>

                    <!-- Step 3 -->
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="steps-item">
                            <div class="steps-image">
                                <img src="https://images.unsplash.com/photo-1556155092-490a1ba16284?auto=format&fit=crop&w=600&q=80"
                                    alt="Step 3 Integrasi & Pemantauan" class="img-fluid" loading="lazy">
                            </div>
                            <div class="steps-content">
                                <div class="steps-number">03</div>
                                <h3>Integrasi & Pemantauan</h3>
                                <p>Nikmati kemudahan memantau pengeringan gabah secara real-time melalui aplikasi web
                                    atau mobile kami. Perangkat IoT terintegrasi penuh untuk memberikan data akurat dan
                                    prediksi durasi pengeringan.</p>
                                <div class="steps-features">
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Aplikasi Web & Mobile</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Pemantauan Real-Time</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Prediksi yang Akurat</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Steps Item -->
                    </div>

                </div>

            </div>

        </section>

        <!-- Call To Action Section -->
        <section id="call-to-action" class="call-to-action section dark-background">

            <img src="assets_landingpage/img/bg_gabah.png" alt="">

            <div class="container">

                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                    <div class="col-xl-9 text-center text-xl-start">
                        <h3>Optimalkan Pengeringan Gabah Anda</h3>
                        <p>Nikmati kemudahan pemantauan real-time dan prediksi durasi pengeringan dengan teknologi IoT
                            dan model prediksi yang akurat.
                            Tingkatkan kualitas gabah dan kurangi kerugian dengan solusi kami.</p>
                    </div>
                    <div class="col-xl-3 cta-btn-container text-center">
                        @auth
                            {{-- <a class="cta-btn align-middle" href="/dashboard">Dashboard</a> --}}
                        @else
                            <a class="cta-btn align-middle" href="/login">Coba Sekarang</a>
                        @endauth
                    </div>
                </div>

            </div>

        </section><!-- /Call To Action Section -->

        <!-- Pricing Section -->
        <section id="pricing" class="pricing section light-background">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Harga</h2>
                <p>Pilih paket GrainDryer IoT untuk pengeringan gabah yang efisien dan cerdas!</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4" id="paket-container">
                    <!-- Paket akan dimuat dari API -->
                </div>
            </div>

            <!-- Order Recap Modal -->
            <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" style="max-width: 400px;">
                    <div class="modal-content">
                        <div class="receipt-header text-center py-3" style="background-color: #198754;">
                            <h5 class="modal-title" id="orderModalLabel" style="color: white">
                                <i class="bi bi-receipt-cutoff me-2"></i> Pemesanan GrainDryer - IoT
                            </h5>
                        </div>
                        <div class="modal-body p-4">
                            <form action="{{ config('services.api.base_url') }}/pesanan/store" method="post"
                                enctype="multipart/form-data" class="order-form">
                                @csrf
                                <div class="receipt-content text-center mb-3">
                                    <p class="mb-0 fw-bold">GrainDryer IoT</p>
                                </div>

                                <div class="receipt-content text-center mb-3">
                                    <input type="hidden" name="nomor_struk" id="receipt-number-field"
                                        value="">
                                    <p class="mb-0"><strong>No. Struk:</strong> <span id="receipt-number">-</span>
                                    </p>
                                    <p class="mb-0"><strong>Tanggal:</strong> <span id="receipt-date">-</span></p>
                                    <p class="mb-0"><strong>Waktu:</strong> <span id="receipt-time">-</span></p>
                                    <hr class="dashed-hr">
                                </div>

                                <div class="receipt-content mb-3">
                                    <p class="mb-0"><strong>Nama Pelanggan:</strong>
                                        {{ auth()->user()->name ?? '-' }}</p>
                                    <p class="mb-0"><strong>Email:</strong> {{ auth()->user()->email ?? '-' }}</p>
                                    <hr class="dashed-hr">
                                </div>

                                <div class="receipt-content mb-3">
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-0"><strong>Paket:</strong></p>
                                        <p class="mb-0" id="recap-package">-</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-0 fw-bold"><strong>Total:</strong></p>
                                        <p class="mb-0 fw-bold text-success" id="total-price">-</p>
                                    </div>
                                    <hr class="dashed-hr">
                                </div>

                                <div class="mb-3">
                                    <label for="address-field" class="form-label fw-bold d-block">Alamat
                                        Pengiriman</label>
                                    <textarea name="alamat" id="address-field" class="form-control" rows="2" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="notes-field" class="form-label fw-bold d-block">Catatan</label>
                                    <textarea name="catatan" id="notes-field" class="form-control" rows="2"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="payment-proof" class="form-label fw-bold d-block">Bukti
                                        Pembayaran</label>
                                    <input type="file" name="bukti_pembayaran" id="payment-proof"
                                        class="form-control" accept="image/*,.pdf" required>
                                </div>

                                <input type="hidden" name="paket_id" id="package-id-field">

                                <div class="text-center">
                                    <div class="loading" style="display: none; color: #007bff; font-weight: bold;">
                                        Memuat...</div>
                                    <div class="error-message"
                                        style="display: none; color: #dc3545; font-weight: bold;"></div>
                                    <div class="sent-message"
                                        style="display: none; color: #28a745; font-weight: bold;">
                                        Pesanan Anda telah dikirim. Tim kami akan segera menghubungi Anda!
                                    </div>
                                    <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill">
                                        Konfirmasi Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Pricing Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Kontak Kami</h2>
                <p>Hubungi kami untuk informasi lebih lanjut tentang solusi pengeringan gabah berbasis IoT dan mulailah
                    optimalkan hasil panen Anda!</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-5">

                        <div class="info-wrap">
                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                                <i class="bi bi-geo-alt flex-shrink-0"></i>
                                <div>
                                    <h3>Alamat</h3>
                                    <p id="alamat-kontak">Memuat alamat...</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                                <i class="bi bi-telephone flex-shrink-0"></i>
                                <div>
                                    <h3>Telepon</h3>
                                    <p id="telepon-kontak">Memuat telepon...</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                                <i class="bi bi-envelope flex-shrink-0"></i>
                                <div>
                                    <h3>Email</h3>
                                    <p id="email-kontak">Memuat email...</p>
                                </div>
                            </div><!-- End Info Item -->
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <form id="contact-form" class="php-email-form" action="#" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <label for="name-field" class="pb-2">Nama Anda</label>
                                    <input type="text" name="name" id="name-field" class="form-control"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label for="email-field" class="pb-2">Email Anda</label>
                                    <input type="email" class="form-control" name="email" id="email-field"
                                        required>
                                </div>

                                <div class="col-md-12">
                                    <label for="message-field" class="pb-2">Pesan</label>
                                    <textarea class="form-control" name="message" rows="6" id="message-field" required></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <div class="loading" style="display:none;">Memuat</div>
                                    <div class="error-message" style="color:red;"></div>
                                    <div class="sent-message" style="display:none;color:green;">Pesan Anda telah
                                        terkirim.
                                        Terima kasih!</div>

                                    <button type="submit">Kirim Pesan</button>
                                </div>

                            </div>
                        </form>
                    </div><!-- End Contact Form -->

                </div>

            </div>

        </section><!-- /Contact Section -->

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const formatPrice = (price) => `Rp ${parseInt(price).toLocaleString('id-ID')}`;
                const generateReceiptNumber = () => `GD-${Math.floor(100000 + Math.random() * 900000)}`;
                const getCurrentDate = () => new Date().toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                const getCurrentTime = () => new Date().toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });

                // Manual deskripsi paket + status available
                const paketDescriptions = {
                    'paket basic': [{
                            text: '1 alat tombak untuk pemantauan kadar air dan suhu gabah',
                            available: true
                        },
                        {
                            text: 'Akses aplikasi web atau mobile',
                            available: true
                        },
                        {
                            text: 'Riwayat data sensor',
                            available: true
                        },
                        {
                            text: 'Integrasi multi-alat tombak',
                            available: false
                        },
                        {
                            text: 'Prediksi durasi pengeringan',
                            available: false
                        }
                    ],
                    'paket premium': [{
                            text: '2 alat tombak untuk pemantauan kadar air dan suhu gabah',
                            available: true
                        },
                        {
                            text: 'Akses aplikasi web dan mobile',
                            available: true
                        },
                        {
                            text: 'Riwayat data sensor',
                            available: true
                        },
                        {
                            text: 'Integrasi data 2 alat tombak',
                            available: true
                        },
                        {
                            text: 'Prediksi durasi pengeringan yang akurat',
                            available: true
                        }
                    ],
                    'paket ultimate': [{
                            text: '4 alat tombak untuk pemantauan kadar air dan suhu gabah',
                            available: true
                        },
                        {
                            text: 'Akses aplikasi web dan mobile',
                            available: true
                        },
                        {
                            text: 'Riwayat data sensor',
                            available: true
                        },
                        {
                            text: 'Integrasi data multi alat tombak',
                            available: true
                        },
                        {
                            text: 'Prediksi durasi pengeringan yang akurat',
                            available: true
                        }
                    ]
                };

                // Ambil data paket dari API dan tampilkan
                async function fetchPaket() {
                    try {
                        const res = await fetch('{{ config('services.api.base_url') }}/paket-harga', {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        if (!res.ok) {
                            throw new Error(`Gagal memuat data paket: ${res.statusText}`);
                        }
                        const data = await res.json();

                        const container = document.getElementById('paket-container');
                        container.innerHTML = '';

                        data.forEach((paket, i) => {
                            const key = paket.nama_paket.trim().toLowerCase();
                            const descList = paketDescriptions[key] || [];
                            const descHtml = descList.map(d =>
                                `<li class="${d.available ? '' : 'na'}">
                        <i class="bi ${d.available ? 'bi-check' : 'bi-x'}"></i> ${d.text}
                    </li>`
                            ).join('');

                            container.innerHTML += `
                    <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="${(i + 1) * 100}">
                        <div class="pricing-item featured">
                            <h3>${paket.nama_paket}</h3>
                            <h4><sup>Rp</sup>${parseInt(paket.harga).toLocaleString('id-ID')}</h4>
                            <ul>${descHtml}</ul>
                            @auth
                                <a href="#" class="buy-btn" data-bs-toggle="modal"
                                   data-bs-target="#orderModal"
                                   data-id="${paket.id}"
                                   data-name="${paket.nama_paket}"
                                   data-price="${paket.harga}">
                                    Beli Sekarang
                                </a>
                            @else
                                <a href="/login" class="buy-btn">Beli Sekarang</a>
                            @endauth
                        </div>
                    </div>
                `;
                        });

                        setupOrderModal();
                    } catch (err) {
                        console.error(err);
                        const container = document.getElementById('paket-container');
                        container.innerHTML =
                            '<p class="text-danger text-center">Gagal memuat paket. Silakan coba lagi nanti.</p>';
                    }
                }

                // Setup event tombol beli untuk buka modal dan set data order
                function setupOrderModal() {
                    document.querySelectorAll('.buy-btn[data-bs-toggle="modal"]').forEach(button => {
                        button.addEventListener('click', () => {
                            const paketId = button.getAttribute('data-id');
                            const paketName = button.getAttribute('data-name');
                            const paketPrice = button.getAttribute('data-price');

                            // document.getElementById('receipt-number').textContent =
                            //     generateReceiptNumber();
                            document.getElementById('receipt-number').textContent =
                                generateReceiptNumber();
                            document.getElementById('receipt-number-field').value = document
                                .getElementById('receipt-number').textContent;
                            document.getElementById('receipt-date').textContent = getCurrentDate();
                            document.getElementById('receipt-time').textContent = getCurrentTime();
                            document.getElementById('recap-package').textContent = paketName;
                            document.getElementById('total-price').textContent = formatPrice(
                                paketPrice);
                            document.getElementById('package-id-field').value = paketId;

                            // Reset form & messages
                            const orderForm = document.querySelector('.order-form');
                            if (orderForm) {
                                orderForm.reset();
                                document.getElementById('address-field').value = '';
                                document.getElementById('notes-field').value = '';
                                document.getElementById('payment-proof').value = '';
                                document.getElementById('package-id-field').value = paketId;
                                orderForm.querySelector('.loading').style.display = 'none';
                                orderForm.querySelector('.error-message').style.display = 'none';
                                orderForm.querySelector('.sent-message').style.display = 'none';
                            }
                        });
                    });
                }

                // Validasi file
                function validateFile(file) {
                    const maxSize = 20 * 1024 * 1024; // 20MB
                    const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                    if (!file) return 'File bukti pembayaran diperlukan.';
                    if (!allowedTypes.includes(file.type)) return 'File harus berupa JPG, PNG, atau PDF.';
                    if (file.size > maxSize) return 'Ukuran file maksimal 20MB.';
                    return null;
                }

                // Submit form order via fetch API
                const orderForm = document.querySelector('.order-form');
                if (orderForm) {
                    orderForm.addEventListener('submit', async (e) => {
                        e.preventDefault();

                        const loading = orderForm.querySelector('.loading');
                        const errorMsg = orderForm.querySelector('.error-message');
                        const sentMsg = orderForm.querySelector('.sent-message');
                        loading.style.display = 'block';
                        errorMsg.style.display = 'none';
                        sentMsg.style.display = 'none';

                        // Validasi file
                        const fileInput = document.getElementById('payment-proof');
                        const fileError = validateFile(fileInput.files[0]);
                        if (fileError) {
                            errorMsg.textContent = fileError;
                            errorMsg.style.display = 'block';
                            loading.style.display = 'none';
                            return;
                        }

                        try {
                            // Ambil token dari localStorage (atau tempat penyimpanan lainnya)
                            const token = localStorage.getItem('token');
                            const formData = new FormData(orderForm);
                            const res = await fetch(orderForm.action, {
                                method: 'POST',
                                headers: {
                                    'Authorization': `Bearer ${token}`,
                                    'Accept': 'application/json, application/pdf'
                                },
                                body: formData
                            });

                            // Periksa tipe konten respons
                            const contentType = res.headers.get('content-type');
                            if (contentType.includes('application/json')) {
                                const data = await res.json();
                                if (!res.ok) {
                                    let errorMessage = data.message || 'Gagal mengirim pesanan';
                                    if (data.errors) {
                                        errorMessage = Object.values(data.errors).flat().join(', ');
                                    }
                                    throw new Error(errorMessage);
                                }
                                // Jika JSON sukses (opsional, tergantung controller)
                                loading.style.display = 'none';
                                sentMsg.textContent = data.message ||
                                    'Pesanan Anda telah dikirim. Tim kami akan segera menghubungi Anda!';
                                sentMsg.style.display = 'block';
                                setTimeout(() => {
                                    sentMsg.style.display = 'none';
                                    bootstrap.Modal.getInstance(document.getElementById(
                                        'orderModal')).hide();
                                }, 3000);
                            } else if (contentType.includes('application/pdf')) {
                                const blob = await res.blob();
                                const url = window.URL.createObjectURL(blob);
                                const a = document.createElement('a');
                                a.href = url;
                                const noStruk = document.getElementById('receipt-number').textContent
                                    .trim();
                                a.download = `Pemesanan_Alat_IoT_${noStruk}.pdf`;
                                document.body.appendChild(a);
                                a.click();
                                a.remove();
                                window.URL.revokeObjectURL(url);

                                loading.style.display = 'none';
                                sentMsg.style.display = 'block';
                                setTimeout(() => {
                                    sentMsg.style.display = 'none';
                                    bootstrap.Modal.getInstance(document.getElementById(
                                        'orderModal')).hide();
                                }, 3000);
                            } else {
                                throw new Error('Tipe respons tidak didukung');
                            }
                        } catch (err) {
                            console.error(err);
                            errorMsg.textContent = err.message ||
                                'Terjadi kesalahan saat mengirim pesanan. Silakan coba lagi.';
                            errorMsg.style.display = 'block';
                            loading.style.display = 'none';
                        }
                    });
                }

                // Load data paket awal
                fetchPaket();

                fetch('{{ config('services.api.base_url') }}/kontak')
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            document.getElementById('alamat-kontak').textContent = data.alamat;
                            document.getElementById('telepon-kontak').textContent = data.telepon;
                            document.getElementById('email-kontak').textContent = data.email;
                        }
                    })
                    .catch(err => {
                        console.error('Gagal load data kontak:', err);
                        document.getElementById('alamat-kontak').textContent = 'Gagal memuat alamat';
                        document.getElementById('telepon-kontak').textContent = 'Gagal memuat telepon';
                        document.getElementById('email-kontak').textContent = 'Gagal memuat email';
                    });

                document.getElementById('contact-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = e.target;

                // Clear message states
                form.querySelector('.loading').style.display = 'block';
                form.querySelector('.error-message').textContent = '';
                form.querySelector('.error-message').style.display = 'none';
                form.querySelector('.sent-message').style.display = 'none';

                const data = {
                    name: form.name.value.trim(),
                    email: form.email.value.trim(),
                    message: form.message.value.trim(),
                };

                fetch('{{ config('services.api.base_url') }}/pesan', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => {
                        form.querySelector('.loading').style.display = 'none';
                        if (!response.ok) return response.json().then(err => Promise.reject(err));
                        return response.json();
                    })
                    .then(res => {
                        const sentMessage = form.querySelector('.sent-message');
                        sentMessage.style.display = 'block';
                        form.reset();
                        setTimeout(() => {
                            sentMessage.style.display = 'none';
                        }, 4000);
                    })
                    .catch(err => {
                        const errorMessage = form.querySelector('.error-message');
                        let msg = err.message || 'Terjadi kesalahan saat mengirim pesan.';
                        if (err.errors) {
                            msg = Object.values(err.errors).flat().join(' ');
                        }
                        errorMessage.textContent = msg;
                        errorMessage.style.display = 'block';
                        setTimeout(() => {
                            errorMessage.style.display = 'none';
                        }, 4000);
                    });
                });
            });
        </script>

    </main>

    <footer id="footer" class="footer">
        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> 
                <strong class="px-1 sitename">GrainDryer</strong> |
                <span>{{ date('Y') }}</span>
            </p>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets_landingpage2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets_landingpage2/vendor/aos/aos.js"></script>
    <script src="assets_landingpage2/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets_landingpage2/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets_landingpage2/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="assets_landingpage2/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets_landingpage2/vendor/isotope-layout/isotope.pkgd.min.js"></script>

    <!-- Main JS File -->
    <script src="assets_landingpage2/js/main.js"></script>

</body>

</html>
