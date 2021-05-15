<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Customer;
use Validator;

class CustomerController extends Controller
{
    public function index(){
        // $customer= Customer::all();

        $customer = Customer::where('status_hapus','=', '0')->get();
        if(count($customer) > 0){
            return response([
                'message' => 'Berhasil tampil data customer',
                'data' => $customer
            ]);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ]);
    }

    public function store(Request $request){
    
        $customer = new Customer;
        $customer->nama_customer = $request->nama_customer;
        $customer->email_customer = $request->email_customer;
        $customer->telepon_customer = $request->telepon_customer;
        
        if($customer->save()){
            return response([
                'message' => 'Berhasil menambah data customer !',
                'data' => $customer,
            ]);
       }else{
            return response([
                'message' => 'Gagal menambah data customer !',
                'data' => null,
            ]);
       }
    }

    public function getAllName(){
        $customer = Customer::where('status_hapus','=', '0')->get();

        $names = [];

        if(count($customer)>0){
            foreach($customer as $cust){
                array_push($names,$cust->nama_customer);
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
        $matchThese = ['nama_customer' => $name,'status_hapus'=>0];
        $customer = Customer::where($matchThese)->first();
        if($customer){
            return response([
                'message' => 'success',
                'data' => $customer
            ]);
        }

        return response([
            'message' => 'fail',
            'data' => null
        ]);
    }

    //hard-delete
    public function destroy($id){
        $customer = Customer::where('id_customer','=', $id)->first();

        if(is_null($customer)){
            return response([
                'message' => 'Data Customer tidak ditemukan !',
                'data' => $null
            ]);
        }

        if($customer->delete()){
            return response([
            'message' => 'Berhasil menghapus data customer !',
            'data' => $customer,
            ],200);
        } 
        
        return response([
            'message' => 'Gagal menghapus data customer !',
            'data' => null,
        ]);
    }

    //soft-delete
    public function destroySoft($id){
        $customer = Customer::where('id_customer','=', $id)->first();

        if(is_null($customer)){
            return response([
                'message' => 'Data customer tidak ditemukan !',
                'data' => $null
            ]);
        }

        $customer->status_hapus = 1;
        if($customer->save()){
            return response([
            'message' => 'Berhasil menghapus data customer !',
            'data' => $customer,
            ]);
        } 
        
        return response([
            'message' => 'Gagal menghapus data customer !',
            'data' => null,
        ]);
    }

    public function update(Request $request, $id){
        $customer = Customer::where('id_customer','=', $id)->first();
        if(is_null($customer)){
            return response([
                'message' => 'Data customer tidak ditemukan !',
                'data' => $null
            ]);
        }

        $updateData = $request->all();
        $customer->nama_customer = $updateData['nama_customer'];
        $customer->email_customer = $updateData['email_customer'];
        $customer->telepon_customer = $updateData['telepon_customer'];

        if($customer->save()){
            return response([
            'message' => 'Berhasil Update data customer !',
            'data' => $customer,
            ]);
        } 
        
        return response([
            'message' => 'Gagal Update data customer !',
            'data' => null,
        ]);
    }

    public function search($id){
        $matchThese = ['id_customer' => $id,'status_hapus'=>0];
        $customer = Customer::where($matchThese)->get();

        if(count($customer)>0){
            return response([
                'message' => 'Data customer berhasil ditemukan !',
                'data' => $customer
            ]);
        }

        return response([
            'message' => 'Data customer tidak ditemukan !',
            'data' => null
        ]);
    }
}
