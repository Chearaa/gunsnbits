@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="margin-bottom: 50px;">
        <div class="col-lg-6 text-center" data-mh="row1">
            <figure>
                <img class="img-responsive" src="images/gnb/logo.svg">
            </figure>
            <h4>Die LAN der Region<br/>Köln-Düren-Aachen</h4>
        </div>
        <div class="col-lg-6" data-mh="row1">
            <div class="panel panel-default">
                <div class="panel-heading">Alles auf einen Blick!</div>
                <div class="panel-body">

                    @if ($lanparty instanceof \App\Lanparty)

                        @if ($lanparty->registrationstart < \Carbon\Carbon::now() && $lanparty->registrationend > \Carbon\Carbon::now())

                            <h5>Die Anmeldung zur {{ $lanparty->title }} ist <span class="text-success">offen</span>!</h5>

                            <div class="row">
                                <div class="col-sm-8 col-xs-12">
                                    <div class="progress">

                                        <div class="progress-bar progress-bar-info progress-bar-striped" style="width: {{ $progress['deactivated']['percent'] }}%" data-toggle="tooltip" title="{{ $progress['deactivated']['value'] }} Plätze sind bisher noch deaktiviert">
                                            <span class="sr-only">{{ $progress['deactivated']['value'] }} reserviert</span>
                                        </div>
                                        <div class="progress-bar progress-bar-danger progress-bar-striped" style="width: {{ $progress['reserved']['percent'] }}%" data-toggle="tooltip" title="{{ $progress['reserved']['value'] }} Plätze sind bereits reserviert">
                                            <span class="sr-only">{{ $progress['reserved']['value'] }} reserviert</span>
                                        </div>
                                        <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: {{ $progress['marked']['percent'] }}%" data-toggle="tooltip" title="{{ $progress['marked']['value'] }} Plätze sind bereits vorgemerkt">
                                            <span class="sr-only">{{ $progress['marked']['value'] }} vorgemerkt</span>
                                        </div>
                                        <div class="progress-bar progress-bar-success progress-bar-striped" style="width: {{ $progress['free']['percent'] }}%" data-toggle="tooltip" title="{{ $progress['free']['value'] }} Plätze sind noch frei">
                                            <span class="sr-only">{{ $progress['free']['value'] }} frei</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <a href="{{ route('lanparty.reservation') }}" class="btn btn-default"><i class="fa fa-fw fa-chevron-right"></i> Jetzt anmelden</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                        <p>Letzter Kontocheck:
                                            @if (Auth::check() && Auth::user()->hasRole('lanpartymanager'))
                                                <a href="{{ route('bankaccountcheck') }}" class="btn btn-sm btn-default pull-right" style="margin-right: 10px;"><i class="fa fa-fw fa-refresh"></i> jetzt checken</a>
                                            @endif
                                            @if ($last_bankaccount_check)
                                                {!! $last_bankaccount_check->last_check->format('d.m.Y - H:i:s') !!} Uhr
                                            @else
                                                <i class="fa fa-times"></i>
                                            @endif
                                        </p>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6">
                                    <dl>
                                        <dt><i class="fa fa-fw fa-users"></i> Maximale Teilnehmer</dt>
                                        <dd>{{ config('lanparty')['maxseats'] }}</dd>

                                        <dt><i class="fa fa-fw fa-calendar-check-o"></i> Start</dt>
                                        <dd>{{ $lanparty->start->format('d.m.Y') }} - 16:00 Uhr</dd>

                                        <dt><i class="fa fa-fw fa-calendar"></i> Ende</dt>
                                        <dd>{{ $lanparty->end->format('d.m.Y') }} - 14:00 Uhr</dd>
                                    </dl>
                                </div>
                                <div class="col-lg-6">
                                    <dl>
                                        <dt><i class="fa fa-fw fa-map-marker"></i> Wo?</dt>
                                        <dd>{{ config('lanparty')['location']['name'] }}<br/>{{ config('lanparty')['location']['address'] }}</dd>

                                        <dt><i class="fa fa-fw fa-money"></i> Kosten</dt>
                                        <dd>{{ config('lanparty')['costs'] }} &euro;</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <dl>
                                        <dt><i class="fa fa-fw fa-star"></i> Was wir bieten!</dt>
                                        <dd>{!! config('lanparty')['specials'] !!}</dd>
                                    </dl>
                                </div>
                            </div>


                        @elseif ($lanparty->registrationstart > \Carbon\Carbon::now())

                            <p>Die Anmeldung für die <span class="text-warning">{{ $lanparty->title }}</span> öffnet in ...</p>
                            <div id="countdown" data-timer="{{ $lanparty->registrationstart->format('Y/m/d H:i:s') }}" style="margin-bottom: 30px;"></div>
                            <p><span class="text-warning">Macht euch bereit!</span></p>
                            <p>Es gibt wie immer die beste Unterhaltung, besondere Turniere, großartige Preise und die einzigartige Atmosphäre der Guns'n Bits.</p>
                            <p>Einen kleinen Vorgeschmack findet ihr in unserer Bilder-Galerie oder direkt und persönlich in unserem TeamSpeak.</p>
                            <p><span class="text-warning">Also kommt vorbei!</span></p>

                        @elseif ($lanparty->registrationend < \Carbon\Carbon::now() && $lanparty->start > \Carbon\Carbon::now())

                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">

                                        Gleich gehts los!

                                    </div>
                                </div>
                            </div>

                        @elseif ($lanparty->registrationend < \Carbon\Carbon::now() && $lanparty->start > \Carbon\Carbon::now())

                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <h6>Gleich gehts los!</h6>


                                    </div>
                                </div>
                            </div>

                        @endif

                    @endif

                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default" data-mh="row2">
                <div class="panel-heading">Spiele & Turniere</div>
                <div class="panel-body">
                    <ul>
                        <li>CounterStrike GO</li>
                        <li>League of Legens</li>
                        <li>DOTA2</li>
                        <li>Starcraft 2 - Wings of Liberty</li>
                        <li>Trackmania Nations</li>
                        <li>Blobby Volley</li>
                        <li>...</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default" data-mh="row2">
                <div class="panel-heading">Unsere Sponsoren</div>
                <div class="panel-body">
                    <div class="owl-carousel owl-theme owl-sponsors">
                        @foreach($sponsors as $sponsor)
                            <div>
                                <figure>
                                    <a href="{{ route('sponsor.show', [$sponsor->slug]) }}">
                                        <img src="/images/sponsors/{{ $sponsor->logo }}" class="img-responsive">
                                    </a>
                                </figure>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Facebook News</div>
                <div class="panel-body">

                    <ul class="timeline">
                        @foreach($posts as $post)
                            <li class="">
                                <div class="timeline-badge text-warning">
                                    @if($post->type == 'event')
                                        <i class="fa fa-fw fa-calendar"></i>
                                    @elseif($post->type == 'video')
                                        <i class="fa fa-fw fa-play"></i>
                                    @elseif($post->type == 'status')
                                        <i class="fa fa-fw fa-comment"></i>
                                    @elseif($post->type == 'photo')
                                        <i class="fa fa-fw fa-camera"></i>
                                    @elseif($post->type == 'link')
                                        <i class="fa fa-fw fa-link"></i>
                                    @endif
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-body">
                                        <article class="post-wrap thumbnail">
                                            <div class="post-media">
                                                <div class="post-meta clearfix">
                                                    <span class="pull-left text-warning"><span class="post-date"><i class="fa fa-calendar-o"></i> {{ $post->created_time->format('d.m.Y') }} <i class="fa fa-clock-o"></i> {{ $post->created_time->format('H:i') }} Uhr</span></span>
                                                </div>
                                            </div>
                                            <div class="post-header">
                                                @if ($post->story)
                                                    <p>{{ $post->story }}</p>
                                                @endif
                                            </div>
                                            <div class="post-body">
                                                @if ($post->images()->get()->count() > 0)
                                                    <div class="pull-right" style="margin-bottom: 10px;">
                                                        @if ($post->images()->get()->count() == 1)
                                                            <figure>
                                                                <img class="img-responsive img-thumbnail" src="images/facebook/{{ $post->images()->first()->basename }}" width="200">
                                                            </figure>
                                                        @else

                                                        @endif
                                                    </div>
                                                @endif
                                                <div class="post-excerpt">{!! nl2br($post->message) !!}</div>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Checkliste</div>
                <div class="panel-body">

                    <p>Damit ihr zu unserer Lanparty auch nix vergesst, hier eine kleine Checkliste, was so alles bei euch im Koffer(raum) sein sollte.</p>

                    <ul>
                        <li>Rechner</li>
                        <li>Monitor</li>
                        <li>Tastatur und Maus</li>
                        <li>Stromkabel</li>
                        <li>Netzwerkkabel (min. 5 Meter)</li>
                        <li>3er Steckdose</li>
                        <li>Kopfhörer</li>
                        <li>Ladegeräte (z.B. fürs Handy)</li>
                        <li>...</li>
                    </ul>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Statistik</div>
                <div class="panel-body">

                    <dl class="dl-horizontal iconlist">
                        <dt><i class="fa fa-fw fa-users"></i></dt>
                        <dd>wir haben insgesamt <span class="text-warning">{{ $users->count() }}</span> registrierte Benutzer</dd>
                        <dt><i class="fa fa-fw fa-circle-thin"></i></dt>
                        <dd><span class="text-warning">{{ $max_coins->name }}</span> hat mit <span class="text-warning">{{ $max_coins->coins()->sum('coins') }}</span> Coins bisher die meisten GnB-Coins gesammelt</dd>
                    </dl>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript" src="/js/jquery.countdownTimer.min.js"></script>
    <script type="text/javascript">
        $(function() {
            'use strict';

            var countdowntime = $('#countdown').data('timer') ? $('#countdown').data('timer') : '2020/01/01 00:00:00';

            $('#countdown').countdowntimer({
                dateAndTime: countdowntime,
                size: 'lg'
            });

            $('.owl-sponsors').owlCarousel({
                items: 1,
                loop: true,
                lazyLoad: true,
                autoplay: true,
                autoplayTimeout: 5000,

            });

        });
    </script>
@endsection
