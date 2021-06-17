<?php

namespace App\Http\Controllers\API;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;

class ModeratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:moderator-api');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::all();
        return Admin::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'email' => 'required|string|email|unique:admins',
            'password' => 'required|string|min:6'
        ]);
        return Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        $admin = Admin::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|string',
            'email' => 'required|string|email|unique:admins,email,' .$admin->id,
            'password' => 'sometimes|string|min:6'
        ]);
        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }
        $admin->update($request->all());
        return(['msg'=>'succes']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
    }
    public function search(){
        if ($search = \Request::get('q')) {
            $admins = Admin::where(function($query) use ($search){
                $query->orWhere('name','LIKE',"%$search%")
                        ->orWhere('id','LIKE',"%$search%")
                        ->orWhere('created_at','LIKE',"%$search%")
                        ->orWhere('updated_at','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%");
            })->paginate(1000);
        }else{
            $admins = Admin::latest()->paginate(10);
        }
        return $admins;
    }
}
