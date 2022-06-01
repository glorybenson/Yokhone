<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from emr.dreamguystech.com/html/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 Oct 2021 23:00:33 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <title>Yokhone Club - Sign In</title>

    <meta name="description" content="Prototype">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('logo/logo2.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<style>
    .login-new-btn {
        background-color: #4DD434;
        border-color: #4DD434;
    }
</style>

<body>
    <div class="main-wrapper login-body" style="background: none;">
        <div class="login-wrapper">
            <div class="container">
                <img class="img-fluid logo-dark mb-2" src="{{ asset('logo/logo.png') }}" alt="Logo">
                <div class="loginbox">
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>{{ __('Login') }}</h1>
                            <p class="account-subtitle">{{__('Access to our dashboard')}}</p>
                            <form method="POST" action="">
                                @csrf
                                <input type="hidden" name="timezone" id="timezone">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('Email Address')}}</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">{{__('Password')}}</label>
                                    <div class="pass-group">
                                        <input type="password" name="password" class="form-control pass-input @error('password') is-invalid @enderror">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="remember" id="cb1" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="cb1">{{ __('Remember Me') }}</label>
                                            </div>
                                        </div>

                                        @if (Route::has('password.request'))
                                        <div class="col-6 text-right">
                                            <a class="forgot-link" href="{{ route('password.request') }}">
                                                {{__('Forgot Password')}}?
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <button class="btn btn-lg btn-block btn-primary" type="submit">{{__('Login')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

<script>
    $(function() {
        // get user timezone
        $('#timezone').val(Intl.DateTimeFormat().resolvedOptions().timeZone)
    })
</script>
<!-- Mirrored from emr.dreamguystech.com/html/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 Oct 2021 23:00:33 GMT -->

</html>
