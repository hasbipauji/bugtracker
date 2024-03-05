<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if( Auth::check() ) {
            return redirect('/dasbor');
        } else {
            return view('auth.login');
        }
    }

    public function process(Request $req)
    {
        $data = [
            'username' => $req->username,
            'password' => $req->password
        ];

        if( Auth::attempt($data) ) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function logout()
    {
        Auth::logout();
    }
}
