<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\stok_masuk;

class StokMasukController extends Controller
{
    public function index(){

        // $matchThese = ['' => '0','stok_masuk.status_hapus'=>0];
        $matchThese=["stok_masuks.status_hapus"=>0];
        $masuk = DB::table('data_bahans')
        ->join('stok_masuks','data_bahans.id_bahan','stok_masuks.id_bahan')
        ->where($matchThese)
        ->get();
        
        if(count($masuk)){
            return response([
                'message' => 'Berhasil tampil data bahan !',
                'data' => $masuk
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    // public function indexMakanan(){
    //     $matchThese = ['data_bahans.tipe_bahan' => 'Makanan','stok_masuks.status_hapus'=>0,'data_bahans.status_hapus'=>0];
    //     $masuk = DB::table('data_bahans')
    //     ->join('stok_masuks','data_bahans.id_bahan','stok_masuks.id_bahan')
    //     ->where($matchThese)
    //     ->get();
        
    //     if(count($masuk)){
    //         return response([
    //             'message' => 'Berhasil tampil data bahan !',
    //             'data' => $masuk
    //         ]);
    //     }

    //     return response([
    //         'message' => 'Empty',
    //         'data' => null
    //     ]);
    // }

    // public function indexSide(){
    //     $matchThese = ['data_bahans.tipe_bahan' => 'Side Dish','stok_masuks.status_hapus'=>0,'data_bahans.status_hapus'=>0];
    //     $masuk = DB::table('data_bahans')
    //     ->join('stok_masuks','data_bahans.id_bahan','stok_masuks.id_bahan')
    //     ->where($matchThese)
    //     ->get();
        
    //     if(count($masuk)){
    //         return response([
    //             'message' => 'Berhasil tampil data bahan !',
    //             'data' => $masuk
    //         ]);
    //     }

    //     return response([
    //         'message' => 'Empty',
    //         'data' => null
    //     ]);
    // }

    // public function indexMinuman(){
    //     $matchThese = ['data_bahans.tipe_bahan' => 'Minuman','stok_masuks.status_hapus'=>0,'data_bahans.status_hapus'=>0];
    //     $masuk = DB::table('data_bahans')
    //     ->join('stok_masuks','data_bahans.id_bahan','stok_masuks.id_bahan')
    //     ->where($matchThese)
    //     ->get();
        
    //     if(count($masuk)){
    //         return response([
    //             'message' => 'Berhasil tampil data bahan !',
    //             'data' => $masuk
    //         ]);
    //     }

    //     return response([
    //         'message' => 'Empty',
    //         'data' => null
    //     ]);
    // }

    public function update(Request $request, $id){
        $masuk = stok_masuk::where('id_stok_masuk','=', $id)->first();
        if(is_null($masuk)){
            return response([
                'message' => 'Data stok masuk tidak ditemukan !',
                'data' => $null
            ]);
        }

        //cek no meja unik
        $updateData = $request->all();
        $masuk->id_bahan = $updateData['id_bahan'];
        $masuk->jumlah_stok_masuk = $updateData['jumlah_stok_masuk'];
        $masuk->harga_stok_masuk = $updateData['harga_stok_masuk'];
        $masuk->tanggal_masuk = $updateData['tanggal_masuk'];

        if($masuk->save()){
            return response([
            'message' => 'Berhasil Update data stok masuk !',
            'data' => $masuk,
            ]);
        } 
        
        return response([
            'message' => 'Gagal Update data stok masuk!',
            'data' => null,
        ]);
    }

    public function store(Request $request){
    
        $masuk = new stok_masuk;

        $masuk->id_bahan = $request->id_bahan;
        $masuk->jumlah_stok_masuk = $request->jumlah_stok_masuk;
        $masuk->harga_stok_masuk = $request->harga_stok_masuk;
        $masuk->tanggal_masuk = $request->tanggal_masuk;
        
        if($masuk->save()){
            return response([
                'message' => 'Berhasil menambah stok masuk !',
                'data' => $masuk,
            ]);
       }else{
            return response([
                'message' => 'Gagal menambah stok masuk !',
                'data' => null,
            ]);
       }
    }

    public function destroySoft($id){
        $masuk = stok_masuk::where('id_stok_masuk','=', $id)->first();

        if(is_null($masuk)){
            return response([
                'message' => 'Data stok masuk tidak ditemukan !',
                'data' => $null
            ]);
        }

        $masuk->status_hapus = 1;
        if($masuk->save()){
            return response([
            'message' => 'Berhasil menghapus data stok masuk !',
            'data' => $masuk,
            ]);
        } 
        
        return response([
            'message' => 'Gagal menghapus data stok masuk !',
            'data' => null,
        ]);
    }
}

