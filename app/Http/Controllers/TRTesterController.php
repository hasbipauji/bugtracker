<?php

namespace App\Http\Controllers;

use App\Models\TRTester;
use App\Models\TRTiketHistori;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TRTesterController extends Controller
{
    public function index($tr_tiket_id)
    {
        $tr_tester = TRTester::where('tr_tiket_id', $tr_tiket_id)->get();

        $data = [];
        $i = 1;
        foreach ($tr_tester as $key => $value) {
            $data[] = $value;
            $data[$key]['nama'] = User::find($value->user_id)->name;
        }

        $kolom = array_column($data, 'nama');
        array_multisort($kolom, SORT_ASC, $data);

        $res = [
            'data' => $data
        ];

        return response()->json($res);
    }

    public function store(Request $request)
    {
        try 
        {
            $tr_tester = new TRTester();
            $tr_tester->tr_tiket_id = $request->tr_tiket_id;
            $tr_tester->user_id = $request->user_id;
            $status = $tr_tester->save();

            if( $status )
            {
                $user = User::find($request->user_id);

                $tr_tiket_histori = new TRTiketHistori();
                $tr_tiket_histori->tr_tiket_id = $request->tr_tiket_id;
                $tr_tiket_histori->keterangan = 'Menambah tester atas nama '.$user->name;
                $tr_tiket_histori->save();   
            }

            $res = [
                'status' => $status
            ];
        }
        catch (QueryException $qe)
        {
            $res = [
                'status' => false,
                'pesan' => $qe->errorInfo
            ];
        }

        return response()->json($res);
    }

    public function delete($id)
    {
        $tr_tester = TRTester::find($id);
        
        $user = User::find( $tr_tester->user_id );
        $tr_tiket_id = $tr_tester->tr_tiket_id;

        $status = $tr_tester->delete();

        if( $status )
        {
            $tr_tiket_histori = new TRTiketHistori();
            $tr_tiket_histori->tr_tiket_id = $tr_tiket_id;
            $tr_tiket_histori->keterangan = 'Menghapus tester atas nama '.$user->name;
            $tr_tiket_histori->save();   
        }
        
        $res = [
            'status' => $status
        ];

        return response()->json($res);
    }
}
