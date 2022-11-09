<?php

namespace App\Http\Controllers;

use App\Models\Pengerjaan;
use App\Models\Persentase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PenghasilanController extends Controller
{
    //
    public function index(){
        $data = Persentase::with(['bagians'])->where('status_persentase', 1)->sum('nilai_persentase');
        // today
        $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->OrderBy('id','DESC')->get()->groupBy('barcode');
        $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->OrderBy('id','ASC')->get()->groupBy('persentases.bagians.id');
        $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
        
        return view('ViewAdmin.va_penghasilan.va_penghasilan_index', compact('data','dataRiwayat','tmp_th'));
        
    }

    public function allAjaxData(Request $request){
        if($request->ajax())
        {
            if ($request->chooseBy == 'today') {
                if ($request->statusPembayaran == 'all') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->OrderBy('id','ASC')->get()->groupBy('persentases.bagians.id');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                }elseif ($request->statusPembayaran == 'done' ) {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->OrderBy('id','ASC')->get()->groupBy('persentases.bagians.id');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                }elseif ($request->statusPembayaran == 'notYet') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->OrderBy('id','ASC')->get()->groupBy('persentases.bagians.id');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                }
            }elseif ($request->chooseBy == 'week') {
                if ($request->statusPembayaran == 'all') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','ASC')->get()->groupBy('persentases.bagians.id');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                }elseif ($request->statusPembayaran == 'done' ) {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','ASC')->get()->groupBy('persentases.bagians.id');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                }elseif ($request->statusPembayaran == 'notYet') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','ASC')->get()->groupBy('persentases.bagians.id');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                }
            }elseif ($request->chooseBy == 'month') {
                if ($request->statusPembayaran == 'all') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('persentases.bagians.id');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                }elseif ($request->statusPembayaran == 'done' ) {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('persentases.bagians.id');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                }elseif ($request->statusPembayaran == 'notYet') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('persentases.bagians.id');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                }
            }elseif ($request->chooseBy == 'year') {
                if ($request->statusPembayaran == 'all') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('persentases.bagians.id');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                }elseif ($request->statusPembayaran == 'done' ) {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('persentases.bagians.id');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                }elseif ($request->statusPembayaran == 'notYet') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('persentases.bagians.id');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                }
            }elseif ($request->chooseBy == 'custom') {
                $tmp_start_date = Carbon::parse($request->start_date)->toDateTimeString();
                $tmp_end_date = Carbon::parse($request->end_date)->addDays(1)->toDateTimeString();
                $cd1 =strtotime($request->start_date);
                $cd2 =strtotime($request->end_date);
                if ($request->start_date == null or $request->end_date==null) {
                    return response()->json(['errPer'=>'Tangal belum di atur'],422);
                }elseif ($cd1 > $cd2) {
                    return response()->json(['errPer'=>'Tangal tidak valid'],422);
                }elseif ($cd1 < $cd2 or $cd1 == $cd2) {
                    // year
                    if ($request->statusPembayaran == 'all') {
                        $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->OrderBy('id','DESC')->get()->groupBy('barcode');
                        $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->OrderBy('id','DESC')->get()->groupBy('persentases.bagians.id');
                        $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                        return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                    }elseif ($request->statusPembayaran == 'done' ) {
                        $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('barcode');
                        $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->OrderBy('id','DESC')->get()->groupBy('persentases.bagians.id');
                        $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                        return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                    }elseif ($request->statusPembayaran == 'notYet') {
                        $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('barcode');
                        $tmp_th = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->OrderBy('id','DESC')->get()->groupBy('persentases.bagians.id');
                        $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                        return view('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data', compact('dataRiwayat','tmp_th'))->render();
                    }
                }
            }
        }
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

    
    public function editData($id){
        // $data = Pengerjaan::findOrFail($id);
        $data = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->where('barcode', $id)->get();
        return response()->json($data);
    }

    public function updateData(Request $request,$id){
        $allParameters = $request->all();
        $cek_value_null=false;
        foreach ($allParameters as $key => $value) {
            if ($value == null) {
                $cek_value_null=true;
            }
        }

        if ($cek_value_null == false) {
            foreach ($allParameters as $key => $value) {
                $tmp_name=explode("PersenU",$key);
                if (count($tmp_name)==2) {
                    if ($tmp_name[0] =='nm') {
                        $data = Pengerjaan::where('barcode',$request->idBarcode)->where('persentases_id',$tmp_name[1])->update([
                            'users_id' =>$value,
                            'harga_jasas_id' =>$request->nmHargaJasa,
                        ]);
                    }
                }
                
            }
            return response()->json($data);
        }elseif ($cek_value_null == true) {
            return response()->json(['errPer'=>'Proses pembaruan data tidak di izinkan jika semua "input field" belum diisi']);
            
        } 
    }

    public function totalPenghasilan($data){
        $result = [];
        foreach ($data as $key => $value) {
            $len = count($value);
            $tmp_penghasilan=0;
            foreach ($value as $key2 => $value2) {
                $tmp_persentase_keuntungan = ($value2->harga_jasas->nominal_harga_jasa * $value2->persentases->nilai_persentase) / 100;
                $tmp_penghasilan += $tmp_persentase_keuntungan;
                
                if ($key2 == ($len-1)) {
                
                    $result[$value2->users_id] = [$value2->users->name => $tmp_penghasilan];
                }
            }
            
        }
        return $result;
    }

    public function checkTotalData(Request $request){
        if($request->ajax())
        {
            if ($request->chooseBy == 'today') {
                if ($request->statusPembayaran == 'all') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->OrderBy('id','DESC')->get()->groupBy('users_id');
                    $tmp_result=$this->totalPenghasilan($myCollectionObj);
                    return response()->json($tmp_result);
                }elseif ($request->statusPembayaran == 'done' ) {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('users_id');
                    $tmp_result=$this->totalPenghasilan($myCollectionObj);
                    return response()->json($tmp_result);
                }elseif ($request->statusPembayaran == 'notYet') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('users_id');
                    $tmp_result=$this->totalPenghasilan($myCollectionObj);
                    return response()->json($tmp_result);
                }
            }elseif ($request->chooseBy == 'week') {
                if ($request->statusPembayaran == 'all') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','DESC')->get()->groupBy('users_id');
                    $tmp_result=$this->totalPenghasilan($myCollectionObj);
                    return response()->json($tmp_result);
                }elseif ($request->statusPembayaran == 'done' ) {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('users_id');
                    $tmp_result=$this->totalPenghasilan($myCollectionObj);
                    return response()->json($tmp_result);
                }elseif ($request->statusPembayaran == 'notYet') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('users_id');
                    $tmp_result=$this->totalPenghasilan($myCollectionObj);
                    return response()->json($tmp_result);
                }
            }elseif ($request->chooseBy == 'month') {
                if ($request->statusPembayaran == 'all') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('users_id');
                    $tmp_result=$this->totalPenghasilan($myCollectionObj);
                    return response()->json($tmp_result);
                }elseif ($request->statusPembayaran == 'done' ) {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('users_id');
                    $tmp_result=$this->totalPenghasilan($myCollectionObj);
                    return response()->json($tmp_result);
                }elseif ($request->statusPembayaran == 'notYet') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('users_id');
                    $tmp_result=$this->totalPenghasilan($myCollectionObj);
                    return response()->json($tmp_result);
                }
            }elseif ($request->chooseBy == 'year') {
                if ($request->statusPembayaran == 'all') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('users_id');
                    $tmp_result=$this->totalPenghasilan($myCollectionObj);
                    return response()->json($tmp_result);
                }elseif ($request->statusPembayaran == 'done' ) {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('users_id');
                    $tmp_result=$this->totalPenghasilan($myCollectionObj);
                    return response()->json($tmp_result);
                }elseif ($request->statusPembayaran == 'notYet') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('users_id');
                    $tmp_result=$this->totalPenghasilan($myCollectionObj);
                    return response()->json($tmp_result);
                }
            }elseif ($request->chooseBy == 'custom') {
                $tmp_start_date = Carbon::parse($request->start_date)->toDateTimeString();
                $tmp_end_date = Carbon::parse($request->end_date)->addDays(1)->toDateTimeString();
                $cd1 =strtotime($request->start_date);
                $cd2 =strtotime($request->end_date);
                if ($request->start_date == null or $request->end_date==null) {
                    return response()->json(['errPer'=>'Tangal belum di atur'],422);
                }elseif ($cd1 > $cd2) {
                    return response()->json(['errPer'=>'Tangal tidak valid'],422);
                }elseif ($cd1 < $cd2 or $cd1 == $cd2) {
                    if ($request->statusPembayaran == 'all') {
                        $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->OrderBy('id','DESC')->get()->groupBy('users_id');
                        $tmp_result=$this->totalPenghasilan($myCollectionObj);
                        return response()->json($tmp_result);
                    }elseif ($request->statusPembayaran == 'done' ) {
                        $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('users_id');
                        $tmp_result=$this->totalPenghasilan($myCollectionObj);
                        return response()->json($tmp_result);
                    }elseif ($request->statusPembayaran == 'notYet') {
                        $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('users_id');
                        $tmp_result=$this->totalPenghasilan($myCollectionObj);
                        return response()->json($tmp_result);
                    }
                }
            }
        }
        
        // return response()->json([$request->inputJasa,$request->inputHargaJasa,$request->inputStatusHargaJasa]);
    }

    public function deleteData($id){
        $cust = Pengerjaan::where('barcode',$id)->delete();
        return response()->json($cust);
    }
}
