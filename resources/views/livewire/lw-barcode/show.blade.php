<div>
    <div class="flex d-flex">
        <div>{!! DNS1D::getBarcodeHTML('123456789', 'C128',1,33) !!}</div>
        {{-- <div style="margin-top: auto; margin-bottom: auto; margin-left:10px"><button wire:click="exportBarPDF1" class="btn btn-sm btn-primary" target="_blank">Generate PDF</button></div> --}}
        <div style="margin-top: auto; margin-bottom: auto; margin-left:10px">
            @if ($barcode_type1->status_barcode=='Early')
                <button wire:click="exportBarPDF1" class="btn btn-sm btn-primary" target="_blank">Generate PDF</button>
            @elseif ($barcode_type1->status_barcode=='Process')
                    @if ($cek_progress < 100 and $cek_finishedAt ==null )
                    <div wire:poll="fBatch">Please wait....
                        {{-- {{ $cek_progress }} --}}
                    </div>
                    @endif
            @elseif ($barcode_type1->status_barcode=='Done')
            {{-- <a href="barcode-download" target="_blank">download file here....</a> --}}
            {{-- <button wire:click="downloadExportBarPDF1" target="_blank">download file here....</button> --}}
            <button wire:click="downloadExportBarPDF1" class="btn btn-sm btn-primary" target="_blank">download file here....</button>    
            @endif
        </div>
    </div>











    {{-- @if ($get_batch_id != null and $cek_createdAt != null)
        @if ($cek_progress < 100 and $cek_finishedAt ==null)
            <div>
                bath id : {{ $get_batch_id }}
            </div>
            <div wire:poll="fBatch">
                progress : {{ $cek_progress }}%
            </div>
            <div>finished : {{ $cek_finishedAt }}</div>
        @else
            {{ $cek_progress }}% download file here.... <br>
            
        @endif
    @endif --}}
    
</div>
