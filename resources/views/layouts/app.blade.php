<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>{{__('Yokhone Club Dashboard')}} - {{$title ?? "" }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('logo/logo2.png') }}">
</head>

@include('layouts.includes.style')
@include('layouts.includes.alert')

<body>

    <div class="main-wrapper">

        @include('layouts.includes.nav')

        @include('layouts.includes.sidebar')

        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>
    @include('layouts.includes.notification')
    </div>

</body>
@include('layouts.includes.script')

</html>
