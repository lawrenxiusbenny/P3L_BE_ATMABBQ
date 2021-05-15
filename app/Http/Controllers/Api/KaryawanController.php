<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;

class KaryawanController extends Controller
{
    //get all karyawan
    public function index(){
        $karyawan= DB::table('roles')
        ->join('users','roles.id_role','users.id_role')
        ->get();

        if(count($karyawan) > 0){
            return response([
                'message' => 'Berhasil tampil data karyawan',
                'data' => $karyawan
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }
    
    //get all karyawan aktif
    public function indexAktif(){
        $karyawan = DB::table('roles')
        ->join('users','roles.id_role','users.id_role')
        ->where('status','=', 'aktif')
        ->get();

        if(count($karyawan) > 0){
            return response([
                'message' => 'Berhasil tampil data karyawan',
                'data' => $karyawan
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    //get all karyawan non-aktif
    public function indexNonAktif(){
        $karyawan = DB::table('roles')
        ->join('users','roles.id_role','users.id_role')
        ->where('status','=', 'non-aktif')
        ->get();
        if(count($karyawan) > 0){
            return response([
                'message' => 'Berhasil tampil data karyawan',
                'data' => $karyawan
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    public function search($id){
        $karyawan = User::where('id_karyawan','=',$id)->first();

        if(!is_null($karyawan)){
            return response([
                'message' => 'Data Karyawan berhasil ditemukan !',
                'data' => $karyawan
            ]);
        }

        return response([
            'message' => 'Data karyawan tidak ditemukan !',
            'data' => null
        ]);
    }

    public function store(Request $request){

        $registrationData = $request->all();
        $registrationData['password'] = bcrypt($request->password); //enkripsi password

        $karyawan = User::create($registrationData);
        if($karyawan){
            return response([
                'message'=>'Berhasil menambah data karyawan !',
                'data'=>$karyawan,
            ],200);    
        }
        
        return response([
            'message'=>'Gagal menambah data karyawan !',
            'data'=>null,
        ]);
    }

    public function login(Request $request){

        $email = $request->email_karyawan;
        $karyawan = User::where('email_karyawan','=',$email)->first();
        
        if(is_null($karyawan)){
            return response([
                'status' => 'fail',
                'message' => "Email tidak terdaftar !",
                'data' => null
            ]);
        }

        $loginData = $request->all();
        if(!Auth::attempt($loginData))
            return response([
                'status' => 'fail',
                'message' => 'Email atau password anda salah',
                'data' => null,
            ]); 
        
        if($karyawan->status == "non-aktif"){
            return response([
                'status' => 'fail',
                'message' => "Karyawan dalam status non-aktif",
                'data' => null
            ]);
        }

        $karyawan = Auth::user();
        $token = $karyawan->createToken('Authentication Token')->accessToken; //generate token

        return response([
            'status' => 'success',
            'message'=>'Berhasil login !',
            'karyawan'=>$karyawan,
            'token_type'=>'Bearer',
            'access_token'=>$token,
        ],200);//return data user dalam bentuk json
    }

    //change-status
    public function changeStatus($id){
        $karyawan = User::where('id_karyawan','=', $id)->first();
        if(is_null($karyawan)){
            return response([
                'message' => 'Data karyawan tidak ditemukan !',
                'data' => $null
            ]);
        }

        if($karyawan->status == "aktif"){
            $karyawan->status = "non-aktif";
        }
        else if($karyawan->status == "non-aktif"){
            $karyawan->status = "aktif";
        }
        
        if($karyawan->save()){
            return response([
            'message' => 'Berhasil mengganti status karyawan !',
            'data' => $karyawan,
            ]);
        } 
        
        return response([
            'message' => 'Gagal mengganti status karyawan !',
            'data' => null,
        ]);
    }
    
    //hard-delete
    public function destroy($id){
        $Karyawan = User::where('id_karyawan','=', $id)->first();

        if(is_null($Karyawan)){
            return response([
                'message' => 'Data Karyawan tidak ditemukan !',
                'data' => $null
            ]);
        }

        if($Karyawan->delete()){
            return response([
            'message' => 'Berhasil menghapus data Karyawan !',
            'data' => $Karyawan,
            ]);
        } 
        
        return response([
            'message' => 'Gagal menghapus data Karyawan !',
            'data' => null,
        ]);
    }

    public function update(Request $request, $id){
        $Karyawan = User::where('id_karyawan','=', $id)->first();
        if(is_null($Karyawan)){
            return response([
                'message' => 'Data Karyawan tidak ditemukan !',
                'data' => $null
            ]);
        }

        $updateData = $request->all();
        $Karyawan->id_role = $updateData['id_role'];
        $Karyawan->nama_karyawan = $updateData['nama_karyawan'];
        $Karyawan->jenis_kelamin = $updateData['jenis_kelamin'];
        $Karyawan->telepon_karyawan = $updateData['telepon_karyawan'];
        $Karyawan->tanggal_bergabung = $updateData['tanggal_bergabung'];
        if($Karyawan->save()){
            return response([
            'message' => 'Berhasil Update data Karyawan !',
            'data' => $Karyawan,
            ]);
        } 
        
        return response([
            'message' => 'Gagal Update data Karyawan !',
            'data' => null,
        ]);
    }
}
