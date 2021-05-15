<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Meja;

class MejaController extends Controller
{
    public function index(){
        // $meja= Meja::all();
        $meja = Meja::where('status_hapus','=', '0')->get();
        
        if(!is_null($meja)){
            return response([
                'message' => 'Berhasil tampil data meja !',
                'data' => $meja
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    //get all name
    public function getAllNomor(){
        $meja = Meja::where('status_hapus','=', '0')->get();

        $nomor = [];

        if(count($meja)>0){
            foreach($meja as $mej){
                array_push($nomor,$mej->no_meja);
            }

            return response([
                'message' => 'success',
                'data' => $nomor
            ]);
        }

        return response([
            'message' => 'fail',
            'data' => null
        ]);
    }

    public function store(Request $request){
    
        $meja = new Meja;
        $meja->no_meja = $request->no_meja;
        
        if($meja->save()){
            return response([
                'message' => 'Berhasil menambah data meja !',
                'data' => $meja,
            ]);
       }else{
            return response([
                'message' => 'Gagal menambah data meja !',
                'data' => null,
            ]);
       }
    }

    //hard-delete
    public function destroyHard($id){
        $meja = Meja::where('id_meja','=', $id)->first();

        if(is_null($meja)){
            return response([
                'message' => 'Data Meja tidak ditemukan !',
                'data' => $null
            ]);
        }

        if($meja->delete()){
            return response([
            'message' => 'Berhasil menghapus data meja !',
            'data' => $meja,
            ],200);
        } 
        
        return response([
            'message' => 'Gagal menghapus data meja !',
            'data' => null,
        ]);
    }

    //soft-delete
    public function destroySoft($id){
        $meja = Meja::where('id_meja','=', $id)->first();

        if(is_null($meja)){
            return response([
                'message' => 'Data Meja tidak ditemukan !',
                'data' => $null
            ]);
        }

        $meja->status_hapus = 1;
        $meja->no_meja = null;
        if($meja->save()){
            return response([
            'message' => 'Berhasil menghapus data meja !',
            'data' => $meja,
            ]);
        } 
        
        return response([
            'message' => 'Gagal menghapus data meja !',
            'data' => null,
        ]);
    }

    //update status jadi terisi
    public function updateStatusManual(Request $request,$id){
        $meja = Meja::where('id_meja','=', $id)->first();
        if(is_null($meja)){
            return response([
                'message' => 'Data meja tidak ditemukan !',
                'data' => $null
            ]);
        }

        $updateData = $request->all();
        $meja->status_meja = $updateData['status_meja'];
        
        if($meja->save()){
            return response([
            'message' => 'Berhasil Update data meja !',
            'data' => $meja,
            ]);
        } 
        
        return response([
            'message' => 'Gagal Update data customer !',
            'data' => null,
        ]);
    }

    //updateStatusMeja
    public function updateStatusMeja($id){
        $meja = Meja::where('id_meja','=', $id)->first();
        if(is_null($meja)){
            return response([
                'message' => 'Data meja tidak ditemukan !',
                'data' => $null
            ]);
        }

        if($meja->status_meja == "Tersedia"){
            $meja->status_meja = "Terisi";
        }
        else if($meja->status_meja == "Terisi"){
            $meja->status_meja = "Tersedia";
        }
        
        if($meja->save()){
            return response([
            'message' => 'Berhasil Update data meja !',
            'data' => $meja,
            ]);
        } 
        
        return response([
            'message' => 'Gagal Update data customer !',
            'data' => null,
        ]);
    }

    //update biasa
    public function update(Request $request, $id){
        $meja = Meja::where('id_meja','=', $id)->first();
        if(is_null($meja)){
            return response([
                'message' => 'Data meja tidak ditemukan !',
                'data' => $null
            ]);
        }

        //cek no meja unik


        $updateData = $request->all();
        $meja->status_meja = $updateData['status_meja'];
        $meja->no_meja = $updateData['no_meja'];

        if($meja->save()){
            return response([
            'message' => 'Berhasil Update data meja !',
            'data' => $meja,
            ]);
        } 
        
        return response([
            'message' => 'Gagal Update data customer !',
            'data' => null,
        ]);
    }

    //searchById
    public function searchById($id){
        $matchThese = ['id_meja' => $id,'status_hapus'=>0];
        $meja = Meja::where($matchThese)->get();

        // $meja = Meja::where('no_meja','=',$no_meja)->first();

        if(count($meja)>0){
            return response([
                'message' => 'succes',
                'data' => $meja->no_meja
            ]);
        }

        return response([
            'message' => 'fail',
            'data' => null
        ]);
    }

    //searchById
    public function searchByNo($no){
        $matchThese = ['no_meja' => $no,'status_hapus'=>0];
        $meja = Meja::where($matchThese)->first();

        // $meja = Meja::where('no_meja','=',$no_meja)->first();

        
        if($meja != null){
            $id = $meja->id_meja;
            return response([
                'message' => 'success',
                'data' => $id
            ]);
        }

        return response([
            'message' => 'fail',
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
