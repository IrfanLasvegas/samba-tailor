<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use Illuminate\Http\Request;

class JasaController extends Controller
{
    //
    public function index(){
        
        return view('ViewAdmin.va_jasa.va_jasa_index');
        
    }

    public function allData(){
        $data =Jasa::OrderBy('id','DESC')->get();
        return response()->json($data);
    }


    public function storeData(Request $request){
        $request->validate([
            'name' => 'required|max:255',
        ]);
        $data = Jasa::create([
            'nama_jasa' =>$request->name,
        ]);

        return response()->json($data);
    }

    public function editData($id){
        $data = Jasa::findOrFail($id);
        return response()->json($data);
    }

    public function updateData(Request $request,$id){
        $request->validate([
            'name' => 'required|max:255',
        ]);
        $data = Jasa::findOrFail($id)->update([
            'nama_jasa' =>$request->name,
        ]);
        
        return response()->json($data);
    }

    public function deleteData($id){
        $cust = Jasa::where('id',$id)->delete();
        return response()->json($cust);
    }
}
