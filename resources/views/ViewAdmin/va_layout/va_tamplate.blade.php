<!DOCTYPE html>
<html>

<head>
    @include("ViewAdmin.va_layout.va_head")
    <title>@yield("title")</title>
</head>

<body class="hold-transition layout-top-nav" >
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        @include("ViewAdmin.va_layout.va_navbar")
        
        <!-- Main Sidebar Container -->
        {{-- @include("ViewAdmin.va_layout.va_sidebar") --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            {{-- <section class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- <h1>Visi dan Misi</h1> -->
                        </div>
                        <div class="col-sm-6">
                            @yield("breadcrumbWeb")
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section> --}}

            <section class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            {{-- <h1 class="m-0 text-dark"> Top Navigation <small>Example 3.0</small></h1> --}}
                            
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            @yield("breadcrumbWeb")
                        </div>
                        <!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                @yield("contentWeb")
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        @include("ViewAdmin.va_layout.va_footer")

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    
    <!-- Bootstrap 4 -->
    <script src="{{asset('TamplateAdminLTE')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('TamplateAdminLTE')}}/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('TamplateAdminLTE')}}/dist/js/demo.js"></script>
</body>

</html>