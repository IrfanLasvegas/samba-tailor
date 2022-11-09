<?php

namespace App\Http\Controllers;

use App\Models\Persentase;
use Illuminate\Http\Request;

class PersentaseBagianController extends Controller
{
    //
    public function allData(){
        $data =Persentase::with(['bagians'])->OrderBy('id','DESC')->get();
        return response()->json($data);
    }




    public function allActiveStatusData(){
        // $data = Persentase::with(['bagians'])->where('status_persentase', 1)->get();
        $data = Persentase::with(['bagians'])->where('status_persentase', 1)->get();
        return response()->json($data);
    }

    public function sumActiveStatusData(){
        $data = Persentase::with(['bagians'])->where('status_persentase', 1)->sum('nilai_persentase');
        return response()->json($data);
    }

    public function storeData(Request $request){
        $request->validate([
            'inputBagianPersen' => 'required|max:255',
            'inputNilaiPersen' => 'required|numeric|min:0|max:100',
            'inputStatusPersen' => 'required',         
            'inputStatusHidden' => 'required',         
        ]);
        // $data = Persentase::create([
        //     'bagians_id' =>$request->inputBagianPersen,
        //     'nilai_persentase' =>$request->inputNilaiPersen,
        //     'status_persentase' =>$request->inputStatusPersen,
        // ]);
        // return response()->json($data);

        if($request->inputStatusPersen==1){
            $sum_persen = Persentase::with(['bagians'])->where('status_persentase', 1)->sum('nilai_persentase');
            if (($sum_persen+$request->inputNilaiPersen) <= 100) {
                # code...
                $data = Persentase::create([
                    'bagians_id' =>$request->inputBagianPersen,
                    'nilai_persentase' =>$request->inputNilaiPersen,
                    'status_persentase' =>$request->inputStatusPersen,
                    'status_hidden' =>$request->inputStatusHidden,
                ]);
                return response()->json($data);
            }
            elseif (($sum_persen+$request->inputNilaiPersen) > 100) {
                # code...
                return response()->json(['errPer'=>'Proses tambah data yg berstatus "Active" tidak di ijinkan jika "Active status" sudah 100%, silahkan lakukan perubahan pada tabel persentase.']);
            }
        }elseif($request->inputStatusPersen==0){
            $data = Persentase::create([
                'bagians_id' =>$request->inputBagianPersen,
                'nilai_persentase' =>$request->inputNilaiPersen,
                'status_persentase' =>$request->inputStatusPersen,
                'status_hidden' =>$request->inputStatusHidden,
            ]);
            return response()->json($data);
        }
        

        
    }


    public function editData($id){
        $data = Persentase::findOrFail($id);
        return response()->json($data);
    }

    public function updateData(Request $request,$id){
        $request->validate([
            'inputBagianPersen' => 'required|max:255',
            'inputNilaiPersen' => 'required|numeric|min:0|max:100',
            'inputStatusPersen' => 'required', 
            'inputStatusHidden' => 'required',         
        ]);
        // $data = Persentase::findOrFail($id)->update([
        //     'id' =>$request->$id,
        //     'bagians_id' =>$request->inputBagianPersen,
        //     'nilai_persentase' =>$request->inputNilaiPersen,
        //     'status_persentase' =>$request->inputStatusPersen,
        // ]);
        // return response()->json($data);

        if($request->inputStatusPersen==1){
            $tmp = Persentase::with(['bagians'])->where('status_persentase', 1)->get();
            $sum_persen=0;
            foreach ($tmp as $item) {
                if($item->id != $id){
                    $sum_persen += $item->nilai_persentase;
                }
            }
            // return response()->json($sum_persen);
            if (($sum_persen+$request->inputNilaiPersen) <= 100) {
                $data = Persentase::findOrFail($id)->update([
                    'id' =>$request->$id,
                    'bagians_id' =>$request->inputBagianPersen,
                    'nilai_persentase' =>$request->inputNilaiPersen,
                    'status_persentase' =>$request->inputStatusPersen,
                    'status_hidden' =>$request->inputStatusHidden,
                ]);
                return response()->json($data);
            }
            elseif (($sum_persen+$request->inputNilaiPersen) > 100) {
                return response()->json(['errPer'=>'Proses pembaruan data yg berstatus "Active" tidak di ijinkan jika "Active status" sudah 100%, silahkan lakukan perubahan pada tabel persentase.']);
            }
        }elseif($request->inputStatusPersen==0){
            $data = Persentase::findOrFail($id)->update([
                'id' =>$request->$id,
                'bagians_id' =>$request->inputBagianPersen,
                'nilai_persentase' =>$request->inputNilaiPersen,
                'status_persentase' =>$request->inputStatusPersen,
                'status_hidden' =>$request->inputStatusHidden,
            ]);
            return response()->json($data);
        }
    }

    public function deleteData($id){
        $cust = Persentase::where('id',$id)->delete();
        return response()->json($cust);
    }

}
