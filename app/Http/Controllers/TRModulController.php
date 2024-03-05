<?php

namespace App\Http\Controllers;

use App\Models\TRFitur;
use App\Models\TRModul;
use App\Models\TRTiket;
use App\Models\TRTiketHistori;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TRModulController extends Controller
{
    public function data($tr_tiket_id)
    {
        $tr_modul = TRModul::where('tr_tiket_id', $tr_tiket_id)->get();

        $data = [];
        $i = 1;
        foreach ($tr_modul as $key => $value) {
            $data[] = $value;

            $data[$key]['fitur'] = TRFitur::where('tr_modul_id', $value->id)->orderBy('nama')->get();
        }

        $urutan = ['REVISI', 'TES', 'PROSES', 'MENUNGGU', 'SELESAI'];

        $data_urut = [];
        $i = 0;
        $l = 1;
        foreach ($urutan as $value1) 
        {
            foreach ($data as $value2)
            {
                if( $value1 == $value2->status ) 
                {
                    $data_urut[$i] = $value2;
                    $data_urut[$i]['no'] = $l++;

                    $i++;
                }
            }
        }

        $res = [
            'data' => $data_urut
        ];

        return response()->json($res);
    }

    public function show($id)
    {
        $tr_modul = TRModul::find($id);

        $res = ['data' => $tr_modul];

        return response()->json($res);
    }

    public function store(Request $request)
    {
        try 
        {
            $tr_tiket_id = $request->tr_tiket_id;
    
            $tr_modul = new TRModul();
            $tr_modul->tr_tiket_id = $tr_tiket_id;
            $tr_modul->nama = $request->nama;
            $tr_modul->lama_pengerjaan = $request->lama_pengerjaan;
            $status = $tr_modul->save();

            if( $status ) 
            {
                $tr_tiket_histori = new TRTiketHistori();
                $tr_tiket_histori->tr_tiket_id = $tr_tiket_id;
                $tr_tiket_histori->keterangan = 'Menambah modul '.$request->nama.' dengan lama pengerjaan '.$request->lama_pengerjaan.' hari';
                $tr_tiket_histori->save();   
            }

            $res = [
                'status' => $status
            ];

            return response()->json($res);
        }
        catch ( QueryException $qe )
        {
            $res = [
                'status' => false,
                'pesan' => $qe->errorInfo
            ];

            return response()->json($res);
        }        
    }

    public function update(Request $request, $id)
    {
        try 
        {
            $tr_modul = TRModul::find($id);
            $tr_modul->nama = $request->nama;
            $tr_modul->lama_pengerjaan = $request->lama_pengerjaan;

            if( $tr_modul->waktu_tutup != null )
            {
                $lama_pengerjaan = $request->lama_pengerjaan;
                $tr_modul->waktu_tutup = date_add(date_create($tr_modul->waktu_mulai), date_interval_create_from_date_string("$lama_pengerjaan days"));
            }

            $status = $tr_modul->save();

            if( $status )
            {
                $tr_tiket_histori = new TRTiketHistori();
                $tr_tiket_histori->tr_tiket_id = $tr_modul->tr_tiket_id;
                $tr_tiket_histori->keterangan = 'Merubah modul '.$request->nama.' dengan lama pengerjaan '.$request->lama_pengerjaan.' hari';
                $tr_tiket_histori->save();   
            }

            $res = [
                'status' => $status
            ];

            return response()->json($res);
        }
        catch ( QueryException $qe )
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
        $tr_modul = TRModul::find($id);
        $status = $tr_modul->delete();

        if( $status ) 
        {
            $tr_tiket_histori = new TRTiketHistori();
            $tr_tiket_histori->tr_tiket_id = $tr_modul->tr_tiket_id;
            $tr_tiket_histori->keterangan = 'Menghapus modul '.$tr_modul->nama;
            $tr_tiket_histori->save();   
        }

        $res = [
            'status' => $status
        ];

        return response()->json($res);
    }

    public function openAccess($id)
    {
        $tr_modul = TRModul::find($id);
        $tr_modul->status = 'PROSES';
        $tr_modul->waktu_mulai = date_create('now');

        $lama_pengerjaan = strval( $tr_modul->lama_pengerjaan );
        
        $tr_modul->waktu_tutup = date_add(date_create('now'), date_interval_create_from_date_string("$lama_pengerjaan days"));
        $status = $tr_modul->save();

        if( $status ) 
        {
            $tr_tiket = TRTiket::find( $tr_modul->tr_tiket_id);
            $tr_tiket->status = 'PROSES';
            $tr_tiket->save();

            $tr_tiket_histori = new TRTiketHistori();
            $tr_tiket_histori->tr_tiket_id = $tr_modul->tr_tiket_id;
            $tr_tiket_histori->keterangan = 'Membuka akses modul '.$tr_modul->nama;
            $tr_tiket_histori->save();   
        }

        $res = [
            'status' => $status
        ];

        return response()->json($res);
    }

    public function endAccess($id)
    {
        $tr_modul = TRModul::find($id);
        $tr_modul->status = 'SELESAI';
        $status = $tr_modul->save();

        if( $status )
        {
            $tr_tiket_histori = new TRTiketHistori();
            $tr_tiket_histori->tr_tiket_id = $tr_modul->tr_tiket_id;
            $tr_tiket_histori->keterangan = 'Menutup akses modul '.$tr_modul->nama;
            $tr_tiket_histori->save();   
        }

        $res = [
            'status' => $status
        ];

        return response()->json($res);
    }

    public function serahkan($id)
    {
        $tr_modul = TRModul::find($id);
        $tr_modul->status = 'TES';
        $status = $tr_modul->save();

        if( $status )
        {
            $tr_tiket_histori = new TRTiketHistori();
            $tr_tiket_histori->tr_tiket_id = $tr_modul->tr_tiket_id;
            $tr_tiket_histori->keterangan = 'Menyerahkan hasil pengerjaan modul '.$tr_modul->nama;
            $tr_tiket_histori->save();
        }

        $res = [
            'status' => $status
        ];

        return response()->json($res);
    }

}
