<?php

namespace App\Http\Controllers;

use App\Models\Harga_jasa;
use Illuminate\Http\Request;

class HargaJasaController extends Controller
{
    //
    public function allData(){
        $data =Harga_jasa::with(['jasas'])->OrderBy('id','DESC')->get();
        return response()->json($data);
    }

    public function allActiveData(){
        $data =Harga_jasa::with(['jasas'])->where('status_harga_jasa', 1)->get();
        return response()->json($data);
    }
    

    public function storeData(Request $request){
        $request->validate([
            'inputJasa' => 'required|max:255',
            'inputHargaJasa' => 'required',
            'inputStatusHargaJasa' => 'required',         
        ]);
        $data = Harga_jasa::create([
            'jasas_id' =>$request->inputJasa,
            'nominal_harga_jasa' =>$request->inputHargaJasa,
            'status_harga_jasa' =>$request->inputStatusHargaJasa,
        ]);
        
        return response()->json($data);
        // return response()->json([$request->inputJasa,$request->inputHargaJasa,$request->inputStatusHargaJasa]);
    }

    public function editData($id){
        $data = Harga_jasa::findOrFail($id);
        return response()->json($data);
    }

    public function updateData(Request $request,$id){
        $request->validate([
            'inputJasa' => 'required|max:255',
            'inputHargaJasa' => 'required',
            'inputStatusHargaJasa' => 'required',         
        ]);
        $data = Harga_jasa::findOrFail($id)->update([
            'id' =>$request->$id,
            'jasas_id' =>$request->inputJasa,
            'nominal_harga_jasa' =>$request->inputHargaJasa,
            'status_harga_jasa' =>$request->inputStatusHargaJasa,
        ]);
        return response()->json($data);

        
    }

    public function deleteData($id){
        $cust = Harga_jasa::where('id',$id)->delete();
        return response()->json($cust);
    }

}
