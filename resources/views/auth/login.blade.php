<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon link -->
    <link rel="icon" href="/path/to/your/favicon.ico" type="image/x-icon">
    <!-- Title -->
    <title>@yield('title')</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <!-- Admin Style-->
    <link href="{{ asset('public/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Include Datatables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

    <!-- Custom Style -->
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">

</head>

<body class="bg-custom-primary">

    <div class="login-form">
        <div class="left-box">
            <div class="logo">
                <h1>Library<span>Pro</span></h1>
            </div>
        </div>
        <div class="right-box">
            <div class="contact"><p>Call Us : 8114479678</p></div>
            <div class="login-fields">
                <div class="heading">
                    <h4>Welcome to Admin</h4>
                    <p>Sign in to continue</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-code">
                        <div class="input">
                            <input id="email" placeholder="Enter Email Address" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input">
                            <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input">
                            <button type="submit" class="btn btn-primary btn-user btn-block bg-custom-primary">Login</button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="developedby"><span><a href="javascript:;">Developed By : NBCC</a></span></div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('public/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('public/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('public/js/sb-admin-2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('input').attr('autocomplete', 'off');
        });
    </script>

</body>

</html>