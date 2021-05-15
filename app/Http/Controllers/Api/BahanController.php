<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\data_bahan;

class BahanController extends Controller
{
    public function index(){
        // $meja= Meja::all();
        $bahan = data_bahan::where('status_hapus','=', '0')->get();
        
        if(!is_null($bahan)){
            return response([
                'message' => 'Berhasil tampil data bahan !',
                'data' => $bahan
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    // public function indexMakanan(){
    //     // $meja= Meja::all();
    //     $matchThese = ['status_hapus' => 0,'tipe_bahan'=>"Makanan"];
    //     $bahan = data_bahan::where($matchThese)->get();
        
    //     if(!is_null($bahan)){
    //         return response([
    //             'message' => 'Berhasil tampil data bahan !',
    //             'data' => $bahan
    //         ]);
    //     }

    //     return response([
    //         'message' => 'Empty',
    //         'data' => null
    //     ]);
    // }

    // public function indexSide(){
    //     // $meja= Meja::all();
    //     $matchThese = ['status_hapus' => 0,'tipe_bahan'=>"Side Dish"];
    //     $bahan = data_bahan::where($matchThese)->get();
        
    //     if(!is_null($bahan)){
    //         return response([
    //             'message' => 'Berhasil tampil data bahan !',
    //             'data' => $bahan
    //         ]);
    //     }

    //     return response([
    //         'message' => 'Empty',
    //         'data' => null
    //     ]);
    // }

    // public function indexMinuman(){
    //     // $meja= Meja::all();
    //     $matchThese = ['status_hapus' => 0,'tipe_bahan'=>"Minuman"];
    //     $bahan = data_bahan::where($matchThese)->get();
        
    //     if(!is_null($bahan)){
    //         return response([
    //             'message' => 'Berhasil tampil data bahan !',
    //             'data' => $bahan
    //         ]);
    //     }

    //     return response([
    //         'message' => 'Empty',
    //         'data' => null
    //     ]);
    // }

    public function store(Request $request){
    
        $bahan = new data_bahan;

        $bahan->nama_bahan = $request->nama_bahan;
        $bahan->stok_bahan = $request->stok_bahan;
        // $bahan->tipe_bahan = $request->tipe_bahan;
        $bahan->satuan_bahan = $request->satuan_bahan;
        
        if($bahan->save()){
            return response([
                'message' => 'Berhasil menambah data Bahan !',
                'data' => $bahan,
            ]);
       }else{
            return response([
                'message' => 'Gagal menambah data Bahan !',
                'data' => null,
            ]);
       }
    }

    //get all name
    public function getAllName(){
        $bahan = data_bahan::where('status_hapus','=', '0')->get();

        $names = [];

        if(count($bahan)>0){
            foreach($bahan as $bah){
                array_push($names,$bah->nama_bahan);
            }

            return response([
                'message' => 'success',
                'data' => $names
            ]);
        }

        return response([
            'message' => 'fail',
            'data' => null
        ]);
    }

    public function getDataByName($name){
        $matchThese = ['nama_bahan' => $name,'status_hapus'=>0];
        $bahan = data_bahan::where($matchThese)->first();
        if($bahan){
            return response([
                'message' => 'success',
                'data' => $bahan
            ]);
        }

        return response([
            'message' => 'fail',
            'data' => null
        ]);
    }


    //soft-delete
    public function destroySoft($id){
        $bahan = data_bahan::where('id_bahan','=', $id)->first();

        if(is_null($bahan)){
            return response([
                'message' => 'Data Bahan tidak ditemukan !',
                'data' => $null
            ]);
        }

        $bahan->status_hapus = 1;
        if($bahan->save()){
            return response([
            'message' => 'Berhasil menghapus data bahan !',
            'data' => $bahan,
            ]);
        } 
        
        return response([
            'message' => 'Gagal menghapus data bahan !',
            'data' => null,
        ]);
    }

    //update biasa
    public function update(Request $request, $id){
        $bahan = data_bahan::where('id_bahan','=', $id)->first();
        if(is_null($bahan)){
            return response([
                'message' => 'Data bahan tidak ditemukan !',
                'data' => $null
            ]);
        }

        //cek no meja unik
        $updateData = $request->all();
        $bahan->nama_bahan = $updateData['nama_bahan'];
        // $bahan->tipe_bahan = $updateData['tipe_bahan'];
        $bahan->satuan_bahan = $updateData['satuan_bahan'];
        $bahan->stok_bahan = $updateData['stok_bahan'];

        if($bahan->save()){
            return response([
            'message' => 'Berhasil Update data bahan !',
            'data' => $bahan,
            ]);
        } 
        
        return response([
            'message' => 'Gagal Update data bahan!',
            'data' => null,
        ]);
    }

    public function updateStok(Request $request, $id){
        $bahan = data_bahan::where('id_bahan','=', $id)->first();
        if(is_null($bahan)){
            return response([
                'message' => 'Data bahan tidak ditemukan !',
                'data' => $null
            ]);
        }

        $updateData = $request->all();
        $bahan->stok_bahan = $bahan->stok_bahan+$updateData['stok_bahan_baru']-$updateData['stok_bahan_lama'];

        if($bahan->save()){
            return response([
            'message' => 'Berhasil Update data bahan !',
            'data' => $bahan,
            ]);
        } 
        
        return response([
            'message' => 'Gagal Update data bahan!',
            'data' => null,
        ]);
    }

    //searchByNoMeja
    public function searchByNoMeja($no_meja){
        $matchThese = ['no_meja' => $no_meja,'status_hapus'=>0];
        $meja = Meja::where($matchThese)->get();

        // $meja = Meja::where('no_meja','=',$no_meja)->first();

        if(count($meja)>0){
            return response([
                'message' => 'Data Meja berhasil ditemukan !',
                'data' => $meja
            ]);
        }

        return response([
            'message' => 'Data meja tidak ditemukan !',
            'data' => null
        ]);
    }

    public function searchByStatusKetersediaan($status){
        $matchThese = ['status_meja' => $status,'status_hapus'=>0];
        $meja = Meja::where($matchThese)->get();

        // $meja = Meja::where('no_meja','=',$no_meja)->first();

        if(count($meja)>0){
            return response([
                'message' => 'Data Meja berhasil ditemukan !',
                'data' => $meja
            ]);
        }

        return response([
            'message' => 'Data meja tidak ditemukan !',
            'data' => null
        ]);
    }
}
