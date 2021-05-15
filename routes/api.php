<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::put('reservasi-selesai/{today}', 'Api\ReservasiController@updateDate'); //update status slesai
Route::post('/login',"Api\KaryawanController@login"); // login-karyawan
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('role', 'Api\RoleController@index'); //get all role
    
    
    Route::get('customer', 'Api\CustomerController@index'); //get all customer
    Route::get('customer/{id}', 'Api\CustomerController@search'); //search customer by id
    Route::get('customer-name', 'Api\CustomerController@getAllName'); //get all name customer
    Route::get('customer-name/{name}', 'Api\CustomerController@getDataByName'); //get data by name 
    Route::post('customer', 'Api\CustomerController@store'); //insert new customer
    Route::put('customer/{id}', 'Api\CustomerController@update'); //update data customer
    Route::put('customer-soft/{id}', 'Api\CustomerController@destroySoft'); //soft-delete customer
    Route::delete('customer/{id}', 'Api\CustomerController@destroy'); //hard-delete customer

    Route::get('reservasi', 'Api\ReservasiController@index'); //get all reservasi belum datang
    Route::get('reservasi-datang', 'Api\ReservasiController@indexDatang'); //get all reservasi sudah datang
    Route::get('reservasi/{date}/{sesi}', 'Api\ReservasiController@getIdMeja'); //get id meja full
    Route::post('reservasi', 'Api\ReservasiController@store'); //insert new reservasi
    Route::put('reservasi/{id}', 'Api\ReservasiController@update'); //insert new reservasi
    Route::get('reservasi/{id}', 'Api\ReservasiController@search'); //search reservasi by id
    Route::put('reservasi-soft/{id}', 'Api\ReservasiController@delete'); //insert new reservasi
    Route::put('reservasi-status/{id}', 'Api\ReservasiController@changeStatusReservasi'); //change status reservasi

    Route::get('karyawan/{id}', 'Api\KaryawanController@search'); //search karyawan by id
    Route::get('karyawan', 'Api\KaryawanController@index'); // get all karyawan
    Route::get('karyawan-aktif', 'Api\KaryawanController@indexAktif'); // get all karyawan aktif
    Route::get('karyawan-non-aktif', 'Api\KaryawanController@indexNonAktif'); // get all karyawan non-aktif
    Route::post('karyawan', 'Api\KaryawanController@store'); // insert new karyawan
    Route::put('karyawan/{id}', 'Api\KaryawanController@update'); // update data karyawan
    Route::put('karyawan-status/{id}', 'Api\KaryawanController@changeStatus'); // change status karyawan
    Route::delete('karyawan/{id}', 'Api\KaryawanController@destroy'); // hard-delete karyawan
    

    Route::get('meja/{id}', 'Api\MejaController@searchById'); //search by id
    Route::get('meja-no/{no}', 'Api\MejaController@searchByNo'); //search by nomor
    Route::get('meja', 'Api\MejaController@index'); // get all meja
    Route::get('meja-nomor', 'Api\MejaController@getAllNomor'); //get all nomor meja
    Route::get('show-meja-status/{status}', 'Api\MejaController@searchByStatusKetersediaan'); //show meja berdasarkan status (tersedia / terisi)
    Route::post('meja', 'Api\MejaController@store'); //insert meja baru
    Route::put('meja/{id}', 'Api\MejaController@update'); //update meja normal
    Route::put('meja-status/{id}', 'Api\MejaController@updateStatusMeja'); //update status meja (toggle)
    Route::put('meja-manual/{id}', 'Api\MejaController@updateStatusManual'); //update status meja manual
    Route::put('meja-soft/{id}', 'Api\MejaController@destroySoft'); // soft-delete meja
    Route::delete('meja-hard/{id}', 'Api\MejaController@destroyHard'); // hard-delete meja

    Route::get('bahan-makanan', 'Api\BahanController@indexMakanan'); // get all bahan makanan
    Route::get('bahan-side', 'Api\BahanController@indexSide'); // get all bahan side dish
    Route::get('bahan-minuman', 'Api\BahanController@indexMinuman'); // get all bahan minuman
    Route::get('bahan', 'Api\BahanController@index'); // get all bahan
    Route::get('bahan-name', 'Api\BahanController@getAllName'); //get all name customer
    Route::get('bahan-name/{name}', 'Api\BahanController@getDataByName'); //get data by name 
    Route::post('bahan', 'Api\BahanController@store'); //insert bahan baru
    Route::put('bahan/{id}', 'Api\BahanController@update'); //ubah bahan 
    Route::put('bahan-stok/{id}', 'Api\BahanController@updateStok'); //ubah bahan 
    Route::put('bahan-soft/{id}', 'Api\BahanController@destroySoft'); // soft-delete bahan

    Route::get('stok-makanan', 'Api\StokMasukController@indexMakanan'); // get all stok masuk makanan
    Route::get('stok-side', 'Api\StokMasukController@indexSide'); // get all stok masuk side dish
    Route::get('stok-minuman', 'Api\StokMasukController@indexMinuman'); // get all stok masuk minuman
    Route::get('stok', 'Api\StokMasukController@index'); // get all stok masuk
    Route::post('stok', 'Api\StokMasukController@store'); //insert stok masuk baru
    Route::put('stok/{id}', 'Api\StokMasukController@update'); //ubah stok masuk 
    Route::put('stok-soft/{id}', 'Api\StokMasukController@destroySoft'); // soft-delete stok masuk

    Route::get('stok-makanan-keluar', 'Api\StokKeluarController@indexMakanan'); // get all stok keluar makanan
    Route::get('stok-side-keluar', 'Api\StokKeluarController@indexSide'); // get all stok keluar side dish
    Route::get('stok-minuman-keluar', 'Api\StokKeluarController@indexMinuman'); // get all stok keluar minuman
    Route::get('stok-keluar', 'Api\StokKeluarController@index'); // get all stok keluar
    Route::post('stok-keluar', 'Api\StokKeluarController@store'); //insert stok keluar baru
    Route::put('stok-keluar/{id}', 'Api\StokKeluarController@update'); //ubah stok keluar 
    Route::put('stok-soft-keluar/{id}', 'Api\StokKeluarController@destroySoft'); // soft-delete stok keluar

    Route::get('kartu', 'Api\DataKartuController@index'); // get all data kartu
    Route::get('kartu-nomor', 'Api\DataKartuController@getAllNomor'); //get all nomor kartu
    Route::get('kartu/{nomor}', 'Api\DataKartuController@getDataByNomor'); //get data by nomor kartu
    Route::post('kartu', 'Api\DataKartuController@store'); //insert data kartu baru
    Route::put('kartu/{id}', 'Api\DataKartuController@update'); //ubah data kartu
    Route::put('kartu-soft/{id}', 'Api\DataKartuController@destroySoft'); // soft-delete data kartu

    Route::get('menu', 'Api\MenuController@index'); // get all menu 
    Route::get('menu-makanan', 'Api\MenuController@indexMakanan'); // get all menu makanan
    Route::get('menu-side', 'Api\MenuController@indexSide'); // get all menu side dish
    Route::get('menu-minuman', 'Api\MenuController@indexMinuman'); // get all menu minuman
    Route::post('menu', 'Api\MenuController@store'); //insert data menu
    Route::post('menu/upload-image/{id}', 'Api\MenuController@uploadImage'); // upload image
    Route::put('menu/{id}', 'Api\MenuController@update'); //ubah data menu
    Route::put('menu-soft/{id}', 'Api\MenuController@destroySoft'); // soft-delete data menu

    Route::get('pesanan', 'Api\PesananController@index'); // get all pesanan
    Route::get('pesanan-search/{id}/{tanggal}/{sesi}', 'Api\PesananController@searchPesanan'); // get pesanan by tanggal, id meja, waktu
    Route::get('pesanan-search-by-reservasi/{id}/{status}', 'Api\PesananController@indexByReservasi'); // get pesanan Mobile
    Route::post('pesanan', 'Api\PesananController@store'); //insert data pesanan
    Route::put('pesanan-penyajian/{id}', 'Api\PesananController@editPenyajian'); // edit penyajian pesanan
    Route::put('pesanan-soft/{id}', 'Api\PesananController@destroySoft'); // soft-delete pesanan
    Route::put('pesanan/{id}', 'Api\PesananController@update'); //update data pesanan (jumlah)

    Route::get('transaksi', 'Api\TransaksiController@index'); // get all transaksi
    Route::post('transaksi', 'Api\TransaksiController@store'); //insert data transaksi
});









