<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class UserManage extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function status(Request $request,$id){
        $data=User::find($id);
        if($data->status == 0){
            $data->status=1;
        }
        else{
            $data->status=0;
        }
        $data->save();
        return redirect(route('admin.dashboard'))->with('message',$data->name . 'status has been changed sucessfully');
    }

}


