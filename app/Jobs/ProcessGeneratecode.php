<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Batchable;

use Illuminate\Support\Facades\App;

use App\Models\Barcode;

use Illuminate\Support\Facades\Storage;




class ProcessGeneratecode implements ShouldQueue, ShouldBeUnique
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        // echo 'bbb';
        // for ($i=0; $i < 40000; $i++) { 
        //     # code...
        //     echo $i;
        // }

        ini_set('memory_limit', -1);
        ini_set('MAX_EXECUTION_TIME', '120000');
        set_time_limit(120*60);

        
        $count=140;  // sebanyak apapun bisa hanya kendala di penggunaan memory/ram 
        $tmp_barcode=Barcode::get()->first();
        $nameBarcode = $tmp_barcode->name_barcode;
        $currentBarcode = $tmp_barcode->current_barcode;

        $html = view('ViewAdmin.va_barcode.va_barcode_pdf_1',compact('nameBarcode','currentBarcode','count'))->render();
        $pdf = App::make('dompdf.wrapper');
        $tmpPDF = $pdf->loadHTML($html)->setPaper('a4', 'potrait')->setWarnings(false);
        $output = $tmpPDF->output();

        $new_current_barcode = intval($tmp_barcode->current_barcode)+$count;
        $data = Barcode::findOrFail($tmp_barcode->id)->update([
            'current_barcode' => $new_current_barcode,
        ]);
        Storage::put('public/BarcodeResult.pdf', $output);
        
    }
}
