<?php

namespace App\Http\Controllers;

use App\Models\TRModul;
use App\Models\TRProgrammer;
use App\Models\TRTester;
use App\Models\TRTiket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DasborController extends Controller
{
    public function index()
    {
        $res['jumlah_programmer'] = User::where('access', 'PROGRAMMER')->count();
        $res['jumlah_tester'] = User::where('access', 'TESTER')->count();
        $res['jumlah_tiket_belum_selesai'] = TRTiket::where('status', '!=', 'SELESAI')->count();
        $res['jumlah_tiket_selesai'] = TRTiket::where('status', '=', 'SELESAI')->count();

        if( Auth::user()->access == 'ADMIN' || Auth::user()->access == 'PROJECT_MANAGER' )
        {
            return view('pages.dasbor.index', $res);
        }
        else if( Auth::user()->access == 'PROGRAMMER' )
        {
            return view('pages.dasbor.programmer', $res);
        }
        else if( Auth::user()->access == 'TESTER' )
        {
            return view('pages.dasbor.tester', $res);
        }
    }

    public function pengingat()
    {
        $user = Auth::user();
        $tr_modul = TRModul::where('status', 'PROSES')->orWhere('status', 'TES')->orWhere('status', 'REVISI')->get();

        $data = [];
        $i = 0;
        foreach ($tr_modul as $key => $value) {
            if( $user->access == 'ADMIN' || $user->access == 'PROJECT_MANAGER' )
            {
                $data[$key] = $value;
                $data[$key]['nama_tiket'] = TRTiket::find($value->tr_tiket_id)->nama;
    
                $sisa = date_diff(date_create($value->waktu_tutup), date_create('now'));
                $data[$key]['sisa_hari'] = $sisa->d.' Hari '.$sisa->h.' Jam';
                $data[$key]['sisa_level'] = $sisa->d;
            }
            else if( $user->access == 'PROGRAMMER' )
            {
                if( TRProgrammer::where(['user_id' => $user->id, 'tr_tiket_id' => $value->tr_tiket_id])->count() > 0 )
                {
                    $data[$i] = $value;
                    $data[$i]['nama_tiket'] = TRTiket::find($value->tr_tiket_id)->nama;
    
                    $sisa = date_diff(date_create($value->waktu_tutup), date_create('now'));
                    $data[$i]['sisa_hari'] = $sisa->d.' Hari '.$sisa->h.' Jam';
                    $data[$i]['sisa_level'] = $sisa->d;

                    $i++;
                }
            }
            else if( $user->access == 'TESTER')
            {
                if( TRTester::where(['user_id' => $user->id, 'tr_tiket_id' => $value->tr_tiket_id])->count() > 0 )
                {
                    $data[$i] = $value;
                    $data[$i]['nama_tiket'] = TRTiket::find($value->tr_tiket_id)->nama;
    
                    $sisa = date_diff(date_create($value->waktu_tutup), date_create('now'));
                    $data[$i]['sisa_hari'] = $sisa->d.' Hari '.$sisa->h.' Jam';
                    $data[$i]['sisa_level'] = $sisa->d;

                    $i++;
                }
            }
        }

        $res = [
            'data' => $data
        ];

        return response()->json($res);
    }
}
