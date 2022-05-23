@extends('user.layout')
@section('title', 'Авторизация')
@section('content')
    <div class="text-center">
        <h3 class="">Авторизация</h3>
        <p>Вы не зарегистрированы? <a href="{{ route('register.create') }}">Зарегистрируйтесь здесь</a>
        </p>
    </div>
    <div class="login-separater text-center mb-4"> <span>ИЛИ ВОЙДИТЕ</span>
        <hr>
    </div>
    <div class="form-body">
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
        <form class="row g-3" action="{{ route('login') }}" method="post">
            @csrf
            @method('post')
            <div class="col-12">
                <label for="inputEmailAddress" class="form-label">Email<span class="text-danger">*</span></label>
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="Email"
                       name="email"
                       id="inputEmailAddress"
                       value="{{ old('email') }}"
                       required
                >
            </div>
            <div class="col-12">
                <label for="inputChoosePassword" class="form-label">Пароль<span class="text-danger">*</span></label>
                <div class="input-group" id="show_hide_password">
                    <input type="password"
                           id="inputChoosePassword"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password"
                           placeholder="Пароль"
                           required
                           value="{{ old('password') }}"
                    >
                    <a href="javascript:;" id="eye-password" class="input-group-text bg-transparent">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-12">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                        Войти
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
