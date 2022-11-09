<?php

namespace App\Http\Controllers;

use App\Models\Detail_pembayaran;
use App\Models\Pembayaran;
use App\Models\Pengerjaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class pembayaranController extends Controller
{
    //
    public function index(){
        $dt_pembayaran = Detail_pembayaran::with(['pembayarans.users', 'pembayarans', 'pengerjaans.harga_jasas.jasas', 'pengerjaans.harga_jasas', 'pengerjaans.persentases.bagians', 'pengerjaans.persentases'])->whereDate('created_at', Carbon::today())->OrderBy('id','DESC')->get()->groupBy('pembayarans_id');
        $dataRiwayat = $this->paginate($dt_pembayaran, 6); //panggil fungsi "paginate di bawah"
        
        return view('ViewAdmin.va_pembayaran.va_pembayaran_index', compact('dataRiwayat'));
        
    }

    public function allAjaxData(Request $request){
        if($request->ajax())
        {
            if ($request->chooseBy == 'today') {
                $dt_pembayaran = Detail_pembayaran::with(['pembayarans.users', 'pembayarans', 'pengerjaans.harga_jasas.jasas', 'pengerjaans.harga_jasas', 'pengerjaans.persentases.bagians', 'pengerjaans.persentases'])->whereDate('created_at', Carbon::today())->OrderBy('id','DESC')->get()->groupBy('pembayarans_id');
                $dataRiwayat = $this->paginate($dt_pembayaran, 6); //panggil fungsi "paginate di bawah"
                return view('ViewAdmin.va_pembayaran.va_pembayaran_pagination_data', compact('dataRiwayat'))->render();
            }elseif ($request->chooseBy == 'week') {
                $myCollectionObj = Detail_pembayaran::with(['pembayarans.users', 'pembayarans', 'pengerjaans.harga_jasas.jasas', 'pengerjaans.harga_jasas', 'pengerjaans.persentases.bagians', 'pengerjaans.persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','DESC')->get()->groupBy('pembayarans_id');
                $dataRiwayat = $this->paginate($myCollectionObj, 6); //panggil fungsi "paginate di bawah"
                return view('ViewAdmin.va_pembayaran.va_pembayaran_pagination_data', compact('dataRiwayat'))->render();
            }elseif ($request->chooseBy == 'month') {
                $myCollectionObj = Detail_pembayaran::with(['pembayarans.users', 'pembayarans', 'pengerjaans.harga_jasas.jasas', 'pengerjaans.harga_jasas', 'pengerjaans.persentases.bagians', 'pengerjaans.persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('pembayarans_id');
                $dataRiwayat = $this->paginate($myCollectionObj, 6); //panggil fungsi "paginate di bawah"
                return view('ViewAdmin.va_pembayaran.va_pembayaran_pagination_data', compact('dataRiwayat'))->render();
            }elseif ($request->chooseBy == 'year') {
                $myCollectionObj = Detail_pembayaran::with(['pembayarans.users', 'pembayarans', 'pengerjaans.harga_jasas.jasas', 'pengerjaans.harga_jasas', 'pengerjaans.persentases.bagians', 'pengerjaans.persentases'])->whereYear('created_at', date('Y'))->OrderBy('id','DESC')->get()->groupBy('pembayarans_id');
                $dataRiwayat = $this->paginate($myCollectionObj, 6); //panggil fungsi "paginate di bawah"
                return view('ViewAdmin.va_pembayaran.va_pembayaran_pagination_data', compact('dataRiwayat'))->render();
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
                    $myCollectionObj = Detail_pembayaran::with(['pembayarans.users', 'pembayarans', 'pengerjaans.harga_jasas.jasas', 'pengerjaans.harga_jasas', 'pengerjaans.persentases.bagians', 'pengerjaans.persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->OrderBy('id','DESC')->get()->groupBy('pembayarans_id');
                    $dataRiwayat = $this->paginate($myCollectionObj, 7); //panggil fungsi "paginate di bawah"
                    return view('ViewAdmin.va_pembayaran.va_pembayaran_pagination_data', compact('dataRiwayat'))->render();
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
        $request->validate(
        [
            'codeScan' => 'required|max:50',
        ],

        [
            'codeScan.required'=> 'Code scan belum diisi',
            'codeScan.max'=> 'Code scan tidak boleh lebih dari 50 karakter',
            
        ]);

  
        $data = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->where('barcode', $request->codeScan)->first();
        
        
        if ($data != null) {
            if ($request->session()->has('sesCart')) {
                if ($data->status_pengerjaan == 0) {
                    $collection = collect(session('sesCart'));
                    $check_code=true;
                    foreach ($collection as $key => $value) {
                        if ($value[0] == $request->codeScan) {
                            $check_code=false;
                        }
                    }
                    if ($check_code==false) {
                        return response()->json(['errPer'=>'Code sudah terdaftar di list pembayaran'],422);
                    }elseif ($check_code=true) {
                        $request->session()->push('sesCart',[$data->barcode, $data->harga_jasas->jasas->nama_jasa,$data->harga_jasas->nominal_harga_jasa]);
                        return response()->json($data);
                    }
                }elseif ($data->status_pengerjaan == 1) {
                    return response()->json(['errPer'=>'Code yang sudah di lakukan transaksi pembayaran tidak diizinkan di scan ulang'],422);
                }

                
            }
            else{
                if ($data->status_pengerjaan == 0) {
                    $request->session()->push('sesCart',[$data->barcode, $data->harga_jasas->jasas->nama_jasa,$data->harga_jasas->nominal_harga_jasa]);
                    return response()->json($data);
                }elseif ($data->status_pengerjaan == 1) {
                    return response()->json(['errPer'=>'Code yang sudah di lakukan transaksi pembayaran tidak diizinkan di scan ulang'],422);
                }
                // $request->session()->push('sesCart',[$data->barcode, $data->harga_jasas->jasas->nama_jasa,$data->harga_jasas->nominal_harga_jasa]);
                // return response()->json($data);
            }
            
            return response()->json($data);
        }elseif ($data == null) {
            return response()->json(['errPer'=>'Code scan belum terdaftar'],422);
        }
        
    }

    public function cancelData(Request $request){
        $request->session()->forget('sesCart');
        return response()->json(("list pembayaran berhasil dihapus") );
    }

    // print and save to database
    public function printData(Request $request){
        $request->validate(
            [
                // 'tunai' => 'required|numeric',
                'tunai' => 'required',
            ],
            [
                'tunai.required'=> 'Tunai belum diisi',
                'tunai.max'=> 'Tunai tidak boleh lebih dari 50 karakter',
                // 'tunai.numeric'=> 'Tunai harus angka',
            ]);

            if ($request->session()->has('sesCart')) {
                $total_pembayaran=0;
                $collection = collect(session('sesCart'));
                foreach ($collection as $key => $value) {
                    $total_pembayaran += $value[2];
                }
                $kembalian = $request->tunai - $total_pembayaran;

                if (($kembalian >=0)) {
                    // ...SUKSES
                    $PembayaranId = Pembayaran::insertGetId([
                        'users_id' => auth()->user()->id,
                        'total_pembayaran' => $total_pembayaran,
                        'tunai_pembayaran' => $request->tunai]);
                    
                    foreach ($collection as $key2 => $value2) {
                        $selectPengerjaan = Pengerjaan::where('barcode',  $value2[0])->get();
                        foreach ($selectPengerjaan as $keyP => $valueP) {
                            $dataDetailPembayaran = Detail_pembayaran::create([
                                'pembayarans_id' => $PembayaranId,
                                'pengerjaans_id' => $valueP->id]);
                                $updatePengerjaan = Pengerjaan::where('id',$valueP->id)->update([
                                'status_pengerjaan' => '1',
                            ]);
                        }
                    }

                    $collection = collect(session('sesCart'));
                    $request->session()->forget('sesCart');
                    return response()->json($collection);
                }else{
                    return response()->json(['errPer'=>'Tunai tidak mencukupi'],422);
                }
                return response()->json( $total_pembayaran);
            }else{
                return response()->json(['errPer'=>'list pembayaran kosong'],422);
            }
        
        return response()->json(($request) );
    }

    public function editData($id){
        $dt_detail_pembayaran = Detail_pembayaran::with(['pembayarans.users', 'pembayarans', 'pengerjaans.harga_jasas.jasas', 'pengerjaans.harga_jasas', 'pengerjaans.persentases.bagians', 'pengerjaans.persentases'])->where('pembayarans_id', $id)->OrderBy('id','DESC')->get()->groupBy('pengerjaans.barcode');
        
        return response()->json($dt_detail_pembayaran);
    }


    public function printOneHistoryData($id){
        $dt_detail_pembayaran = Detail_pembayaran::with(['pembayarans.users', 'pembayarans', 'pengerjaans.harga_jasas.jasas', 'pengerjaans.harga_jasas', 'pengerjaans.persentases.bagians', 'pengerjaans.persentases'])->where('pembayarans_id', $id)->OrderBy('id','DESC')->get()->groupBy('pengerjaans.barcode');
        return response()->json($dt_detail_pembayaran);
    }

    public function deleteData($id){
        $dt_detail_pembayaran = Detail_pembayaran::with(['pembayarans.users', 'pembayarans', 'pengerjaans.harga_jasas.jasas', 'pengerjaans.harga_jasas', 'pengerjaans.persentases.bagians', 'pengerjaans.persentases'])->where('pembayarans_id', $id)->OrderBy('id','DESC')->get()->groupBy('pengerjaans.barcode');
        foreach ($dt_detail_pembayaran as $key => $value) {
            $updatePengerjaan = Pengerjaan::where('barcode',  $key)->update([
                'status_pengerjaan' => '0',
            ]);
        }
        $cust = Pembayaran::where('id',$id)->delete();
        return response()->json("data berhasil dihapus");
    }


}
