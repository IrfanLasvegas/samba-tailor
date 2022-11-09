@extends("ViewAdmin.va_layout.va_tamplate")

@section('title', 'Samba | Bagian')

@section('breadcrumbWeb')
    {{-- <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"><a href="#">Bagian</a></li>
    </ol> --}}
@endsection

@section('contentWeb')

    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0">Bagian</h5>
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
                        <h5 class="card-title m-0">Persentase</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-borderless">
                                    <input type="hidden" id="inputIdPersen">
                                    <tr>
                                        <td>
                                            <select class="form-control text-sm" id="inputBagianPersen">
    
                                            </select>
                                            <span class="text-danger" id="inputBagianPersenError"> </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id="inputNilaiPersen" class="form-control text-sm" placeholder="Persentase....%">
                                            <span class="text-danger" id="inputNilaiPersenError"></span>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select class="form-control text-sm" id="inputStatusPersen">
                                                <option value=""> ---Pilih status --- </option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
    
                                            </select>
                                            <span class="text-danger" id="inputStatusPersenError"> </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select class="form-control text-sm" id="inputStatusHidden">
                                                <option value=""> ---Pilih hidden --- </option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
    
                                            </select>
                                            <span class="text-danger" id="inputStatusHiddenError"> </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td  class="text-right">
                                            <button type="submit" id="addButtonPersen" onclick="addDatavPersen()"style='width: 50px;' class="btn btn-xs btn-primary">Add</button>
                                            <button type="submit" id="updateButtonPersen" onclick="updateDatavPersen()" style='width: 50px;' class="btn btn-xs btn-primary d-none">Update</button>
                                            <button id="cencelButtonPersen" onclick="cencelEditDatavPersen()" style='width: 50px;' class="btn btn-xs btn-danger d-none">cancel</button>
                                        </td>
                                    </tr>
                                    
                                </table>
                                
                                <div>
                                    <span class="badge mb-1" style="background-image: linear-gradient(to right, #43e97b 0%, #38f9d7 100%);">Active status <span class="sum-active-status"></span> </span>
                                </div>
    
                                
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="" >
                                            <tr class="text-sm">
                                                <th scope="col">#</th>
                                                <th scope="col">Bagian</th>
                                                <th>persentase</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Hidden</th>
                                                <th scope="col">Tanggal</th>
                                                <th class="text-center" scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-persen">
                                            
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

        // ----- BAGIAN ----------------------------------------------------------------
        


        function refreshDatav(){
            $.ajax({
                type:"GET",
                dataType:'json',
                url:"/bagian/all",
                success: function(response){
                    var data=""
                    var n=0;
                    $.each(response,function(key, value){
                        n+=1;
                        data = data + "<tr>"
                        data = data + "<td class='text-sm align-middle'>"+n+"</td>"
                        data = data + "<td class='text-sm align-middle'>"+value.nama_bagian+"</td>"
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
                url: "/bagian/store",
                success: function (data) {
                    $('#name').val('');
                    $('#nameError').text('');
                    refreshDatav();
                    bagianPersenDatav();

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
                    console.log(error);
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
                url: "/bagian/edit/" + id,
                success: function (data) {
                    $('#addButton').addClass('d-none');
                    $('#updateButton').removeClass('d-none');
                    $('#cencelButton').removeClass('d-none');

                    $("#id").val(data.id);
                    $("#name").val(data.nama_bagian);
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
                url: "/bagian/update/" + tmp_id,
                success: function (data) {
                    $('#id').val('');
                    $('#name').val('');
                    $('#nameError').text('');

                    $('#addButton').removeClass('d-none');
                    $('#updateButton').addClass('d-none');
                    $('#cencelButton').addClass('d-none');

                    // $('#addButton').show();
                    // $('#updateButton').hide();
                    // $('#cencelButton').hide();
                    refreshDatav();
                    bagianPersenDatav();
                    refreshDatavPersen();
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
                            url: "/bagian/delete/" + id,
                            success: function (data) {
                                $('#id').val('');
                                $('#name').val('');
                                $('#nameError').text('');

                                $('#addButton').removeClass('d-none');
                                $('#updateButton').addClass('d-none');
                                $('#cencelButton').addClass('d-none');

                                refreshDatav();
                                bagianPersenDatav();
                                refreshDatavPersen();
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
        // -----END BAGIAN ----------------------------------------------------------------


        // ----- PERSENTASE BAGIAN ----------------------------------------------------------------

        function bagianPersenDatav() {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/bagian/all",
                success: function (response) {
                    var data = ""
                    data = data + "<option value=''> --- Pilih bagian --- </option>"
                    $.each(response, function (key, value) {
                        data = data + "<option value='" + value.id + "'>" + value.nama_bagian + "</option>"
                    })
                    $('#inputBagianPersen').html(data)
                    // console.log(response);
                }

            })
        }
        bagianPersenDatav();

        function refreshDatavPersen(){
            
            $.ajax({
                type:"GET",
                dataType:'json',
                url:"/persentase/all",
                success: function(response){
                    
                    var data=""
                    var n=0;
                    $.each(response,function(key, value){
                        n+=1;
                        data = data + "<tr>"
                        data = data + "<td class='text-sm align-middle'>"+n+"</td>"
                        data = data + "<td class='text-sm align-middle'>"+value.bagians.nama_bagian+"</td>"
                        data = data + "<td class='text-sm align-middle'>"+value.nilai_persentase+"%</td>"
                        
                        
                        if(value.status_persentase == 0){
                            data = data + "<td class='text-sm align-middle'>Inactive</td>"
                        }if (value.status_persentase == 1) {
                            data = data + "<td class='text-sm align-middle'>Active</td>"
                        }

                        if(value.status_hidden == 0){
                            data = data + "<td class='text-sm align-middle'>No</td>"
                        }else if (value.status_hidden == 1) {
                            data = data + "<td class='text-sm align-middle'>Yes</td>"
                        }

                        data = data + "<td class='text-sm align-middle'>"+moment(value.created_at).format('DD/MM/YYYY')+"</td>"
                        data = data + "<td class='text-center'>"
                        data = data + "<button onclick='editDatavPersen("+value.id+")' style='width: 50px;' type='button' class='btn btn-xs btn-primary align-middle m-1'>Edit</button>"
                        data = data + "<button onclick='deleteDatavPersen("+value.id+")' style='width: 50px;' type='button' class='btn btn-xs btn-danger align-middle m-1'>Delete</button>"
                        data = data + "</td>"
                        data = data + "/<tr>"
                    })
                    $('.body-persen').html(data);
                    
                }

            })
        }
        refreshDatavPersen();

        function sumDatavPersenV2(){
            
            $.ajax({
                type:"GET",
                dataType:'json',
                url:"/persentase/sumActive",
                success: function(response){
                    
                    $('.sum-active-status').text(response+'%');
                    // console.log(response);
                    
                }
            })
        }
        sumDatavPersenV2();

        function clearDatavPersen() {
            $('#inputIdPersen').val('');
            $('#inputBagianPersen').val('');
            $('#inputNilaiPersen').val('');
            $('#inputStatusPersen').val('');
            $('#inputStatusHidden').val('');
        }

        function clearErrPersen() {
            $('#inputBagianPersenError').text('');
            $('#inputNilaiPersenError').text('');
            $('#inputStatusPersenError').text('');
            $('#inputStatusHiddenError').text('');
        }

        // ----------------- add data -----------------
        function addDatavPersen() {
            var tmp_bagian = $('#inputBagianPersen').val();
            var tmp_persen = $('#inputNilaiPersen').val();
            var tmp_status = $('#inputStatusPersen').val();
            var tmp_hidded = $('#inputStatusHidden').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    inputBagianPersen: tmp_bagian,
                    inputNilaiPersen: tmp_persen,
                    inputStatusPersen: tmp_status,
                    inputStatusHidden: tmp_hidded
                },
                url: "/persentase/store",
                success: function (data) {
                    clearDatavPersen();
                    clearErrPersen();
                    refreshDatavPersen();
                    sumDatavPersenV2();

                    if (data.errPer) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 8000,
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutRight'
                            },
                            timerProgressBar: true,
                            didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                            },
                        })
                        Toast.fire({
                            icon: 'error',
                            title: data.errPer
                        })
                    }else{
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
                    }
                    
                },
                error: function (error) {
                    clearErrPersen();
                    $('#inputBagianPersenError').text(error.responseJSON.errors.inputBagianPersen);
                    $('#inputNilaiPersenError').text(error.responseJSON.errors.inputNilaiPersen);
                    $('#inputStatusPersenError').text(error.responseJSON.errors.inputStatusPersen);
                    $('#inputStatusHiddenError').text(error.responseJSON.errors.inputStatusHidden);
                }
            })
        }
        // ----------------- and edd data -----------------

        // ----------------- edit data -----------------
        function editDatavPersen(id) {
            clearDatavPersen();
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/persentase/edit/" + id,
                success: function (data) {
                    clearErrPersen();
                    $('#addButtonPersen').addClass('d-none');
                    $('#updateButtonPersen').removeClass('d-none');
                    $('#cencelButtonPersen').removeClass('d-none');

                    $("#inputIdPersen").val(data.id);
                    $("#inputBagianPersen").val(data.bagians_id);
                    $("#inputNilaiPersen").val(data.nilai_persentase);
                    $("#inputStatusPersen").val(data.status_persentase);
                    $("#inputStatusHidden").val(data.status_hidden);
                    // console.log(data);
                }
            })
        }

        function cencelEditDatavPersen(){
            clearDatavPersen();
            clearErrPersen();
            $('#addButtonPersen').removeClass('d-none');
            $('#updateButtonPersen').addClass('d-none');
            $('#cencelButtonPersen').addClass('d-none');
            
        }
        // ----------------- end edit data -----------------

        // ----------------- update data -----------------
        function updateDatavPersen() {
            var tmp_id = $('#inputIdPersen').val();
            var tmp_bagian = $('#inputBagianPersen').val();
            var tmp_persen = $('#inputNilaiPersen').val();
            var tmp_status = $('#inputStatusPersen').val();
            var tmp_hidden = $('#inputStatusHidden').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    inputIdPersen: tmp_id,
                    inputBagianPersen: tmp_bagian,
                    inputNilaiPersen: tmp_persen,
                    inputStatusPersen: tmp_status,
                    inputStatusHidden: tmp_hidden
                },
                url: "/persentase/update/" + tmp_id,
                success: function (data) {
                    clearDatavPersen();
                    clearErrPersen();
                    refreshDatavPersen();
                    sumDatavPersenV2();

                    $('#addButtonPersen').removeClass('d-none');
                    $('#updateButtonPersen').addClass('d-none');
                    $('#cencelButtonPersen').addClass('d-none');
                    if (data.errPer) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 8000,
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutRight'
                            },
                            timerProgressBar: true,
                            didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                            },
                        })
                        Toast.fire({
                            icon: 'error',
                            title: data.errPer
                        })
                    }else{
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
                    }
                    
                },
                error: function (error) {
                    clearErrPersen();
                    $('#inputBagianPersenError').text(error.responseJSON.errors.inputBagianPersen);
                    $('#inputNilaiPersenError').text(error.responseJSON.errors.inputNilaiPersen);
                    $('#inputStatusPersenError').text(error.responseJSON.errors.inputStatusPersen);
                    $('#inputStatusHiddenError').text(error.responseJSON.errors.inputStatusHidden);
                }
            })
        }
        // ----------------- end update data -----------------
        
        // ----------------- delete data -----------------
        function deleteDatavPersen(id) {
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
                            url: "/persentase/delete/" + id,
                            success: function (data) {
                                clearDatavPersen();
                                clearErrPersen();
                                $('#addButtonPersen').show();
                                $('#updateButtonPersen').hide();
                                $('#cencelButtonPersen').hide();
                                refreshDatavPersen();
                                sumDatavPersenV2();
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
        // ----- END PERSENTASE BAGIAN ----------------------------------------------------------------
    </script>

@endsection
