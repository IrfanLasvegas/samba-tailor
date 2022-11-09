@extends("ViewAdmin.va_layout.va_tamplate")

@section('title', 'Samba | Pengaturan Jasa')

@section('breadcrumbWeb')
    {{-- <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"><a href="#">Jasa</a></li>
    </ol> --}}
@endsection

@section('contentWeb')

    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0">Jasa</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-borderless">
                                    <tr class="">
                                        <td class="align-middle">
                                                <input type="hidden" id="id">
                                                <input type="text" id="name" class="form-control text-sm" placeholder="Nama">
                                                <span class="text-danger" id="nameError"></span>
                                        </td>
                                        <td class="align-middle">
                                            <button type="submit" id="addButton" onclick="addDatav()"style='width: 50px;' class="btn btn-xs btn-primary">Add</button>
                                            <button type="submit" id="updateButton" onclick="updateDatav()" style='width: 50px;' class="btn btn-xs btn-primary d-none">Update</button>
                                            <button id="cencelButton" onclick="cencelEditDatav()" style='width: 50px;' class="btn btn-xs btn-danger d-none">cancel</button>
                                        </td>
                                    </tr>
                                </table>
                                
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="" >
                                            <tr class="text-sm">
                                                <th scope="col">#</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Tanggal</th>
                                                <th class="text-center" scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-bagian">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
            <div class="col-sm-7">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0">Harga</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-borderless">
                                    <input type="hidden" id="inputIdHargaJasa">
                                    <tr>
                                        <td>
                                            <select class="form-control text-sm" id="inputJasa">
    
                                            </select>
                                            <span class="text-danger" id="inputJasaError"> </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id="inputHargaJasa" class="form-control text-sm" placeholder="Rp.........">
                                            <span class="text-danger" id="inputHargaJasaError"></span>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select class="form-control text-sm" id="inputStatusHargaJasa">
                                                <option value=""> ---Pilih status --- </option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
    
                                            </select>
                                            <span class="text-danger" id="inputStatusHargaJasaError"> </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">
                                            <button type="submit" id="addButtonHargaJasa" onclick="addDatavHargaJasa()"style='width: 50px;' class="btn btn-xs btn-primary">Add</button>
                                            <button type="submit" id="updateButtonHargaJasa" onclick="updateDatavHargaJasa()" style='width: 50px;' class="btn btn-xs btn-primary d-none">Update</button>
                                            <button id="cencelButtonHargaJasa" onclick="cencelEditDatavHargaJasa()" style='width: 50px;' class="btn btn-xs btn-danger d-none">cancel</button>
                                        </td>
                                    </tr>
                                    
                                </table>
                                
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="" >
                                            <tr class="text-sm">
                                                <th scope="col">#</th>
                                                <th scope="col">Jasa</th>
                                                <th>Harga</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Tanggal</th>
                                                <th class="text-center" scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-harga-jasa">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                
    
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        // ----- JASA ----------------------------------------------------------------


        function refreshDatav(){
            $.ajax({
                type:"GET",
                dataType:'json',
                url:"/jasa/all",
                success: function(response){
                    var data=""
                    var n=0;
                    $.each(response,function(key, value){
                        n+=1;
                        data = data + "<tr>"
                        data = data + "<td class='text-sm align-middle'>"+n+"</td>"
                        data = data + "<td class='text-sm align-middle'>"+value.nama_jasa+"</td>"
                        data = data + "<td class='text-sm align-middle'>"+moment(value.created_at).format('DD/MM/YYYY')+"</td>"
                        data = data + "<td class='text-center'>"
                        data = data + "<button onclick='editDatav("+value.id+")' style='width: 50px;' type='button' class='btn btn-xs btn-primary align-middle m-1'>Edit</button>"
                        data = data + "<button onclick='deleteDatav("+value.id+")' style='width: 50px;' type='button' class='btn btn-xs btn-danger align-middle m-1'>Delete</button>"
                        data = data + "</td>"
                        data = data + "/<tr>"
                    })
                    $('.body-bagian').html(data);
                    
                }

            })
        }
        refreshDatav();
        

        // ----------------- add data -----------------
        function addDatav() {
            var tmp_name = $('#name').val();

            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: tmp_name
                },
                url: "/jasa/store",
                success: function (data) {
                    $('#name').val('');
                    $('#nameError').text('');
                    refreshDatav();
                    jasaDatav();

                    // ----------------- start alert -----------------
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1600,
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutRight'
                        },
                        width: 240,
                        timerProgressBar: true,
                            didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        },
                    })
                    Toast.fire({
                        icon: 'success',
                        title: "Data berhasil  ditambah"
                    })
                    // ----------------- end alert -----------------
                },
                error: function (error) {
                    $('#nameError').text('');
                    $('#nameError').text(error.responseJSON.errors.name)
                }
            })
        }
        // ----------------- and edd data -----------------


        // ----------------- edit data -----------------
        function editDatav(id) {
            $('#id').val('');
            $('#name').val('');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/jasa/edit/" + id,
                success: function (data) {
                    $('#addButton').addClass('d-none');
                    $('#updateButton').removeClass('d-none');
                    $('#cencelButton').removeClass('d-none');

                    $("#id").val(data.id);
                    $("#name").val(data.nama_jasa);
                    // console.log(data);
                }
            })
        }

        function cencelEditDatav(){
            $('#id').val('');
            $('#name').val('');
            $('#addButton').removeClass('d-none');
            $('#updateButton').addClass('d-none');
            $('#cencelButton').addClass('d-none');
            
        }
        // ----------------- end edit data -----------------

        // ----------------- update data -----------------
        function updateDatav() {
            var tmp_id = $('#id').val();
            var tmp_name = $('#name').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    id: tmp_id,
                    name: tmp_name
                },
                url: "/jasa/update/" + tmp_id,
                success: function (data) {
                    $('#id').val('');
                    $('#name').val('');
                    $('#nameError').text('');

                    $('#addButton').removeClass('d-none');
                    $('#updateButton').addClass('d-none');
                    $('#cencelButton').addClass('d-none');
                    refreshDatav();
                    jasaDatav();
                    refreshDatavHargaJasa();
                    // ----------------- start alert -----------------
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1600,
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutRight'
                        },
                        width: 240,
                        timerProgressBar: true,
                            didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        },
                    })
                    Toast.fire({
                        icon: 'success',
                        title: "Data berhasil  diperbarui"
                    })
                    // ----------------- end alert -----------------
                },
                error: function (error) {
                    $('#nameError').text('');
                    $('#nameError').text(error.responseJSON.errors.name)
                }
            })
        }
        // ----------------- end update data -----------------

        // ----------------- delete data -----------------
        function deleteDatav(id) {
            Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Semua data yang terkait dengan data ini akan dihapus dan  tidak  dapat dipulihkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            detaType: "json",
                            url: "/jasa/delete/" + id,
                            success: function (data) {
                                $('#id').val('');
                                $('#name').val('');
                                $('#nameError').text('');

                                $('#addButton').removeClass('d-none');
                                $('#updateButton').addClass('d-none');
                                $('#cencelButton').addClass('d-none');
                                refreshDatav();
                                jasaDatav();
                                refreshDatavHargaJasa();
                                // ----------------- start alert -----------------
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 1600,
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOutRight'
                                    },
                                    width: 240,
                                    timerProgressBar: true,
                                        didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    },
                                })
                                Toast.fire({
                                    icon: 'success',
                                    title: "Data berhasil  dihapus"
                                })
                                // ----------------- end alert -----------------
                            }
                        })
                    }
                })
        }
        // ----------------- end delete data -----------------
        // -----END JASA ----------------------------------------------------------------


        // ----- HARGA ----------------------------------------------------------------
        $('#addButtonHargaJasa').show();
        $('#updateButtonHargaJasa').hide();
        $('#cencelButtonHargaJasa').hide();

        function jasaDatav() {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/jasa/all",
                success: function (response) {
                    var data = ""
                    data = data + "<option value=''> --- Pilih jasa --- </option>"
                    $.each(response, function (key, value) {
                        data = data + "<option value='" + value.id + "'>" + value.nama_jasa + "</option>"
                    })
                    $('#inputJasa').html(data)
                    // console.log(response);
                }

            })
        }
        jasaDatav();

        function refreshDatavHargaJasa(){
            
            $.ajax({
                type:"GET",
                dataType:'json',
                url:"/harga/all",
                success: function(response){
                    
                    var data=""
                    var n=0;
                    $.each(response,function(key, value){
                        n+=1;
                        data = data + "<tr>"
                        data = data + "<td class='text-sm align-middle'>"+n+"</td>"
                        data = data + "<td class='text-sm align-middle'>"+value.jasas.nama_jasa+"</td>"
                        data = data + "<td class='text-sm align-middle'>"+formatRupiah(value.nominal_harga_jasa, 'Rp. ')+"</td>"
                        
                        
                        if(value.status_harga_jasa == 0){
                            data = data + "<td class='text-sm align-middle'>Inactive</td>"
                        }if (value.status_harga_jasa == 1) {
                            data = data + "<td class='text-sm align-middle'>Active</td>"
                        }

                        data = data + "<td class='text-sm align-middle'>"+moment(value.created_at).format('DD/MM/YYYY')+"</td>"
                        data = data + "<td class='text-center'>"
                        data = data + "<button onclick='editDatavHargaJasa("+value.id+")' style='width: 50px;' type='button' class='btn btn-xs btn-primary align-middle m-1'>Edit</button>"
                        data = data + "<button onclick='deleteDatavHargaJasa("+value.id+")' style='width: 50px;' type='button' class='btn btn-xs btn-danger align-middle m-1'>Delete</button>"
                        data = data + "</td>"
                        data = data + "/<tr>"
                    })
                    $('.body-harga-jasa').html(data);
                    
                }

            })
        }
        refreshDatavHargaJasa();

        function clearDatav() {
            $('#inputIdHargaJasa').val('');
            $('#inputJasa').val('');
            $('#inputHargaJasa').val('');
            $('#inputStatusHargaJasa').val('');
        }

        function clearErr() {
            $('#inputJasaError').text('');
            $('#inputHargaJasaError').text('');
            $('#inputStatusHargaJasaError').text('');
        }

        // ----------------- add data -----------------
        function addDatavHargaJasa() {
            var tmp_jasa = $('#inputJasa').val();
            var tmp_nominal = $('#inputHargaJasa').val();
            var tmp_status = $('#inputStatusHargaJasa').val();

            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    inputJasa: tmp_jasa,
                    inputHargaJasa: tmp_nominal,
                    inputStatusHargaJasa: tmp_status
                },
                url: "/harga/store",
                success: function (data) {
                    clearDatav();
                    clearErr();
                    refreshDatavHargaJasa();
                    // ----------------- start alert -----------------
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1600,
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutRight'
                        },
                        width: 240,
                        timerProgressBar: true,
                            didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        },
                    })
                    Toast.fire({
                        icon: 'success',
                        title: "Data berhasil  ditambah"
                    })
                    // ----------------- end alert -----------------
                    
                },
                error: function (error) {
                    clearErr();
                    $('#inputJasaError').text(error.responseJSON.errors.inputJasa);
                    $('#inputHargaJasaError').text(error.responseJSON.errors.inputHargaJasa);
                    $('#inputStatusHargaJasaError').text(error.responseJSON.errors.inputStatusHargaJasa);
                }
            })
        }
        // ----------------- and edd data -----------------

        // ----------------- edit data -----------------
        function editDatavHargaJasa(id) {
            clearDatav();
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/harga/edit/" + id,
                success: function (data) {
                    clearErr();
                    
                    $('#addButtonHargaJasa').hide();
                    $('#updateButtonHargaJasa').show();
                    $('#cencelButtonHargaJasa').show();

                    $('#addButtonHargaJasa').addClass('d-none');
                    $('#updateButtonHargaJasa').removeClass('d-none');
                    $('#cencelButtonHargaJasa').removeClass('d-none');

                    $("#inputIdHargaJasa").val(data.id);
                    $("#inputJasa").val(data.jasas_id);
                    $("#inputHargaJasa").val(data.nominal_harga_jasa);
                    $("#inputStatusHargaJasa").val(data.status_harga_jasa);
                    // console.log(data);
                }
            })
        }


        function cencelEditDatavHargaJasa(){
            clearDatav();
            clearErr();
            $('#addButtonHargaJasa').removeClass('d-none');
            $('#updateButtonHargaJasa').addClass('d-none');
            $('#cencelButtonHargaJasa').addClass('d-none');

            
        }
        // ----------------- end edit data -----------------

        // ----------------- update data -----------------
        function updateDatavHargaJasa() {
            var tmp_id = $('#inputIdHargaJasa').val();
            var tmp_jasa = $('#inputJasa').val();
            var tmp_nominal = $('#inputHargaJasa').val();
            var tmp_status = $('#inputStatusHargaJasa').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    inputJasa: tmp_jasa,
                    inputHargaJasa: tmp_nominal,
                    inputStatusHargaJasa: tmp_status
                },
                url: "/harga/update/" + tmp_id,
                success: function (data) {
                    clearDatav();
                    clearErr();
                    refreshDatavHargaJasa();

                    $('#addButtonHargaJasa').removeClass('d-none');
                    $('#updateButtonHargaJasa').addClass('d-none');
                    $('#cencelButtonHargaJasa').addClass('d-none');

                    // ----------------- start alert -----------------
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1600,
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutRight'
                        },
                        width: 240,
                        timerProgressBar: true,
                            didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        },
                    })
                    Toast.fire({
                        icon: 'success',
                        title: "Data berhasil  diperbarui"
                    })
                    // ----------------- end alert -----------------
                    
                },
                error: function (error) {
                    clearErr();
                    $('#inputJasaError').text(error.responseJSON.errors.inputJasa);
                    $('#inputHargaJasaError').text(error.responseJSON.errors.inputHargaJasa);
                    $('#inputStatusHargaJasaError').text(error.responseJSON.errors.inputStatusHargaJasa);
                }
            })
        }
        // ----------------- end update data -----------------

        // ----------------- delete data -----------------
        function deleteDatavHargaJasa(id) {
            Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Semua data yang terkait dengan data ini akan dihapus dan  tidak  dapat dipulihkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            detaType: "json",
                            url: "/harga/delete/" + id,
                            success: function (data) {
                                clearDatav();
                                clearErr();
                                refreshDatavHargaJasa();

                                $('#addButtonHargaJasa').removeClass('d-none');
                                $('#updateButtonHargaJasa').addClass('d-none');
                                $('#cencelButtonHargaJasa').addClass('d-none');
                                // ----------------- start alert -----------------
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 1600,
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOutRight'
                                    },
                                    width: 240,
                                    timerProgressBar: true,
                                        didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    },
                                })
                                Toast.fire({
                                    icon: 'success',
                                    title: "Data berhasil  dihapus"
                                })
                                // ----------------- end alert -----------------
                            }
                        })
                    }
                })
        }
        // ----------------- end delete data -----------------

    
        // ----- END HARGA JASA ----------------------------------------------------------------

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

    </script>

@endsection
