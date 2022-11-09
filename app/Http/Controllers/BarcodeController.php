<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Jobs\ProcessGeneratecode;
use App\Jobs\ProcessGeneratecode2;
use PDF;

use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\BarcodeExport;


// use Illuminate\Support\Facades\Artisan;
// use Illuminate\Console\Scheduling\Schedule;

use Illuminate\Support\Facades\Storage;

class BarcodeController extends Controller
{
    public function index(){
        return view('ViewAdmin.va_barcode.va_barcode_index');
    }


    // public function downloadFileExportPdf(){
    //     $data = Barcode::where('name_barcode', 'S-83')->update([
    //         'status_barcode' => 'Early',
    //     ]);
    //     return Storage::download('public/BarcodeResult.pdf');
        
    // }

    public function exportBarcodePDF1(){
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML('<h1>Test</h1>');
        // return $pdf->stream();

        // $pdf = PDF::loadView('welcome');
        // return $pdf->download('user.pdf');

       

        // $currentBarcode='35765001001';
        // $currentBarcode='83100000';
        // set_time_limit(200);
        // $count=200;


          
        // $pdf = PDF::loadView('ViewAdmin.va_barcode.va_barcode_pdf_1',compact('currentBarcode','count'));
     
        // return $pdf->stream('tutsmake.pdf');
        

    
        // $html = view('ViewAdmin.va_barcode.va_barcode_pdf_1',compact('currentBarcode','count'))->render();
        // $pdf = App::make('dompdf.wrapper');
        // $invPDF = $pdf->loadHTML($html);
        // return $pdf->download('Barcode.pdf');


        
        // $html = view('ViewAdmin.va_barcode.va_barcode_pdf_1',compact('currentBarcode','count'))->render();
        // $pdf = App::make('dompdf.wrapper');
        // $invPDF = $pdf->loadHTML($html)->setPaper('a4', 'potrait')->setWarnings(false);
        // return $pdf->download('Barcode.pdf');


        

        // set_time_limit(200);
        // $count=140;
        // $tmp_barcode=Barcode::get()->first();
        // $nameBarcode = $tmp_barcode->name_barcode;
        // $currentBarcode = $tmp_barcode->current_barcode;

        // $html = view('ViewAdmin.va_barcode.va_barcode_pdf_1',compact('nameBarcode','currentBarcode','count'))->render();
        // $pdf = App::make('dompdf.wrapper');
        // $tmpPDF = $pdf->loadHTML($html)->setPaper('a4', 'potrait')->setWarnings(false);
        // $new_current_barcode = intval($tmp_barcode->current_barcode)+$count;
        
        // $data = Barcode::findOrFail($tmp_barcode->id)->update([
        //     'current_barcode' => $new_current_barcode,
        // ]);
        // return $tmpPDF->stream();

        // ProcessGeneratecode::dispatch();

        // $batch = Bus::batch([new  ProcessGeneratecode()])->dispatch();
        // return $batch;

        $batch = Bus::batch([])->dispatch();
        $batch->add(new  ProcessGeneratecode());
        $batch->add(new  ProcessGeneratecode());
        $batch->add(new  ProcessGeneratecode());
        $batch->add(new  ProcessGeneratecode());
        dd($batch) ;
    }

    public function pdfBatch($batch_id){
        return(Bus::findBatch($batch_id)) ;
    }

    public function exportBarcodePDF2(){
        // ini_set('memory_limit', -1);
        // ini_set('MAX_EXECUTION_TIME', '120000');
        // set_time_limit(120*60);


        // ini_set('MAX_EXECUTION_TIME', '8000');
        // set_time_limit(180*60);

        // $count=152;
        // $tmp_barcode=Barcode::get()->first();
        // $nameBarcode = $tmp_barcode->name_barcode;
        // $currentBarcode = $tmp_barcode->current_barcode;

        // $html = view('ViewAdmin.va_barcode.va_barcode_pdf_2',compact('nameBarcode','currentBarcode','count'))->render();
        // $pdf = App::make('dompdf.wrapper');
        // $tmpPDF = $pdf->loadHTML($html)->setPaper('a4', 'potrait')->setWarnings(false);
        // $new_current_barcode = intval($tmp_barcode->current_barcode)+$count;
        
        // $data = Barcode::findOrFail($tmp_barcode->id)->update([
        //     'current_barcode' => $new_current_barcode,
        // ]);
        // return $tmpPDF->stream();
        // Artisan::call('queue:work', ['--stop-when-empty' => true]);
        
        
        // $schedule->command('queue:work');
        
        ProcessGeneratecode2::dispatch();
        
        // echo 'ggg';
    }


    public function exportBarcodePDF3(){
        ini_set('memory_limit', -1);
        ini_set('MAX_EXECUTION_TIME', '120000');
        set_time_limit(120*60);


        $count=100;
        $tmp_barcode=Barcode::get()->first();
        $nameBarcode = $tmp_barcode->name_barcode;
        $currentBarcode = $tmp_barcode->current_barcode;

        $html = view('ViewAdmin.va_barcode.va_barcode_pdf_3',compact('nameBarcode','currentBarcode','count'))->render();
        $pdf = App::make('dompdf.wrapper');
        $tmpPDF = $pdf->loadHTML($html)->setPaper('a4', 'potrait')->setWarnings(false);
        // $new_current_barcode = intval($tmp_barcode->current_barcode)+$count;
        
        // $data = Barcode::findOrFail($tmp_barcode->id)->update([
        //     'current_barcode' => $new_current_barcode,
        // ]);
        // return $tmpPDF->download();

        
        $output = $tmpPDF->output();
        file_put_contents('AJAXBarcodeResult.pdf', $output);
        return response()->json($html);


        // return response()->json($html);

        // return view('ViewAdmin.va_barcode.va_barcode_pdf_2',compact('nameBarcode','currentBarcode','count'));
    }







    

    public function generateExel(){
        return Excel::download(new UsersExport, 'exportDariCollection.xls');
        // return Excel::download(new BarcodeExport, 'exportDariView.xls');
        echo 'dalam';
    }


}
