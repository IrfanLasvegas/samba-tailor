<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use Illuminate\Http\Request;

class BagianController extends Controller
{
    //
    public function index(){
        
        return view('ViewAdmin.va_bagian.va_bagian_index');
        
    }

    public function allData(){
        $data =Bagian::OrderBy('id','DESC')->get();
        return response()->json($data);
    }


    public function storeData(Request $request){
        $request->validate([
            'name' => 'required|max:255',
        ]);
        $data = Bagian::create([
            'nama_bagian' =>$request->name,
        ]);

        return response()->json($data);
    }

    public function editData($id){
        $data = Bagian::findOrFail($id);
        return response()->json($data);
    }

    public function updateData(Request $request,$id){
        $request->validate([
            'name' => 'required|max:255',
        ]);
        $data = Bagian::findOrFail($id)->update([
            'nama_bagian' =>$request->name,
        ]);
        
        return response()->json($data);
    }

    public function deleteData($id){
        $cust = Bagian::where('id',$id)->delete();
        return response()->json($cust);
    }
}
