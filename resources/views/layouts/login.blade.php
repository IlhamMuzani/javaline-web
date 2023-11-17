<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Javaline</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <img class="mb-2" src="{{ asset('storage/uploads/user/logo3.png') }}" alt="AdminLTELogo" height="150"
        width="330">
    <div class="login-box">
        {{-- <div class="login-logo">
            <a href=""><b>PT. JAVALINE LOGISTICS</b></a>
        </div> --}}
        @if (session('success'))
            <div class="alert alert-primary alert-dismissible" user="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" user="alert">
                <h5 class="text-danger">Error!</h5>
                <p>
                    @foreach (session('error') as $error)
                        -&nbsp; {{ $error }} <br>
                    @endforeach
                </p>
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Masuk untuk melanjutkan</p>

                <form action="{{ url('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="kode_user" placeholder="Masukan kode"
                            value="{{ old('kode_user') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Masukan password"
                            value="{{ old('password') }}">
                        <div class="input-group-append">
                            {{-- <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div> --}}
                            <div class="input-group-text" style="cursor: pointer;" id="password-toggle">
                                <span id="password-icon" class="fas fa-eye"></span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary">Masuk</button>
                </form>
                {{-- <div class="social-auth-links text-center">
                    <p>- OR -</p> --}}
                {{-- <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i>
                        Sign up using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i>
                        Sign up using Google+
                    </a> --}}
                {{-- </div> --}}
                <div class="social-auth-links text-center">belum punya akun ?
                    <a href="{{ url('register') }}" class="social-auth-links text-center">Daftar</a>
                </div>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#password-toggle').click(function() {
                var passwordInput = $('input[name="password"]');
                var passwordIcon = $('#password-icon');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    passwordIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    passwordIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
</body>

</html>
