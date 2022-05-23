<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'surname', 'patronymic', 'boss',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Регистранция пользователя
     *
     * @param object $request - Массив из формы регистрации
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function createUser(object $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'patronymic' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);
        $aUserData = [
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];
        if (isset($request->boss)) {
            $oBoss = User::where('email', $request->boss)->select('email')->first();
            if ($oBoss != null) {
                $aUserData['boss'] = $oBoss->email;
            } else {
                return redirect()->back()->with('error', 'Вы ввели неверного руководителя')->send();
            }
        }
        return User::create($aUserData);
    }
}
