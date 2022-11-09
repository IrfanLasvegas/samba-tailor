

            <div class="table-responsive">
                <table class="table" style="width: 100%">
                    <thead class="" >
                        <tr class="text-sm">
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Bagian</th>
                            <th class="text-center" scope="col">Action</th>
                        </tr>
                    </thead>
                    
                    
                    <tbody class="body-riwayat">
                        @if(!empty($dataUser) && $dataUser->count())
                            @foreach($dataUser as $key => $value)
                                <tr>
                                    @if ($dataUser->currentPage()==1)
                                        <td>{{ $loop->iteration }}</td>
                                    @else
                                        <td>{{ $loop->iteration +(10*($dataUser->currentPage()-1)) }}</td>
                                    @endif
                                    <td class="text-sm align-middle">{{ $value->name}}</td>
                                    <td class="text-sm align-middle">{{ $value->email}}</td>
                                    <td class="text-sm align-middle">{{ $value->roles->namerole}}</td>
                                    @if ($value->persentases == null) {{-- null bisa diganti '' --}}
                                       <td class="text-sm align-middle">--- --- ---</td>
                                    @else
                                        <td class="text-sm align-middle">{{ $value->persentases->bagians->nama_bagian}}</td>    
                                    @endif
                                    
                                    <td class="text-center">
    
                                        <button onclick="editDatav('{{$value->id}}')" style="width: 50px;" type="button" class="btn btn-xs btn-warning align-middle m-1 text-white">Edit</button>
                                        <button onclick="deleteDatav('{{$value->id}}')" style="width: 50px;" type="button" class="btn btn-xs btn-danger align-middle m-1">Delete</button>
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
                {!! $dataUser->links() !!}
            </div>
            



