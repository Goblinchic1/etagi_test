<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">
    <title>Etagi test</title>
</head>
<body class="main-body">
<nav class="navbar navbar-expand-lg navbar-dark bg-white fixed-top">
    <div class="container-fluid">
        <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#sidebar"
                aria-controls="offcanvasExample"
        >
            <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>
        <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold"
           href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="max-width: 200px; height: 40px">
        </a>
        <a class="d-flex p-2" href="{{ route('logout') }}">Выйти</a>
    </div>
</nav>
<div class="offcanvas offcanvas-start sidebar-nav bg-white mt-4" tabindex="-1" id="sidebar">
    <div class="offcanvas-body p-0">
        <nav class="navbar-dark">
            <ul class="navbar-nav">
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="nav-link px-3 @if(route('dashboard') == url()->full()) active @endif">
                        <span class="me-2"><i class="bi bi-house-door"></i></span>
                        <span>Список задач</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<main class="">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
        @yield('content')
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>

