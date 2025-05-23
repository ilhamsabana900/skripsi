<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>
    Material Dashboard 3 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  {{-- <link rel="stylesheet" href="{{ asset('assets/css/nucleo-icons.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/nucleo-svg.css') }}" /> --}}
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
        <img src="#" class="navbar-brand-img" width="26" height="26" >
        <span class="ms-1 text-sm text-dark">PRODISTIK MAN 1 PASURUAN</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('dashboard') }}">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('siswa.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('siswa.index') }}">
            <i class="material-symbols-rounded opacity-5">table_view</i>
            <span class="nav-link-text ms-1">Data siswa</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('guru.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('guru.index') }}">
            <i class="material-symbols-rounded opacity-5">table_view</i>
            <span class="nav-link-text ms-1">Data guru</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('kelas.*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('kelas.index') }}">
            <i class="material-symbols-rounded opacity-5">groups</i>
            <span class="nav-link-text ms-1">Data Kelas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ (request()->routeIs('nilai.massal')) ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('nilai.massal') }}">
            <i class="material-symbols-rounded opacity-5">playlist_add_check_circle</i>
            <span class="nav-link-text ms-1">Input Nilai Massal</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ (request()->routeIs('nilai.index') || request()->routeIs('nilai.create') || request()->routeIs('nilai.edit') || request()->routeIs('nilai.show') || request()->routeIs('nilai.rekap')) ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('nilai.index') }}">
            <i class="material-symbols-rounded opacity-5">grading</i>
            <span class="nav-link-text ms-1">Nilai</span>
          </a>
        </li>        
      </ul>
    </div>
    
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
          </ol>
        </nav>
        
            <li class="nav-item d-flex align-items-center">
                @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link text-body font-weight-bold px-0 bg-transparent border-0">
                        <i class="material-symbols-rounded">logout</i> Logout
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="nav-link text-body font-weight-bold px-0">
                    <i class="material-symbols-rounded">account_circle</i> Login
                </a>
                @endauth
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    @yield('content')
  </main>

</body>

</html>