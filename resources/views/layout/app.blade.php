<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GrainDryer')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo_gabah.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @yield('styles') <!-- For page-specific styles -->
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="#"
                                    class="d-flex align-items-center justify-content-center gap-2 py-3 w-100 text-decoration-none">
                                    <img src="{{ asset('assets/images/logos/logo_gabah.png') }}" width="40" height="40"
                                        alt="" >
                                    <span class="mb-0" style="color: #1E3B8A; font-weight: 800; font-size: 23px;">GrainDryer</span>
                                </a>
                    {{-- <a href="./index.html" class="text-nowrap logo-img">
                        <img src="../assets/images/logos/logo_gabah.png" width="45" style="border-radius: 50%;" alt="" />
                    </a> --}}
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap" style="margin-left: -10px;">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Beranda</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/dashboard" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard" style="width: 24"></i>
                                </span>
                                <span class="hide-menu">Dasbor</span>
                            </a>
                        </li>
                        <li class="nav-small-cap" style="margin-left: -10px;">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Pengeringan Gabah</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/prediksi" aria-expanded="false">
                                <span>
                                    <svg width="24" height="24" viewBox="0 0 33 33" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                            d="M25.5557 14.3825L24.2797 12.7902C23.9222 12.3502 23.991 11.6902 24.4447 11.3465C24.8985 10.989 25.5447 11.0577 25.8885 11.5115L28.6385 14.949C28.996 15.389 28.9272 16.049 28.4735 16.3927L25.036 19.1427C24.8435 19.294 24.6235 19.3627 24.3897 19.3627L24.4035 19.349C24.101 19.349 23.7985 19.2115 23.5922 18.964C23.2347 18.524 23.3035 17.864 23.7572 17.5202L25.1322 16.4202C21.5339 15.8977 13.6867 13.871 5.79975 5.98398C5.60829 5.78974 5.50097 5.52796 5.50097 5.25523C5.50097 4.9825 5.60829 4.72072 5.79975 4.52648C6.1985 4.12773 6.8585 4.12773 7.25725 4.52648C14.7785 12.0477 22.3465 13.9177 25.5557 14.3839M7.90625 31.0365C7.1775 31.0365 6.7375 31.0365 6.2975 30.8577C5.70625 30.6102 5.23875 30.1427 4.99125 29.5515C4.8125 29.1115 4.8125 28.6715 4.8125 27.9427V15.5677C4.8125 14.839 4.8125 14.399 4.99125 13.959C5.23875 13.3677 5.70625 12.9002 6.2975 12.6527C6.7375 12.474 7.1775 12.474 7.90625 12.474C8.635 12.474 9.075 12.474 9.515 12.6527C10.1062 12.9002 10.5737 13.3677 10.8212 13.959C11 14.399 11 14.839 11 15.5677V27.9427C11 28.6715 11 29.1115 10.8212 29.5515C10.5737 30.1427 10.1062 30.6102 9.515 30.8577C9.075 31.0365 8.635 31.0365 7.90625 31.0365ZM7.90625 14.5365C7.54875 14.5365 7.1775 14.5365 7.08125 14.564C6.99875 14.5915 6.94375 14.6602 6.9025 14.7427C6.875 14.8252 6.875 15.1965 6.875 15.5677V27.9427C6.875 28.3002 6.875 28.6715 6.9025 28.7677C6.93 28.8502 6.99875 28.919 7.08125 28.9465C7.26 29.0015 8.53875 29.0015 8.73125 28.9465C8.81375 28.919 8.86875 28.8502 8.91 28.7677C8.9375 28.6852 8.9375 28.314 8.9375 27.9427V15.5677C8.9375 15.2102 8.9375 14.839 8.91 14.7427C8.89571 14.7013 8.87219 14.6637 8.84123 14.6328C8.81026 14.6018 8.77265 14.5783 8.73125 14.564C8.64875 14.5365 8.2775 14.5365 7.90625 14.5365ZM17.5312 31.0365C16.8025 31.0365 16.3625 31.0365 15.9225 30.8577C15.3312 30.6102 14.8637 30.1427 14.6162 29.5515C14.4375 29.1115 14.4375 28.6715 14.4375 27.9427V20.3802C14.4375 19.6515 14.4375 19.2115 14.6162 18.7715C14.8637 18.1802 15.3312 17.7127 15.9225 17.4652C16.3625 17.2865 16.8025 17.2865 17.5312 17.2865C18.26 17.2865 18.7 17.2865 19.14 17.4652C19.7312 17.7127 20.1987 18.1802 20.4462 18.7715C20.625 19.2115 20.625 19.6515 20.625 20.3802V27.9427C20.625 28.6715 20.625 29.1115 20.4462 29.5515C20.1987 30.1427 19.7312 30.6102 19.14 30.8577C18.7 31.0365 18.26 31.0365 17.5312 31.0365ZM17.5312 19.349C17.1737 19.349 16.8025 19.349 16.7062 19.3765C16.6237 19.404 16.5687 19.4727 16.5275 19.5552C16.5 19.6377 16.5 20.009 16.5 20.3802V27.9427C16.5 28.3002 16.5 28.6715 16.5275 28.7677C16.555 28.8502 16.6237 28.919 16.7062 28.9465C16.885 29.0015 18.1637 29.0015 18.3562 28.9465C18.4387 28.919 18.4937 28.8502 18.535 28.7677C18.5625 28.6852 18.5625 28.314 18.5625 27.9427V20.3802C18.5625 20.0227 18.5625 19.6515 18.535 19.5552C18.5207 19.5138 18.4972 19.4762 18.4662 19.4453C18.4353 19.4143 18.3976 19.3908 18.3562 19.3765C18.2737 19.349 17.9025 19.349 17.5312 19.349ZM25.5475 30.8577C25.9875 31.0365 26.4275 31.0365 27.1562 31.0365C27.885 31.0365 28.325 31.0365 28.765 30.8577C29.3562 30.6102 29.8237 30.1427 30.0712 29.5515C30.25 29.1115 30.25 28.6715 30.25 27.9427V23.8177C30.25 23.089 30.25 22.649 30.0712 22.209C29.8237 21.6177 29.3562 21.1502 28.765 20.9027C28.325 20.724 27.885 20.724 27.1562 20.724C26.4275 20.724 25.9875 20.724 25.5475 20.9027C24.9562 21.1502 24.4887 21.6177 24.2412 22.209C24.0625 22.649 24.0625 23.089 24.0625 23.8177V27.9427C24.0625 28.6715 24.0625 29.1115 24.2412 29.5515C24.4887 30.1427 24.9562 30.6102 25.5475 30.8577ZM26.3312 22.814C26.4275 22.7865 26.7987 22.7865 27.1562 22.7865C27.5275 22.7865 27.8987 22.7865 27.9812 22.814C28.0637 22.8415 28.1325 22.9102 28.16 22.9927C28.1875 23.089 28.1875 23.4602 28.1875 23.8177V27.9427C28.1875 28.314 28.1875 28.6852 28.16 28.7677C28.1187 28.8502 28.0637 28.919 27.9812 28.9465C27.7887 29.0015 26.51 29.0015 26.3312 28.9465C26.2898 28.919 26.2323 28.8502 26.2095 28.7677C26.1822 28.6852 26.1822 28.314 26.1822 27.9427V23.8177C26.1822 23.4602 26.1822 23.089 26.2095 22.9927C26.2323 22.9102 26.2898 22.8415 26.3312 22.814Z" />
                                    </svg>
                                </span>
                                <span class="hide-menu">Proses Pengeringan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/validasi" aria-expanded="false">
                                <span>
                                    <svg width="24" height="24" viewBox="0 0 35 35"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-gray-500 hover:text-blue-500 transition-colors duration-200">
                                        <path
                                            d="M21.8458 10.2316C21.8458 10.2316 22.575 10.9608 23.3042 12.4191C23.3042 12.4191 25.6215 8.7733 27.6792 8.04414M14.576 2.94726C10.9317 2.79414 8.11708 3.21268 8.11708 3.21268C6.33937 3.34101 2.93271 4.3356 2.93271 10.1573C2.93271 15.9264 2.89625 23.0402 2.93271 25.8766C2.93271 27.6091 4.00604 31.6516 7.71896 31.8675C12.2325 32.13 20.3627 32.1868 24.0931 31.8675C25.0906 31.8106 28.4156 31.0275 28.8356 27.4108C29.2717 23.6629 29.1856 21.0598 29.1856 20.44"
                                            fill="none" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M10.1792 18.9816H16.0125M10.1792 24.8149H21.8459M32.0834 10.2316C32.0834 14.2581 28.8167 17.5233 24.7844 17.5233C23.8262 17.5242 22.8773 17.3363 21.9918 16.9703C21.1063 16.6043 20.3016 16.0674 19.6237 15.3902C18.9458 14.713 18.4081 13.9088 18.0412 13.0237C17.6743 12.1386 17.4854 11.1898 17.4854 10.2316C17.4854 6.20369 20.7536 2.93995 24.7844 2.93995C25.7426 2.93899 26.6915 3.12688 27.577 3.4929C28.4626 3.85891 29.2672 4.39586 29.9451 5.07304C30.623 5.75023 31.1607 6.55438 31.5276 7.43953C31.8945 8.32467 32.0834 9.27344 32.0834 10.2316Z"
                                            fill="none" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                </span>
                                <span class="hide-menu">Validasi Pengeringan</span>
                            </a>
                        </li>
                        <li class="nav-small-cap" style="margin-left: -10px;">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Manajemen</span>
                        </li>
                        <li
                            class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('jenis_gabah') || request()->is('data_device') || request()->is('role_manage') ? 'active' : '' }}" href="/jenis_gabah" aria-expanded="false">
                                <span>
                                    <svg width="27" height="27" viewBox="0 0 39 39"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        class="w-5 h-5 transition-colors duration-200">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M21.125 7.8V4.875H24.5335V8.40838C25.1051 8.6912 25.6522 9.02091 26.1693 9.39412L26.6699 9.08989L29.093 7.62892L30.4912 10.1605L32.7268 14.2145L34.125 16.7476L31.7047 18.2101L31.2042 18.5099C31.2322 18.8419 31.2462 19.1709 31.2462 19.5C31.2462 19.8291 31.2322 20.1581 31.2042 20.4901L31.7047 20.7899L34.125 22.2524L32.7268 24.7855L30.4912 28.8395L29.093 31.3711L26.6699 29.9101L26.1693 29.6059C25.6522 29.9791 25.1051 30.3088 24.5335 30.5916V34.125H21.125V31.2H21.7373V28.5529C23.3355 28.1229 24.7616 27.2498 25.883 26.0549L28.0683 27.377L30.3068 23.323L28.1173 22.0009C28.327 21.2038 28.4501 20.3673 28.4501 19.5C28.4501 18.6327 28.327 17.7962 28.1173 16.9991L30.3068 15.677L28.0683 11.623L25.883 12.9451C24.7616 11.7502 23.3355 10.8771 21.7373 10.4471V7.8H21.125ZM25.0936 19.5C25.0936 22.1402 23.4218 24.3717 21.125 25.0995V21.8814C21.8347 21.351 22.2972 20.4821 22.2972 19.5C22.2972 18.5179 21.8347 17.649 21.125 17.1186V13.9005C23.4218 14.6283 25.0936 16.8598 25.0936 19.5ZM6.5 11.3751C6.5 8.06043 11.4623 5.32518 17.8751 4.92543V8.18276C15.4984 8.35286 13.3511 8.89078 11.7611 9.68579C10.326 10.4033 9.75003 11.0842 9.75003 11.3751C9.75003 11.666 10.326 12.3469 11.7611 13.0644C13.3511 13.8594 15.4984 14.3974 17.8751 14.5674V17.8248C14.6512 17.6238 11.7939 16.8326 9.74949 15.6743L9.74896 19.5001H9.75003C9.75003 19.791 10.326 20.4719 11.7611 21.1894C13.3511 21.9844 15.4984 22.5223 17.8751 22.6924V25.9498C14.6506 25.7488 11.793 24.9573 9.74843 23.7986L9.74789 27.5083L9.75018 27.6297C9.83046 28.7439 13.1931 30.4777 17.8751 30.8166V34.0748C11.6166 33.6846 6.73971 31.07 6.50861 27.8634L6.5 27.6251V11.3751Z" />
                                    </svg>
                                </span>
                                <span class="hide-menu">Data Master</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('riwayat*') ? 'active' : '' }}" href="/riwayat" aria-expanded="false">
                                <span>
                                    <svg width="23" height="23" viewBox="0 0 27 27" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                            d="M13.5 0C16.17 0 18.7801 0.791761 21.0002 2.27516C23.2203 3.75856 24.9506 5.86697 25.9724 8.33377C26.9942 10.8006 27.2615 13.515 26.7406 16.1337C26.2197 18.7525 24.934 21.1579 23.0459 23.0459C21.1579 24.934 18.7525 26.2197 16.1337 26.7406C13.515 27.2615 10.8006 26.9942 8.33377 25.9724C5.86697 24.9506 3.75856 23.2203 2.27516 21.0002C0.791761 18.7801 0 16.17 0 13.5C0 13.2762 0.0888949 13.0616 0.247129 12.9034C0.405363 12.7451 0.619974 12.6563 0.84375 12.6563C1.06753 12.6563 1.28214 12.7451 1.44037 12.9034C1.59861 13.0616 1.6875 13.2762 1.6875 13.5C1.6875 15.8363 2.38029 18.1201 3.67827 20.0627C4.97624 22.0052 6.8211 23.5193 8.97955 24.4133C11.138 25.3074 13.5131 25.5413 15.8045 25.0855C18.0959 24.6297 20.2007 23.5047 21.8527 21.8527C23.5047 20.2007 24.6297 18.0959 25.0855 15.8045C25.5413 13.5131 25.3074 11.138 24.4133 8.97955C23.5193 6.8211 22.0052 4.97624 20.0627 3.67827C18.1201 2.38029 15.8363 1.6875 13.5 1.6875C10.5435 1.6875 8.01563 2.77425 5.99063 4.79588L8.19113 6.99638C8.30079 7.10561 8.3783 7.2429 8.41516 7.39323C8.45202 7.54356 8.44682 7.70114 8.40013 7.84871C8.35343 7.99628 8.26705 8.12817 8.15042 8.22993C8.03379 8.3317 7.89141 8.39942 7.73888 8.42569L7.59375 8.4375H2.53125C2.33377 8.43757 2.14252 8.36836 1.99081 8.24194C1.8391 8.11551 1.73655 7.93988 1.701 7.74563L1.6875 7.59375V2.53125C1.68711 2.3765 1.72928 2.22462 1.8094 2.09223C1.88953 1.95984 2.00452 1.85203 2.1418 1.7806C2.27908 1.70917 2.43336 1.67688 2.58777 1.68724C2.74217 1.69761 2.89075 1.75024 3.01725 1.83938L3.12863 1.93388L4.79588 3.6045C7.12463 1.27406 10.0744 0 13.5 0ZM12.6563 7.59375C12.8537 7.59368 13.045 7.66289 13.1967 7.78931C13.3484 7.91574 13.451 8.09137 13.4865 8.28563L13.5 8.4375V14.1058L18.2453 17.9027C18.3997 18.0261 18.5059 18.1997 18.5454 18.3934C18.5849 18.5871 18.5551 18.7885 18.4613 18.9624L18.3769 19.089C18.2536 19.243 18.0802 19.349 17.8869 19.3884C17.6936 19.4279 17.4926 19.3984 17.3188 19.305L17.1923 19.2206L12.1298 15.1706C11.9708 15.044 11.863 14.8642 11.826 14.6644L11.8125 14.5125V8.4375C11.8125 8.21372 11.9014 7.99911 12.0596 7.84088C12.2179 7.68265 12.4325 7.59375 12.6563 7.59375Z" />
                                    </svg>
                                </span>
                                <span class="hide-menu">Riwayat Pengeringan</span>
                            </a>
                        </li>
                        {{-- <li class="sidebar-item">
                            <a class="sidebar-link" href="/data_sensor" aria-expanded="false">
                                <span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="w-5 h-5 text-gray-500 hover:text-blue-500 transition-colors duration-200">
                                        <rect x="4" y="4" width="16" height="16" rx="2" />
                                        <path d="M9 9h6v6H9z" />
                                        <path d="M3 9h2M3 15h2M19 9h2M19 15h2M9 3v2M15 3v2M9 19v2M15 19v2" />
                                    </svg>

                                </span>
                                <span class="hide-menu">Data Sensor</span>
                            </a>
                        </li> --}}
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                {{-- <i class="ti ti-bell-ringing"></i> --}}
                                {{-- <div class="notification bg-primary rounded-circle"></div> --}}
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            {{-- <a href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/"
                                target="_blank" class="btn btn-primary">Download Free</a> --}}
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="" width="35"
                                        height="35" class="rounded-circle">
                                </a> 
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-mail fs-6"></i>
                                            <p class="mb-0 fs-3">My Account</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-list-check fs-6"></i>
                                            <p class="mb-0 fs-3">My Task</p>
                                        </a>
                                        <a href="/logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>
