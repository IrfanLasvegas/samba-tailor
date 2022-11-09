<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Hello, world!</title>
</head>

<body >

    <div style="height: 100%">

    </div>

    <div class="row" style="margin-top: 100px">
        <div class="col d-flex justify-content-center">
            
            <div class="card p-4 shadow">
                <h1 class="mb-4">Login</h1>
                <form action="/login" method="POST" >
                    @csrf
                    <div class="form-group">
                        {{-- <label for="exampleInputEmail1">Email address</label> --}}
                        <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        @error('email')
                        <small id="emailHelp" class="form-text text-muted">{{ $message }}.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{-- <label for="exampleInputPassword1">Password</label> --}}
                        <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        @error('password')
                        <small id="emailHelp" class="form-text text-muted">{{ $message }}.</small>
                        @enderror
                    </div>
        
                    {{-- <div class="form-check">
                        <input name="remember" type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Remember me</label>
                    </div> --}}
                    <button type="submit" class="btn btn-sm btn-primary float-right">Submit</button>
                </form>
            </div>
        </div>
    </div>
    
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>

</html>
