<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\menu;

class MenuController extends Controller
{
    public function index(){

        $matchThese=["menus.status_hapus"=>0];
        $menu = DB::table('data_bahans')
        ->join('menus','data_bahans.id_bahan','menus.id_bahan')
        ->where($matchThese)
        ->orderBy('menus.jenis_menu','ASC')
        ->orderBy('menus.nama_menu','ASC')
        ->get();

        if(count($menu) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $menu
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    public function indexMakanan(){
        $matchThese=["menus.status_hapus"=>0,"menus.jenis_menu"=>"Makanan"];
        $menu = DB::table('data_bahans')
        ->join('menus','data_bahans.id_bahan','menus.id_bahan')
        ->where($matchThese)
        ->orderBy('menus.nama_menu','ASC')
        ->get();

        if(count($menu) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $menu
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }    

    public function indexSide(){
        $matchThese=["menus.status_hapus"=>0,"menus.jenis_menu"=>"Side Dish"];
        $menu = DB::table('data_bahans')
        ->join('menus','data_bahans.id_bahan','menus.id_bahan')
        ->where($matchThese)
        ->orderBy('menus.nama_menu','ASC')
        ->get();

        if(count($menu) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $menu
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    public function indexMinuman(){
        $matchThese=["menus.status_hapus"=>0,"menus.jenis_menu"=>"Minuman"];
        $menu = DB::table('data_bahans')
        ->join('menus','data_bahans.id_bahan','menus.id_bahan')
        ->where($matchThese)
        ->orderBy('menus.nama_menu','ASC')
        ->get();

        if(count($menu) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $menu
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    public function store(Request $request){
        $storeData = $request->all();
        
        if($request->hasfile('gambar_menu'))
        {
            $file = $request->file('gambar_menu');
            $ekstensi = $file->extension();
            $filename = 'IMG_'.time().'.'.$ekstensi;
            $path = base_path().'/public/menus/';
            $file->move($path,$filename);

            $menu = new menu;
            $menu->id_bahan = $request->id_bahan;
            $menu->nama_menu = $request->nama_menu;
            $menu->harga_menu = $request->harga_menu;
            $menu->deskripsi_menu = $request->deskripsi_menu;
            $menu->gambar_menu = $filename;
            $menu->jenis_menu = $request->jenis_menu;
            $menu->serving_size = $request->serving_size;
            
            if($menu->save()){
                    return response([
                        'message' => 'Berhasil menambah data menu !',
                        'data' => $menu,
                    ]);
            }else{
                    return response([
                        'message' => 'Gagal menambah data menu !',
                        'data' => null,
                    ]);
            }   
        }
    }

    public function update(Request $request, $id){
        $menu = menu::where('id_menu','=', $id)->first();
        if(is_null($menu)){
            return response([
                'message' => 'Data Menu tidak ditemukan !',
                'data' => $null
            ]);
        }

        $updateData = $request->all();

        $menu->id_bahan = $updateData['id_bahan'];
        $menu->nama_menu = $updateData['nama_menu'];
        $menu->harga_menu = $updateData['harga_menu'];
        $menu->deskripsi_menu = $updateData['deskripsi_menu'];
        $menu->jenis_menu = $updateData['jenis_menu'];
        $menu->serving_size= $updateData['serving_size'];

        if($menu->save()){
            return response([
            'message' => 'Berhasil ubah data menu !',
            'data' => $menu,
            ]);
        } 
        
        return response([
            'message' => 'Gagal ubah data menu',
            'data' => null,
        ]);
    }

    public function uploadImage(Request $request , $id){
        if($request->hasFile('gambar_menu')){
            $menu = menu::find($id);
            if(is_null($menu)){
                return response([
                    'message' => 'Menu tidak ditemukan',
                    'data' => null
                ]);
            }

            $updateData = $request->all();

            $file = $request->file('gambar_menu');
            $ekstensi = $file->extension();
            $filename = 'IMG_'.time().'.'.$ekstensi;
            $path = base_path().'/public/menus/';
            $file->move($path,$filename);

            $menu->gambar_menu = $filename;

            if($menu->save()){
                return response([
                    'message'=> 'Berhasil Unggah Foto',
                    'user'=>$menu
                ]);
            }else{
                return response([
                    'message'=> 'Gagal Unggah Foto',
                    'user'=>null
                ]);
            }
        }
    }

    public function destroySoft($id){
        $menu = menu::where('id_menu','=', $id)->first();

        if(is_null($menu)){
            return response([
                'message' => 'Data menu tidak ditemukan !',
                'data' => $null
            ]);
        }

        $menu->status_hapus = 1;
        if($menu->save()){
            return response([
            'message' => 'Berhasil menghapus data menu !',
            'data' => $menu,
            ]);
        } 
        
        return response([
            'message' => 'Gagal menghapus data menu !',
            'data' => null,
        ]);
    }
}

