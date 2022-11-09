@extends('ViewAdmin.va_layout.va_tamplate')

@section('title', 'Samba | Home')

@section('breadcrumbWeb')
    {{-- <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active"><a href="#">Kasir</a></li>
</ol> --}}
@endsection

@section('contentWeb')


    <script>
        var nJS = 0;
        var tmp_total = 0;

        $(function() {
            $('#code-scan').codeScanner();
            $('#code-scan').codeScanner({
                onScan: function($element, code) {
                    addToCart();
                }
            });
        });
    </script>

    <div class="container">
        <div class="row">
            <div class="col-sm-7">
                <div class="card text-sm" style="color: rgb(100, 100, 99)">
                    <div class="card-header" style="margin-bottom: -12px">
                        <h5 class="card-title m-0">Kasir</h5>
                    </div>
                    <div class="card-body">
                        <table class="mb-2" style="width: 100%">
                            <tr>
                                <td>
                                    <input id="code-scan" type="text" class="form-control form-control-sm text-sm"
                                        placeholder="Scanned code" style="width: 200px">
                                </td>
                                <td>

                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <input id="tunai" name="tunai" type="text"
                                        class="form-control form-control-sm text-sm"
                                        placeholder="Tunai"style="width: 200px">
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <button id="payAndPrintButton" onclick="payAndPrint()" style='width: 90px;'
                                        class="btn btn-xs btn-info"><i class="fas fa-print"></i></button>
                                    <button id="addToCartButton" onclick="addToCart()" style='width: 51px; '
                                        class="btn btn-xs btn-primary"><i class="fas fa-plus-circle"></i></button>
                                    <button id="CancelCartButton" onclick="CancelCart()" style='width: 51px;'
                                        class="btn btn-xs btn-danger "><i class="fas fa-times-circle"></i></button>
                                </td>
                                <td class="pr-1 text-sm">
                                    <div class="d-flex flex-row-reverse" style="margin-bottom: -11px">
                                        {{-- <div style="color: #6c757d">
                                            <span style="font-size: 20px; color: rgb(100, 100, 99);">
                                                <i class="fas fa-users"></i>
                                            </span>Umum/Cash
                                        </div> --}}
                                        {{-- <div class="mr-4"></div> --}}
                                        <div style="color: #6c757d">
                                            <span style="font-size: 20px; color: rgb(100, 100, 99)">
                                                <i class=" fas fa-cash-register"></i>
                                            </span>{{ auth()->user()->name }}
                                        </div>

                                    </div>

                                </td>
                            </tr>
                        </table>
                        <table class="table">
                            <thead class="border-top">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Jasa</th>
                                    <th scope="col">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="pembayaran-pelanggan">
                                @if (session()->has('sesCart'))
                                    @php
                                        $collection = collect(session('sesCart'))->toArray();
                                        $no = 0;
                                    @endphp
                                    @foreach ($collection as $key => $value)
                                        <script>
                                            nJS += 1;
                                            tmp_total += parseInt("{{ $value[2] }}");
                                        </script>
                                        @php
                                            $no += 1;
                                            $tmp_code = 0;
                                        @endphp
                                        <tr class="LIST-PEMBAYARAN" id="code-{{ $value[0] }}">
                                            @foreach ($value as $key2 => $value2)
                                                @if ($loop->iteration == 1)
                                                    <td>{{ $no }}</td>
                                                    @php
                                                        $tmp_code = $value2;
                                                    @endphp
                                                @elseif($loop->iteration == 2)
                                                    <td>{{ $value2 }}</td>
                                                @elseif($loop->iteration == 3)
                                                    <td>Rp {{ number_format($value2,0,".",".") }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endif

                                <!-- list jasa -->
                                <tr class="total-pembayaran">
                                    <td colspan="2">Total</td>
                                    <td class="Rp-total-pembayaran"></td>
                                </tr>
                                <tr class="">
                                    <td colspan="2">Tunai</td>
                                    <td class="Rp-tunai"></td>
                                </tr>
                                <tr class="">
                                    <td colspan="2">Kembalian</td>
                                    <td class="Rp-kembalian"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>



                <div class="card text-sm  text-color1">

                </div>
            </div>

            <div class="col-sm-5">

                <div class="card text-sm" style="color: rgb(100, 100, 99); min-height: 359px">
                    <div class="card-header" style="margin-bottom: -12px">
                        <h5 class="card-title m-0">Riwayat pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <select class="form-control form-control-sm   text-color1 " name="chooseBy" id="chooseBy"
                                style="width: 80px; height:25px; font-size:11px">
                                <option value="today">Hari ini</option>
                                <option value="week">Minggu ini</option>
                                <option value="month">Bulan ini</option>
                                <option value="year">Tahun ini</option>
                                <option value="custom">Custom</option>
                            </select>
                            <table id="custom-choose" class="custom-choose mt-1 d-none">
                                <tr>
                                    <td><input type="date" class="form-control form-control-sm" name="start_date"
                                            id="start_date" style="width: 120px; height:25px; font-size:11px"></td>
                                    <td>-</td>
                                    <td><input type="date" class="form-control form-control-sm" name="end_date"
                                            id="end_date" style="width: 120px; height:25px; font-size:11px"></td>
                                    <td><button onclick="checkHistory()" class="btn btn-xs btn-primary ml-1"
                                            style="width: 27px; height:24px; font-size:1px"><i
                                                class="fas fa-search"></i></button></td>
                                </tr>
                            </table>
                        </div>
                        <div id="table_data">
                            @include('ViewAdmin.va_pembayaran.va_pembayaran_pagination_data')
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-7">

            </div>

            <div class="col-sm-5">


            </div>

        </div>
        <!-- Modal show-->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="body-show-one">

                    </div>

                </div>
            </div>
        </div>


        <div style="height: 150px"></div>



    </div><!-- /.container-fluid -->

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        if (tmp_total == 0) {
            $(".Rp-total-pembayaran").text("");
        } else {
            $(".Rp-total-pembayaran").text(formatRupiah(tmp_total.toString(), 'Rp. '));
        }
        $('#tunai').keyup(function() {
            tunai.value = formatRupiah(this.value, 'Rp. ');
            var del_tunai_Rp=formatRupiah(this.value, 'Rp. ').replace('Rp. ','')
            var del_tunai_dot=del_tunai_Rp.replaceAll('.','')
            // console.log(f1);
            // console.log(del_tunai_dot);
            // var tmp_tunai = parseInt($('input[name="tunai"]').val());
            tmp_tunai=del_tunai_dot
            var tmp_kembalian = tmp_tunai - tmp_total;
            $(".Rp-tunai").text(formatRupiah(tmp_tunai.toString(), 'Rp. '));

            // if ((tmp_tunai)>=tmp_total ) {
            //     $(".Rp-kembalian").text(formatRupiah(tmp_kembalian.toString(), 'Rp. '));
            // } else {
            //     $(".Rp-kembalian").text('Rp. -')
            // }

            $(".Rp-kembalian").text(formatRupiah2(tmp_kembalian.toString(), 'Rp. ', tmp_tunai, tmp_total));
            

            
            // console.log(tmp_tunai);
            
        });




        // ----------------- add data -----------------
        function addToCart() {
            var tmp_code_scan = $('#code-scan').val();

            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    codeScan: tmp_code_scan
                },
                url: "/pembayaran/store",
                success: function(response) {
                    // console.log(response.barcode);
                    nJS += 1;
                    tmp_total += parseInt(response.harga_jasas.nominal_harga_jasa);
                    $(".total-pembayaran").before("<tr class='LIST-PEMBAYARAN' id=code-" + response.barcode +
                        "><td>" + nJS + "</td><td>" + response.harga_jasas.jasas.nama_jasa + "</td><td>" +
                            formatRupiah(response.harga_jasas.nominal_harga_jasa, 'Rp. ') + "</td></tr>");
                    $(".Rp-total-pembayaran").text(formatRupiah(tmp_total.toString(), 'Rp. '));
                    $('#code-scan').val("");
                },
                error: function(error) {
                    // console.log(error);
                    if (error.responseJSON.errPer) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutRight'
                            },
                            width: 280,
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
                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
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
                            title: error.responseJSON.errors.codeScan
                        })
                    }


                }
            })
        }
        // ----------------- and edd data -----------------


        // ----------------- cancel data -----------------
        function CancelCart() {
            Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Semua list pembayaran akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        var tmp_code_scan = $('#code-scan').val();
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            data: {
                                codeScan: tmp_code_scan
                            },
                            url: "/pembayaran/cancel",
                            success: function(response) {
                                console.log(response);
                                $('.LIST-PEMBAYARAN').remove();
                                $(".Rp-total-pembayaran").text("");
                                $('#code-scan').val("");
                                $('#tunai').val("");
                                $(".Rp-tunai").text("");
                                $(".Rp-kembalian").text("");
                                tmp_total = 0

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
                                    title: response
                                })
                                // ----------------- end alert -----------------
                            },
                            error: function(error) {

                            }
                        })
                    }
                })

        }
        // ----------------- and cancel data -----------------

        // ----------------- print data -----------------
        function payAndPrint() {
            var tmp_tunai = $('#tunai').val();


            
            var tmp_tunai=tmp_tunai.replace('Rp. ','')
            var tmp_tunai=tmp_tunai.replaceAll('.','')
            // console.log(f1);
            // console.log(del_tunai_dot);
            // var tmp_tunai = parseInt($('input[name="tunai"]').val());
            // tmp_tunai=del_tunai_dot
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    tunai: tmp_tunai
                },
                url: "/pembayaran/print",
                success: function(response) {
                    // console.log(response);
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
                        title: 'Transaksi pembayaran berhasil'
                    })
                    // ----------------- end alert -----------------

                    $('.LIST-PEMBAYARAN').remove();
                    $(".Rp-total-pembayaran").text("");
                    $('#code-scan').val("");
                    $('#tunai').val("");
                    $(".Rp-tunai").text("");
                    $(".Rp-kembalian").text("");
                    tmp_total = 0

                    // list pembayaran yg di print
                    console.log('list pembayaran yg di print');
                    $.each(response, function(key, value) {
                        console.log(value);
                    })
                },
                error: function(error) {
                    // console.log(error);
                    if (error.responseJSON.errPer) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
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
                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
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
                            title: error.responseJSON.errors.tunai
                        })
                    }
                }
            })
        }
        // ----------------- end print data -----------------
















        // ----------------- show one data -----------------
        function showDatav(id) {
            $('#myModal').modal('show');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/pembayaran/edit/" + id,
                success: function(response) {
                    var len = Object.keys(response).length;
                    var data = ""

                    var ii = 0;
                    // var sumHarga=0;
                    $.each(response, function(key, value) {
                        if (ii == 0) {
                            data = data + "<div class='modal-body text-sm'>"
                            data = data + "<div class='d-flex flex-row' style='margin-bottom: -5px'>"
                            data = data +
                                "<div class='mr-1'><span style='font-size: 20px; color: rgb(100, 100, 99)'><i class='fas fa-cash-register'></i></span></div>"
                            data = data +
                                "<div class='d-flex flex-column'><div  style='font-size: 11px; margin-bottom: -5px'>#" +
                                value[0].pembayarans_id + "</div><div style='font-size: 11px'>" + value[
                                    0].pembayarans.users.name + "</div></div>"
                            data = data + "</div>"
                            data = data + "<div style='font-size: 11px'>" + moment(value[0].created_at)
                                .format('Do MMMM YYYY, HH:mm:ss') + "</div>"
                            data = data + "<table class='table   mt-1'>"
                            data = data + "<thead><th>#</th><th>jasa</th><th>harga</th></thead>"
                            data = data + "<tbody>"
                            data = data + "<tr>";
                            data = data + "<td>" + (ii + 1) + "</td>"
                            data = data + "<td>" + value[0].pengerjaans.harga_jasas.jasas.nama_jasa +
                                "</td>"
                            data = data + "<td>" + formatRupiah(value[0].pengerjaans.harga_jasas.nominal_harga_jasa, 'Rp. ') +
                                "</td>"
                            data = data + "</tr>"
                        } else {
                            data = data + "<tr>";
                            data = data + "<td>" + (ii + 1) + "</td>"
                            data = data + "<td>" + value[0].pengerjaans.harga_jasas.jasas.nama_jasa +
                                "</td>"
                            data = data + "<td>" + formatRupiah(value[0].pengerjaans.harga_jasas.nominal_harga_jasa, 'Rp. ') +
                                "</td>"
                            data = data + "</tr>"
                        }

                        if (ii == (len - 1)) {
                            parseInt(value[0].pembayarans.total_pembayaran)
                            data = data + "<tr>";
                            data = data + "<td colspan='2'>Total</td>"
                            data = data + "<td>" + formatRupiah(value[0].pembayarans.total_pembayaran, 'Rp. ') + "</td>"
                            data = data + "</tr>"
                            data = data + "</tbody> "
                            data = data + "<tr>";
                            data = data + "<td colspan='2'>Tunai</td>"
                            data = data + "<td>" + formatRupiah(value[0].pembayarans.tunai_pembayaran, 'Rp. ') + "</td>"
                            data = data + "</tr>"
                            data = data + "</tbody> "
                            data = data + "<tr>";
                            data = data + "<td colspan='2'>Kembalian</td>"
                            data = data + "<td>" + formatRupiah((parseInt(value[0].pembayarans.tunai_pembayaran) -
                                                    parseInt(value[0].pembayarans.total_pembayaran)).toString(), 'Rp. ') + "</td>"
                            data = data + "</tr>"
                            data = data + "</tbody> "
                            data = data + "</table>"
                            data = data + "</div>"

                            data = data + "<div class='modal-footer'>"
                            data = data + "<button id='cencelButton' onclick='printOneHistory(" + value[
                                    0].pembayarans_id +
                                ")' style='width: 50px;' class='btn btn-xs btn-info'><i class='fas fa-print'></i></button>"
                            data = data + " </div>"
                        }
                        ii += 1;


                    })
                    $('.body-show-one').html(data);
                }
            })

        }
        // ----------------- end show one data -----------------

        // ----------------- history print data -----------------
        function printOneHistory(id) {
            console.log(id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/pembayaran/print-one-history/" + id,
                success: function(response) {
                    console.log('-- history print --');
                    console.log(response);
                    // list pembayaran yg di print
                    $.each(response, function(key, value) {
                        console.log(value);
                    })
                }
            })
        }
        // ----------------- end history print data -----------------

        // ----------------- show payment history data -----------------
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page) {
            var tmp_chooseBy = $('#chooseBy').val();
            var tmp_start_date = $('#start_date').val();
            var tmp_end_date = $('#end_date').val();
            $.ajax({
                data: {
                    chooseBy: tmp_chooseBy,
                    start_date: tmp_start_date,
                    end_date: tmp_end_date
                },
                url: "/pembayaran/all?page=" + page,
                success: function(data) {
                    $('#table_data').html(data);
                },
                error: function(error) {
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
            } else {
                $('#custom-choose').addClass('d-none');
                // refreshDatav();
                refreshToFirstPaginationDatav();
            }

        });

        function checkHistory() {
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
        // ----------------- show payment history data -----------------


        // ----------------- delete data -----------------
        function deleteDatav(id) {
            Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Riwayat pembayaran ini akan dihapus!",
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
                            url: "/pembayaran/delete/" + id,
                            success: function(data) {
                                console.log(data);
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

        function formatRupiah2(angka, prefix,angkatunai,angkatotal) {
            
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
        
            if(angkatunai>=angkatotal){
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');  
            }else if(angkatunai==''){
                return ''
            }
            else{
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. -' + rupiah : '');
            }
            
        }
    </script>

@endsection
