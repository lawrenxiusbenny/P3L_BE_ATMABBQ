<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\pesanan;
use App\menu;
use App\stok_keluar;
use App\data_bahan;

class PesananController extends Controller
{
    //get untuk web
    public function index(){
        $matchThese=["pesanans.status_hapus"=>0,"pesanans.status_bayar"=>0,"pesanans.status_selesai"=>0];
        $pesanan = DB::table('menus')
        ->join('pesanans','menus.id_menu','pesanans.id_menu')
        ->join('reservasis','reservasis.id_reservasi','pesanans.id_reservasi')
        ->join('mejas','mejas.id_meja','reservasis.id_meja')
        ->where($matchThese)
        ->orderBy('reservasis.tanggal_reservasi','ASC')
        ->orderBy('reservasis.waktu_reservasi','ASC')
        ->orderBy('mejas.no_meja','ASC')
        ->orderBy('pesanans.status_penyajian','DESC')
        ->get();
        
        if(count($pesanan)){
            return response([
                'message' => 'Berhasil tampil data pesanan !',
                'data' => $pesanan
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    //get by id reservasi dan status checkout (mobile dan web)
    public function indexByReservasi($id,$status){
        $matchThese=["pesanans.id_reservasi"=>$id,"pesanans.status_hapus"=>0,"pesanans.status_bayar"=>0,
                    "pesanans.status_selesai"=>0,"pesanans.status_checkout"=>$status];
        $pesanan = DB::table('menus')
        ->join('pesanans','menus.id_menu','pesanans.id_menu')
        ->join('reservasis','reservasis.id_reservasi','pesanans.id_reservasi')
        ->join('customers','customers.id_customer','reservasis.id_customer')
        ->where($matchThese)
        ->get();
        
        $totalHarga = 0;
        foreach($pesanan as $pes){
            $totalHarga = $totalHarga + $pes->sub_total;
        }

        if(count($pesanan)){
            return response([
                'message' => 'Berhasil tampil data pesanan !',
                'data' => $pesanan,
                'total' => $totalHarga
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    //cari berdasarkan id meja dan tanggal dan sesi (tampil pesanan pas transaksi)
    public function searchPesanan($id,$tanggal,$sesi){
        $matchThese = ["reservasis.id_meja"=>$id,"reservasis.tanggal_reservasi"=>$tanggal,
                    "reservasis.waktu_reservasi"=>$sesi,"pesanans.status_hapus"=>0,
                    "pesanans.status_selesai"=>0,"pesanans.status_bayar"=>0];
        
        $pesanan = DB::table('menus')
        ->join('pesanans','menus.id_menu','pesanans.id_menu')
        ->join('reservasis','reservasis.id_reservasi','pesanans.id_reservasi')
        ->where($matchThese)
        ->get();
        
        $totalHarga = 0;
        foreach($pesanan as $pes){
            $totalHarga = $totalHarga + $pes->sub_total;
        }

        if(count($pesanan)){
            return response([
                'message' => 'Berhasil tampil data pesanan !',
                'data' => $pesanan,
                'total' => $totalHarga
            ]);
        }

        return response([
            'message' => 'Daftar pesanan masih kosong, silahkan tambah pesanan',
            'data' => null
        ]);
    }

    public function store(Request $request){
    
        $matchThese=["id_menu"=> $request->id_menu,"id_reservasi"=> $request->id_reservasi,
                    "status_bayar"=>0,"status_selesai"=>0,"status_hapus"=>0,"status_checkout"=>0];
        $cekPesanan = pesanan::where($matchThese)->first();

        if($cekPesanan == null){
            $pesanan = new pesanan;
            $pesanan->id_menu = $request->id_menu;
            $pesanan->id_reservasi = $request->id_reservasi;
            $pesanan->tanggal_pemesanan = $request->tanggal_pemesanan;
            $pesanan->jumlah = $request->jumlah;


            $menu = menu::where('id_menu','=', $request->id_menu)->first();
            if($menu!=null){
                $pesanan->sub_total = $menu->harga_menu * $request->jumlah;
            }
            
            $keluar = new stok_keluar;

            $keluar->id_bahan = $menu->id_bahan;
            $keluar->jumlah_stok_keluar = $request->jumlah * $menu->serving_size;
            $keluar->tanggal_keluar = $request->tanggal_pemesanan;
            $keluar->save();

            $keluar_baru = stok_keluar::orderBy('id_stok_keluar','DESC')->limit(1)->first();

            $id = $keluar_baru->id_stok_keluar;
            $pesanan->id_stok_keluar = $id;
            if($pesanan->save()){
                return response([
                    'status' => 'success',
                    'message' => 'Berhasil menambah pesanan !',
                    'data' => $pesanan,
                ]);
            }else{
                    return response([
                        'status' => 'fail',
                        'message' => 'Gagal menambah pesanan !',
                        'data' => null,
                    ]);
            }
        }else{
            $jumlah_sebelum = $cekPesanan->jumlah;
            $jumlah_sesudah = $jumlah_sebelum + $request->jumlah;
            $cekPesanan->jumlah = $jumlah_sesudah;

            $menu = menu::where('id_menu','=', $cekPesanan->id_menu)->first();
            if($menu!=null){
                $cekPesanan->sub_total = $menu->harga_menu * $jumlah_sesudah;
            }

            //update stok keluar
            $matchThese=["id_stok_keluar"=>$cekPesanan->id_stok_keluar];
            $keluar = stok_keluar::where($matchThese)->first();
            $keluar->jumlah_stok_keluar = $jumlah_sesudah*$menu->serving_size;

            //update stok bahan
            $bahan = data_bahan::where("id_bahan","=",$menu->id_bahan)->first();
            $bahan->stok_bahan = $bahan->stok_bahan + ($jumlah_sebelum*$menu->serving_size) - ($jumlah_sesudah*$menu->serving_size);

            if($cekPesanan->save() && $keluar->save() && $bahan->save()){
                return response([
                'message' => 'Berhasil ubah data pesanan!',
                'data' => $menu,
                ]);
            } 
            
            return response([
                'message' => 'Gagal ubah data pesanan',
                'data' => null,
            ]);
        }
        
    }

    //ubah status penyajian
    public function editPenyajian($id){
        $pesanan = pesanan::where('id_pesanan','=', $id)->first();

        if(is_null($pesanan)){
            return response([
                'message' => 'Data Pesanan tidak ditemukan !',
                'data' => $null
            ]);
        }

        $pesanan->status_penyajian = "Served";
        if($pesanan->save()){
            return response([
            'message' => 'Berhasil mengubah status penyajian pesanan !',
            'data' => $pesanan,
            ]);
        } 
        
        return response([
            'message' => 'Gagal mengubah status penyajian pesanan !',
            'data' => null,
        ]);
    }

    //soft delete
    public function destroySoft($id){
        $pesanan = pesanan::where('id_pesanan','=', $id)->first();

        if(is_null($pesanan)){
            return response([
                'message' => 'Data Pesanan tidak ditemukan !',
                'data' => $null
            ]);
        }

        $pesanan->status_hapus = 1;

        $keluar = stok_keluar::where('id_stok_keluar','=',$pesanan->id_stok_keluar)->first();

        $keluar->delete();
        
        if($pesanan->save()){
            return response([
            'message' => 'Berhasil menghapus pesanan !',
            'data' => $pesanan,
            ]);
        } 
        
        return response([
            'message' => 'Gagal menghapus pesanan !',
            'data' => null,
        ]);
    }

    public function update(Request $request, $id){
        $matchThese=["id_pesanan"=>$id,"status_hapus"=>0,"pesanans.status_bayar"=>0,"pesanans.status_selesai"=>0];
        $pesanan = pesanan::where($matchThese)->first();
        if(is_null($pesanan)){
            return response([
                'message' => 'Data pesanan tidak ditemukan !',
                'data' => null
            ]);
        }

        $jumlah_sebelum = $pesanan->jumlah;
        $jumlah_sesudah = $request->jumlah;

        $updateData = $request->all();

        $pesanan->jumlah = $updateData['jumlah'];

        $menu = menu::where('id_menu','=', $pesanan->id_menu)->first();
        if($menu!=null){
            $pesanan->sub_total = $menu->harga_menu * $updateData['jumlah'];
        }

        //update stok keluar
        $matchThese=["id_stok_keluar"=>$pesanan->id_stok_keluar];
        $keluar = stok_keluar::where($matchThese)->first();
        $keluar->jumlah_stok_keluar = $jumlah_sesudah*$menu->serving_size;

        //update stok bahan
        $bahan = data_bahan::where("id_bahan","=",$menu->id_bahan)->first();
        $bahan->stok_bahan = $bahan->stok_bahan + ($jumlah_sebelum*$menu->serving_size) - ($jumlah_sesudah*$menu->serving_size);


        if($pesanan->save() && $keluar->save() && $bahan->save()){
            return response([
            'message' => 'Berhasil ubah data pesanan!',
            'data' => $menu,
            ]);
        } 
        
        return response([
            'message' => 'Gagal ubah data pesanan',
            'data' => null,
        ]);
    }
}
