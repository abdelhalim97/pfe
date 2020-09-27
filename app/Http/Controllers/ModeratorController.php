<?php

namespace App\Http\Controllers;
use App\Admin;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class ModeratorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:moderator');
    }
    //adding admin
    public function addAdmin(){

        return view('moderator.add-admin');
    }
    public function addNewAdmin(Request $request){
        //dd($request->all());
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




    public function display(){
        $admins = Admin::all();
        return view('moderator.display-admin')->with('admins',$admins);
    }


    public function showw($id){
        $admin = Admin::find($id);
        //$admin = Admin::find($id)->paginate(1);
        return view('moderator.show-admin')->with('admin',$admin);
    }
    //update admin
    public function updateForm($id){
        $admin = Admin::find($id);
        return view('moderator.edit-admin')->with('admin',$admin);
    }

    public function update(Request $request,$id){
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


    public function deleteAdmin($id){
        $admin = Admin::find($id);
            $admin->delete();
        return redirect(route('moderator.admin.display'))->with('success','Admin deleted');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('moderator');
    }
}
