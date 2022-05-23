<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    /**
     * Главная страница
     *
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string|void
     */
    public function index(Request $request)
    {
        if ($request->filled('sort')) {
            return $this->filter($request);
        }
        $oResponsible = User::where('boss', auth()->user()->email)->select(['id', 'email'])->get();
        $oTasks = Task::where('creator', auth()->user()->email)->orWhere('responsible', auth()->user()->email)->get();
        return view('main.index', compact('oResponsible', 'oTasks'));
    }


    /**
     * Фильтры для задач
     *
     * @return void
     */
    public function filter($request)
    {
        if ($request->sort_name === 'expiration_date') {
            if ($request->sort === 'today') {
                $oTasks = DB::table('tasks')->
                whereDate($request->sort_name, '=', Carbon::today()->toDateString())->
                where('creator', auth()->user()->email)->
                orWhere('responsible', auth()->user()->email)->get();
            } elseif ($request->sort === 'week') {
                $oTasks = DB::table('tasks')->
                whereBetween($request->sort_name, [Carbon::today()->toDateString(), Carbon::today()->addWeek()->toDateString()])->
                where('creator', auth()->user()->email)->
                orWhere('responsible', auth()->user()->email)->get();
            } else {
                $oTasks = DB::table('tasks')->
                whereDate($request->sort_name, '>', Carbon::today()->addWeek()->toDateString())->
                where('creator', auth()->user()->email)->
                orWhere('responsible', auth()->user()->email)->get();
            }
        } elseif($request->sort_name === 'responsible') {
            $oTasks = DB::table('tasks')->
            where($request->sort_name, $request->sort)->get();
        } elseif($request->sort_name === 'date_sort') {
            $oTasks = Task::where('creator', auth()->user()->email)->orWhere('responsible', auth()->user()->email)->orderBy('updated_at', 'DESC')->get();
        }
        return view('components.task-list', compact('oTasks'));
    }
}
