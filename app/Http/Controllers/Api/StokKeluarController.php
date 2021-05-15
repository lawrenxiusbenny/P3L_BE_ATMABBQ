<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\stok_keluar;

class StokKeluarController extends Controller
{
    public function index(){
        $matchThese=["stok_keluars.status_hapus"=>0];
        $keluar = DB::table('data_bahans')
        ->join('stok_keluars','data_bahans.id_bahan','stok_keluars.id_bahan')
        ->where($matchThese)
        ->get();
        
        if(count($keluar)){
            return response([
                'message' => 'Berhasil tampil data bahan !',
                'data' => $keluar
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    // public function indexMakanan(){
    //     $matchThese = ['data_bahans.tipe_bahan' => 'Makanan','stok_keluars.status_hapus'=>0,'data_bahans.status_hapus'=>0];
    //     $keluar = DB::table('data_bahans')
    //     ->join('stok_keluars','data_bahans.id_bahan','stok_keluars.id_bahan')
    //     ->where($matchThese)
    //     ->get();
        
    //     if(count($keluar)){
    //         return response([
    //             'message' => 'Berhasil tampil data bahan !',
    //             'data' => $keluar
    //         ]);
    //     }

    //     return response([
    //         'message' => 'Empty',
    //         'data' => null
    //     ]);
    // }

    // public function indexSide(){
    //     $matchThese = ['data_bahans.tipe_bahan' => 'Side Dish','stok_keluars.status_hapus'=>0,'data_bahans.status_hapus'=>0];
    //     $keluar = DB::table('data_bahans')
    //     ->join('stok_keluars','data_bahans.id_bahan','stok_keluars.id_bahan')
    //     ->where($matchThese)
    //     ->get();
        
    //     if(count($keluar)){
    //         return response([
    //             'message' => 'Berhasil tampil data bahan !',
    //             'data' => $keluar
    //         ]);
    //     }

    //     return response([
    //         'message' => 'Empty',
    //         'data' => null
    //     ]);
    // }

    // public function indexMinuman(){
    //     $matchThese = ['data_bahans.tipe_bahan' => 'Minuman','stok_keluars.status_hapus'=>0,'data_bahans.status_hapus'=>0];
    //     $keluar = DB::table('data_bahans')
    //     ->join('stok_keluars','data_bahans.id_bahan','stok_keluars.id_bahan')
    //     ->where($matchThese)
    //     ->get();
        
    //     if(count($keluar)){
    //         return response([
    //             'message' => 'Berhasil tampil data bahan !',
    //             'data' => $keluar
    //         ]);
    //     }

    //     return response([
    //         'message' => 'Empty',
    //         'data' => null
    //     ]);
    // }

    public function update(Request $request, $id){
        $keluar = stok_keluar::where('id_stok_keluar','=', $id)->first();
        if(is_null($keluar)){
            return response([
                'message' => 'Data stok keluar tidak ditemukan !',
                'data' => $null
            ]);
        }

        //cek no meja unik
        $updateData = $request->all();
        $keluar->id_bahan = $updateData['id_bahan'];
        $keluar->jumlah_stok_keluar = $updateData['jumlah_stok_keluar'];
        $keluar->tanggal_keluar = $updateData['tanggal_keluar'];

        if($keluar->save()){
            return response([
            'message' => 'Berhasil Update data stok keluar !',
            'data' => $keluar,
            ]);
        } 
        
        return response([
            'message' => 'Gagal Update data stok keluar!',
            'data' => null,
        ]);
    }

    public function store(Request $request){
    
        $keluar = new stok_keluar;

        $keluar->id_bahan = $request->id_bahan;
        $keluar->jumlah_stok_keluar = $request->jumlah_stok_keluar;
        $keluar->tanggal_keluar = $request->tanggal_keluar;
        
        if($keluar->save()){
            return response([
                'message' => 'Berhasil menambah stok keluar !',
                'data' => $keluar,
            ]);
       }else{
            return response([
                'message' => 'Gagal menambah stok keluar !',
                'data' => null,
            ]);
       }
    }

    public function destroySoft($id){
        $keluar = stok_keluar::where('id_stok_keluar','=', $id)->first();

        if(is_null($keluar)){
            return response([
                'message' => 'Data stok keluar tidak ditemukan !',
                'data' => $null
            ]);
        }

        $keluar->status_hapus = 1;
        if($keluar->save()){
            return response([
            'message' => 'Berhasil menghapus data stok keluar !',
            'data' => $keluar,
            ]);
        } 
        
        return response([
            'message' => 'Gagal menghapus data stok keluar !',
            'data' => null,
        ]);
    }
}
