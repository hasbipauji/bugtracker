<?php

namespace App\Http\Controllers;

use App\Models\TRTiketHistori;
use Illuminate\Http\Request;

class TRTiketHistoriController extends Controller
{
    public function index($tr_tiket_id)
    {
        $tr_tiket_histori = TRTiketHistori::where('tr_tiket_id', $tr_tiket_id)->orderBy('id', 'DESC')->get();

        $data = [];
        foreach ($tr_tiket_histori as $key => $value):
            $data[$key] = $value;
            $data[$key]['waktu'] = date('Y-m-d H:i:s', strtotime($value->created_at)); 
        endforeach;

        $res = [
            'data' => $data
        ];

        return response()->json($res);
    }
}
