<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="57x57" href="/images/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/images/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="/images/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <title>Guns'n Bits e.V.</title>

    <meta property="og:url"                content="http://gunsnbits.de" />
    <meta property="og:type"               content="website" />
    <meta property="og:title"              content="Guns'n Bits e.V. - Die Lan der Region Köln-Düren-Aachen" />
    <meta property="og:description"        content="Die größte Lanparty in der Region mit maximal 220 Teilnehmern, Internet-Anbindung, vielen Turnieren und super Preisen! Dazu gibt es wie immer die Kaffee-Flat, Catering rund um die Uhr und viel, viel Spass!" />
    <meta property="og:image"              content="http://gunsnbits.de/images/gnb/logo.png" />

    <!-- Styles -->
    <link href="/css/owl.carousel.css" rel="stylesheet">
    <link href="/css/lightbox.css" rel="stylesheet">

    <link href="/css/app.css" rel="stylesheet">

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

                    @if(\App\Lanparty::getNextLan() instanceof \App\Lanparty && \App\Lanparty::getNextLan()->registrationstart <= \Carbon\Carbon::now() && \App\Lanparty::getNextLan()->registrationend >= \Carbon\Carbon::now())
                        <li><a href="{{ route('lanparty.reservation') }}">Anmeldung</a></li>
                        <li><a href="{{ route('lanparty.member') }}">Teilnehmer</a></li>
                    @elseif(\App\Lanparty::getNextLan() instanceof \App\Lanparty && \App\Lanparty::getNextLan()->end >= \Carbon\Carbon::now())
                        <li><a href="{{ route('lanparty.seatingplan') }}">Sitzplan</a></li>
                    @endif
                    <li><a href="{{ route('sponsor.list') }}">Sponsoren</a></li>
                    <li><a href="{{ route('catering.list') }}">Catering</a></li>
                    <li><a href="{{ route('lanparty.location') }}">Location</a></li>
                    <li><a href="http://gnb.challonge.com/" target="_blank">Turniere</a></li>
                    <li><a href="{{ route('gallery.list') }}">Bilder</a></li>
                    <li><a href="{{ route('teamspeak.viewer') }}">TeamSpeak</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="social-icon" href="https://www.facebook.com/gunsnbits/" target="_blank"><img class="img-responsive" src="/images/icons/fb.png"></a></li>
                    <li><a class="social-icon" href="https://www.youtube.com/user/Gunsnbits" target="_blank"><img class="img-responsive" src="/images/icons/yt.png"></a></li>
                    <li><a class="social-icon" href="https://www.twitch.tv/gunsn_bits" target="_blank"><img class="img-responsive" src="/images/icons/twitch.png" style="height: 19px;"></a></li>

                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('auth.login') }}"><i class="fa fa-sign-in"></i></a></li>
                        <li><a href="{{ route('auth.register') }}"><i class="fa fa-user-plus"></i></a></li>
                    @else
                        @hasanyrole(\App\Role::all())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-shield"></i> <span class="caret"></span>
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
                                <li><a href="{{ route('admin.lanparty.user.settings') }}"><i class="fa fa-btn fa-users"></i> Benutzer-Einstellungen</a></li>
                                @endrole
                                @role('imagemanager')
                                <li><a href="{{ route('admin.gallery.list') }}"><i class="fa fa-btn fa-picture-o"></i> Bilder-Galerien</a></li>
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
                                <li><a href="{{ route('user.profile') }}"><i class="fa fa-fw fa-user"></i> Profil</a></li>
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
                <li><a href="{{ route('service.impressum') }}">Impressum</a></li>
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
