<?php

namespace App\Http\Controllers;

use App\Models\TRModul;
use App\Models\TRModulViewer;
use App\Models\TRTiketHistori;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TRModulViewerController extends Controller
{
    public function index($tr_modul_id)
    {
        $tr_modul_viewer = TRModulViewer::where('tr_modul_id', $tr_modul_id)->orderBy('id', 'DESC')->get();

        $res = [
            'data' => $tr_modul_viewer
        ];

        return response()->json($res);
    }

    public function store(Request $request)
    {
        try {
            // upload gambar
            $nama_gambar = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('gambar'), $nama_gambar);

            $tr_modul_id = $request->tr_modul_id;

            $tr_modul_viewer = new TRModulViewer();
            $tr_modul_viewer->tr_modul_id = $tr_modul_id;
            $tr_modul_viewer->gambar = 'gambar/'.$nama_gambar;
            $tr_modul_viewer->catatan = $request->catatan;
            $status = $tr_modul_viewer->save();
            
            if( $status )
            {
                $tr_modul = TRModul::find($tr_modul_id);
                $tr_modul->status = $request->status;
                $status = $tr_modul->save();

                $tr_tiket_histori = new TRTiketHistori();
                $tr_tiket_histori->tr_tiket_id = $tr_modul->tr_tiket_id;
                $tr_tiket_histori->keterangan = 'Menambah hasil pengujian modul '.$tr_modul->nama.' dengan status modul '.$request->status;
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
}
