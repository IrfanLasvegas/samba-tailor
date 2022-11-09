<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\Detail_pembayaran;
use App\Models\Pengerjaan;
use App\Models\Persentase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PengerjaanController extends Controller
{
    //
    public function index(){
        $data = Persentase::with(['bagians'])->where('status_persentase', 1)->sum('nilai_persentase');
        
        // $myArray =Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->get()->groupBy('barcode');
        // $myCollectionObj = collect($myArray);
        // $dataRiwayat = $this->paginate($myCollectionObj);

        // cara menggunakan pagination jika hasil query bertipe colection
        // all
        // $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->OrderBy('id','DESC')->get()->groupBy('barcode');

        // today
        $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->OrderBy('id','DESC')->get()->groupBy('barcode');
        
        // week
        // $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','DESC')->get()->groupBy('barcode');
        
        // month
        // $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('barcode');
        
        $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
        
        return view('ViewAdmin.va_jasa.va_pengerjaan_jasa', compact('data','dataRiwayat'));
        
    }

    public function allAjaxData(Request $request){
        if($request->ajax())
        {
            // cara menggunakan pagination jika hasil query bertipe colection
            // all
            // $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->OrderBy('id','DESC')->get()->groupBy('barcode');

            // today
            // $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->OrderBy('id','DESC')->get()->groupBy('barcode');
            
            // week
            // $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','DESC')->get()->groupBy('barcode');
            
            // month
            // $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('barcode');
            
            // $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
            // return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
            
            if ($request->chooseBy == 'today') {
                if ($request->statusPembayaran == 'all') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                }elseif ($request->statusPembayaran == 'done' ) {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                }elseif ($request->statusPembayaran == 'notYet') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                }
                // $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->OrderBy('id','DESC')->get()->groupBy('barcode');
                // $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                // return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
            }elseif ($request->chooseBy == 'week') {
                if ($request->statusPembayaran == 'all') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                }elseif ($request->statusPembayaran == 'done' ) {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                }elseif ($request->statusPembayaran == 'notYet') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                }
                // $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','DESC')->get()->groupBy('barcode');
                // $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                // return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
            }elseif ($request->chooseBy == 'month') {
                if ($request->statusPembayaran == 'all') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                }elseif ($request->statusPembayaran == 'done' ) {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                }elseif ($request->statusPembayaran == 'notYet') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                }
                // $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('barcode');
                // $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                // return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
            }elseif ($request->chooseBy == 'year') {
                if ($request->statusPembayaran == 'all') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                }elseif ($request->statusPembayaran == 'done' ) {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                }elseif ($request->statusPembayaran == 'notYet') {
                    $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('barcode');
                    $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                }
                // $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('barcode');
                // $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                // return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
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
                        $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                        return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                    }elseif ($request->statusPembayaran == 'done' ) {
                        $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('barcode');
                        $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                        return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                    }elseif ($request->statusPembayaran == 'notYet') {
                        $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->where('status_pengerjaan','0')->OrderBy('id','DESC')->get()->groupBy('barcode');
                        $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                        return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
                    }
                    // $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->OrderBy('id','DESC')->get()->groupBy('barcode');
                    // $dataRiwayat = $this->paginate($myCollectionObj, 50); //panggil fungsi "paginate di bawah"
                    // return view('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data', compact('dataRiwayat'))->render();
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

    public function storeData(Request $request){
        $allParameters = $request->all();
        // $data = json_encode(array_keys($allParameters)) ;
        // $data2 = json_encode(array_values($allParameters)) ;

        $cek_value_null=false;
        foreach ($allParameters as $key => $value) {
            if ($value == null) {
                $cek_value_null=true;
            }
        }

        if ($cek_value_null == false) {
            $cek_barcode = Pengerjaan::where('barcode', $request->codeScan)->get();
        
            if(count($cek_barcode)<=0){
                foreach ($allParameters as $key => $value) {
                    $tmp_name=explode("Persen",$key);
                    if (count($tmp_name)==2) {
                        if ($tmp_name[0] =='nm') {
                            $data = Pengerjaan::create([
                                'users_id' =>$value,
                                'harga_jasas_id' =>$request->nmJasa,
                                'persentases_id' =>$tmp_name[1],
                                'status_pengerjaan' => '0',
                                'barcode' =>$request->codeScan,
                            ]);
                            
                        }
                    }
                    
                }
                return response()->json(count($cek_barcode));
            }else{
                return response()->json(['errPer'=>'Proses tambah data tidak di izinkan jika "barcode" sudah terdaftar']);
            }

        }elseif ($cek_value_null == true) {
            return response()->json(['errPer'=>'Proses tambah data tidak di izinkan jika semua "input field" belum diisi']);
            
        }
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
            $n=0;
            $v='';
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

    public function deleteData($id){
        $cust = Pengerjaan::where('barcode',$id)->delete();
        return response()->json($cust);
    }

    public function checkPaymentjeData($id){
        $get_one_detail_pembayaran = Detail_pembayaran::with(['pembayarans.users', 'pembayarans', 'pengerjaans.harga_jasas.jasas', 'pengerjaans.harga_jasas', 'pengerjaans.persentases.bagians', 'pengerjaans.persentases'])->where('pengerjaans_id', $id)->first();
        
        if ($get_one_detail_pembayaran !=null) {
            $id_pembayaran = $get_one_detail_pembayaran['pembayarans_id'];
            $dt_detail_pembayaran = Detail_pembayaran::with(['pembayarans.users', 'pembayarans', 'pengerjaans.harga_jasas.jasas', 'pengerjaans.harga_jasas', 'pengerjaans.persentases.bagians', 'pengerjaans.persentases'])->where('pembayarans_id', $id_pembayaran)->OrderBy('id','DESC')->get()->groupBy('pengerjaans.barcode');
            return response()->json($dt_detail_pembayaran);
        }else{
            return response()->json(['errPer'=>'jasa belum di lakukkan transaksi pembayaran']);
        }
       
    }



    public function test(){
        // echo 'sdsdsd';
        // $persentase_bagian = Persentase::with(['bagians'])->where('status_persentase', 1)->get();
        
        // echo $persentase_bagian[3];
        // echo '<br>';
        // echo '<br>';

        // $text="nmPersen4";
        // $t=explode("Persen",$text);
        // print_r($t);
        // echo $t[0];
        // echo '<br>';
        // echo count($t);

        // $cek_barcode = Pengerjaan::where('barcode', '4902430745703')->get()->first();
        
        // echo( $cek_barcode);
        // echo '<br>';
        // // echo count($cek_barcode);
        // echo '<br>';
        // if($cek_barcode){
        //     echo "not empty";
        // }
        // elseif (!$cek_barcode) {
        //     echo 'empty';
        //     # code...
        // }
        // $users = User::select('name')->groupBy('name')->get()->toArray() ;

        // $data =Pengerjaan::OrderBy('id','DESC')->get();
        // $g=$data->groupBy('barcode');



        // pengerjaann
        // query untuk menampilkan jasa yg sudah di kerjakan 
        // $data =Pengerjaan::get()->groupBy('barcode');
        // // echo($data);
        // foreach ($data as $keyRow => $valueRow) {
        //     echo "<br>";
        //     // echo $keyRow;
        //     echo $valueRow[0];
        //     echo "<br>";
        //     echo $valueRow[0]->barcode.'--'.$valueRow[0]->harga_jasas_id ;
        //     echo "<br>";
            
            
        // }
        // dd($data);


        // $data =Pengerjaan::with(['users.roles', 'users', 'harga_jasas', 'persentases'])->take(10)->get()->groupBy('barcode');
        // $data = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->take(10)->get()->groupBy('barcode');

        // $data = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->take(10)->get()->groupBy('persentases_id');
        // $data = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->take(12)->get()->groupBy('users_id');
        // $result = [];
        // echo '<br>';
        // foreach ($data as $key => $value) {
        //     $len = count($value);
        //     $tmp_penghasilan=0;
        //     foreach ($value as $key2 => $value2) {
                
        //         $tmp_persentase_keuntungan = ($value2->harga_jasas->nominal_harga_jasa * $value2->persentases->nilai_persentase) / 100;
                
        //         $tmp_penghasilan += $tmp_persentase_keuntungan;
        //         echo '<br>'.$value2->users_id.'-'.$value2->barcode.'-'.$value2->harga_jasas_id.'-'.$value2->harga_jasas->nominal_harga_jasa.'-'.$value2->persentases_id.'-'.$value2->persentases->nilai_persentase.'--'.$tmp_persentase_keuntungan;
        //         if ($key2 == ($len-1)) {
        //             echo '++++'.$tmp_penghasilan.'---last <br>';
        //             $result[$value2->users_id] = [$value2->users->name => $tmp_penghasilan];
        //         }
        //     }
            
        // }
        // print_r($result);





        // $data =Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->get()->groupBy('barcode');
        // echo($data);
        // foreach ($data as $keyRow => $valueRow) {
        //     echo "<br>";
        //     // echo $keyRow;
        //     echo $valueRow[0];
        //     echo "<br>";
        //     echo $valueRow[0]->barcode.'--'.$valueRow[0]->harga_jasas->jasas->nama_jasa.'--'.$valueRow[0]->harga_jasas->nominal_harga_jasa.'--'.$valueRow[0]->users->roles->namerole ;
        //     echo "<br>";
            
            
        // }
        // dd($data);

        // $data_all =Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->get();
        
        // $data_today =Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->get();
        // $data_week =Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        // $data_month =Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();
        // $data_year =Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->get();
        

        // $r='2022-01-04 15:14:14';
        // // $o= (new Carbon('first day of December 2008')->addDays(5));
        // $mutable = Carbon::now();
        // $today2 =Carbon::today();
        // $today = Carbon::now()->isoFormat('D MMMM Y');
        // // "28 Juni 2020"

        // $today = Carbon::now()->isoFormat('dddd, D MMMM Y');
        // // "Minggu, 28 Juni 2020"

        // $today = Carbon::now()->isoFormat('dddd, D MMM Y');
        // // "Minggu, 28 Jun 2020"

        // // $registeredAt = $user->created_at->isoFormat('dddd, D MMMM Y');
        // // // "Minggu, 28 Juni 2020"

        // // $lastUpdated = $post->updated_at->diffForHumans(); 
        // // "2 hari yang lalu"
        // echo $mutable;
        // echo "<br>";
        // echo $today2;
        // echo "<br>";
        // echo $today;
        // echo "<br>";
        // echo $data_all[0]->created_at;
        // echo "<br>";
        // echo $data_all[0]->created_at->diffForHumans();
        // echo "<br>";
        // // echo $data[35]->created_at;
        // // echo "<br>";
        // // echo $data[35]->created_at->diffForHumans();
    

        // dd($data_month);



        $data = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->take(12)->get()->groupBy('barcode');
        

        
        // $data2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->take(12)->get()->groupBy('persentases.bagians.id');
        // // print_r($data[121]->harga_jasas->jasas->nama_jasa);
        // $tmp_data=array_keys($data2->toArray());
        // print_r($tmp_data);
        // foreach ($data as $key => $value) {
        //     // echo '<br>'.$value[0]->persentases->bagians->id;
        //     echo '<br><br>xxxxx';
        //     foreach ($tmp_data as $key2 => $value2) {
        //         // echo '<br>'.$value2;
        //         foreach ($value as $key3 => $value3) {
        //             if ($value2 == $value3->persentases->bagians->id) {
        //                 echo '<br>'.$value2.'--'.$value3->persentases->bagians->id.'--'.$value3->users->name;
        //                 break;
        //             }
        //             // echo '<br>'.$value2.'--'.$value3->persentases->bagians->id;
        //             // break;
        //             // echo '<br>'.$value2.'--'.$value3->persentases->bagians->id;
        //         }

        //     }

        // }




        // $data = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->take(7)->get();
        // $labelBot =[]; 
        // $nilai=[];

        
        // foreach ($data as $key => $value) {
        //     # code...
        //     array_push($labelBot, 'lb'.strval($key));
           
        //     array_push($nilai, $value->users_id);

        // }
        // $dt=["LABELBOT" => $labelBot, "NILAI" => $nilai];

        // print_r($labelBot);
        // print('<br>');
        // print_r($nilai);
        // print('<br>');
        // print_r($dt);

        print('<br>');
        $r='2022-01-04';
        $oo=Carbon::parse($r)->addDays(1)->toDateTimeString();
        $today =Carbon::today()->subWeek(1);
        $minday =Carbon::today()->subDays(1);

        // print($oo);
        print('<br>-----');
        print($today);
        print('<br>');
        print($minday);
        



        
        // $myDataToday = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->get()->groupBy('barcode');
        // $sum_today=0;
        // foreach ($myDataToday as $key => $value) {
        //    $sum_today += $value[0]->harga_jasas->nominal_harga_jasa;
        // }

        // $myDataMinday = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today()->subDays(1))->get()->groupBy('barcode');
        // $sum_minday=0;
        // foreach ($myDataMinday as $key => $value) {
        //    $sum_minday += $value[0]->harga_jasas->nominal_harga_jasa;
        // }

    


        // $week = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','DESC')->take(12)->get()->groupBy('barcode');
        // $week2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','DESC')->take(12)->get()->groupBy(function($item) {
        //             return $item->created_at->format('Y-m-d');
        //         });
        // $week2_barcode=$week2["2022-01-06"]->groupBy('barcode');

        // $week = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','ASC')->get()->groupBy('barcode');
        
        // $week2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','ASC')->get()->groupBy(function($item) {
        //             return $item->created_at->format('Y-m-d');
        //         });
        // $week2_barcode=$week2["2022-01-06"]->groupBy('barcode');

        // $labelBot =[]; 
        // $nilai=[];
        // $lbb=["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];
        // foreach ($lbb as $keyDay => $valueDay) {
        //     $cek_day=false;
        //     foreach ($week2 as $key => $value) {
        //         if ($valueDay == Carbon::parse($key)->isoFormat('dddd')) {
        //             $groub_barcode=$week2[$key]->groupBy('barcode');
        //             $tmp_sum=0;
        //             foreach ($groub_barcode as $key2 => $value2) {
        //                 $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
        //             }
        //             array_push($labelBot, Carbon::parse($key)->isoFormat('dddd'));
        //             array_push($nilai, $tmp_sum);
        //             $cek_day=true;
        //             break;
        //         }
                
        //     }
        //     if ($cek_day == false) {
        //         array_push($nilai, 0);
        //         array_push($labelBot, $valueDay);
        //     }
        // }

        // foreach ($week2 as $key => $value) {
        //     // echo '<br>--'.$key;
        //     $groub_barcode=$week2[$key]->groupBy('barcode');
        //     $tmp_sum=0;
        //     foreach ($groub_barcode as $key2 => $value2) {
        //         $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
        //         # code...
        //         // echo '<br>'.$value2[0]->harga_jasas->nominal_harga_jasa;
        //     }
        //     array_push($labelBot, Carbon::parse($key)->isoFormat('dddd'));
        //     array_push($nilai, $tmp_sum);
        //     echo '<br>';
        // }
        // $nilai = array_reverse($nilai);


        // $tt= Carbon::now()->isoFormat('MMMM');
        // echo $tt.'<br>';
        // $tt2="2022-01-06";
        // echo Carbon::parse($tt2)->isoFormat('MMMM');

        $lbb=["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];
        $previous_week = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::today()->subWeek(1)->startOfWeek(), Carbon::today()->subWeek(1)->endOfWeek()])->OrderBy('id','ASC')->get()->groupBy(function($item) {
                    return $item->created_at->format('Y-m-d');
                });

        $labelBot_previous_week =[]; 
        $nilai_previous_week=[];
        foreach ($lbb as $keyDay => $valueDay) {
            // echo $valueDay."<br>";
            $cek_day=false;
            foreach ($previous_week as $key => $value) {
                // echo '<br>@@@@';
                    if ($valueDay == Carbon::parse($key)->isoFormat('dddd')) {
                        // echo '<br>'.$valueDay.'======'.Carbon::parse($key)->isoFormat('dddd');
                        $groub_barcode=$previous_week[$key]->groupBy('barcode');
                        $tmp_sum=0;
                        foreach ($groub_barcode as $key2 => $value2) {
                            $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                        }
                        array_push($labelBot_previous_week, Carbon::parse($key)->isoFormat('dddd'));
                        array_push($nilai_previous_week, $tmp_sum);
                        $cek_day=true;
                        break;
                    }
            }
            if ($cek_day == false) {
                array_push($nilai_previous_week, 0);
                array_push($labelBot_previous_week, $valueDay);
            }
        }






        

        // $m2 =Carbon::today()->subMonths(1)->isoFormat('MM');
        // $y2 =Carbon::today()->subMonths(1)->isoFormat('Y');
        // $d2 =Carbon::today()->subMonths(1)->isoFormat('D');
        // echo '<br>'.$m2;
        // echo '<br>'.$y2;
        // echo '<br>'.$d2;
        // if ($d2 == 07) {
        //     echo '----';
        // }
        
        // echo'<br>';
        // echo '<br>'.date('m');
        // echo'<br>'.date('Y');


        
        // $month2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->OrderBy('id','ASC')->get()->groupBy(function($item) {
        //     return $item->created_at->format('Y-m-d');
        // });
        // $previous_month2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', $m2)->whereYear('created_at', $y2)->OrderBy('id','ASC')->get()->groupBy(function($item) {
        //     return $item->created_at->format('Y-m-d');
        // });

        // $lbb=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];

        // $labelBot_month =[]; 
        // $nilai_month=[];
        // foreach ($lbb as $keyDay => $valueTGL) {
        //     // echo $valueTGL."<br>";
        //     $cek_day=false;
        //     foreach ($month2 as $key => $value) {
        //         // echo '<br>@@@@';
        //             if ($valueTGL == Carbon::parse($key)->isoFormat('D')) {
        //                 echo '<br>'.$valueTGL.'======'.Carbon::parse($key)->isoFormat('D');
        //                 $groub_barcode=$month2[$key]->groupBy('barcode');
        //                 $tmp_sum=0;
        //                 foreach ($groub_barcode as $key2 => $value2) {
        //                     $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
        //                 }
        //                 array_push($labelBot_month, Carbon::parse($key)->isoFormat('D'));
        //                 array_push($nilai_month, $tmp_sum);
        //                 $cek_day=true;
        //                 break;
        //             }
        //     }
        //     if ($cek_day == false) {
        //         array_push($nilai_month, 0);
        //         array_push($labelBot_month, $valueTGL);
        //     }
        // }
        // print_r($labelBot_month);
        // echo '<br>'; echo '<br>';
        // print_r($nilai_month);
        // echo '<br>'; echo '<br>'; echo '<br>'; echo '<br>';


        // $labelBot_previous_month =[]; 
        // $nilai_previous_month=[];
        // foreach ($lbb as $keyDay => $valueTGL) {
        //     // echo $valueTGL."<br>";
        //     $cek_day=false;
        //     foreach ($previous_month2 as $key => $value) {
        //         // echo '<br>@@@@';
        //             if ($valueTGL == Carbon::parse($key)->isoFormat('D')) {
        //                 echo '<br>'.$valueTGL.'======'.Carbon::parse($key)->isoFormat('D');
        //                 $groub_barcode=$previous_month2[$key]->groupBy('barcode');
        //                 $tmp_sum=0;
        //                 foreach ($groub_barcode as $key2 => $value2) {
        //                     $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
        //                 }
        //                 array_push($labelBot_previous_month, Carbon::parse($key)->isoFormat('D'));
        //                 array_push($nilai_previous_month, $tmp_sum);
        //                 $cek_day=true;
        //                 break;
        //             }
        //     }
        //     if ($cek_day == false) {
        //         array_push($nilai_previous_month, 0);
        //         array_push($labelBot_previous_month, $valueTGL);
        //     }
        // }
        // print_r($labelBot_previous_month);
        // echo '<br>'; echo '<br>';
        // print_r($nilai_previous_month);

        // $m2 =Carbon::today()->subYear(1)->isoFormat('MM');
        // $y2 =Carbon::today()->subYear(1)->isoFormat('Y');
        // $d2 =Carbon::today()->subYear(1)->isoFormat('D');
        // echo '<br>'.$m2;
        // echo '<br>'.$y2;
        // echo '<br>'.$d2;
 



        // $year2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->OrderBy('id','ASC')->get()->groupBy(function($item) {
        //     return $item->created_at->format('M');
        // });
        // $previous_year2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', Carbon::today()->subYear(1))->OrderBy('id','ASC')->get()->groupBy(function($item) {
        //     return $item->created_at->format('M');
        // });

        // $lbb=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

        // $labelBot_year =[]; 
        // $nilai_year=[];
        // foreach ($lbb as $keyMonth => $valueMonth) {
        //     $cek_day=false;
        //     foreach ($year2 as $key => $value) {
        //         if ($valueMonth == $key) {
        //             echo '<br>'.$valueMonth.'======'.$key;
        //             $groub_barcode=$year2[$key]->groupBy('barcode');
        //             $tmp_sum=0;
        //             foreach ($groub_barcode as $key2 => $value2) {
        //                 $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
        //             }
        //             array_push($labelBot_year, $key);
        //             array_push($nilai_year, $tmp_sum);
        //             $cek_day=true;
        //             break;
        //         }
                
        //     }
        //     if ($cek_day == false) {
        //         array_push($nilai_year, 0);
        //         array_push($labelBot_year, $valueMonth);
        //     }
        // }
        // print_r($labelBot_year);
        // echo '<br>'; echo '<br>';
        // print_r($nilai_year);



        // $labelBot_previous_year =[]; 
        // $nilai_previous_year=[];
        // foreach ($lbb as $keyMonth => $valueMonth) {
        //     $cek_day=false;
        //     foreach ($previous_year2 as $key => $value) {
        //         if ($valueMonth == $key) {
        //             echo '<br>'.$valueMonth.'======'.$key;
        //             $groub_barcode=$previous_year2[$key]->groupBy('barcode');
        //             $tmp_sum=0;
        //             foreach ($groub_barcode as $key2 => $value2) {
        //                 $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
        //             }
        //             array_push($labelBot_previous_year, $key);
        //             array_push($nilai_previous_year, $tmp_sum);
        //             $cek_day=true;
        //             break;
        //         }
                
        //     }
        //     if ($cek_day == false) {
        //         array_push($nilai_previous_year, 0);
        //         array_push($labelBot_previous_year, $valueMonth);
        //     }
        // }
        // echo '<br>'; echo '<br>';
        // echo '<br>'; echo '<br>';
        // echo '<br>'; echo '<br>';
        // print_r($labelBot_previous_year);
        // echo '<br>'; echo '<br>';
        // print_r($nilai_previous_year);

        // echo '<br>--'.Carbon::today();
        // $reqDate1="2021-01-01";
        // $reqDate2="2022-01-09";
        // $tmp_start_date = Carbon::parse($reqDate1)->toDateTimeString();
        // $tmp_end_date = Carbon::parse($reqDate2)->toDateTimeString();
        // echo '<br>--'.$tmp_start_date;
        // echo '<br>--'.$tmp_end_date;
        // $selectedYear = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->OrderBy('id','ASC')->get()->groupBy(function($item) {
        //     return $item->created_at->format('Y');
        // });

        //  $labelBot_selectedYear =[]; 
        // $nilai_selectedYear=[];
        // foreach ($selectedYear as $key => $value) {
        //     echo '<br>'.$key;
        //     $tmp_sum=0;
        //     $groub_barcode=$value->groupBy('barcode');
        //     foreach ($groub_barcode as $key2 => $value2) {
        //         $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
        //     }
        //     array_push($labelBot_selectedYear, $key);
        //     array_push($nilai_selectedYear, $tmp_sum);

            
        // }
        // print_r($labelBot_selectedYear);
        // echo '<br>'; echo '<br>';
        // print_r($nilai_selectedYear);

        // $dt_pembayaran = Detail_pembayaran::with(['pembayarans.users', 'pembayarans', 'pengerjaans.harga_jasas.jasas', 'pengerjaans.harga_jasas', 'pengerjaans.persentases.bagians', 'pengerjaans.persentases'])->whereDate('created_at', Carbon::today())->OrderBy('id','DESC')->get()->groupBy('pembayarans_id');
        // $dt_detail_pembayaran = Detail_pembayaran::with(['pembayarans.users', 'pembayarans', 'pengerjaans.harga_jasas.jasas', 'pengerjaans.harga_jasas', 'pengerjaans.persentases.bagians', 'pengerjaans.persentases'])->where('pembayarans_id', '16')->OrderBy('id','DESC')->get()->groupBy('pengerjaans.barcode');
        
        // $myCollectionObj = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->where('status_pengerjaan','1')->OrderBy('id','DESC')->get()->groupBy('barcode');
        
        // dd($myCollectionObj);

        dd(User::OrderBy('id','DESC')->get());

        




        
        

        
    }
}
