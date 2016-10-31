<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GNB</title>

    <!-- Styles -->
    <link href="/css/owl.carousel.css" rel="stylesheet">
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

</head>
<body id="app-layout">
    <!-- background slider -->
    <div class="carousel slide carousel-fade" data-ride="carousel" data-interval="7000">
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
            </div>
            <div class="item">
            </div>
            <div class="item">
            </div>
        </div>
    </div>

    <!-- navigation -->
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ route('welcome') }}"><i class="fa fa-home"></i></a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('lanparty.reservation') }}">Anmeldung</a></li>
                    <li><a href="{{ route('lanparty.member') }}">Teilnehmer</a></li>
                    <li><a href="{{ route('sponsor.list') }}">Sponsoren</a></li>
                    <li><a href="{{ route('catering.list') }}">Catering</a></li>
                    <li><a href="{{ route('lanparty.location') }}">Location</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('auth.login') }}"><i class="fa fa-sign-in"></i></a></li>
                        <li><a href="{{ route('auth.register') }}"><i class="fa fa-user-plus"></i></a></li>
                    @else
                        @hasanyrole(\App\Role::all())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-shield"></i> Administration <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                @role('permissionmanager')
                                <li><a href="{{ route('admin.user.permissions') }}"><i class="fa fa-btn fa-users"></i> Benutzer-Berechtigungen</a></li>
                                @endrole
                                @role('lanpartymanager')
                                <li><a href="{{ route('admin.lanparty.list') }}"><i class="fa fa-btn fa-gamepad"></i> Lanparties</a></li>
                                <li><a href="{{ route('admin.lanparty.regularseats') }}"><i class="fa fa-btn fa-th-large"></i> Stammplätze</a></li>
                                <li><a href="{{ route('admin.coin.user') }}"><i class="fa fa-btn fa-gg-circle"></i> GnB-Coins</a></li>
                                <li><a href="{{ route('admin.code.list') }}"><i class="fa fa-btn fa-qrcode"></i> Gutscheine</a></li>
                                <li><a href="{{ route('admin.sponsor.list') }}"><i class="fa fa-btn fa-star"></i> Sponsoren</a></li>
                                @endrole
                                @role('cateringmanager')
                                <li><a href="{{ route('admin.catering.list') }}"><i class="fa fa-btn fa-cutlery"></i> Catering</a></li>
                                @endrole
                            </ul>
                        </li>
                        @endhasanyrole
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('auth.logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="col-sm-12">
            @include('flash::message')
        </div>
    </div>

    @yield('content')

    <!-- navigation footer -->
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <ul class="nav navbar-nav pull-right">
                <li><a href="{{ route('impressum') }}">Impressum</a></li>
                <!-- <li><a href="{{ route('impressum') }}">Datenschutz</a></li> -->
                <li><a href="{{ route('service.contact') }}">Kontakt</a></li>
            </ul>
        </div>
    </nav>

    <!-- JavaScripts -->
    <script src="{{ elixir('js/all.js') }}"></script>
    <script src="/js/gunsnbits.js"></script>
    <script>
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>

    @yield('scripts')
</body>
</html>
