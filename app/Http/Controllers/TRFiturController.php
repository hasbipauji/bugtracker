<?php

namespace App\Http\Controllers;

use App\Models\TRFitur;
use App\Models\TRModul;
use App\Models\TRTiketHistori;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TRFiturController extends Controller
{
    public function index($id_modul)
    {
        $data = TRFitur::where('tr_modul_id', $id_modul)->orderBy('nama')->get();

        $res = [
            'data' => $data
        ];

        return response()->json($res);
    }

    public function store(Request $request)
    {
        try 
        {
            $tr_fitur = new TRFitur();
            $tr_fitur->tr_modul_id = $request->tr_modul_id;
            $tr_fitur->nama = $request->nama;
            $status = $tr_fitur->save();

            if( $status )
            {
                $tr_modul = TRModul::find( $request->tr_modul_id );
                $tr_tiket_id = $tr_modul->tr_tiket_id;

                $tr_tiket_histori = new TRTiketHistori();
                $tr_tiket_histori->tr_tiket_id = $tr_tiket_id;
                $tr_tiket_histori->keterangan = 'Menambah fitur '.$request->nama.' pada modul '.$tr_modul->nama;
                $tr_tiket_histori->save();   
            }

            $res = [
                'status' => $status
            ];

            return response()->json($res);
        }
        catch (QueryException $qe)
        {
            $res = [
                'status' => false,
                'pesan' => $qe->errorInfo
            ];

            return response()->json($res);
        }
    }

    public function delete($id)
    {
        $tr_fitur = TRFitur::find($id); 

        $tr_modul_id = $tr_fitur->tr_modul_id;

        $status = $tr_fitur->delete();

        if( $status )
        {
            $tr_modul = TRModul::find( $tr_modul_id );
            $tr_tiket_id = $tr_modul->tr_tiket_id;

            $tr_tiket_histori = new TRTiketHistori();
            $tr_tiket_histori->tr_tiket_id = $tr_tiket_id;
            $tr_tiket_histori->keterangan = 'Menghapus fitur '.$tr_fitur->nama.' pada modul '.$tr_modul->nama;
            $tr_tiket_histori->save();   
        }

        $res = ['status' => $status];

        return response()->json($res);
    }

    public function hasil(Request $request)
    {
        $tr_fitur_id =  $request->tr_fitur_id;
        $status = $request->status;

        foreach ($tr_fitur_id as $key => $id) {
            $tr_fitur = TRFitur::find($id);
            $tr_fitur->status = $status[$key];
            $tr_fitur->save();
        }

        $tr_modul_id =  $request->tr_modul_id;
        $tr_modul = TRModul::find( $tr_modul_id );
        $tr_modul->status = in_array('REVISI', $status) ? 'REVISI' : 'STATUS';
        $status = $tr_modul->save();

        $res = [
            'status' => $status
        ];

        return response()->json($res);
    }
}
