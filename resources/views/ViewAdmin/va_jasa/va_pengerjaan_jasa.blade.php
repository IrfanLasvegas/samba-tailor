@extends("ViewAdmin.va_layout.va_tamplate")

@section('title', 'Samba | Pengerjaan Jasa')

@section('breadcrumbWeb')
    {{-- <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Jasa</a></li>
        <li class="breadcrumb-item active"><a href="#">Pengerjan jasa</a></li>
    </ol> --}}
@endsection

@section('contentWeb')
<script>
    var n=0;
    var tmp_harga=55000;
    var tmp_jasa='Permak PDH';
    var tmp_total=0;
    

    $(function () {
        $('#code-scan').codeScanner();
        $('#code-scan').codeScanner({
        onScan: function ($element, code) {
                // console.log(code);
                // console.log($('#code-scan').val());
                // if ($('#code-scan').val()!) {
                    
                // }

                $('#subHere').click();
                // n+=1;
                // tmp_total+=55000;
                // $(".total-pembayaran").before("<tr><td>"+n+"</td><td>"+tmp_jasa+"</td><td>"+tmp_harga+"</td></tr>");
                
                // $(".Rp-total-pembayaran").text(tmp_total);
            }
        });

    });
</script>

    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0">Pengerjaan</h5>
                    </div>
                    
                       
                    @if ($data ==100)
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-sm-12">
                                <form id="myForm">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="text-sm align-middle">Barcode</td>
                                            <td class="align-middle">
                                                <input type="text" id="code-scan" name="codeScan" class="form-control text-sm" placeholder="...........">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm align-middle">Jasa</td>
                                            <td class="align-middle">
                                                <select class="form-control text-sm" name="nmJasa" id="nmJasa">
                                                    
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="table table-borderless body-persen">

                                    </table>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="text-right mb-4 mt-0">
                                                <button id="subHere" type="submit" style='width: 50px;' class="btn btn-xs btn-primary">Submit</button>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </form>
                                {{-- <option value=""></option> --}}

                                {{-- 
                                
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
                                </table> --}}
                            </div>
                        </div>
                    </div>
                    @else
                        <div class="text-center text-sm text-danger container mt-3">
                            Active status saat ini {{ $data }}%. Proses tambah data di izinkan jika Active status 100%, silahkan lakkan pembaruan di menu header "Bagian".
                        </div>
                    @endif
                    
                </div>
            </div>



            <div class="col-sm-7">
                <div class="card">
                    <div class="card-header">
                        <td colspan="2"><h5 class="card-title ">Riwayat pengerjaan</h5></td>
                        
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="pr-2">
                                <select class="form-control form-control-sm text-sm "  style="width: 120px"   name="chooseBy" id="chooseBy">
                                    <option selected value="today">Hari ini</option>
                                    @can('gateSuperAdmin')
                                    <option value="week">Minggu ini</option>
                                    <option value="month">Bulan ini</option>
                                    <option value="year">Tahun ini</option>
                                    <option value="custom">Custom</option>
                                    @endcan
                                   
                                </select>
                            </div>
                            <div class="pl-2">
                                <select class="form-control form-control-sm text-sm "   name="statusPembayaran" id="statusPembayaran">
                                    <option selected value="all">Semua</option>
                                    <option value="done">Sudah</option>
                                    <option value="notYet">Belum</option>

                                </select>
                            </div>
                        </div>
    
                        <div class="mb-2">
                            
                            <table id="custom-choose" class="custom-choose mt-1 d-none">
                                <tr>
                                    <td><input type="date" class="form-control form-control-sm" style="width: 140px" name="start_date" id="start_date"></td>
                                    <td>-</td>
                                    <td><input type="date" class="form-control form-control-sm" style="width: 140px" name="end_date" id="end_date"></td>
                                    <td><button onclick="checkHistory()" style="width: 50px;" type="button" class="btn btn-sm btn-secondary align-middle text-sm ml-1 ">cek</button></td>
                                </tr>
                            </table>
                            
                        </div>
                        <div id="table_data">
                            @include('ViewAdmin.va_jasa.va_pengerjaan_jasa_pagination_data')
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- <script>
                $('#chooseBy').on('change', function() {
                    alert( $('#chooseBy').val());
                });
            </script> --}}

        </div>
    </div>
    <!-- Modal show-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Pengerjaan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form id="myFormUpdate">
                <div class="modal-body">
                        
                        <table class="table table-borderless body-show-one-pengerjaan">

                        </table>
                    
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" id="updateButton"  style='width: 50px;' class="btn btn-xs btn-primary">update</button>
                </div>
            </form>
            {{-- <button id='cencelButton' onclick='cekPembayaranDatav()' style='width: 80px;position: absolute; bottom:16px;right: 70px' class='btn btn-xs btn-info'>pembayaran</button> --}}
        </div>
        </div>
    </div>

    <!-- Modal show cek pembayaran-->
    <div class="modal fade" id="myModalCekPembayaran" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="body-show-one-cek-pembayaran">

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

        function hargaJasaDatav() {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "harga/allActive",
                success: function (response) {
                    var data = ""
                    data = data + "<option value=''> --- Pilih Jasa --- </option>"
                    $.each(response, function (key, value) {
                        data = data + "<option value='" + value.id + "'>" + value.jasas.nama_jasa + "</option>"
                    })
                    $('#nmJasa').html(data)
                }
            })
        }
        hargaJasaDatav();

        function bagianPersenDatav() {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "persentase/allActive",
                success: function (response) {
                    var data=""
                    var n=0;                    
                    $.each(response,function(key, value){
                        n+=1;
                                                
                        if (value.status_hidden == 0) {
                            data = data + "<tr>"
                            data = data + "<td class='text-sm align-middle'>"+value.bagians.nama_bagian+"</td>"    
                        } else if (value.status_hidden == 1){
                            data = data + "<tr class='d-none'>"
                            data = data + "<td class='text-sm align-middle'>"+value.bagians.nama_bagian+"</td>"    
                        }
                        data = data + "<td class='align-middle'>"
                        if (value.status_hidden == 0) {
                            data = data + "<select class='form-control  text-sm nmPersen' name='nmPersen"+value.id+"' id='nmPersen"+value.id+"'>"
                        } else if(value.status_hidden == 1){
                            data = data + "<select hidden class='form-control  text-sm nmPersen' name='nmPersen"+value.id+"' id='nmPersen"+value.id+"'>"
                        }
                        
                        data = data + "</select>"
                        data = data + "</td>"
                        data = data + "/<tr>"
                        $.ajax({
                            type: "GET",
                            dataType: 'json',
                            url: "manage-user/all",
                            success: function (response2) {
                                var tmp_id='nmPersen'+value.id;
                                var data2 = ""
                                data2 = data2 + "<option value=''> --- Pilih Pekerja --- </option>"
                                $.each(response2, function (key2, value2) {
                                    if (value2.persentases_id != null) {
                                        if(value.bagians_id == value2.persentases.bagians_id){
                                            data2 = data2 + "<option selected value='" + value2.id + "'>" + value2.name + "</option>"
                                        }else{
                                            data2 = data2 + "<option value='" + value2.id + "'>" + value2.name + "</option>"
                                        }
                                    }else{
                                        data2 = data2 + "<option value='" + value2.id + "'>" + value2.name + "</option>"
                                    }
                                })
                                $('#'+tmp_id).html(data2);
                                // console.log(response2);
                            }
                        });
                    });
                    $('.body-persen').html(data);
                    // console.log(response);
                    

                }
            })
        }
        bagianPersenDatav();
        

        // ----------------- add data -----------------
        $( "#myForm" ).on( "submit", function( event ) {
            var formdata = $(this).serialize();
            event.preventDefault();
            $.ajax({
                type: "POST",
                dataType: "json",
                data:formdata,
                url: "/pengerjaan/store",
                success: function (data) {
                    // console.log(data);
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
                        $('#code-scan').val('');
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
                    }
                }
            })
        });
        // ----------------- end add data -----------------


        // ----------------- show data history -----------------
        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page) {
            var tmp_chooseBy = $('#chooseBy').val();
            var tmp_start_date = $('#start_date').val();
            var tmp_end_date = $('#end_date').val();
            var tmp_statusPembayaran = $('#statusPembayaran').val();
            
            $.ajax({
                data: {
                    chooseBy: tmp_chooseBy,
                    start_date: tmp_start_date,
                    end_date: tmp_end_date,
                    statusPembayaran: tmp_statusPembayaran
                },
                url: "/pengerjaan/all?page=" + page,
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

        // ----------------- choose data show -----------------
        $('#chooseBy').on('change', function() {
            if ($('#chooseBy').val() == 'custom') {
                $('#custom-choose').removeClass('d-none');
            }else{
                $('#custom-choose').addClass('d-none');
                // refreshDatav();
                refreshToFirstPaginationDatav();
            }
            
        });

        $('#statusPembayaran').on('change', function() {
            if ($('#chooseBy').val() == 'custom') {
                $('#custom-choose').removeClass('d-none');
            }else{
                $('#custom-choose').addClass('d-none');
                // refreshDatav();
                refreshToFirstPaginationDatav();
            }
            
        });

        function checkHistory(){
            refreshToFirstPaginationDatav();
        }
        // ----------------- end choose data show -----------------

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



        // ----------------- edit data -----------------
        function showDatav(id){
            $('#cekPembayaranButton').remove();
            $('#myModal').modal('show');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/pengerjaan/edit/" + id,
                success: function (response) {
                    var data=""
                    var n=0;
                    $.each(response,function(key, value){
                        n+=1;
                        if (n==1) {
                            if (value.status_pengerjaan == '1') {
                                $('#myModal .modal-content').append("<button id='cekPembayaranButton' onclick='cekPembayaranDatav("+value.id+","+value.barcode+")' style='width: 80px;position: absolute; bottom:16px;right: 70px' class='btn btn-xs btn-info'>pembayaran</button>");   
                            }
                            data = data + "<input type='hidden' name ='idBarcode' id='idBarcode' value='"+value.barcode+"'>"
                            data = data + "<tr>"
                            data = data + "<td class='text-sm align-middle'>jasa</td>"
                            data = data + "<td class='align-middle'>"
                            data = data + "<select class='form-control  text-sm nmHargaJasa' name='nmHargaJasa' id='nmHargaJasa'>"
                            data = data + "<option value=''> --- Pilih Jasa--- </option>"
                            data = data + "</select>"
                            data = data + "</td>"
                            data = data + "</tr>"
                            $.ajax({
                                type: "GET",
                                dataType: 'json',
                                url: "/harga/allActive",
                                success: function (responsej) {
                                    var dataj = ""
                                    var len = Object.keys(responsej).length;
                                    var n_loop=0;
                                    var cek_harga=false;
                                    dataj = dataj + "<option value=''> --- Pilih jasa  --- </option>"
                                    $.each(responsej, function (keyj, valuej) {
                                        n_loop=n_loop+1;
                                        
                                        if(value.harga_jasas_id == valuej.id){
                                            cek_harga=true;
                                            dataj = dataj + "<option selected value='" + valuej.id + "'>" + valuej.jasas.nama_jasa + "</option>"
                                        }else{
                                            dataj = dataj + "<option value='" + valuej.id + "'>" + valuej.jasas.nama_jasa + "</option>"
                                        } 
                                        
                                        if (len == n_loop) {
                                            if (cek_harga==false) {
                                                dataj = dataj + "<option selected value='" + value.harga_jasas_id + "'>" + value.harga_jasas.jasas.nama_jasa + "</option>"
                                            }
                                        }
                                        
                                    })
                                    $('#nmHargaJasa').html(dataj);
                                }
                            });
                        }
                        if (value.persentases.status_hidden == 0) {
                            data = data + "<tr>"
                        }else if (value.persentases.status_hidden == 1) {
                            data = data + "<tr class='d-none'>"    
                        } 
                        data = data + "<td class='text-sm align-middle'>"+value.persentases.bagians.nama_bagian+"</td>"
                        data = data + "<td class='align-middle'>"
                        data = data + "<select class='form-control  text-sm nmPersenU' name='nmPersenU"+value.persentases_id+"' id='nmPersenU"+value.persentases_id+"'>"
                        // data = data + "<option value=''> --- Pilih Pekerja--- </option>"
                        data = data + "</select>"
                        data = data + "</td>"
                        data = data + "</tr>"
                        $.ajax({
                            type: "GET",
                            dataType: 'json',
                            url: "/manage-user/all",
                            success: function (response2) {
                                var tmp_id='nmPersenU'+value.persentases_id;
                                var data2 = ""
                                data2 = data2 + "<option value=''> --- Pilih Pekerja --- </option>"
                                $.each(response2, function (key2, value2) {
                                    
                                    if(value.users_id == value2.id){
                                        data2 = data2 + "<option selected value='" + value2.id + "'>" + value2.name + "</option>"
                                    }else{
                                        data2 = data2 + "<option value='" + value2.id + "'>" + value2.name + "</option>"
                                    } 
                                })
                                $('#'+tmp_id).html(data2);
                            }
                        });
                    });
                    $('.body-show-one-pengerjaan').html(data);
                }
            })
        
        }

        function cekPembayaranDatav(id, brcd){
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/pengerjaan/check-payment/" + id,
                success: function(response) {
                    console.log(response);
                    if (response.errPer) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2600,
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
                            title: response.errPer
                        })
                    } else {
                        $('#myModal').modal('hide');
                        $('#myModalCekPembayaran').modal('show');
                        var len=Object.keys(response).length;
                        var data = ""
                        var ii=0;
                        $.each(response, function(key, value) {
                            if (ii == 0) {
                                data = data + "<div class='modal-body text-sm'>"
                                data = data + "<div class='d-flex flex-row' style='margin-bottom: -5px'>"
                                data = data + "<div class='mr-1'><span style='font-size: 20px; color: rgb(100, 100, 99)'><i class='fas fa-cash-register'></i></span></div>"
                                data = data + "<div class='d-flex flex-column'><div  style='font-size: 11px; margin-bottom: -5px'>#" + value[0].pembayarans_id + "</div><div style='font-size: 11px'>" + value[0].pembayarans.users.name + "</div></div>"
                                data = data + "</div>"
                                data = data + "<div style='font-size: 11px'>" +moment(value[0].created_at).format('Do MMMM YYYY, HH:mm:ss') + "</div>"
                                data = data + "<table class='table   mt-1'>"
                                data = data + "<thead><th>#</th><th>jasa</th><th>harga</th></thead>"
                                data = data + "<tbody>"
                                if (value[0].pengerjaans.barcode == brcd) {
                                    console.log("---1");
                                    data = data + "<tr style='background:rgba(228, 228, 228, 0.2)'>";
                                    data = data + "<td>"+ (ii+1) +"</td>"
                                    data = data + "<td>"+ value[0].pengerjaans.harga_jasas.jasas.nama_jasa +"</td>"
                                    data = data + "<td>"+ value[0].pengerjaans.harga_jasas.nominal_harga_jasa +"</td>"
                                    data = data + "</tr>"
                                }else{
                                    data = data + "<tr>";
                                    data = data + "<td>"+ (ii+1) +"</td>"
                                    data = data + "<td>"+ value[0].pengerjaans.harga_jasas.jasas.nama_jasa +"</td>"
                                    data = data + "<td>"+ value[0].pengerjaans.harga_jasas.nominal_harga_jasa +"</td>"
                                    data = data + "</tr>"
                                }
                                
                            }else{
                                if (value[0].pengerjaans.barcode == brcd) {
                                    console.log("---2");
                                    data = data + "<tr style='background:rgba(228, 228, 228, 0.2)'>";
                                    data = data + "<td>"+ (ii+1) +"</td>"
                                    data = data + "<td>"+ value[0].pengerjaans.harga_jasas.jasas.nama_jasa +"</td>"
                                    data = data + "<td>"+ value[0].pengerjaans.harga_jasas.nominal_harga_jasa +"</td>"
                                    data = data + "</tr>"
                                }else{
                                    data = data + "<tr>";
                                    data = data + "<td>"+ (ii+1) +"</td>"
                                    data = data + "<td>"+ value[0].pengerjaans.harga_jasas.jasas.nama_jasa +"</td>"
                                    data = data + "<td>"+ value[0].pengerjaans.harga_jasas.nominal_harga_jasa +"</td>"
                                    data = data + "</tr>"
                                }
                                
                            }

                            if (ii == (len-1)) {                           
                                parseInt(value[0].pembayarans.total_pembayaran)
                                data = data + "<tr>";
                                data = data + "<td colspan='2'>Total</td>"
                                data = data + "<td>"+ value[0].pembayarans.total_pembayaran +"</td>"
                                data = data + "</tr>"
                                data = data + "</tbody> "
                                data = data + "<tr>";
                                data = data + "<td colspan='2'>Tunai</td>"
                                data = data + "<td>"+ value[0].pembayarans.tunai_pembayaran +"</td>"
                                data = data + "</tr>"
                                data = data + "</tbody> "
                                data = data + "<tr>";
                                data = data + "<td colspan='2'>Kembalian</td>"
                                data = data + "<td>"+ (parseInt(value[0].pembayarans.tunai_pembayaran)-parseInt(value[0].pembayarans.total_pembayaran)) +"</td>"
                                data = data + "</tr>"
                                data = data + "</tbody> "
                                data = data + "</table>"
                                data = data + "</div>"

                                data = data + "<div class='modal-footer'>"
                                data = data + "<button id='cencelButton' onclick='printOneHistory("+value[0].pembayarans_id+")' style='width: 50px;' class='btn btn-xs btn-info'><i class='fas fa-print'></i></button>"
                                data = data + " </div>"
                            } 
                            ii+=1;
                        })
                        $('.body-show-one-cek-pembayaran').html(data);
                    }
                },
            })
        }
        // ----------------- end edit data -----------------


        // ----------------- update data -----------------
        $( "#myFormUpdate" ).on( "submit", function( event ) {
            var formdata = $(this).serialize();
            var tmp_id = $('#idBarcode').val();
            event.preventDefault();
            $.ajax({
                type: "POST",
                dataType: "json",
                data:formdata,
                url: "/pengerjaan/update/" + tmp_id,
                success: function (data) {
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
                        refreshDatav();
                        $('#myModal').modal('hide');
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
                }
            })
        });
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
                            url: "/pengerjaan/delete/" + id,
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
        
    </script>

@endsection
