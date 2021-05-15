<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Role;

class RoleController extends Controller
{
    public function index(){
        $role= Role::all();
        return response([
            'data' => $role
        ]);
    }
}
