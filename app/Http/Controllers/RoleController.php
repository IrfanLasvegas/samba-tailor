<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function allData(){
        $data =Role::OrderBy('id','ASC')->get();
        return response()->json($data);
    }
}
