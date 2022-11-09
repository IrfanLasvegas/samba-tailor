<?php

namespace App\Http\Controllers;

use App\Models\Pengerjaan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GrafikController extends Controller
{
    //
    public function index(){
        
        return view('ViewAdmin.va_grafik.va_grafik_index');
        
    }

    public function harianData(Request $request){
        $sum_today=0;
        $sum_minday=0;
        

        if ($request->statusPembayaran == 'all') {
            $myDataToday = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->get()->groupBy('barcode');
            foreach ($myDataToday as $key => $value) {
                $sum_today += $value[0]->harga_jasas->nominal_harga_jasa;
            }
            $myDataMinday = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today()->subDays(1))->get()->groupBy('barcode');
            foreach ($myDataMinday as $key => $value) {
                $sum_minday += $value[0]->harga_jasas->nominal_harga_jasa;
            }
        } elseif ($request->statusPembayaran == 'done') {
            $myDataToday = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->where('status_pengerjaan','1')->get()->groupBy('barcode');
            foreach ($myDataToday as $key => $value) {
                $sum_today += $value[0]->harga_jasas->nominal_harga_jasa;
            }
            $myDataMinday = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today()->subDays(1))->where('status_pengerjaan','1')->get()->groupBy('barcode');
            foreach ($myDataMinday as $key => $value) {
                $sum_minday += $value[0]->harga_jasas->nominal_harga_jasa;
            }
        }elseif ($request->statusPembayaran == 'notYet') {
            $myDataToday = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today())->where('status_pengerjaan','0')->get()->groupBy('barcode');
            foreach ($myDataToday as $key => $value) {
                $sum_today += $value[0]->harga_jasas->nominal_harga_jasa;
            }
            $myDataMinday = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereDate('created_at', Carbon::today()->subDays(1))->where('status_pengerjaan','0')->get()->groupBy('barcode');
            foreach ($myDataMinday as $key => $value) {
                $sum_minday += $value[0]->harga_jasas->nominal_harga_jasa;
            }
        }
        

        $labelBot =["Kemarin", "Hari ini"]; 
        $nilai=[$sum_minday, $sum_today];
        $dt=["LABELBOT" => $labelBot, "NILAI" => $nilai];
        return response()->json($dt);
    }









    public function mingguanData(Request $request){
        $lbb=["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];
        
        $labelBot =[]; 
        $nilai=[];

        $labelBot_previous_week =[]; 
        $nilai_previous_week=[];

        if ($request->statusPembayaran == 'all') {
            $week2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });
            foreach ($lbb as $keyDay => $valueDay) {
                $cek_day=false;
                foreach ($week2 as $key => $value) {
                    if ($valueDay == Carbon::parse($key)->isoFormat('dddd')) {
                        $groub_barcode=$week2[$key]->groupBy('barcode');
                        $tmp_sum=0;
                        foreach ($groub_barcode as $key2 => $value2) {
                            $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                        }
                        array_push($labelBot, Carbon::parse($key)->isoFormat('dddd'));
                        array_push($nilai, $tmp_sum);
                        $cek_day=true;
                        break;
                    }
                }
                if ($cek_day == false) {
                    array_push($nilai, 0);
                    array_push($labelBot, $valueDay);
                }
            }
            $previous_week = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::today()->subWeek(1)->startOfWeek(), Carbon::today()->subWeek(1)->endOfWeek()])->OrderBy('id','ASC')->get()->groupBy(function($item) {
                                return $item->created_at->format('Y-m-d');
                            });
            foreach ($lbb as $keyDay => $valueDay) {
                $cek_day=false;
                foreach ($previous_week as $key => $value) {
                        if ($valueDay == Carbon::parse($key)->isoFormat('dddd')) {
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
        } elseif ($request->statusPembayaran == 'done') {
            $week2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status_pengerjaan','1')->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });
            foreach ($lbb as $keyDay => $valueDay) {
                $cek_day=false;
                foreach ($week2 as $key => $value) {
                    if ($valueDay == Carbon::parse($key)->isoFormat('dddd')) {
                        $groub_barcode=$week2[$key]->groupBy('barcode');
                        $tmp_sum=0;
                        foreach ($groub_barcode as $key2 => $value2) {
                            $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                        }
                        array_push($labelBot, Carbon::parse($key)->isoFormat('dddd'));
                        array_push($nilai, $tmp_sum);
                        $cek_day=true;
                        break;
                    }
                }
                if ($cek_day == false) {
                    array_push($nilai, 0);
                    array_push($labelBot, $valueDay);
                }
            }
            $previous_week = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::today()->subWeek(1)->startOfWeek(), Carbon::today()->subWeek(1)->endOfWeek()])->where('status_pengerjaan','1')->OrderBy('id','ASC')->get()->groupBy(function($item) {
                                return $item->created_at->format('Y-m-d');
                            });
            foreach ($lbb as $keyDay => $valueDay) {
                $cek_day=false;
                foreach ($previous_week as $key => $value) {
                        if ($valueDay == Carbon::parse($key)->isoFormat('dddd')) {
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
        }elseif ($request->statusPembayaran == 'notYet') {
            $week2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status_pengerjaan','0')->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });
            foreach ($lbb as $keyDay => $valueDay) {
                $cek_day=false;
                foreach ($week2 as $key => $value) {
                    if ($valueDay == Carbon::parse($key)->isoFormat('dddd')) {
                        $groub_barcode=$week2[$key]->groupBy('barcode');
                        $tmp_sum=0;
                        foreach ($groub_barcode as $key2 => $value2) {
                            $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                        }
                        array_push($labelBot, Carbon::parse($key)->isoFormat('dddd'));
                        array_push($nilai, $tmp_sum);
                        $cek_day=true;
                        break;
                    }
                }
                if ($cek_day == false) {
                    array_push($nilai, 0);
                    array_push($labelBot, $valueDay);
                }
            }
            $previous_week = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at', [Carbon::today()->subWeek(1)->startOfWeek(), Carbon::today()->subWeek(1)->endOfWeek()])->where('status_pengerjaan','0')->OrderBy('id','ASC')->get()->groupBy(function($item) {
                                return $item->created_at->format('Y-m-d');
                            });
            foreach ($lbb as $keyDay => $valueDay) {
                $cek_day=false;
                foreach ($previous_week as $key => $value) {
                        if ($valueDay == Carbon::parse($key)->isoFormat('dddd')) {
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
        }

        $dt=["LABELBOT" => $lbb, "NILAI" => [["LBL"=>"Minggu ini","NLI"=>$nilai],
                                            ["LBL"=>"Minggu kemarin","NLI"=>$nilai_previous_week]]];
        return response()->json($dt);
    }












    public function bulananData(Request $request){
        $m2 =Carbon::today()->subMonths(1)->isoFormat('MM');
        $y2 =Carbon::today()->subMonths(1)->isoFormat('Y');

        $lbb=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];
        $lbbSTR=["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"];

        $labelBot_month =[]; 
        $nilai_month=[];
        $labelBot_previous_month =[]; 
        $nilai_previous_month=[];

        if ($request->statusPembayaran == 'all') {
            $month2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });
            $previous_month2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', $m2)->whereYear('created_at', $y2)->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });
            foreach ($lbb as $keyDay => $valueTGL) {
                $cek_day=false;
                foreach ($month2 as $key => $value) {
                    if ($valueTGL == Carbon::parse($key)->isoFormat('D')) {
                        $groub_barcode=$month2[$key]->groupBy('barcode');
                        $tmp_sum=0;
                        foreach ($groub_barcode as $key2 => $value2) {
                            $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                        }
                        array_push($labelBot_month, Carbon::parse($key)->isoFormat('D'));
                        array_push($nilai_month, $tmp_sum);
                        $cek_day=true;
                        break;
                    }
                }
                if ($cek_day == false) {
                    array_push($nilai_month, 0);
                    array_push($labelBot_month, $valueTGL);
                }
            }
            foreach ($lbb as $keyDay => $valueTGL) {
                $cek_day=false;
                foreach ($previous_month2 as $key => $value) {
                        if ($valueTGL == Carbon::parse($key)->isoFormat('D')) {
                            $groub_barcode=$previous_month2[$key]->groupBy('barcode');
                            $tmp_sum=0;
                            foreach ($groub_barcode as $key2 => $value2) {
                                $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                            }
                            array_push($labelBot_previous_month, Carbon::parse($key)->isoFormat('D'));
                            array_push($nilai_previous_month, $tmp_sum);
                            $cek_day=true;
                            break;
                        }
                }
                if ($cek_day == false) {
                    array_push($nilai_previous_month, 0);
                    array_push($labelBot_previous_month, $valueTGL);
                }
            }
        } elseif ($request->statusPembayaran == 'done') {
            $month2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status_pengerjaan','1')->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });
            $previous_month2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', $m2)->whereYear('created_at', $y2)->where('status_pengerjaan','1')->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });
            foreach ($lbb as $keyDay => $valueTGL) {
                $cek_day=false;
                foreach ($month2 as $key => $value) {
                    if ($valueTGL == Carbon::parse($key)->isoFormat('D')) {
                        $groub_barcode=$month2[$key]->groupBy('barcode');
                        $tmp_sum=0;
                        foreach ($groub_barcode as $key2 => $value2) {
                            $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                        }
                        array_push($labelBot_month, Carbon::parse($key)->isoFormat('D'));
                        array_push($nilai_month, $tmp_sum);
                        $cek_day=true;
                        break;
                    }
                }
                if ($cek_day == false) {
                    array_push($nilai_month, 0);
                    array_push($labelBot_month, $valueTGL);
                }
            }
            foreach ($lbb as $keyDay => $valueTGL) {
                $cek_day=false;
                foreach ($previous_month2 as $key => $value) {
                        if ($valueTGL == Carbon::parse($key)->isoFormat('D')) {
                            $groub_barcode=$previous_month2[$key]->groupBy('barcode');
                            $tmp_sum=0;
                            foreach ($groub_barcode as $key2 => $value2) {
                                $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                            }
                            array_push($labelBot_previous_month, Carbon::parse($key)->isoFormat('D'));
                            array_push($nilai_previous_month, $tmp_sum);
                            $cek_day=true;
                            break;
                        }
                }
                if ($cek_day == false) {
                    array_push($nilai_previous_month, 0);
                    array_push($labelBot_previous_month, $valueTGL);
                }
            }
        }elseif ($request->statusPembayaran == 'notYet') {
            $month2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status_pengerjaan','0')->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });
            $previous_month2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereMonth('created_at', $m2)->whereYear('created_at', $y2)->where('status_pengerjaan','0')->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });
            foreach ($lbb as $keyDay => $valueTGL) {
                $cek_day=false;
                foreach ($month2 as $key => $value) {
                    if ($valueTGL == Carbon::parse($key)->isoFormat('D')) {
                        $groub_barcode=$month2[$key]->groupBy('barcode');
                        $tmp_sum=0;
                        foreach ($groub_barcode as $key2 => $value2) {
                            $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                        }
                        array_push($labelBot_month, Carbon::parse($key)->isoFormat('D'));
                        array_push($nilai_month, $tmp_sum);
                        $cek_day=true;
                        break;
                    }
                }
                if ($cek_day == false) {
                    array_push($nilai_month, 0);
                    array_push($labelBot_month, $valueTGL);
                }
            }
            foreach ($lbb as $keyDay => $valueTGL) {
                $cek_day=false;
                foreach ($previous_month2 as $key => $value) {
                        if ($valueTGL == Carbon::parse($key)->isoFormat('D')) {
                            $groub_barcode=$previous_month2[$key]->groupBy('barcode');
                            $tmp_sum=0;
                            foreach ($groub_barcode as $key2 => $value2) {
                                $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                            }
                            array_push($labelBot_previous_month, Carbon::parse($key)->isoFormat('D'));
                            array_push($nilai_previous_month, $tmp_sum);
                            $cek_day=true;
                            break;
                        }
                }
                if ($cek_day == false) {
                    array_push($nilai_previous_month, 0);
                    array_push($labelBot_previous_month, $valueTGL);
                }
            }
        }

        

        $dt=["LABELBOT" => $lbbSTR, "NILAI" => [["LBL"=>"Bulan ini","NLI"=>$nilai_month],
                                            ["LBL"=>"Bulan kemarin","NLI"=>$nilai_previous_month]]];
        return response()->json($dt);
    }














    public function tahunanData(Request $request){
        $lbb=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
        $lbbSTR=["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Des"];

        $labelBot_year =[]; 
        $nilai_year=[];
        $labelBot_previous_year =[]; 
        $nilai_previous_year=[];

        if ($request->statusPembayaran == 'all') {
            $year2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('M');
            });
            $previous_year2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', Carbon::today()->subYear(1))->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('M');
            });
            foreach ($lbb as $keyMonth => $valueMonth) {
                $cek_day=false;
                foreach ($year2 as $key => $value) {
                    if ($valueMonth == $key) {
                        $groub_barcode=$year2[$key]->groupBy('barcode');
                        $tmp_sum=0;
                        foreach ($groub_barcode as $key2 => $value2) {
                            $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                        }
                        array_push($labelBot_year, $key);
                        array_push($nilai_year, $tmp_sum);
                        $cek_day=true;
                        break;
                    }
                    
                }
                if ($cek_day == false) {
                    array_push($nilai_year, 0);
                    array_push($labelBot_year, $valueMonth);
                }
            }
            foreach ($lbb as $keyMonth => $valueMonth) {
                $cek_day=false;
                foreach ($previous_year2 as $key => $value) {
                    if ($valueMonth == $key) {
                        $groub_barcode=$previous_year2[$key]->groupBy('barcode');
                        $tmp_sum=0;
                        foreach ($groub_barcode as $key2 => $value2) {
                            $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                        }
                        array_push($labelBot_previous_year, $key);
                        array_push($nilai_previous_year, $tmp_sum);
                        $cek_day=true;
                        break;
                    }
                    
                }
                if ($cek_day == false) {
                    array_push($nilai_previous_year, 0);
                    array_push($labelBot_previous_year, $valueMonth);
                }
            }
        } elseif ($request->statusPembayaran == 'done') {
            $year2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->where('status_pengerjaan','1')->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('M');
            });
            $previous_year2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', Carbon::today()->subYear(1))->where('status_pengerjaan','1')->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('M');
            });
            foreach ($lbb as $keyMonth => $valueMonth) {
                $cek_day=false;
                foreach ($year2 as $key => $value) {
                    if ($valueMonth == $key) {
                        $groub_barcode=$year2[$key]->groupBy('barcode');
                        $tmp_sum=0;
                        foreach ($groub_barcode as $key2 => $value2) {
                            $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                        }
                        array_push($labelBot_year, $key);
                        array_push($nilai_year, $tmp_sum);
                        $cek_day=true;
                        break;
                    }
                    
                }
                if ($cek_day == false) {
                    array_push($nilai_year, 0);
                    array_push($labelBot_year, $valueMonth);
                }
            }
            foreach ($lbb as $keyMonth => $valueMonth) {
                $cek_day=false;
                foreach ($previous_year2 as $key => $value) {
                    if ($valueMonth == $key) {
                        $groub_barcode=$previous_year2[$key]->groupBy('barcode');
                        $tmp_sum=0;
                        foreach ($groub_barcode as $key2 => $value2) {
                            $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                        }
                        array_push($labelBot_previous_year, $key);
                        array_push($nilai_previous_year, $tmp_sum);
                        $cek_day=true;
                        break;
                    }
                    
                }
                if ($cek_day == false) {
                    array_push($nilai_previous_year, 0);
                    array_push($labelBot_previous_year, $valueMonth);
                }
            }
        }elseif ($request->statusPembayaran == 'notYet') {
            $year2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', date('Y'))->where('status_pengerjaan','0')->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('M');
            });
            $previous_year2 = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereYear('created_at', Carbon::today()->subYear(1))->where('status_pengerjaan','0')->OrderBy('id','ASC')->get()->groupBy(function($item) {
                return $item->created_at->format('M');
            });
            foreach ($lbb as $keyMonth => $valueMonth) {
                $cek_day=false;
                foreach ($year2 as $key => $value) {
                    if ($valueMonth == $key) {
                        $groub_barcode=$year2[$key]->groupBy('barcode');
                        $tmp_sum=0;
                        foreach ($groub_barcode as $key2 => $value2) {
                            $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                        }
                        array_push($labelBot_year, $key);
                        array_push($nilai_year, $tmp_sum);
                        $cek_day=true;
                        break;
                    }
                    
                }
                if ($cek_day == false) {
                    array_push($nilai_year, 0);
                    array_push($labelBot_year, $valueMonth);
                }
            }
            foreach ($lbb as $keyMonth => $valueMonth) {
                $cek_day=false;
                foreach ($previous_year2 as $key => $value) {
                    if ($valueMonth == $key) {
                        $groub_barcode=$previous_year2[$key]->groupBy('barcode');
                        $tmp_sum=0;
                        foreach ($groub_barcode as $key2 => $value2) {
                            $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                        }
                        array_push($labelBot_previous_year, $key);
                        array_push($nilai_previous_year, $tmp_sum);
                        $cek_day=true;
                        break;
                    }
                    
                }
                if ($cek_day == false) {
                    array_push($nilai_previous_year, 0);
                    array_push($labelBot_previous_year, $valueMonth);
                }
            }
        }
        

        $dt=["LABELBOT" => $lbbSTR, "NILAI" => [["LBL"=>"Tahun ini","NLI"=>$nilai_year],
                            ["LBL"=>"Tahun kemarin","NLI"=>$nilai_previous_year]]];
        return response()->json($dt);
    }

















    public function grupTahunData(Request $request){
        if($request->ajax()){
            echo'';
            if ($request->chooseBy == 'custom'){
                $tmp_start_year = $request->start_year;
                $tmp_end_year = $request->end_year;
                if ($tmp_start_year==null or $tmp_end_year==null) {
                    return response()->json(['errPer'=>'Tahun belum di atur'],422);
                }elseif ($tmp_start_year > $tmp_end_year) {
                    return response()->json(['errPer'=>'Tahun tidak valid'],422);
                }elseif ($tmp_start_year == $tmp_end_year) {
                    return response()->json(['errPer'=>'Tahun tidak boleh sama'],422);
                }elseif ($tmp_start_year < $tmp_end_year ) {
                    $y_start=$tmp_start_year."-01-01";
                    $y_end=$tmp_end_year."-12-31";
                
                    $tmp_start_date = Carbon::parse($y_start)->toDateTimeString();
                    $tmp_end_date = Carbon::parse($y_end)->toDateTimeString();

                    $labelBot_selectedYear =[]; 
                    $nilai_selectedYear=[];

                    if ($request->statusPembayaran == 'all') {
                        $selectedYear = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->OrderBy('id','ASC')->get()->groupBy(function($item) {
                            return $item->created_at->format('Y');
                        });                    
                        foreach ($selectedYear as $key => $value) {
                            $tmp_sum=0;
                            $groub_barcode=$value->groupBy('barcode');
                            foreach ($groub_barcode as $key2 => $value2) {
                                $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                            }
                            array_push($labelBot_selectedYear, $key);
                            array_push($nilai_selectedYear, $tmp_sum);
                        }
                    } elseif ($request->statusPembayaran == 'done') {
                        $selectedYear = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->where('status_pengerjaan','1')->OrderBy('id','ASC')->get()->groupBy(function($item) {
                            return $item->created_at->format('Y');
                        });                    
                        foreach ($selectedYear as $key => $value) {
                            $tmp_sum=0;
                            $groub_barcode=$value->groupBy('barcode');
                            foreach ($groub_barcode as $key2 => $value2) {
                                $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                            }
                            array_push($labelBot_selectedYear, $key);
                            array_push($nilai_selectedYear, $tmp_sum);
                        }
                    }elseif ($request->statusPembayaran == 'notYet') {
                        $selectedYear = Pengerjaan::with(['users.roles', 'users', 'harga_jasas.jasas', 'harga_jasas', 'persentases.bagians', 'persentases'])->whereBetween('created_at',[$tmp_start_date,$tmp_end_date])->where('status_pengerjaan','0')->OrderBy('id','ASC')->get()->groupBy(function($item) {
                            return $item->created_at->format('Y');
                        });                    
                        foreach ($selectedYear as $key => $value) {
                            $tmp_sum=0;
                            $groub_barcode=$value->groupBy('barcode');
                            foreach ($groub_barcode as $key2 => $value2) {
                                $tmp_sum += $value2[0]->harga_jasas->nominal_harga_jasa;
                            }
                            array_push($labelBot_selectedYear, $key);
                            array_push($nilai_selectedYear, $tmp_sum);
                        }
                    }

                    $dt=["LABELBOT" => $labelBot_selectedYear, "NILAI" => [$nilai_selectedYear]];
                    return response()->json($dt);

                }
                return response()->json( $tmp_end_year);
            }
        }
    }
}
