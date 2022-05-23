<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Страница формы регистрации
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('user.create');
    }


    /**
     * Регистрация пользователя
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = User::createUser($request);
        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Регистрация пройдена, добро пожаловать');
    }


    /**
     * Страница формы авторизации
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function loginForm()
    {
        return view('user.login');
    }


    /**
     * Авторизация
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return redirect()->route('dashboard')->with('success', 'Добро пожаловать');
        }
        return redirect()->back()->with('error', 'Вы ввели некорректные данные');
    }


    /**
     * Выйти из аккаунта
     *
     * @return mixed
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.create');
    }
}
