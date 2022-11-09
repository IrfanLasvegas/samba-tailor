

            
            <table class="table">
                <thead class="" >
                    <tr class="text-sm text-capitalize">
                        <th scope="col">#</th>
                        <th scope="col">Jasa</th>
                        @foreach ($tmp_th as $key => $value)
                            <th scope="col">{{ $value[0]->persentases->bagians->nama_bagian }}</th>
                        @endforeach
                        <th scope="col">Harga</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal</th>
                        <th class="text-center" scope="col">Action</th>
                    </tr>
                </thead>
                
                
                <tbody class="body-riwayat">
                    @if(!empty($dataRiwayat) && $dataRiwayat->count())
                        @foreach($dataRiwayat as $keyRow => $valueRow)
                            <tr>
                                @if ($dataRiwayat->currentPage()==1)
                                    <td>{{ $loop->iteration }}</td>
                                @else
                                    <td>{{ $loop->iteration +(50*($dataRiwayat->currentPage()-1)) }}</td>
                                @endif
                                @foreach ($tmp_th as $keyCol => $valueCol)
                                    @if ($loop->iteration == 1)
                                        <td class="text-sm align-middle">{{ $valueRow[0]->harga_jasas->jasas->nama_jasa}}</td>
                                    @endif
                                    @php
                                        $cek=false
                                    @endphp
                                    @foreach ($valueRow as $key => $value)
                                        @if ($keyCol == $value->persentases->bagians->id)
                                            <td class="text-sm align-middle">{{ $value->users->name}}</td>
                                            @php
                                                $cek=true
                                            @endphp
                                            @break
                                        @endif  
                                        @if ($loop->last)
                                            @if ($cek==false)
                                            <td class="text-sm align-middle">-</td>
                                            @endif
                                        @endif 
                                    @endforeach
                                    @if ($loop->last)
                                        <td class="text-sm align-middle">Rp. {{ number_format($valueRow[0]->harga_jasas->nominal_harga_jasa,0,".",".")}}</td>
                                        <td class="text-sm align-middle">
                                            @php
                                                if ($valueRow[0]->status_pengerjaan == '1') {
                                                    echo 'sudah';
                                                }elseif ($valueRow[0]->status_pengerjaan == '0') {
                                                    echo 'belum';
                                                }
                                            @endphp
                                        </td>
                                        <td class="text-sm align-middle">{{ $valueRow[0]->created_at->isoFormat('D MMMM Y')}}</td>
                                        <td class="text-center">
                                            <button onclick="showDatav('{{$valueRow[0]->barcode}}')" style="width: 50px;" type="button" class="btn btn-xs btn-warning align-middle m-1 text-white">Detail</button>                                            
                                            <button onclick="deleteDatav('{{$valueRow[0]->barcode}}')" style="width: 50px;" type="button" class="btn btn-xs btn-danger align-middle m-1">Delete</button>
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                            






                            {{-- <tr>
                                @if ($dataRiwayat->currentPage()==1)
                                    <td>{{ $loop->iteration }}</td>
                                @else
                                    <td>{{ $loop->iteration +(50*($dataRiwayat->currentPage()-1)) }}</td>
                                @endif
                                <td class="text-sm align-middle">{{ $value[0]->harga_jasas->jasas->nama_jasa}}</td>
                                <td class="text-sm align-middle">{{ $value[0]->harga_jasas->nominal_harga_jasa}}</td>
                                <td class="text-sm align-middle">{{ $value[0]->created_at->isoFormat('D MMMM Y')}}</td>
                                
                                <td class="text-center">

                                    <button onclick="showDatav('{{$value[0]->barcode}}')" style="width: 50px;" type="button" class="btn btn-xs btn-warning align-middle m-1 text-white">Detail</button>
                                    
                                    <button onclick="deleteDatav('{{$value[0]->barcode}}')" style="width: 50px;" type="button" class="btn btn-xs btn-danger align-middle m-1">Delete</button>
                                </td>
                            </tr> --}}
                        @endforeach
                    @else
                    <tr>
                        <td colspan="4">No data found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            {!! $dataRiwayat->links() !!}








            






