@extends("ViewAdmin.va_layout.va_tamplate")

@section('title', 'Samba | Barcode')

@section('breadcrumbWeb')
    {{-- <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"><a href="#">Barcode</a></li>
    </ol> --}}
@endsection

@section('contentWeb')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0">Generate Code</h5>
                    </div>
                    <div class="card-body">
                        {{-- <div style="text-align: center;">
                            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG('123456789', 'C39',1,33)}}" alt="barcode" /><br><br>
                            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG('123456789', 'C39+',1,33,array(0,255,0), true)}}" alt="barcode" /><br><br>
                            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG('123456789', 'CODE11',1,33)}}" alt="barcode" /><br><br>
                            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG('123456789', 'C39+',1,33)}}" alt="barcode" /><br><br>
                            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG('123456789', 'POSTNET',1,33,array(0,255,0), true)}}" alt="barcode" /><br/><br/>
                        </div>
                        <br>
                        <br> --}}
                        <div style="text-align: center;">
                            {{-- <div class="d-flex mb-4">
                                C39 <div class="ml-2">{!! DNS1D::getBarcodeHTML('123456789', 'C39',1,33) !!}</div>
                            </div>
                            <div class="d-flex mb-4">
                                C39+ <div class="ml-2">{!! DNS1D::getBarcodeHTML('123456789', 'C39+',1,33) !!}</div>
                            </div> --}}
                            {{-- <div class="d-flex mb-4">
                                POSTNET <div class="ml-2">{!! DNS1D::getBarcodeHTML('123456789', 'POSTNET',1,33) !!}</div>
                            </div>
                            <div class="d-flex mb-4">
                                PHARMA <div class="ml-2">{!! DNS1D::getBarcodeHTML('123456789', 'PHARMA',1,33) !!}</div>
                            </div>
                            <div class="d-flex mb-4">
                                CODABAR <div class="ml-2">{!! DNS1D::getBarcodeHTML('123456789', 'CODABAR',1,33) !!}</div>
                            </div> --}}
                            {{-- <div class="d-flex mb-4">
                                UPCE <div class="ml-2">{!! DNS1D::getBarcodeHTML('123456789', 'UPCE',1,33) !!}</div>
                            </div> --}}
                            {{-- <div class="d-flex mb-4">
                                CODE11 <div class="ml-2">{!! DNS1D::getBarcodeHTML('123456789', 'CODE11',1,33) !!}</div>
                            </div> --}}

                            {{-- <div class="d-flex mb-4">
                                Barcode <div class="ml-2">{!! DNS1D::getBarcodeHTML('123456789', 'C128',1,33) !!}</div> 
                                <a href="/pdf-barcode" class="btn btn-sm btn-primary" target="_blank">Generate PDF</a>
                            </div>
                            <div class="d-flex mb-4">
                                QRCODE <div class="ml-2">{!! DNS2D::getBarcodeHTML('123456789', 'QRCODE',3,3) !!}</div>
                                <a href="/pdf-barcode2" class="btn btn-sm btn-primary" target="_blank">Generate PDF</a>
                            </div>
                            <button class="btn btn-sm btn-primary" onclick="brcd()">ajx</button>
                             --}}

                            {{-- <table>
                                <tr>
                                    <td class="p-2">Barcode</td>
                                    <td class="p-2">{!! DNS1D::getBarcodeHTML('123456789', 'C128',1,33) !!}</td>
                                    <td class="p-2"><a href="/pdf-barcode" class="btn btn-sm btn-primary" target="_blank">Generate PDF</a></td>
                                </tr>
                                <tr>
                                    <td class="p-2">QRCODE</td>
                                    <td class="p-2">{!! DNS2D::getBarcodeHTML('123456789', 'QRCODE',3,3) !!}</td>
                                    <td class="p-2"><a href="/pdf-barcode2" class="btn btn-sm btn-primary" target="_blank">Generate PDF</a></td>
                                </tr>
                            </table>
                            <button class="btn btn-sm btn-primary" onclick="brcd()">ajx</button>
                            <a href="/generate-exel" class="btn btn-sm btn-primary" target="_blank">Generate exel</a>
                            <div id="table_data"></div> --}}
                            @livewireStyles
                            @livewireScripts
                            @livewire('lw-barcode.show')
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
        
        

        {{-- @livewireStyles
        @livewireScripts
        <div class="row">
            @livewire('counter')
        </div>

        <div class="row">
            @livewire('lw-barcode.show')
        </div> --}}
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })


        function brcd(){
            console.log('prosess.....');
            $.ajax({
                url: "/pdf-barcode3",
                success: function (data) {
                    $('#table_data').html(data);
                  
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    </script>

@endsection
