<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return false|\Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'expiration_date' => 'required',
            'priority' => 'required',
        ]);
        $aData = $request->all();
        $aData['creator'] = auth()->user()->email;
        if (isset($request->responsible)) {
            $oUser = User::where('email', $request->responsible)->first();
            if(!isset($oUser->boss) || $oUser->boss !== auth()->user()->email) {
                $aData['responsible'] = null;
            }
        }
        $oNewTask = Task::create($aData);
        return json_encode($oNewTask);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param integer $id
     * @return false|\Illuminate\Http\Response|string
     */
    public function edit(int $id)
    {
        return json_encode(Task::find($id)->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $oTask = Task::find($id);
        if(auth()->user()->email !== $oTask->creator) {
            $oTask->update(['status' => $request->status]);
        } else {
            $oTask->update($request->all());
        }
        return (json_encode($oTask->toArray()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $category = Task::find($id);
        $category->delete();
    }
}
