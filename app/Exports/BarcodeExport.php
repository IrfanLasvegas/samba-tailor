<?php

namespace App\Exports;



use App\Models\Barcode;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BarcodeExport implements FromView
{
    public function view(): View
    {
        

        $count=100;
        $tmp_barcode=Barcode::get()->first();
        $nameBarcode = $tmp_barcode->name_barcode;
        $currentBarcode = $tmp_barcode->current_barcode;
        return view('ViewAdmin.va_barcode.va_barcode_pdf_3',compact('nameBarcode','currentBarcode','count'));

        // $html = view('ViewAdmin.va_barcode.va_barcode_pdf_3',compact('nameBarcode','currentBarcode','count'))->render();
    }
}
