<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Reservasi;

class ReservasiController extends Controller
{
    public function index(){
        $matchThese = ['status_selesai' => '0','reservasis.status_hapus'=>0,'customers.status_hapus'=>0,'mejas.status_hapus'=>0];
        $reservasi = DB::table('customers')
        // ->select("reservasis.id_reservasi",'reservasis.status_reservasi','customers.id_customer','customers.nama_customer','mejas.no_meja','reservasis.tanggal_reservasi','reservasis.waktu_reservasi','reservasis.jumlah_customer')
        ->join('reservasis','customers.id_customer','reservasis.id_customer')
        ->join('mejas','reservasis.id_meja','mejas.id_meja')
        ->where($matchThese)
        ->orderBy('reservasis.tanggal_reservasi','ASC')
        ->get();
        
        if(count($reservasi) > 0){
            return response([
                'message' => 'Berhasil tampil data reservasi',
                'data' => $reservasi
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    public function search($id){
        $matchThese = ['reservasis.id_reservasi' => $id,'reservasis.status_hapus'=>0];
        $reservasi = DB::table('customers')
        ->join('reservasis','customers.id_customer','reservasis.id_customer')
        ->join('mejas','reservasis.id_meja','mejas.id_meja')
        ->join('users','users.id_karyawan','reservasis.id_karyawan')
        ->where($matchThese)
        ->get();

        if(count($reservasi)>0){
            return response([
                'message' => 'Data customer berhasil ditemukan !',
                'data' => $reservasi
            ]);
        }

        return response([
            'message' => 'Data customer tidak ditemukan !',
            'data' => null
        ]);
    }

    public function updateDate($today){
        // $matchThese = ['status_selesai','=', '0','status_hapus'=>0, 'tanggal_reservasi'  $today];
        $reservasi = Reservasi::where('tanggal_reservasi','<',$today)->get();

        foreach($reservasi as $reser){
            $reser->status_selesai = 1;
            // $reser->status_reservasi = "sudah datang";
            $reser->save();
        }
            return response([
                'message' => 'success',
                'data' => $reservasi
            ]);
    

        return response([
            'message' => 'fail',
            'data' => null,
        ]);
        
    }

    public function indexDatang(){
        $matchThese = ['status_selesai' => '1','reservasis.status_hapus'=>0];
        $reservasi = DB::table('customers')
        ->join('reservasis','customers.id_customer','reservasis.id_customer')
        ->join('mejas','reservasis.id_meja','mejas.id_meja')
        ->where($matchThese)
        ->orderBy('reservasis.tanggal_reservasi','ASC')
        ->get();
        
        if(count($reservasi) > 0){
            return response([
                'message' => 'Berhasil tampil data reservasi',
                'data' => $reservasi
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    public function changeStatusReservasi($id){
        $reservasi = Reservasi::where('id_reservasi','=', $id)->first();
        if(is_null($reservasi)){
            return response([
                'message' => 'Data Reservasi tidak ditemukan !',
                'data' => $null
            ]);
        }

        if($reservasi->status_reservasi == "belum datang"){
            $reservasi->status_reservasi = "sudah datang";
        }
        else if($reservasi->status_reservasi == "sudah datang"){
            $reservasi->status_reservasi = "belum datang";
        }
        
        if($reservasi->save()){
            return response([
            'message' => 'Berhasil mengganti status reservasi !',
            'data' => $reservasi,
            ]);
        } 
        
        return response([
            'message' => 'Gagal mengganti status reservasi !',
            'data' => null,
        ]);
    }

    public function getIdMeja($date,$sesi){
        $matchThese = ['tanggal_reservasi' => $date,'waktu_reservasi'=>$sesi,'status_selesai'=>0,'status_hapus'=>0];
        $reservasi = Reservasi::where($matchThese)->get();

        $id = [];
        
        if(count($reservasi)>0){
            foreach($reservasi as $reser){
                array_push($id,$reser->id_meja);
            }

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
    public function store(Request $request){
        $reservasi = new Reservasi;
        $reservasi->id_customer = $request->id_customer;
        $reservasi->id_meja = $request->id_meja;
        $reservasi->id_karyawan = $request->id_karyawan;
        $reservasi->tanggal_reservasi = $request->tanggal_reservasi;
        $reservasi->waktu_reservasi = $request->waktu_reservasi;
        $reservasi->jumlah_customer = $request->jumlah_customer;
        $reservasi->status_reservasi = $request->status_reservasi;

        if($reservasi->save()){
            return response([
                'message' => 'Berhasil menambah data reservasi !',
                'data' => $reservasi,
            ]);
        }else{
                return response([
                    'message' => 'Gagal menambah data reservasi !',
                    'data' => null,
                ]);
        }
    }

    public function update(Request $request, $id){
        $reservasi = Reservasi::where('id_reservasi','=', $id)->first();
        if(is_null($reservasi)){
            return response([
                'message' => 'Data Reservasi tidak ditemukan !',
                'data' => $null
            ]);
        }

        $updateData = $request->all();
        $reservasi->id_customer = $updateData['id_customer'];
        $reservasi->id_meja = $updateData['id_meja'];
        $reservasi->jumlah_customer = $updateData['jumlah_customer'];
        $reservasi->tanggal_reservasi = $updateData['tanggal_reservasi'];
        $reservasi->waktu_reservasi = $updateData['waktu_reservasi'];
        $reservasi->status_reservasi = $updateData['status_reservasi'];
        if($reservasi->save()){
            return response([
            'message' => 'Berhasil Update data Reservasi !',
            'data' => $reservasi,
            ]);
        } 
        
        return response([
            'message' => 'Gagal Update data Reservasi !',
            'data' => null,
        ]);
    }

    public function delete($id){
        $reservasi = Reservasi::where('id_reservasi','=', $id)->first();

        if(is_null($reservasi)){
            return response([
                'message' => 'Data Reservasi tidak ditemukan !',
                'data' => $null
            ]);
        }

        $reservasi->status_hapus = 1;
        if($reservasi->save()){
            return response([
            'message' => 'Berhasil menghapus data Reservasi !',
            'data' => $reservasi,
            ]);
        } 
        
        return response([
            'message' => 'Gagal menghapus data reservasi !',
            'data' => null,
        ]);
    }
}
