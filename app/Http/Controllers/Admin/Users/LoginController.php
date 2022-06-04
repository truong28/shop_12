<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.users.login',[
            'title' => 'Login Page'
        ]);
    }

    public function store(request $request)
    {
       
        $this->validate($request, [
            'email' => 'required|email:filter',
            'password' => 'required|min:4|max:10'
        ]);
      
        if (Auth::attempt([ 
            'email'=> $request->input('email'),
            'password'=> $request->input('password'),
            'level' => '1'
        ], $request->input('remember'))){
            return redirect()->route('admin');
        }

        Session::flash('error','Email or passwork are wrong!');
        return redirect()->back();
        
    }
}