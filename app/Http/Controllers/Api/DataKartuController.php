<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\data_kartu;


class DataKartuController extends Controller
{
    public function index(){
        $kartu = data_kartu::where('status_hapus','=',0)
        ->get();
        
        if(count($kartu)){
            return response([
                'message' => 'Berhasil tampil data kartu !',
                'data' => $kartu
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    public function store(Request $request){
    
        $data = new data_kartu;

        $data->nomor_kartu = $request->nomor_kartu;
        $data->kode_verifikasi = $request->kode_verifikasi;
        $data->nama_pemilik_kartu = $request->nama_pemilik_kartu;
        $data->jenis_kartu = $request->jenis_kartu;
        $data->expired_date = $request->expired_date;
        
        if($data->save()){
            return response([
                'message' => 'Berhasil menambah data kartu !',
                'data' => $data,
            ]);
       }else{
            return response([
                'message' => 'Gagal menambah data kartu !',
                'data' => null,
            ]);
       }
    }

    public function update(Request $request, $id){
        $kartu = data_kartu::where('id_data_kartu','=', $id)->first();
        if(is_null($kartu)){
            return response([
                'message' => 'Data kartu tidak ditemukan !',
                'data' => null
            ]);
        }

        $updateData = $request->all();
        $kartu->nama_pemilik_kartu = $updateData['nama_pemilik_kartu'];
        $kartu->nomor_kartu = $updateData['nomor_kartu'];
        $kartu->kode_verifikasi = $updateData['kode_verifikasi'];
        $kartu->jenis_kartu = $updateData['jenis_kartu'];
        $kartu->expired_date = $updateData['expired_date'];

        if($kartu->save()){
            return response([
            'message' => 'Berhasil Update data kartu !',
            'data' => $kartu,
            ]);
        } 
        
        return response([
            'message' => 'Gagal Update data kartu !',
            'data' => null,
        ]);
    }

    public function getAllNomor(){
        $kartu = data_kartu::where('status_hapus','=', '0')->get();

        $nomor = [];

        if(count($kartu)>0){
            foreach($kartu as $kart){
                array_push($nomor,$kart->nomor_kartu);
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

    public function getDataByNomor($nomor){
        $matchThese = ['nomor_kartu' => $nomor,'status_hapus'=>0];
        $kartu = data_kartu::where($matchThese)->first();

        if($kartu!=null){
            return response([
                'message' => 'success',
                'data' => $kartu
            ]);
        }

        return response([
            'message' => 'fail',
            'data' => null
        ]);
    }

    public function destroySoft($id){
        $kartu = data_kartu::where('id_data_kartu','=', $id)->first();

        if(is_null($kartu)){
            return response([
                'message' => 'Data kartu tidak ditemukan !',
                'data' => $null
            ]);
        }

        $kartu->status_hapus = 1;
        if($kartu->save()){
            return response([
            'message' => 'Berhasil menghapus data kartu !',
            'data' => $kartu,
            ]);
        } 
        
        return response([
            'message' => 'Gagal menghapus data kartu !',
            'data' => null,
        ]);
    }

}
