<?php

namespace App\Http\Controllers;

use App\Models\TRModul;
use App\Models\TRProgrammer;
use App\Models\TRTester;
use App\Models\TRTiket;
use App\Models\TRTiketHistori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Validator;
use PharIo\Manifest\Author;

class TRTiketController extends Controller
{
    public function index()
    {
        
        $tiketuser = $this->gettiketuser();
        if( Auth::user()->access == 'ADMIN' || Auth::user()->access == 'PROJECT_MANAGER' )
        {
            return view('pages.tiket.index');
        } 
        else if( Auth::user()->access == 'PROGRAMMER' )
        {

            
            return view('pages.tiket.programmer', compact( 'tiketuser'));
            
        }
        else if( Auth::user()->access == 'TESTER' )
        {
            return view('pages.tiket.tester', compact( 'tiketuser'));
        }
    }

    public function data()
    {
        $daftar_urutan = ['PROSES', 'MENUNGGU', 'SELESAI'];
        $daftar_tr_tiket = TRTiket::orderBy('id', 'DESC')->get();
        
        $data = [];
        $i = 0;
        $l = 1;
        foreach ($daftar_urutan as $value1) 
        {
            foreach ($daftar_tr_tiket as $key => $value2) {
                if( Auth::user()->access == 'ADMIN' || Auth::user()->access == 'PROJECT_MANAGER' )
                {
                    if( $value1 == $value2->status )
                    {
                        $data[$i] = $value2;
                        $data[$i]['no'] = $l++;
                        $i++;
                    }
                }
                else if( Auth::user()->access == 'PROGRAMMER' )
                {
                    if( TRProgrammer::where(['user_id' => Auth::user()->id, 'tr_tiket_id' => $value2->id ])->count() > 0 )
                    {
                        if( $value1 == $value2->status )
                        {
                            $data[$i] = $value2;
                            $data[$i]['no'] = $l++;
                            $i++;
                        }
                    }
                }
                else if( Auth::user()->access == 'TESTER' )
                {
                    if( TRTester::where(['user_id' => Auth::user()->id, 'tr_tiket_id' => $value2->id ])->count() > 0 )
                    {
                        if( $value1 == $value2->status )
                        {
                            $data[$i] = $value2;
                            $data[$i]['no'] = $l++;
                            $i++;
                        }
                    }
                }
            }
        }

        $res = [
            'data' => $data
        ];

        return response()->json($res);
    }

    public function show($id)
    {
        $res = [
            'id' => $id
        ];

        return view('pages.tiket.detail', $res);
    }

    public function detail($id)
    {
        $tr_tiket = TRTiket::find($id);

        $data = $tr_tiket;
        $data['url_pengembangan'] = $tr_tiket->url_pengembangan == '-' ? '#' : $tr_tiket->url_pengembangan;
        $data['programmer'] = TRProgrammer::where('tr_tiket_id', $id)->count(); 
        $data['tester'] = TRTester::where('tr_tiket_id', $id)->count(); 

        $tr_modul = TRModul::where(['tr_tiket_id' => $id])->get();

        $modul_status = [];
        foreach ($tr_modul as $key => $value) {
            $modul_status[] = $value->status;
        }

        if( count( $modul_status ) > 0 )
        {
            $data['modul_status'] = in_array('REVISI', $modul_status) ? 'REVISI' : in_array('MENUNGGU', $modul_status) ? 'MENUNGGU' : in_array('PROSES', $modul_status) ? 'PROSES' : 'SELESAI';
        }
        else
        {
            $data['modul_status'] = 'MENUNGGU';
        }

        $res = [
            'data' => $data
        ];

        return response()->json($res);
    }

    public function store(Request $request)
    {
        // VALIDASI REQUEST DARI USER
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
            'dokumen' => 'required|mimes:pdf'
        ]);

        if(! $validator->fails() )
        {
            // UPLOAD DOKUMEN
            $nama_dokumen = time().'.'.$request->dokumen->extension();
            $request->dokumen->move(public_path('dokumen'), $nama_dokumen);

            // SAVE
            $tr_tiket = new TRTiket();
            $tr_tiket->nama = $request->nama;
            $tr_tiket->deskripsi = $request->deskripsi;
            $tr_tiket->dokumen = 'dokumen/'.$nama_dokumen;
            $status = $tr_tiket->save();

            $res = ['status' => $status];
        } 
        else
        {
            $res = ['status' => false, 'pesan' => $validator->errors() ];
        } 

        return response()->json($res);
    }

    public function delete($id)
    {
        $status = TRTiket::find($id)->delete();

        $res = [
            'status' => $status
        ];

        return response()->json($res);
    }

    public function do($id)
    {
        $res = [
            'id' => $id
        ];

        return view('pages.tiket.do', $res);
    }

    public function url_pengembangan(Request $request)
    {
        $tr_tiket = TRTiket::find($request->tr_tiket_id);
        $tr_tiket->url_pengembangan = $request->url_pengembangan;
        $status = $tr_tiket->save();

        if( $status )
        {
            $tr_tiket_histori = new TRTiketHistori();
            $tr_tiket_histori->tr_tiket_id = $request->tr_tiket_id;
            $tr_tiket_histori->keterangan = 'Merubah url pengembangan menjadi '.$request->url_pengembangan;
            $tr_tiket_histori->save();   
        }

        $res = [
            'status' => $status
        ];

        return response()->json($res);
    }

    public function serahkan(Request $request)
    {
        $tr_tiket = TRTiket::find($request->tr_tiket_id);
        $tr_tiket->status = 'PROSES';
        $status = $tr_tiket->save();

        $res = [
            'status' => $status
        ];

        return response()->json($res);
    }

    public function check($id)
    {
        $res = [
            'id' => $id
        ];

        return view('pages.tiket.check', $res);
    }

    public function end(Request $request)
    {
        $tr_tiket_id = $request->tr_tiket_id;

        $tr_tiket = TRTiket::find( $tr_tiket_id );
        $tr_tiket->status = 'SELESAI';
        $status = $tr_tiket->save();

        $res = [
            'status' => $status
        ];

        return response()->json($res);
    }
}
