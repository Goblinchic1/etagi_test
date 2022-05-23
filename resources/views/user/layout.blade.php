<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">
</head>
<body class="hold-transition welcome">
<div class="wrapper">
    <header class="login-header shadow">
        <nav class="navbar navbar-expand-lg navbar-light bg-white rounded fixed-top rounded-0 shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo LeadPartner" width="200px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent1">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item @if(route('register.create') == url()->full()) active @endif">
                            <a class="nav-link" href="{{ route('register.create') }}">
                                <i class="bi bi-building"></i>
                                Регистрация
                            </a>
                        </li>
                        <li class="nav-item @if(route('login.create') == url()->full()) active @endif">
                            <a class="nav-link" href="{{ route('login.create') }}">
                                <i class="bi bi-box-arrow-in-right"></i>
                                Авторизация
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-4">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <div class="card mt-1">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
