<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\transaksi;
use App\pesanan;


class TransaksiController extends Controller
{
    public function index(){
        $matchThese = ['transaksis.status_hapus' => 0];

        $transaksi = DB::table('transaksis')        
        ->join('reservasis','transaksis.id_reservasi','reservasis.id_reservasi')
        ->join('customers','customers.id_customer','reservasis.id_customer')
        ->join('mejas','mejas.id_meja','reservasis.id_meja')
        ->where($matchThese)
        ->get();
        

        if(count($transaksi)){
            
            return response([
                'message' => 'Berhasil tampil data transaksi !',
                'data' => $transaksi
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    public function store(Request $request){
        $transaksi = new transaksi;

        $transaksi->id_data_kartu = $request->id_data_kartu;
        $transaksi->id_karyawan = $request->id_karyawan;
        $transaksi->id_reservasi = $request->id_reservasi;
        $transaksi->total_harga = $request->total_harga;
        $transaksi->tanggal_pembayaran = $request->tanggal_pembayaran;
        $transaksi->waktu_pembayaran = $request->waktu_pembayaran;
        $transaksi->metode_pembayaran = $request->metode_pembayaran;
        $id = 'AKB-'.time();
        $transaksi->id_transaksi = $id;

        $pesanan = pesanan::where("id_reservasi",'=',$request->id_reservasi)->get();
        foreach($pesanan as $pes){
            $pes->status_selesai = 1;
            $pes->status_bayar = 1;
            $pes->save();
        }

        if($transaksi->save()){
            return response([
                'message' => 'Berhasil menambah data transaksi !',
                'data' => $transaksi,
                'pesana'=> $pesanan,
            ]);
       }else{
            return response([
                'message' => 'Gagal menambah data transaksi !',
                'data' => null,
            ]);
       }
    }

}
