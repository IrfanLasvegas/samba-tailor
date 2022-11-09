@extends("ViewAdmin.va_layout.va_tamplate")

@section('title', 'Samba | Jasa')

@section('breadcrumbWeb')
    {{-- <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Finansial</a></li>
        <li class="breadcrumb-item active"><a href="#">Grafik</a></li>
    </ol> --}}
@endsection

@section('contentWeb')
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <h5 class="card-title ">Grafik hari</h5>
                        </div>
                        <div class="float-right d-flex">
                            <select class="form-control form-control-sm custom-choose"  style="width: 80px; height:23px; font-size:10px" name="statusPembayaranHari" id="statusPembayaranHari">
                                <option selected value="all">Semua</option>
                                <option value="done">Sudah</option>
                                <option value="notYet">Belum</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="card-body canv-day">
                        <canvas id="myChart" width="200" height="150"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <h5 class="card-title ">Grafik minggu</h5>
                        </div>
                        <div class="float-right d-flex">
                            <select class="form-control form-control-sm custom-choose"  style="width: 80px; height:23px; font-size:10px" name="statusPembayaranMinggu" id="statusPembayaranMinggu">
                                <option selected value="all">Semua</option>
                                <option value="done">Sudah</option>
                                <option value="notYet">Belum</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body canv-week">
                        <canvas id="myChartWeek" width="200" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <h5 class="card-title ">Grafik bulan</h5>
                        </div>
                        <div class="float-right d-flex">
                            <select class="form-control form-control-sm custom-choose"  style="width: 80px; height:23px; font-size:10px" name="statusPembayaranBulan" id="statusPembayaranBulan">
                                <option selected value="all">Semua</option>
                                <option value="done">Sudah</option>
                                <option value="notYet">Belum</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body canv-month">
                        <canvas id="myChartMonth"  width="200" height="150"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <h5 class="card-title ">Grafik tahun</h5>
                        </div>
                        <div class="float-right d-flex">
                            <select class="form-control form-control-sm custom-choose"  style="width: 80px; height:23px; font-size:10px"   name="chooseBy" id="chooseBy">
                                <option value="Currentyear">Tahun ini</option>
                                <option value="custom">Custom</option>
                            </select>

                            <select class="form-control form-control-sm custom-choose-year d-none"  style="width: 60px; height:23px; font-size:10px;margin-left: 2px;"   name="startYear" id="startYear">
                            
                            </select>

                            <div class="custom-choose-year d-none" style="margin-left: 1px; margin-right:1px;">-</div>
                            
                            <select class="form-control form-control-sm custom-choose-year d-none"  style="width: 60px; height:23px; font-size:10px"   name="endYear" id="endYear">
                                
                            </select>
                            
                            <button id="cekButtonYear" onclick="cekYear()" style="width: 25px; height:23px; font-size:10px; margin-left: 2px;" class="btn btn-xs btn-primary d-none"><i class="fas fa-search"></i></button>
                            
                            <select class="form-control form-control-sm custom-choose ml-2"  style="width: 80px; height:23px; font-size:10px" name="statusPembayaranTahun" id="statusPembayaranTahun">
                                <option selected value="all">Semua</option>
                                <option value="done">Sudah</option>
                                <option value="notYet">Belum</option>
                            </select>

                            <select class="form-control form-control-sm custom-choose ml-2 d-none"  style="width: 80px; height:23px; font-size:10px" name="statusPembayaranGrupTahun" id="statusPembayaranGrupTahun">
                                <option selected value="all">Semua2</option>
                                <option value="done">Sudah2</option>
                                <option value="notYet">Belum2</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="card-body canv-year">
                        <canvas id="myChartYear"  width="200" height="150"></canvas>
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
        });
        
        function patternColor(indexs){
            var pColor=[
                'rgba(47, 230, 230, 0.3)',
                'rgba(248, 217, 138, 0.3)',
                
                'rgba(153, 102, 255, 0.3)',
                'rgba(92, 230, 65, 0.3)',
                'rgba(255, 99, 132, 0.3)',
                'rgba(33, 60, 212, 0.3)',
                'rgba(155, 180, 40, 0.3)',
                'rgba(255, 251, 30, 0.3)',
                'rgba(26, 131, 0, 0.3)',
                'rgba(252, 9, 252, 0.3)',
                'rgba(64, 49, 66, 0.3)',
                'rgba(156, 0, 196, 0.3)',
                'rgba(190, 2, 80, 0.3)',
                'rgba(2, 190, 74, 0.3)',
            ];
            if (indexs <= (pColor.length-1)) {
                return pColor[indexs];
            }else{
                console.log('xxxxx');
                return dynamicColors();
            }
        }

        function patternColorNO(indexs){
            var pColor=[
                'rgba(47, 230, 230, 1)',
                'rgba(248, 217, 138, 1)',
                
                'rgba(153, 102, 255, 1)',
                'rgba(92, 230, 65, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(33, 60, 212, 1)',
                'rgba(155, 180, 40, 1)',
                'rgba(255, 251, 30, 1)',
                'rgba(26, 131, 0, 1)',
                'rgba(252, 9, 252, 1)',
                'rgba(64, 49, 66, 1)',
                'rgba(156, 0, 196, 1)',
                'rgba(190, 2, 80, 1)',
                'rgba(2, 190, 74, 1)',
            ];

            if (indexs <= (pColor.length-1)) {
                return pColor[indexs];
            }else{
                console.log('xxxxx');
                return dynamicColorsNO();
            }
        }


        function dynamicColors() {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);
                return "rgb(" + r + "," + g + "," + b + ")";
            }

        function dynamicColorsNO() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + "," + 1 + ")";
        }








        function gafikHarian() {
            $.ajax({
                data: {
                    statusPembayaran: $('#statusPembayaranHari').val(),
                },
                type: "POST",
                url: "/grafik/hari",
                success: function (response) {
                    console.log(response);
                    $('#myChart').remove();
                    $('.canv-day').append('<canvas id="myChart" width="200" height="150"></canvas>');
                    const ctx = document.getElementById('myChart');
                    const myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            
                            labels: response.LABELBOT,
                            datasets: [{
                                // label: '# of Votes',
                                data: response.NILAI,
                                backgroundColor: [
                                    'rgba(248, 217, 138, 0.3)',
                                    'rgba(47, 230, 230, 0.3)',
                                ],
                                borderColor: [
                                    
                                    'rgba(248, 217, 138, 1)',
                                    'rgba(47, 230, 230, 1)',
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false,
                                    labels: {
                                        // color: 'rgb(25, 992, 132)'
                                    },
                                    position:'bottom',
                                    align:'end'
                                }
                            }
                        }
                    });
                },
                error: function (error) {
                    
                }
            });
        }
        gafikHarian();
        $('#statusPembayaranHari').on('change', function() {
            gafikHarian();
        });


        function gafikMingguan() {
            $.ajax({
                data: {
                    statusPembayaran: $('#statusPembayaranMinggu').val(),
                },
                type: "POST",
                url: "/grafik/minggu",
                success: function (response) {
                    $('#myChartWeek').remove();
                    $('.canv-week').append('<canvas id="myChartWeek" width="200" height="150"></canvas>');
                    const ctx = document.getElementById('myChartWeek');
                    var tmp_dt_set=[];
                    $.each(response.NILAI,function(key, value){
                        var tmp_color=patternColor(key);
                        var tmp_colorNO=patternColorNO(key);
                        var dict = { 
                                    label: value.LBL,
                                    data: value.NLI,
                                    backgroundColor: [
                                        tmp_color
                                    ],
                                    borderColor: [
                                        tmp_colorNO
                                    ],
                                    borderWidth: 1
                        };
                        tmp_dt_set.push(dict)
                        
                    })

                    const myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: response.LABELBOT,
                            datasets: tmp_dt_set
                        },
                        options: {
                            responsive: true,
                                interaction: {
                                intersect: false,
                                axis: 'x'
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    labels: {
                                        // color: 'rgb(25, 992, 132)'
                                    },
                                    position:'top',
                                    align:'end'
                                }
                            }
                        }
                    });
                    
                },
                error: function (error) {
                    
                }
            });

        }
        gafikMingguan();
        $('#statusPembayaranMinggu').on('change', function() {
            gafikMingguan();
        });


        function gafikBulanan() {
            $.ajax({
                data: {
                    statusPembayaran: $('#statusPembayaranBulan').val(),
                },
                type: "POST",
                url: "/grafik/bulan",
                success: function (response) {
                    console.log(response);
                    $('#myChartMonth').remove();
                    $('.canv-month').append('<canvas id="myChartMonth" width="200" height="150"></canvas>');
                    const ctx = document.getElementById('myChartMonth');
                    var tmp_dt_set=[];
                    $.each(response.NILAI,function(key, value){
                        var tmp_color=patternColor(key);
                        var tmp_colorNO=patternColorNO(key);
                        var dict = { 
                                    label: value.LBL,
                                    data: value.NLI,
                                    backgroundColor: [
                                        tmp_color
                                    ],
                                    borderColor: [
                                        tmp_colorNO
                                    ],
                                    borderWidth: 1
                        };
                        tmp_dt_set.push(dict)
                        
                    })

                    const myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: response.LABELBOT,
                            datasets: tmp_dt_set
                        },
                        options: {
                            responsive: true,
                                interaction: {
                                intersect: false,
                                axis: 'x'
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    labels: {
                                        // color: 'rgb(25, 992, 132)'
                                    },
                                    position:'top',
                                    align:'end'
                                }
                            }
                        }
                    });
                    
                },
                error: function (error) {
                    
                }
            });

        }
        gafikBulanan();
        $('#statusPembayaranBulan').on('change', function() {
            gafikBulanan();
        });


        function gafikTahunan() {
            $.ajax({
                data: {
                    statusPembayaran: $('#statusPembayaranTahun').val(),
                },
                type: "POST",
                url: "/grafik/tahun",
                success: function (response) {
                    // console.log(response);
                    $('#myChartYear').remove();
                    $('.canv-year').append('<canvas id="myChartYear" width="200" height="150"></canvas>');
                    const ctx = document.getElementById('myChartYear');
                    var tmp_dt_set=[];
                    $.each(response.NILAI,function(key, value){
                        var tmp_color=patternColor(key);
                        var tmp_colorNO=patternColorNO(key);
                        var dict = { 
                                    label: value.LBL,
                                    data: value.NLI,
                                    backgroundColor: [
                                        tmp_color
                                    ],
                                    borderColor: [
                                        tmp_colorNO
                                    ],
                                    borderWidth: 1
                        };
                        tmp_dt_set.push(dict)
                        
                    })

                    const myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: response.LABELBOT,
                            datasets: tmp_dt_set
                        },
                        options: {
                            responsive: true,
                                interaction: {
                                intersect: false,
                                axis: 'x'
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    labels: {
                                        // color: 'rgb(25, 992, 132)'
                                    },
                                    position:'top',
                                    align:'end'
                                }
                            }
                        }
                    });
                    
                },
                error: function (error) {
                    
                }
            });

        }
        gafikTahunan();
        $('#statusPembayaranTahun').on('change', function() {
            gafikTahunan();
        });
        







        // ----------------- choose data show -----------------
        $('#chooseBy').on('change', function() {
            if ($('#chooseBy').val() == 'custom') {
                $('.custom-choose-year').removeClass('d-none');
                $('#cekButtonYear').removeClass('d-none');
                $('#cencelButtonYear').removeClass('d-none');
                $('#statusPembayaranGrupTahun').removeClass('d-none');
                $('#statusPembayaranTahun').addClass('d-none');
                

            }else{
                $('.custom-choose-year').addClass('d-none');
                $('#cekButtonYear').addClass('d-none');
                $('#cencelButtonYear').addClass('d-none');
                $('#statusPembayaranGrupTahun').addClass('d-none');
                $('#statusPembayaranTahun').removeClass('d-none');
                gafikTahunan();
            }
            
        });

    

        const todaysDate = new Date()
        const currentYear = todaysDate.getFullYear()

        var dataSTART = ""
        dataSTART = dataSTART + "<option value=''> start </option>"
        for (let index = 2020; index <= currentYear; index++) {
            dataSTART = dataSTART + "<option value='" + index + "'>" + index + "</option>"
        }
        $('#startYear').html(dataSTART);

        var dataEND = ""
        dataEND = dataEND + "<option value=''> end </option>"
        for (let index = 2020; index <= currentYear; index++) {
            dataEND = dataEND + "<option value='" + index + "'>" + index + "</option>"
        }
        $('#endYear').html(dataEND)

        
        function cekYear (){
            var tmp_chooseBy = $('#chooseBy').val();
            var tmp_start_year = $('#startYear').val();
            var tmp_end_year = $('#endYear').val();
            $.ajax({
                type: "POST",
                data: {
                    chooseBy: tmp_chooseBy,
                    start_year: tmp_start_year,
                    end_year: tmp_end_year,
                    statusPembayaran: $('#statusPembayaranGrupTahun').val(),
                },
                url: "/grafik/grup-tahun",
                success: function (response) {
                    console.log(response);
                    $('#myChartYear').remove();
                    $('.canv-year').append('<canvas id="myChartYear" width="200" height="150"></canvas>');
                    const ctx = document.getElementById('myChartYear');
                    var tmp_dt_set=[];
                    const tmp_bg_color = [];
                    const tmp_bd_color = [];

                    $.each(response.NILAI,function(key, value){
                        $.each(value,function(key2, value2){
                           console.log(key2);
                           tmp_bg_color.push(patternColor(key2));
                           tmp_bd_color.push(patternColorNO(key2));
                        })
                        console.log(tmp_bd_color);
                        var tmp_color=patternColor(2);
                        var tmp_colorNO=patternColorNO(2);
                        var dict = { 
                                    // label: value.LBL,
                                    data: value,
                                    backgroundColor: tmp_bg_color,
                                    borderColor: tmp_bd_color,
                                    borderWidth: 1
                        };
                        tmp_dt_set.push(dict);

                        
                    })

                    const myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.LABELBOT,
                            datasets: tmp_dt_set
                        },
                        options: {
                            responsive: true,
                                interaction: {
                                intersect: false,
                                axis: 'x'
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false,
                                    labels: {
                                        // color: 'rgb(25, 992, 132)'
                                    },
                                    position:'top',
                                    align:'end'
                                }
                            }
                        }
                    });
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
        $('#statusPembayaranGrupTahun').on('change', function() {
            cekYear();
        });
        



        
        
    </script>

@endsection
