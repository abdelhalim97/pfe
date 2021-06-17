<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModeratorController2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()//display
    {
        $admins = Admin::all();
        return view('moderator.display-admin')->with('admins',$admins);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)//addNewAdmin
    {
        $data = request()->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:8'

        ]);
        $admin = new Admin();
        $admin->name = request('name');
        $admin->email = request('email');
        $admin->password = Hash::make(Input::get('password'));
        $admin->save();
        return redirect(route('moderator.admin.display'))->with('success','Admin created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
