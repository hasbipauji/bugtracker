<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    public function index()
    {
        return view('pages.profil.index');
    }

    public function show($id)
    {
        $user = User::find($id);

        return response()->json(['data' => $user]);
    }

    public function edit()
    {
        $id = Auth::user()->id;

        $res = [
            'id' => $id
        ];

        return view('pages.profil.edit', $res);
    }

    public function update(Request $req, $id)
    {
        try {
            $validator = Validator::make($req->all(), [
                'name' => 'required|max:100',
                'username' => 'required|max:100',
                'email' => 'required|max:100',
            ]);

            if( $validator->fails() ) 
            {
                $res = [
                    'status' => false,
                    'message' => $validator->errors()
                ];
    
                return response()->json($res);
            } 
            else 
            {
                $user = User::find($id);
                $user->name = $req->name;
                $user->username = $req->username;
                $user->email = $req->email;
                $status = $user->save();
    
                $res = [
                    'status' => $status
                ];
    
                return response()->json($res);
            }

        } catch (QueryException $qe) {

            $res = [
                'status' => false,
                'message' => $qe->errorInfo
            ];

            return response()->json($res);

        }
    }

    public function changePassword(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'password' => 'required|min:3'
        ]);

        if( $validator->fails() ) 
        {
            $res = [
                'status' => false,
                'pesan' => $validator->errors()
            ];

            return response()->json($res);
        } 
        else 
        {
            $user = User::find( Auth::user()->id );
            $user->password = Hash::make($req->password);
            $status = $user->save();
    
            $res = ['status' => $status];
    
            return response()->json($res);
        }

    }
}
