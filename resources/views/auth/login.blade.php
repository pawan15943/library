<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('public/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->

    <link href="{{ asset('public/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
</head>

<body class="bg-custom-primary">

    <div class="login-form">
        <div class="left-box">
            <div class="logo">
                <img src="{{ asset('public/img/sitelogo.png') }}" class="fav_img logo" alt="logo" />
            </div>
            <div class="creative">
                <img src="{{ asset('public/img/Vector.png') }}" class="fav_img img-fluid p-3" alt="logo" />
            </div>
            <div class="footer text-center text-dark">Student Tranportation Portal</div>
        </div>
        <div class="right-box">
            <div class="login-fields">
                <h4>Welcome to Admin</h4>
                <p>Sign in to continue</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-code">

                        <input id="email" placeholder="Enter Email Address" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <button type="submit" class="btn btn-primary btn-user btn-block bg-custom-primary">Login</button>

                        {{-- @if (Route::has('password.request'))
                    <a class="text-center d-block" href="{{ route('password.request') }}">
                        Forgot Your Password?</a>
                        @endif --}}

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('public/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('public/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('public/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
