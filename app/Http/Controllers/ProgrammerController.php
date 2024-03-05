<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProgrammerController extends Controller
{
    public function index()
    {
        return view('pages.programmer.index');
    }

    public function data()
    {
        $daftar_user = User::where('access', 'PROGRAMMER')->orderBy('name')->get();

        $data = [];
        $i = 1;
        foreach ($daftar_user as $key => $value) :
            $data[$key] = $value;
            $data[$key]['no'] = $i++;
        endforeach;

        $response = ['data' => $data];

        return response()->json($response);
    }

    public function show($id)
    {
        $user = User::find($id);

        $response = [
            'data' => $user
        ];

        return response()->json($response);
    }

    public function store(Request $request)
    {
        try 
        {
            $user = $request->id == '-' ? new User() : User::find($request->id);
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            
            if( $request->password != '-' ) {
                $user->password = Hash::make($request->password);
            }
            
            $user->access = 'PROGRAMMER';
            $status = $user->save();

            $response = [
                'status' => $status
            ];

            return response()->json($response);

        } 
        catch (QueryException $qe) 
        {
            $request = [
                'status' => false,
                'pesan' => $qe->errorInfo
            ];

            return response()->json($request);
        }
    }

    public function delete($id)
    {
        if( $id != Auth::user()->id )
        {
            $status = User::find($id)->delete();
    
            $response = [
                'status' => $status
            ];
        }
        else 
        {
            $response = [
                'status' => false
            ];
        }

        return response()->json($response);
    }
}
