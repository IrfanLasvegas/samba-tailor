<style>
    .pagination{
        font-size: 11px
    }
</style>
<table class="table">
    {{-- <thead>
        <tr>
            <th scope="col" colspan="2">Riwayat pembayaran</th>
        </tr>
    </thead> --}}
    <tbody class="riwayat-pembayaran">
        @if(!empty($dataRiwayat) && $dataRiwayat->count())
            @foreach($dataRiwayat as $key => $value)
                <tr>
                    <td class="pt-1 pb-1">
                        <div class="float-left">
                            <div class="d-flex ">
                                {{-- @if ($dataRiwayat->currentPage()==1)
                                    <div class="mt-2 align-midle" style="width: 25px; ">
                                        {{ $loop->iteration }}
                                    </div>
                                    
                                @else
                                    <div class="mt-2 align-midle" style="width: 25px; ">
                                        {{ $loop->iteration +(20*($dataRiwayat->currentPage()-1))  }}
                                    </div>
                                    
                                @endif --}}

                                <div class="ml-2">
                                    
                                    
                                    <div class="d-flex flex-row" style="margin-bottom: -5px;">
                                        <div class="mr-1">
                                            <span style="font-size: 20px; color: rgb(100, 100, 99);">
                                                <i class=" fas fa-cash-register"></i>
                                            </span>
                                        </div>

                                        <div class="d-flex flex-column  ">
                                            <div  style="font-size: 11px; margin-bottom: -5px ">#{{ $value[0]->pembayarans_id }}</div>
                                            <div style="font-size: 11px">{{ $value[0]->pembayarans->users->name }}</div>
                                        </div>
                                    </div>
                                    <div style="font-size: 11px">{{ $value[0]->created_at->isoFormat('D MMMM Y, HH:mm:ss')}}</div>
                                    


                                    {{-- 
                                    <div style="d-flex ">
                                        <span style="font-size: 15px; color: rgb(100, 100, 99);">
                                            <i class=" fas fa-cash-register"></i>
                                        </span>
                                        {{ $value[0]->pembayarans->users->name}}
                                    </div>
                                    <div style="font-size: 11px">{{ $value[0]->created_at->isoFormat('D MMMM Y, HH:mm:ss')}}</div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="float-right text-sm">
                            <div>
                                <div class="item-action dropdown mt-2"> 
                                    <a href="#" data-toggle="dropdown" class="text-muted" data-abc="true"> 
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="12" cy="5" r="1"></circle>
                                            <circle cx="12" cy="19" r="1"></circle>
                                        </svg> 
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right text-sm" role="menu"> 
                                        <a class="dropdown-item" onclick="showDatav('{{$value[0]->pembayarans_id}}')" data-abc="true">Detail </a>
                                        <a class="dropdown-item trash" onclick="deleteDatav('{{$value[0]->pembayarans_id}}')" data-abc="true">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    
                </tr>




            @endforeach
        @else
        <tr>
            <td colspan="4">........</td>
        </tr>
        @endif

    </tbody>
    
</table>
@if (!empty($dataRiwayat) && $dataRiwayat->count())
    <div class="ml-3">
        {!! $dataRiwayat->links() !!}
    </div>
  
@endif
