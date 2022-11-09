<style>
    .bbb{
        /* box-shadow:
        1.4px 1.8px 3.6px rgba(0, 0, 0, 0.021),
        4px 5px 10px rgba(0, 0, 0, 0.03),
        9.6px 12.1px 24.1px rgba(0, 0, 0, 0.039),
        32px 40px 80px rgba(0, 0, 0, 0.06)
        ; */

        /* background: #ffffff;
box-shadow:  20px 20px 60px #d9d9d9,
             -20px -20px 60px #ffffff; */

             box-shadow:  5px 5px 17px #cecece,
             -5px -5px 17px #ffffff;

    }
</style>
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white bbb">
    <div class="container">
        <a href="/" class="navbar-brand">
            <!-- <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" style="opacity: .8"> -->
            <span class="brand-text font-weight-light" style="letter-spacing: 5px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;color: rgb(183, 184, 185);">SAMBA</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
            data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav ml-auto">
                
                @can('gateSuperAdmin')
                    {{-- <li class="nav-item">
                        <a href="/" class="nav-link">Beranda</a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="/" class="nav-link">kasir</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link dropdown-toggle">Jasa</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="jasa" class="dropdown-item">Pengaturan Jasa</a></li>
                            <li><a href="pengerjaan" class="dropdown-item">Pengerjaan Jasa</a></li>
                            <li><a href="barcode" class="dropdown-item">Generate Code</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="bagian" class="nav-link">Bagian</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link dropdown-toggle">Finansial</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="penghasilan" class="dropdown-item">Penghasilan</a></li>
                            <li><a href="grafik" class="dropdown-item">Grafik</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="manage-user" class="nav-link">Pengguna</a>
                    </li>
                @endcan

                @can('gateAdmin')
                <li class="nav-item">
                    <a href="/" class="nav-link">kasir</a>
                </li>

                <li class="nav-item">
                    <a href="pengerjaan" class="nav-link">Jasa</a>
                </li>
        
                @endcan

                @auth
                    <form method="POST" action="{{ route('logout') }}" id="my_form" >
                        @csrf
                        <li class="nav-item">
                            <a class="nav-link" role="button" href="javascript:{}" onclick="document.getElementById('my_form').submit();"><i class="fas fa-sign-out-alt"></i></a>
                        </li>
                    </form>
                @endauth
            </ul>
{{-- 
            <!-- SEARCH FORM -->
            <form class="form-inline ml-0 ml-md-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form> --}}

            
        </div>

        
    </div>
</nav>