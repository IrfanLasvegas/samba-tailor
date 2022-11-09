

            
            <table class="table">
                <thead class="" >
                    <tr class="text-sm">
                        <th scope="col">#</th>
                        <th scope="col">Jasa</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal</th>
                        <th class="text-center" scope="col">Action</th>
                    </tr>
                </thead>
                
                
                <tbody class="body-riwayat">
                    @if(!empty($dataRiwayat) && $dataRiwayat->count())
                        @foreach($dataRiwayat as $key => $value)
                            <tr>
                                @if ($dataRiwayat->currentPage()==1)
                                    <td>{{ $loop->iteration }}</td>
                                @else
                                    <td>{{ $loop->iteration +(50*($dataRiwayat->currentPage()-1)) }}</td>
                                @endif
                                <td class="text-sm align-middle">{{ $value[0]->harga_jasas->jasas->nama_jasa}}</td>
                                <td class="text-sm align-middle">Rp. {{ number_format($value[0]->harga_jasas->nominal_harga_jasa,0,".",".")}}</td>
                                <td class="text-sm align-middle">
                                    @php
                                        if ($value[0]->status_pengerjaan == '1') {
                                            echo 'sudah';
                                        }elseif ($value[0]->status_pengerjaan == '0') {
                                            echo 'belum';
                                        }
                                    @endphp
                                </td>
                                <td class="text-sm align-middle">{{ $value[0]->created_at->isoFormat('D MMMM Y')}}</td>
                                
                                <td class="text-center">

                                    <button onclick="showDatav('{{$value[0]->barcode}}')" style="width: 50px;" type="button" class="btn btn-xs btn-warning align-middle m-1 text-white">Detail</button>
                                    {{-- <button onclick="editDatav('{{$value[0]->barcode}}')" style="width: 40px;" type="button" class="btn btn-xs btn-primary m-1"><i class="far fa-edit"></i></button> --}}
                                    <button onclick="deleteDatav('{{$value[0]->barcode}}')" style="width: 50px;" type="button" class="btn btn-xs btn-danger align-middle m-1">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="4">No data found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            {!! $dataRiwayat->links() !!}



