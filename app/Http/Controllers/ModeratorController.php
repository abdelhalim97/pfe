<?php

namespace App\Http\Controllers;
use App\Admin;
use Illuminate\Http\Request;
use App\Moderator;
use App\Http\Resources\Moderator as ModeratorResource;
class ModeratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:moderator');
    }
    public function index()
    {
        $admins = Admin::all();
        return view('moderator.display-admin')->with('admins',$admins);
        //return ModeratorResource::collection($admins);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('moderator.add-admin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        $admin = Admin::find($id);
        return view('moderator.show-admin')->with('admin',$admin);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::find($id);
        return view('moderator.edit-admin')->with('admin',$admin);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)//
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
            'password'=>'required'
            ]);
            $admin = Admin::find($id);
            $admin->name = $request->get('name');
            $admin->email = $request->get('email');
            $admin->save();
            return redirect(route('moderator.admin.display'))->with('succes','admin updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::find($id);
            $admin->delete();
        return redirect(route('moderator.admin.display'))->with('success','Admin deleted');
    }
}
