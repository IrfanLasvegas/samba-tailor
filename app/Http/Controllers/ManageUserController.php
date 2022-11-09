<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;

class ManageUserController extends Controller
{
    //
    public function index(){
        $myCollectionObj = User::with(['roles', 'persentases','persentases.bagians'])->OrderBy('id','DESC')->get();     
        $dataUser= $this->paginate($myCollectionObj, 20); //panggil fungsi "paginate di bawah"

        return view('ViewAdmin.va_manage_user.va_manage_user_index', compact('dataUser'));
        
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function allData(){
        $data =User::with(['roles', 'persentases'])->where('persentases_id','!=',null)->OrderBy('id','ASC')->get();
        return response()->json($data);
    }


    public function allAjaxData(Request $request){
        if($request->ajax())
        {
            $myCollectionObj = User::with(['roles', 'persentases','persentases.bagians'])->OrderBy('id','DESC')->get();     
            $dataUser= $this->paginate($myCollectionObj, 20); //panggil fungsi "paginate di bawah"
            return view('ViewAdmin.va_manage_user.va_manage_user_pagination_data', compact('dataUser'))->render();

            // return response()->json('s');  
        }


        // $data =User::with(['roles', 'persentases','persentases.bagians'])->OrderBy('id','DESC')->get();
        // return response()->json($data);

        // $myCollectionObj = User::with(['roles', 'persentases'])->OrderBy('id','DESC')->get();     
        // return response()->json($myCollectionObj);
    }

    public function storeData(Request $request){ 
        $request->validate([
            'inputNama' => 'required|max:255',
            'email' => 'required|unique:users',
            'inputPassword' => 'required|min:8|max:255',
            'inputRole' => 'required',         
        ]);
        User::create([
            'name' => $request->inputNama,
            'email' => $request->email,
            'password' => Hash::make($request->inputPassword),
            'persentases_id' => $request->inputPersentase,
            'roles_id' => $request->inputRole,
        ]);   
        return response()->json($request);
    }

    public function editData($id){
        // $data = Pengerjaan::findOrFail($id);
        $data = User::with(['roles', 'persentases','persentases.bagians'])->where('id', $id)->get();
        return response()->json($data);
    }

    public function updateData(Request $request,$id){
        $data = User::where('id', $id)->first();
        if ($data->email == $request->email and $request->inputPassword == null) {
            $request->validate([
                'inputNama' => 'required|max:255',
                'inputRole' => 'required',         
            ]);
            $data = User::where('id',$id)->update([
                'name' => $request->inputNama,
                'persentases_id' => $request->inputPersentase,
                'roles_id' => $request->inputRole,
            ]);
            return response()->json($request);
        }elseif ($data->email == $request->email and $request->inputPassword != null) {
            $request->validate([
                'inputNama' => 'required|max:255',
                'inputPassword' => 'required|min:8|max:255',
                'inputRole' => 'required',         
            ]);
            $data = User::where('id',$id)->update([
                'name' => $request->inputNama,
                'password' => Hash::make($request->inputPassword),
                'persentases_id' => $request->inputPersentase,
                'roles_id' => $request->inputRole,
            ]);
            return response()->json($request);
        }elseif ($data->email != $request->email and $request->inputPassword == null) {
            $request->validate([
                'inputNama' => 'required|max:255',
                'email' => 'required|unique:users',
                'inputRole' => 'required',         
            ]);
            $data = User::where('id',$id)->update([
                'name' => $request->inputNama,
                'email' => $request->email,
                'persentases_id' => $request->inputPersentase,
                'roles_id' => $request->inputRole,
            ]);
            return response()->json($request);
        }elseif ($data->email != $request->email and $request->inputPassword != null) {
            $request->validate([
                'inputNama' => 'required|max:255',
                'email' => 'required|unique:users',
                'inputPassword' => 'required|min:8|max:255',
                'inputRole' => 'required',         
            ]);
            $data = User::where('id',$id)->update([
                'name' => $request->inputNama,
                'email' => $request->email,
                'password' => Hash::make($request->inputPassword),
                'persentases_id' => $request->inputPersentase,
                'roles_id' => $request->inputRole,
            ]);
            return response()->json($request);
        }   
    }

    public function deleteData($id){
        $cust = User::where('id',$id)->delete();
        return response()->json($cust);
    }

}
