<div class="header">
    <div class="header-left">
        <a href="{{ route('home') }}" class="logo">{{__('Yokhone App')}}
            <!-- <img src="assets/img/logo.svg" alt="Logo"> -->
        </a>
        <a href="{{ route('home') }}" class="logo logo-small">PT
            <!-- <img src="assets/img/logo.svg" alt="Logo"> -->
        </a>
    </div>
    <a href="javascript:void(0);" id="toggle_btn"> <i class="fas fa-bars"></i>
    </a>

    <div class="top-nav-search">
        <img class="img-fluid logo-dark mb-2" src="{{ asset('logo/logo2.png') }}" alt="Logo">
    </div>
    <div class="top-nav-search ml-5">
        <h5 style="margin-top: 18px; position: relative; width:360px">
            {{ \Carbon\Carbon::now()
                ->locale(App::getLocale() === 'fr' ? 'fr_FR' : 'en')
                ->timezone(Auth::user()->timezone)
                ->format('D, M j, Y \a\t g:ia') }}
        </h5>
    </div>

    <a class="mobile_btn" id="mobile_btn"> <i class="fas fa-bars"></i>
    </a>

    <ul class="nav user-menu">
        <li class="nav-item dropdown">
            <a href="#" class="nav-link notifications-item">
                <i class="fa fa-bell"></i> <span class="badge badge-pill">
                    <?php $notifications = auth()->user()->unreadNotifications; ?>
                    @if(isset($notifications))
                    {{ $notifications->count() ?? 0 }}
                    @else
                    0
                    @endif
                </span>
            </a>
        </li>

        <li class="nav-item dropdown has-arrow main-drop ml-md-3">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img"><img src="{{ asset('avatar.png') }}" alt="">
                    <span class="status online"></span></span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('my.profile') }}"><i class="feather-user"></i>
                    {{ __('My Profile') }}
                </a>
                <a class="dropdown-item" href="{{ route('change.password') }}"><i class="fa fa-lock"></i>
                    {{__('Change Password')}}
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="feather-power"></i>
                    {{__('Logout')}}
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </a>
            </div>
        </li>

        <li class="nav-item dropdown has-arrow main-drop ml-md-3">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img">
                    <img src="{{App::getLocale() === 'en'
                        ? '/assets/img/icons/united-kingdom.png'
                        : '/assets/img/icons/france.png' }}" alt="">
                </span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/language/en">
                    <div>
                        <img src="/assets/img/icons/united-kingdom.png" alt="">
                        <span>English</span>
                    </div>
                </a>
                <a class="dropdown-item" href="/language/fr">
                    <div>
                        <img src="/assets/img/icons/france.png" alt="">
                        <span>Français</span>
                    </div>
                </a>
            </div>
        </li>
    </ul>

</div>
