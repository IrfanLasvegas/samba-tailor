@extends("ViewAdmin.va_layout.va_tamplate")

@section('title', 'Samba | Jasa')

@section('breadcrumbWeb')
    {{-- <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"><a href="#">Jasa</a></li>
    </ol> --}}
@endsection

@section('contentWeb')
    <div class="container">
        <div class="row">
            



            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <td colspan="2"><h5 class="card-title ">Penghasilan</h5></td>
                        
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="pr-2">
                                <select class="form-control form-control-sm text-sm "  style="width: 120px"   name="chooseBy" id="chooseBy">
                                    <option selected value="today">Hari ini</option>
                                    <option value="week">Minggu ini</option>
                                    <option value="month">Bulan ini</option>
                                    <option value="year">Tahun ini</option>
                                    <option value="custom">Custom</option>
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
                        <table class="body-total-penghasilan mt-3 mb-2">
                            
                        </table>
                        <div id="table_data" class="table-responsive">
                            @include('ViewAdmin.va_penghasilan.va_penghasilan_pagination_data')
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

                    {{-- <button id="cencelButton" onclick="cencelEditDatav()" style='width: 50px;' class="btn btn-xs btn-danger">cancel</button> --}}
                    <button type="submit"  style='width: 50px;' class="btn btn-xs btn-primary">update</button>
                    
                </div>
            </form>
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














        function totalPenghasilanTiapUser() {
            var tmp_chooseBy = $('#chooseBy').val();
            var tmp_start_date = $('#start_date').val();
            var tmp_end_date = $('#end_date').val();
            var tmp_statusPembayaran = $('#statusPembayaran').val();
            $.ajax({
                type: "POST",
                data: {
                    chooseBy: tmp_chooseBy,
                    start_date: tmp_start_date,
                    end_date: tmp_end_date,
                    statusPembayaran: tmp_statusPembayaran
                },
                url: "/penghasilan/checkTotal",
                success: function (response) {
                    // console.log(typeof response[11]);
                    var data=""
                    var n=0;
                    var total_penghasilan=0;
                    $.each(response,function(key, value){
                        n+=1;
                        for (var k in value) {
                            if (value.hasOwnProperty(k)) {
                                data = data + "<tr>"
                                data = data + "<td class='text-sm align-middle text-capitalize'>"+k+"</td>"
                                data = data + "<td class='text-sm align-middle text-capitalize pl-2 pr-2'>:</td>"
                                data = data + "<td class='text-sm align-middle text-capitalize'>"+formatRupiah(value[k].toString(), 'Rp. ')+"</td>"
                                data = data + "</tr>"
                                total_penghasilan += value[k];
                                // console.log(k + " -> " + value[k]);
                            }
                        }
                    });
                    data = data + "<tr>"
                    data = data + "<td class='text-sm align-middle text-capitalize text-bold'>total</td>"
                    data = data + "<td class='text-sm align-middle text-capitalize text-bold pl-2 pr-2'>:</td>"
                    data = data + "<td class='text-sm align-middle text-capitalize text-bold'>"+formatRupiah(total_penghasilan.toString(), 'Rp. ')+"</td>"
                    data = data + "</tr>"
                    $('.body-total-penghasilan').html(data);
                },
                error: function (error) {
                    
                }
            });

        }



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
                type: "POST",
                data: {
                    chooseBy: tmp_chooseBy,
                    start_date: tmp_start_date,
                    end_date: tmp_end_date,
                    statusPembayaran: tmp_statusPembayaran
                },
                url: "/penghasilan/all?page=" + page,
                success: function (data) {
                    totalPenghasilanTiapUser();
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
                $('.custom-choose').removeClass('d-none');
            }else{
                $('.custom-choose').addClass('d-none');
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

        refreshToFirstPaginationDatav();
        // ----------------- end refresh data to first page -----------------
        // -------------------- end show all data history -------------------



        // ----------------- edit data -----------------
        function showDatav(id){
            $('#cekPembayaranButton').remove();
            $('#myModal').modal('show');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/penghasilan/edit/" + id,
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
                                    dataj = dataj + "<option value=''> --- Pilih Pekerja --- </option>"
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
                        data = data + "<tr>"
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
                url: "/penghasilan/update/" + tmp_id,
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
                            url: "/penghasilan/delete/" + id,
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
