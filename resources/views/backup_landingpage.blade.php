<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Landing Page</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    {{-- <link href="assets_landingpage/img/favicon.png" rel="icon">
    <link href="assets_landingpage/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo_gabah.png" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets_landingpage/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets_landingpage/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets_landingpage/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets_landingpage/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets_landingpage/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets_landingpage/css/main.css" rel="stylesheet">
    <style>
        .download-btn-img {
            height: 45px;
            border-radius: 50px;
            transition: transform 0.2s ease;
        }

        .download-btn-img:hover {
            transform: scale(1.05);
        }

        @media (max-width: 576px) {
            .download-btn-img {
                height: 40px;
            }
        }
    </style>

    <!-- =======================================================
  * Template Name: Bootslander
  * Template URL: https://bootstrapmade.com/bootslander-free-bootstrap-landing-page-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets_landingpage/img/logo.png" alt=""> -->
                <h1 class="sitename">GrainDryer</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#beranda" class="active">Beranda</a></li>
                    <li><a href="#details">Tentang</a></li>
                    <li><a href="#footer">Kontak</a></li>
                    <a href="/login"
                        style="background-color: #ffffff;
                            padding: 7px;
                            border-radius: 25px;
                            letter-spacing: 2px;
                            width: 85px;
                            justify-content: center;
                            color: #1E3B8A;
                            font-weight: 700;
                            text-decoration: none;
                            display: inline-flex;
                            transition: all 0.3s;"
                        onmouseover="this.style.backgroundColor='#ffffffe6'; this.style.color='#1E3B8A';"
                        onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#1E3B8A';">Login</a>

                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="beranda" class="hero section dark-background">
            <img src="assets_landingpage/img/hero-bg-2.jpg" alt="" class="hero-bg">

            <div class="container">
                <div class="row gy-4 justify-content-between">
                    <div class="col-lg-4 order-lg-last hero-img" data-aos="zoom-out" data-aos-delay="100">
                        <img src="assets_landingpage/img/gambar_mobile.png" class="img-fluid animated" alt="">
                    </div>

                    <div class="col-lg-6  d-flex flex-column justify-content-center" data-aos="fade-in">
                        <h1>Selamat Datang di Website <span>GrainDryer</span></h1>
                        <p>Solusi Digital untuk Pengeringan Gabah — Cepat, Efisien, dan Terintegrasi</p>

                        <div class="container">
                            <div class="d-flex flex-wrap justify-content-start gap-3 mt-4">
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

                                <!-- Tombol Watch Video (jika ingin diaktifkan) -->
                                <!--
    <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center">
      <i class="bi bi-play-circle fs-4 me-2"></i>
      <span>Watch Video</span>
    </a>
    -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 24 150 28 " preserveAspectRatio="none">
                <defs>
                    <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
                    </path>
                </defs>
                <g class="wave1">
                    <use xlink:href="#wave-path" x="50" y="3"></use>
                </g>
                <g class="wave2">
                    <use xlink:href="#wave-path" x="50" y="0"></use>
                </g>
                <g class="wave3">
                    <use xlink:href="#wave-path" x="50" y="9"></use>
                </g>
            </svg>

        </section><!-- /Hero Section -->

        <!-- Stats Section -->
        <section id="stats" class="stats section light-background">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4 justify-content-center">

                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center">
                        <i class="bi bi-box-seam"></i>
                        <div class="stats-item">
                            <span data-purecounter-start="0" data-purecounter-end="500" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Jumlah Proses Diselesaikan</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center">
                        <i class="bi bi-person-check"></i>
                        <div class="stats-item">
                            <span data-purecounter-start="0" data-purecounter-end="50" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Petani Terbantu</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center">
                        <i class="bi bi-cpu"></i>
                        <div class="stats-item">
                            <span data-purecounter-start="0" data-purecounter-end="80" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Alat IoT Terpasang</p>
                        </div>
                    </div><!-- End Stats Item -->

                </div>
            </div>
        </section><!-- /Stats Section -->

        <!-- Details Section -->
        <section id="details" class="details section" style="background-color: #8080800d;">
            <div class="container section-title" data-aos="fade-up">
                <h2>Detail</h2>
                <div><span>Lihat Informasi</span> <span class="description-title">Menarik</span></div>
            </div>
            <div class="container">

                <div class="row g-4 justify-content-center">

                    <!-- Card Aplikasi Website -->
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="d-flex justify-content-center mt-4">
                                <img src="https://img.icons8.com/fluency/96/000000/web.png" alt="Aplikasi Web" />
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-success text-center">Aplikasi Website</h5>
                                <p class="card-text fst-italic text-secondary text-center px-3">
                                    Pantau proses pengeringan gabah secara real-time dengan dashboard web yang mudah
                                    digunakan dan lengkap fitur.
                                </p>
                                <ul class="list-unstyled flex-grow-1 px-3">
                                    <li><i class="bi bi-check2-circle text-success me-2"></i>Monitoring kelembaban &
                                        suhu secara cepat dan akurat</li>
                                    <li><i class="bi bi-check2-circle text-success me-2"></i>Histori data dan laporan
                                        otomatis</li>
                                    <li><i class="bi bi-check2-circle text-success me-2"></i>Manajemen alat dan
                                        pengguna terintegrasi</li>
                                </ul>
                                {{-- <a href="#" class="btn btn-success mt-auto align-self-center px-4">Pelajari
                                    Lebih Lanjut</a> --}}
                            </div>
                        </div>
                    </div>

                    <!-- Card Aplikasi Mobile -->
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="d-flex justify-content-center mt-4">
                                <img src="https://img.icons8.com/fluency/96/000000/smartphone-tablet.png" alt="Aplikasi Mobile" />
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-success text-center">Aplikasi Mobile</h5>
                                <p class="card-text fst-italic text-secondary text-center px-3">
                                    Kendalikan dan terima notifikasi pengeringan gabah langsung dari smartphone Anda,
                                    dimana pun dan kapan pun.
                                </p>
                                <ul class="list-unstyled flex-grow-1 px-3">
                                    <li><i class="bi bi-check2-circle text-success me-2"></i>Notifikasi waktu real-time
                                    </li>
                                    <li><i class="bi bi-check2-circle text-success me-2"></i>Kontrol alat bed dryer
                                        dari jarak jauh</li>
                                    <li><i class="bi bi-check2-circle text-success me-2"></i>Interface responsif dan
                                        user-friendly</li>
                                </ul>
                                {{-- <a href="#" class="btn btn-success mt-auto align-self-center px-4">Unduh
                                    Aplikasi</a> --}}
                            </div>
                        </div>
                    </div>

                    <!-- Card Alat IoT -->
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="d-flex justify-content-center mt-4">
                                <img src="https://img.icons8.com/fluency/96/000000/internet-of-things.png" alt="Alat IoT" />
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-success text-center">Alat IoT Pengeringan Gabah</h5>
                                <p class="card-text fst-italic text-secondary text-center px-3">
                                    Sensor IoT canggih yang mengukur kelembaban dan suhu secara otomatis, membantu
                                    mengoptimalkan proses pengeringan.
                                </p>
                                <ul class="list-unstyled flex-grow-1 px-3">
                                    <li><i class="bi bi-check2-circle text-success me-2"></i>Pengukuran data presisi
                                        dan otomatis</li>
                                    <li><i class="bi bi-check2-circle text-success me-2"></i>Konektivitas internet
                                        stabil</li>
                                    <li><i class="bi bi-check2-circle text-success me-2"></i>Mudah dipasang pada alat
                                        bed dryer Anda</li>
                                </ul>
                                {{-- <a href="#" class="btn btn-success mt-auto align-self-center px-4">Pelajari
                                    Lebih Lanjut</a> --}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

    <footer id="footer" class="footer dark-background text-center py-4">

        <div class="container">
            <div class="row justify-content-center text-white text-center text-md-start">

                <div class="col-md-6 col-lg-4 mb-4">
                    <h5 class="mb-3 fw-bold">GrainDryer</h5>
                    <ul class="list-unstyled text-white">
                        <li class="mb-2 d-flex">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            <div class="d-flex">
                                <span class="me-2" style="min-width: 70px;"><strong>Alamat</strong></span>
                                <span class="me-2">:</span>
                                <span>Jl. Pertanian No. 108, Jakarta</span>
                            </div>
                        </li>
                        <li class="mb-2 d-flex">
                            <i class="bi bi-envelope-fill me-2"></i>
                            <div class="d-flex">
                                <span class="me-2" style="min-width: 70px;"><strong>Email</strong></span>
                                <span class="me-2">:</span>
                                <span>info@example.com</span>
                            </div>
                        </li>
                        <li class="d-flex">
                            <i class="bi bi-telephone-fill me-2"></i>
                            <div class="d-flex">
                                <span class="me-2" style="min-width: 70px;"><strong>Phone</strong></span>
                                <span class="me-2">:</span>
                                <span>+1 5589 55488 55</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <div
                    class="col-md-6 col-lg-4 mb-4 d-flex flex-column align-items-md-start align-items-center justify-content-center">
                    <h6 class="fw-semibold mb-3">Ikuti Kami</h6>
                    <div class="social-links d-flex gap-3">
                        <a href="#"><i class="bi bi-twitter-x text-white fs-5"></i></a>
                        <a href="#"><i class="bi bi-facebook text-white fs-5"></i></a>
                        <a href="#"><i class="bi bi-instagram text-white fs-5"></i></a>
                        <a href="#"><i class="bi bi-linkedin text-white fs-5"></i></a>
                    </div>
                </div>

            </div>
        </div>


        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <span id="year"></span> | <strong
                    class="px-1 sitename">GrainDryer</strong></p>
        </div>

        <script>
            // Isi elemen dengan ID "year" dengan tahun saat ini
            document.getElementById("year").textContent = new Date().getFullYear();
        </script>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets_landingpage/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="assets_landingpage/vendor/php-email-form/validate.js"></script> --}}
    <script src="assets_landingpage/vendor/aos/aos.js"></script>
    <script src="assets_landingpage/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets_landingpage/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets_landingpage/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets_landingpage/js/main.js"></script>

</body>

</html>
