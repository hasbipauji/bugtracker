<?php

namespace App\Http\Controllers;

use App\Models\TRProgrammer;
use App\Models\TRTester;
use App\Models\TRTiket;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function gettiketuser(){
        $daftar_tr_tiket = TRTiket::orderBy('id', 'DESC')->get();
        $daftar_tr_programmer = TRProgrammer::orderBy('id', 'DESC')->get();
        $daftar_tr_tester = TRTester::orderBy('id', 'DESC')->get();
        
        $tiket_auth_programmer = $daftar_tr_programmer->where('user_id', Auth::user()->id);
        $tiket_auth_tester = $daftar_tr_tester->where('user_id', Auth::user()->id);
        $tiketuser = [];
        foreach ($tiket_auth_programmer as $key => $value) {
            $tiketuser[$key] = $daftar_tr_tiket->where('id', $value->tr_tiket_id)->first();
        }

        foreach ($tiket_auth_tester as $key => $value) {
            $tiketuser[$key] = $daftar_tr_tiket->where('id', $value->tr_tiket_id)->first();
        }
        $tiketuser = collect($tiketuser)->where('status', '!=', 'SELESAI');
        return $tiketuser;
    }
}
