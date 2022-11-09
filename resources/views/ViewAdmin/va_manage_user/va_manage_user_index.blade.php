@extends("ViewAdmin.va_layout.va_tamplate")

@section('title', 'Samba | Jasa')

@section('breadcrumbWeb')
    {{-- <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"><a href="#">Pengguna</a></li>
    </ol> --}}
@endsection

@section('contentWeb')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0">Pengguna</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">                                                           
                                <div class="text-right mb-1" style="width: 100%">
                                    <button type="submit" id="ButtonShowFormAdd" onclick="showFormAdd()"style='width: 50px;' class="btn btn-xs btn-primary">Add</button>
                                </div>
                                <div id="table_data" style="width: 100%">
                                    @include('ViewAdmin.va_manage_user.va_manage_user_pagination_data')
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>


    <!-- Modal show-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title add-title">Add Pengguna</h5>
                    <h5 class="modal-title edit-title">Edit Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">                        
                    <table class="table table-borderless">
                        <input type="hidden" id="inputIdUser">
                        
                        <tr>
                            <td>Nama</td>
                            <td>
                                <input type="text" id="inputNama" class="form-control text-sm" placeholder="............">
                                <span class="text-danger" id="inputNamaError"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>
                                <input type="text" id="email" class="form-control text-sm" placeholder="............">
                                <span class="text-danger" id="emailError"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td>
                                <input type="password" id="inputPassword" class="form-control text-sm" placeholder="............">
                                <span class="text-danger" id="inputPasswordError"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Persentase</td>
                            <td>
                                <select class="form-control text-sm" id="inputPersentase">

                                </select>
                                <span class="text-danger" id="inputPersentaseError"> </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td>
                                <select class="form-control text-sm" id="inputRole">

                                </select>
                                <span class="text-danger" id="inputRoleError"> </span>
                            </td>
                        </tr>
                    
                        
                    </table>                   
                </div>
                <div class="modal-footer">
                    <button type="submit" id="ButtonAddDatav" onclick="addDatav()"style='width: 50px;' class="btn btn-xs btn-primary">Submit</button>
                    <button id="ButtonCencelEditDatav" onclick="cencelEditDatav()" style='width: 50px;' class="btn btn-xs btn-danger">Cancel</button>
                    <button type="submit" id="ButtonUpdateDatav" onclick="updateDatav()" style='width: 50px;' class="btn btn-xs btn-primary">Update</button>
                </div>

            </div>
        </div>
    </div>
    

    <script>
            
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function bagianPersenDatav() {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "persentase/allActive",
                success: function (response) {
                    var data = ""
                    data = data + "<option value=''> --- Pilih persentase --- </option>"
                    $.each(response, function (key, value) {
                        data = data + "<option value='" + value.id + "'>" + value.bagians.nama_bagian + "</option>"
                    })
                    $('#inputPersentase').html(data)
                    // console.log(response);
                }

            })
        }
        bagianPersenDatav();

        function roleDatav() {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "role/all",
                success: function (response) {
                    var data = ""
                    data = data + "<option value=''> --- Pilih role --- </option>"
                    $.each(response, function (key, value) {
                        data = data + "<option value='" + value.id + "'>" + value.namerole + "</option>"
                    })
                    $('#inputRole').html(data)
                    // console.log(response);
                }

            })
        }
        roleDatav();

        function showFormAdd(){
            $('.add-title').removeClass('d-none');
            $('.edit-title').addClass('d-none');
            $('#ButtonUpdateDatav').addClass('d-none');
            $('#ButtonCencelEditDatav').addClass('d-none');
            $('#ButtonAddDatav').removeClass('d-none');
            clearDatav();
            clearErr();
            $('#myModal').modal('show');
        }
        function addDatav(){
            var tmp_name = $('#inputNama').val();
            var tmp_email = $('#email').val();
            var tmp_password = $('#inputPassword').val();
            var tmp_persentase = $('#inputPersentase').val();
            var tmp_role = $('#inputRole').val();
            

            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    inputNama: tmp_name,
                    email: tmp_email,
                    inputPassword: tmp_password,
                    inputPersentase: tmp_persentase,
                    inputRole: tmp_role,
                },
                url: "/manage-user/store",
                success: function (data) {
                    // console.log(data);
                    clearDatav();
                    clearErr();
                    $('#myModal').modal('hide');
                    refreshToFirstPaginationDatav();

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
                    // console.log(error);
                    clearErr();
                    $('#inputNamaError').text(error.responseJSON.errors.inputNama);
                    $('#emailError').text(error.responseJSON.errors.email);
                    $('#inputPasswordError').text(error.responseJSON.errors.inputPassword);
                    $('#inputRoleError').text(error.responseJSON.errors.inputRole);
                }
            })
        }


        function clearDatav() {
            $('#inputIdUser').val('');
            $('#inputNama').val('');
            $('#email').val('');
            $('#inputPassword').val('');
            $('#inputPersentase').val('');
            $('#inputRole').val('');
        }

        function clearErr() {
            $('#inputNamaError').text('');
            $('#emailError').text('');
            $('#inputPasswordError').text('');
            $('#inputPersentaseError').text('');
            $('#inputRoleError').text('');
        }
        
        // ----------------- edit data -----------------
        function editDatav (id){
            clearDatav();
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/manage-user/edit/" + id,
                success: function (data) {
                    clearErr();
                    $('.add-title').addClass('d-none');
                    $('.edit-title').removeClass('d-none');
                    $('#ButtonUpdateDatav').removeClass('d-none');
                    $('#ButtonCencelEditDatav').removeClass('d-none');
                    $('#ButtonAddDatav').addClass('d-none');
                    $('#myModal').modal('show');
                    // console.log(data);

                    $("#inputIdUser").val(data[0].id);
                    $("#inputNama").val(data[0].name);
                    $("#email").val(data[0].email);
                    $("#inputRole").val(data[0].roles.id);
                    if (data[0].persentases == null) {
                        $("#inputPersentase").val('');
                    }else{
                        
                        $("#inputPersentase").val(data[0].persentases.id);
                        
                    } 
                }
            })

        }

        function cencelEditDatav(){
            clearDatav();
            clearErr();
            $('#myModal').modal('hide');
        }
        // ----------------- end edit data -----------------

        // ----------------- update data -----------------
        function updateDatav(){
            var tmp_id = $('#inputIdUser').val();
            var tmp_name = $('#inputNama').val();
            var tmp_email = $('#email').val();
            var tmp_password = $('#inputPassword').val();
            var tmp_persentase = $('#inputPersentase').val();
            var tmp_role = $('#inputRole').val();

            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    inputNama: tmp_name,
                    email: tmp_email,
                    inputPassword: tmp_password,
                    inputPersentase: tmp_persentase,
                    inputRole: tmp_role,
                },
                url: "/manage-user/update/" + tmp_id,
                success: function (data) {
                    // console.log(data);
                    clearDatav();
                    clearErr();
                    $('#myModal').modal('hide');
                    refreshDatav();

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
                    $('#inputNamaError').text(error.responseJSON.errors.inputNama);
                    $('#emailError').text(error.responseJSON.errors.email);
                    $('#inputPasswordError').text(error.responseJSON.errors.inputPassword);
                    $('#inputRoleError').text(error.responseJSON.errors.inputRole);
                }
            })
        }
        // ----------------- end update data -----------------

        // ----------------- delete data -----------------
        function deleteDatav(id){
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
                            url: "/manage-user/delete/" + id,
                            success: function (data) {
                                refreshDatav();
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

























        // ----------------- show data history -----------------
        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page) {

            $.ajax({
                url: "/manage-user/all2?page=" + page,
                success: function (data) {
                    $('#table_data').html(data);
                    // console.log(data);
                },
                error: function (error) {
                    if (error.responseJSON.errPer) {
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
                            icon: 'error',
                            title: error.responseJSON.errPer
                        })
                    }
                }
            });

        }

        // ----------------- refresh data -----------------
        function refreshDatav() {
            var page = $('.active .page-link').text();
            fetch_data(page);
        }
        // ----------------- end refresh data -----------------

        // ----------------- refresh data to first page-----------------
        function refreshToFirstPaginationDatav() {
            var page = '1';
            fetch_data(page);
        }
        // ----------------- end refresh data to first page -----------------
        // -------------------- end show all data history -------------------

        
        
    </script>

@endsection
