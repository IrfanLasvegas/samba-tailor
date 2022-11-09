@extends("ViewAdmin.va_layout.va_tamplate")

@section('title', 'Samba | Home')

@section("breadcrumbWeb")
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active"><a href="#">Kasir</a></li>
</ol>
@endsection

@section("contentWeb")
<script>
    var n=0;
    var tmp_harga=55000;
    var tmp_jasa='Permak PDH';
    var tmp_total=0;
    

    $(function () {
        $('#code-scan').codeScanner();
        $('#code-scan').codeScanner({
        onScan: function ($element, code) {
                console.log(code);
                n+=1;
                tmp_total+=55000;
                $(".total-pembayaran").before("<tr><td>"+n+"</td><td>"+tmp_jasa+"</td><td>"+tmp_harga+"</td></tr>");
                
                $(".Rp-total-pembayaran").text(tmp_total);
            }
        });

    });
</script>
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-sm-12">
                    <table class="mb-2">
                        <tr>
                            <td>Scanned code</td>
                            <td><input class="" id="code-scan" type="text" /></td>
                        </tr>
                        <tr>
                            <td>Tunai</td>
                            <td><input class="" id="tunai" name="tunai" type="text" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button class="button" id="btn2"style="width:100px" class="m[-auto">Proses</button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Jasa</th>
                                <th scope="col">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="pembayaran-pelanggan">
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
        </div>
        
        <script>
    
            $('#tunai').keyup(function(){
                var tmp_tunai =parseInt($('input[name="tunai"]').val());
                var tmp_kembalian=tmp_tunai-tmp_total;
                $(".Rp-tunai").text(tmp_tunai);
                $(".Rp-kembalian").text(tmp_kembalian);
                // console.log(tmp_tunai);
            });
    
            
            $("#btn2").click(function(){
                $("ol").append("<li>Appended item</li>");
            });
        </script>
        
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
    
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the
                            card's
                            content.
                        </p>
    
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>
    
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
    
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the
                            card's
                            content.
                        </p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div><!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0">Featured</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Special title treatment</h6>
    
                        <p class="card-text">With supporting text below as a natural lead-in to additional
                            content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
    
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0">Featured</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Special title treatment</h6>
    
                        <p class="card-text">With supporting text below as a natural lead-in to additional
                            content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>

    
</div><!-- /.container-fluid -->

@endsection