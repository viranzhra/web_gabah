<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GrainDryer | Operator</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo_gabah.png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-image: url('/assets/images/bg_body.png');
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }

        @media (max-width: 1024px) {
            body {
                background-size: 80%;
            }
        }

        @media (max-width: 768px) {
            body {
                background-size: 100%;
            }
        }

        .nav-item {
            @apply relative font-medium text-[#1E3A8A] hover:font-bold hover:border-b-2 hover:border-[#1E3A8A] block py-2;
        }

        .nav-item.active {
            font-weight: 700;
            border-bottom: 2px solid #1E3A8A;
        }
    </style>
</head>

<body class="text-[#1E3A8A]">

    <!-- Navbar -->
    <nav class="bg-[#1E3A8A]/5 text-[#1E3A8A] shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Logo dan Nama -->
                <div class="flex items-center space-x-2">
                    <img src="../assets/images/logos/logo_gabah.png" style="width: 35px; height: 35px;" alt="">
                    <span class="font-bold text-lg">GrainDryer</span>
                </div>

                <!-- Menu Navigasi (Desktop) -->
                <div class="hidden md:flex items-center space-x-12">
                    <a href="{{ route('operator.dashboard') }}" class="nav-item {{ Route::is('operator.dashboard') ? 'active' : '' }}">Beranda</a>
                    <a href="#" class="nav-item">Validasi</a>
                    {{-- <a href="#" class="nav-item">Pengeringan</a> --}}
                    <a href="{{ route('operator.riwayat') }}" class="nav-item {{ Route::is('operator.riwayat') ? 'active' : '' }}">Riwayat</a>

                    <!-- Icon Profil -->
                    {{-- <div class="ml-4">
                        <svg class="h-7 w-7" width="40" height="40" viewBox="0 0 40 40" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M26.6667 16.6667C26.6667 20.35 23.6834 23.3333 20 23.3333C16.3167 23.3333 13.3334 20.35 13.3334 16.6667C13.3334 12.9833 16.3167 10 20 10C23.6834 10 26.6667 12.9833 26.6667 16.6667Z"
                                fill="#1E3B8A" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M20 40C31.05 40 40 31.05 40 20C40 8.95 31.05 0 20 0C8.95 0 0 8.95 0 20C0 31.05 8.95 40 20 40ZM30.45 35.0667C35.2167 31.75 38.3333 26.25 38.3333 20C38.3333 9.86667 30.1333 1.66667 20 1.66667C9.86667 1.66667 1.66667 9.86667 1.66667 20C1.66667 26.25 4.78333 31.75 9.55 35.0667C10.725 32.8667 14.5167 26.6667 20 26.6667C25.4833 26.6667 29.2667 32.8667 30.45 35.0667Z"
                                fill="#1E3B8A" />
                        </svg>
                    </div> --}}

                    <style>
                        /* Container profil */
                        .profile-container {
                            position: relative;
                            display: inline-block;
                            cursor: pointer;
                        }

                        /* Dropdown menu */
                        .dropdown-menu {
                            position: absolute;
                            top: 45px;
                            right: 0;
                            background-color: rgb(153 168 208 / 66%);
                            /* transparan dari #1E3B8A */
                            border: 1px solid rgba(255, 255, 255, 0.2);
                            border-radius: 6px;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                            min-width: 160px;
                            display: none;
                            z-index: 1000;
                            backdrop-filter: blur(4px);
                            /* efek blur modern */
                        }

                        .dropdown-menu.show {
                            display: block;
                        }

                        .dropdown-item {
                            padding: 10px 15px;
                            font-size: 14px;
                            color: white;
                            text-decoration: none;
                            display: flex;
                            align-items: center;
                            gap: 10px;
                            transition: background 0.3s;
                        }

                        .dropdown-item:hover {
                            background-color: rgba(255, 255, 255, 0.16);
                        }

                        .dropdown-divider {
                            height: 1px;
                            margin: 5px 0;
                            background-color: rgba(255, 255, 255, 0.3);
                        }

                        .logout-button {
                            cursor: pointer;
                            border: none;
                            background: none;
                            width: 100%;
                            text-align: left;
                        }

                        /* Tombol Aksi Mobile */
                        .mobile-action-btn {
                            flex: 1;
                            text-align: center;
                            padding: 10px 16px;
                            border-radius: 8px;
                            background-color: rgba(30, 59, 138, 0.9);
                            /* Transparan navy */
                            color: white;
                            font-weight: bold;
                            font-size: 14px;
                            text-decoration: none;
                            transition: background-color 0.3s ease;
                            border: none;
                            cursor: pointer;
                        }

                        .mobile-action-btn:hover {
                            background-color: rgba(30, 59, 138, 1);
                        }

                        @media (min-width: 480px) {
                            .xs\:flex-row {
                                flex-direction: row;
                            }

                            .xs\:justify-between {
                                justify-content: space-between;
                            }
                        }
                    </style>

                    <div class="profile-container" id="profileContainer">
                        <!-- Icon Profil -->
                        <svg class="h-7 w-7" width="40" height="40" viewBox="0 0 40 40" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M26.6667 16.6667C26.6667 20.35 23.6834 23.3333 20 23.3333C16.3167 23.3333 13.3334 20.35 13.3334 16.6667C13.3334 12.9833 16.3167 10 20 10C23.6834 10 26.6667 12.9833 26.6667 16.6667Z"
                                fill="#1E3B8A" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M20 40C31.05 40 40 31.05 40 20C40 8.95 31.05 0 20 0C8.95 0 0 8.95 0 20C0 31.05 8.95 40 20 40ZM30.45 35.0667C35.2167 31.75 38.3333 26.25 38.3333 20C38.3333 9.86667 30.1333 1.66667 20 1.66667C9.86667 1.66667 1.66667 9.86667 1.66667 20C1.66667 26.25 4.78333 31.75 9.55 35.0667C10.725 32.8667 14.5167 26.6667 20 26.6667C25.4833 26.6667 29.2667 32.8667 30.45 35.0667Z"
                                fill="#1E3B8A" />
                        </svg>

                        <!-- Dropdown menu -->
                        <div class="dropdown-menu" id="dropdownMenu">
                            <a href="/my-profile" class="dropdown-item">
                                <!-- Icon kecil, bisa pakai SVG kecil -->
                                <span style="font-weight:bold;">👤</span> My Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item logout-button" id="logoutBtn">
                                <span style="font-weight:bold;">🚪</span> Logout
                            </button>
                        </div>

                    </div>

                    <script>
                        const profileContainer = document.getElementById('profileContainer');
                        const dropdownMenu = document.getElementById('dropdownMenu');
                        const logoutBtn = document.getElementById('logoutBtn');

                        // Toggle dropdown saat klik icon profil
                        profileContainer.addEventListener('click', (e) => {
                            e.stopPropagation(); // supaya klik dropdown tidak men-trigger document click
                            dropdownMenu.classList.toggle('show');
                        });

                        // Klik di luar dropdown -> close dropdown
                        document.addEventListener('click', () => {
                            dropdownMenu.classList.remove('show');
                        });

                        // Logout button klik
                        logoutBtn.addEventListener('click', () => {
                            if (confirm('Apakah kamu yakin ingin logout?')) {
                                // Kalau pakai form POST, bisa submit form di sini
                                // Kalau logout via GET, tinggal redirect:
                                window.location.href = '/logout';
                            }
                        });
                    </script>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.getElementById("logoutBtnMobile").addEventListener("click", function() {
                                if (confirm("Yakin ingin logout?")) {
                                    window.location.href = "/logout"; // Ganti sesuai route logout
                                }
                            });
                        });
                    </script>

                </div>

                <!-- Tombol Hamburger Mobile -->
                <div class="md:hidden">
                    <button id="menu-toggle" class="focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div id="mobile-menu" class="md:hidden hidden px-4 pb-4 flex flex-col space-y-2">
            <!-- Icon Profil -->
            <div class="mt-2">
                <svg class="h-7 w-7" width="40" height="40" viewBox="0 0 40 40" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M26.6667 16.6667C26.6667 20.35 23.6834 23.3333 20 23.3333C16.3167 23.3333 13.3334 20.35 13.3334 16.6667C13.3334 12.9833 16.3167 10 20 10C23.6834 10 26.6667 12.9833 26.6667 16.6667Z"
                        fill="#1E3B8A" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M20 40C31.05 40 40 31.05 40 20C40 8.95 31.05 0 20 0C8.95 0 0 8.95 0 20C0 31.05 8.95 40 20 40ZM30.45 35.0667C35.2167 31.75 38.3333 26.25 38.3333 20C38.3333 9.86667 30.1333 1.66667 20 1.66667C9.86667 1.66667 1.66667 9.86667 1.66667 20C1.66667 26.25 4.78333 31.75 9.55 35.0667C10.725 32.8667 14.5167 26.6667 20 26.6667C25.4833 26.6667 29.2667 32.8667 30.45 35.0667Z"
                        fill="#1E3B8A" />
                </svg>
            </div>

            <a href="#" class="nav-item active">Beranda</a>
            <a href="#" class="nav-item">Validasi</a>
            {{-- <a href="#" class="nav-item">Pengeringan</a> --}}
            <a href="#" class="nav-item">Riwayat</a>

            <!-- Tombol My Profile dan Logout (Horizontal) -->
            <div class="mt-4 flex flex-col xs:flex-row xs:justify-between gap-2">
                <a href="/my-profile" class="mobile-action-btn">
                    👤 My Profile
                </a>
                <button id="logoutBtnMobile" class="mobile-action-btn">
                    🚪 Logout
                </button>
            </div>
        </div>
    </nav>

    <!-- Konten utama -->
    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            @yield('content')
        </div>
    </div>

    <script>
        // Toggle menu mobile
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
