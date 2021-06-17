<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class ModeratorLoginController extends Controller
{
    public function __construct () {
        $this->middleware('guest:moderator-api');//auth:api-moderator
    }
    public function showLoginForm () {
        return view('auth.moderator-login');
    }
    public function login(Request $request){
        //validate the form data
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
          ]);
        //attemp to log user in
        if (Auth::guard('moderator')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            //it returns true or flase
        //attempt hash the pass automatically
        //in succeful,then redirect to their intended location
        return redirect()->intended(route('moderator.dashboard'));
    }
    return redirect()->back()->withInput($request->only('email', 'remember'));

        //in succeful, then redirect back to the login with the form data
    }
}
