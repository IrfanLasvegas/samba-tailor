<?php

namespace App\Http\Livewire\LwBarcode;

use Livewire\Component;

use App\Models\Barcode;
use App\Jobs\ProcessGeneratecode;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class Show extends Component
{
    // public  $tmpBatch = [];
    public $get_batch_id=null;
    public $cek_progress;
    public $cek_finishedAt=null;
    public $cek_createdAt=null;

    public $n=null;
    public $cek=true;


    public function exportBarPDF1(){
        $this->get_batch_id = null;
        $this->cek_progress = null;
        $this->cek_finishedAt = null;
        $this->cek_createdAt = null;

        $batch = Bus::batch([])->dispatch();
        $batch->add(new  ProcessGeneratecode());
        // $batch->add(new  ProcessGeneratecode());
        // $batch->add(new  ProcessGeneratecode());
        // $batch->add(new  ProcessGeneratecode());
        // $batch->add(new  ProcessGeneratecode());
        // $batch->add(new  ProcessGeneratecode());
        // $batch->add(new  ProcessGeneratecode());
        // $batch->add(new  ProcessGeneratecode());

        $this->get_batch_id = $batch->id;
        $this->cek_createdAt = $batch->createdAt;
        $data = Barcode::where('name_barcode', 'S-83')->update([
            'status_barcode' => 'Process',
            'id_job_batch_barcode' => $this->get_batch_id,
        ]);
        

        // $batch = [1,2,3];
        // $this->tmpBatch = $batch;
        // $this->get_batch_id = collect([11, 22, 33])->all();
    }

    public function downloadExportBarPDF1(){
        $data = Barcode::where('name_barcode', 'S-83')->update([
            'status_barcode' => 'Early',
        ]);
        return Storage::download('public/BarcodeResult.pdf');
    }


    public function fBatch(){
        if ($this->get_batch_id !=null) {
            $tmp = Bus::findBatch($this->get_batch_id);
            $this->cek_progress = intval(100-(($tmp->pendingJobs/$tmp->totalJobs)*100));
            if ($this->cek_progress == 100 and $tmp->finishedAt !=null) {
                $this->cek_finishedAt = $tmp->finishedAt;
                $data = Barcode::where('name_barcode', 'S-83')->update([
                    'status_barcode' => 'Done',
                ]);
                $this->cek = true;
            }
        }
        
    }

    public function render()
    {
        $barcode_type1 = Barcode::where('name_barcode', 'S-83')->first();
        if ($this->cek == true) {
            if ($barcode_type1->status_barcode=='Process') {
                $this->get_batch_id = $barcode_type1->id_job_batch_barcode;
            }
            $this->cek = false;
            
        }
        
        
        return view('livewire.lw-barcode.show',compact('barcode_type1'));
    }
}
