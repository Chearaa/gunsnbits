@extends('layouts.app')

@section('content')

	@if ($lanparty instanceof \App\Lanparty)

        @if ($lanparty->registrationstart < \Carbon\Carbon::now() && $lanparty->registrationend > \Carbon\Carbon::now())

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h6>Anmeldung zur {{ $lanparty->title }}</h6>
                            </div>
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        @if (is_null($user))
                                            <p>Um dich anmelden zu können musst du eingeloggt sein.</p>
                                            <p><a href="{{ route('auth.login') }}" class="btn btn-default"><i class="fa fa-fw fa-sign-in"></i> jetzt einloggen</a></p>
                                        @else
                                            <h5>Hallo {{ $user->name }}</h5>
                                            @if ($usercanreserveseats > 0)
                                                @if ($usercanreserveseats == 1)
                                                    <p>Du kannst <span class="text-success">einen Platz</span> reservieren.</p>
                                                @else
                                                    <p>Du kannst noch bis zu <span class="text-success">{{ $usercanreserveseats }} weitere Plätze</span> reservieren.</p>
                                                @endif

                                                @if ($next_lan_free)
                                                    <div class="well well-sm bg-info">
                                                        <h5>Herzlichen Glückwunsch!</h5>
                                                        Weil du so oft bei uns warst und schon <span class="text-primary">{{ $user->coins()->sum('coins') }} GnB-Coins</span> gesammelt hast, ist deine nächste Sitzplatzreservierung <span class="text-success">sofort bezahlt</span> und <span class="text-success">reserviert</span>!<br/>
                                                        Wir freuen uns auf dich!
                                                    </div>
                                                @endif
                                            @else
                                                <p>Leider kannst du <span class="text-danger">keinen weiteren</span> Sitzplatz reservieren.</p>
                                                <p>Brauchst du jedoch noch mehr Plätze, melde dich bitte bei unserem <a href="{{ route('service.contact') }}">Support-Team</a>!</p>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 reservations">
                                        @if (!is_null($user) && $user->seats()->where('lanparty_id', $lanparty->id)->get()->count() > 0)
                                            <h5>{{ ($user->seats()->where('lanparty_id', $lanparty->id)->get()->count() == 1) ? 'Deine Reservierung' : 'Deine Reservierungen'}}</h5>
                                            @foreach ($user->seats()->where('lanparty_id', $lanparty->id)->get() as $index => $seat)
                                                @if ($index > 0 && $seat->status > 0)
                                                    <hr>
                                                @endif
                                                @if ($seat->status == 1)
                                                    <button class="btn btn-lg btn-warning pull-left">{{ $seat->seatnumber }}</button>
                                                    <p>Platz <span class="text-warning">{{ $seat->seatnumber }}</span> wurde am {{ $seat->marked_at->format('d.m.Y H:i') }} Uhr <span class="text-warning">vorgemerkt</span> aber <span class="text-danger">noch nicht bezahlt</span>.<p>
                                                    <p>Bitte überweise den Teilnehmerbetrag bis zum <span class="text-warning">{{ $seat->marked_at->addDays(14)->format('d.m.Y') }}</span>, damit dir dieser Platz wirklich sicher ist. Andernfalls kann es sein, dass wir den Platz für andere wieder freigeben.</p>

                                                    <div class="well well-sm">
                                                        <h6>Überweisungs-Infos für Platz #{{ $seat->seatnumber }}</h6>
                                                        <p>Bitte überweise <span class='text-success'>{{ config('lanparty')['costs'] }}</span> &euro; an</p><p>{{ config('lanparty')['accountholder'] }}<br/>IBAN: {{ config('lanparty')['iban'] }}<br/>BIC: {{ config('lanparty')['bic'] }}</p><p>Verwendungszweck: <span class='text-success'>{{ $lanparty->reasonforpayment }}-{{ $user->id }}-{{ $seat->seatnumber }}</span></p>
                                                    </div>

                                                    <p>
                                                        {{--<button class="btn btn-default" data-popover="true" data-trigger="click" data-placement="right" title="Überweisungs-Infos für Platz #{{ $seat->seatnumber }}" data-content="<p>Bitte überweise <span class='text-success'>{{ config('lanparty')['costs'] }}</span> &euro; an</p><p>{{ config('lanparty')['accountholder'] }}<br/>IBAN: {{ config('lanparty')['iban'] }}<br/>BIC: {{ config('lanparty')['bic'] }}</p><p>Verwendungszweck: <span class='text-success'>{{ $lanparty->reasonforpayment }}-{{ $user->id }}-{{ $seat->seatnumber }}</span></p>"><i class="fa fa-fw fa-info-circle"></i> Überweisung-Info</button>--}}
                                                        @if (config('lanparty')['paywithcode'])
                                                            <button class="btn btn-success" data-container="body" data-toggle="modal" data-target="#code-{{ $seat->seatnumber }}"><i class="fa fa-fw fa-qrcode"></i> Gutschein</button>
                                                        @endif
                                                        @if (config('lanparty.paywithpaypal'))
                                                            <button class="btn btn-success" data-container="body" data-toggle="modal" data-target="#paypal-{{ $seat->seatnumber }}"><i class="fa fa-fw fa-paypal"></i> PayPal</button>
                                                        @endif
                                                        {{--
                                                        @if ($user->coins()->lists('coins')->sum() >= config('lanparty')['paybycoins'])
                                                            <button class="btn btn-success" data-container="body" data-toggle="modal" data-target="#coins-{{ $seat->seatnumber }}"><i class="fa fa-fw fa-gg-circle"></i> mit GnB-Coins bezahlen</button>
                                                        @endif
                                                        --}}
                                                        <button class="btn btn-danger pull-right" data-container="body" data-toggle="modal" data-target="#modal-{{ $seat->seatnumber }}" ><i class="fa fa-fw fa-close"></i></button>
                                                    </p>
                                                @elseif ($seat->status == 2)
                                                    <button class="btn btn-lg btn-success pull-left">{{ $seat->seatnumber }}</button>
                                                    <p>Platz <span class="text-success">{{ $seat->seatnumber }}</span> wurde am {{ $seat->reserved_at->format('d.m.Y H:i') }} Uhr <span class="text-success">reserviert</span> aber <span class="text-danger">noch nicht bezahlt</span>.<p>
                                                    <p>Bitte überweise den Teilnehmerbetrag schnellstmöglich auf das angegebene Konto.</p>

                                                    <div class="well well-sm">
                                                        <h6>Überweisungs-Infos für Platz #{{ $seat->seatnumber }}</h6>
                                                        <p>Bitte überweise <span class='text-success'>{{ config('lanparty')['costs'] }}</span> &euro; an</p><p>{{ config('lanparty')['accountholder'] }}<br/>IBAN: {{ config('lanparty')['iban'] }}<br/>BIC: {{ config('lanparty')['bic'] }}</p><p>Verwendungszweck: <span class='text-success'>{{ $lanparty->reasonforpayment }}-{{ $user->id }}-{{ $seat->seatnumber }}</span></p>
                                                    </div>
                                                    <p>
                                                        {{--<button class="btn btn-default" data-popover="true" data-trigger="click" data-placement="right" title="Überweisungs-Infos für Platz #{{ $seat->seatnumber }}" data-content="<p>Bitte überweise <span class='text-success'>{{ config('lanparty')['costs'] }}</span> &euro; an</p><p>{{ config('lanparty')['accountholder'] }}<br/>IBAN: {{ config('lanparty')['iban'] }}<br/>BIC: {{ config('lanparty')['bic'] }}</p><p>Verwendungszweck: <span class='text-success'>{{ $lanparty->reasonforpayment }}-{{ $user->id }}-{{ $seat->seatnumber }}</span></p>"><i class="fa fa-fw fa-info-circle"></i> Überweisung-Info</button>--}}
                                                        @if (config('lanparty')['paywithcode'])
                                                            <button class="btn btn-success" data-container="body" data-toggle="modal" data-target="#code-{{ $seat->seatnumber }}"><i class="fa fa-fw fa-qrcode"></i> Gutschein</button>
                                                        @endif
                                                        @if (config('lanparty.paywithpaypal'))
                                                            <button class="btn btn-success" data-container="body" data-toggle="modal" data-target="#paypal-{{ $seat->seatnumber }}"><i class="fa fa-fw fa-paypal"></i> PayPal</button>
                                                        @endif
                                                        <button class="btn btn-danger pull-right" data-container="body" data-toggle="modal" data-target="#modal-{{ $seat->seatnumber }}" ><i class="fa fa-fw fa-close"></i> stornieren</button>
                                                    </p>
                                                @elseif ($seat->status == 3)
                                                    <button class="btn btn-lg btn-success pull-left">{{ $seat->seatnumber }}</button>
                                                    <p>Platz <span class="text-success">{{ $seat->seatnumber }}</span> wurde am {{ $seat->payed_at->format('d.m.Y H:i') }} Uhr <span class="text-success">reserviert</span> und <span class="text-success">bezahlt</span>.<p>
                                                    <p>{{ config('lanparty')['coins'] }} GnB-Coins wurden dir gutgeschrieben.</p>
                                                @endif

                                                <!-- MODAL RESERVATION DELETE -->
                                                <div class="modal fade" id="modal-{{ $seat->seatnumber }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Platz #{{ $seat->seatnumber }}</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Willst du wirklich diese Reservierung stornieren?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('lanparty.reservation.delete')) !!}
                                                                {!! csrf_field() !!}
                                                                {!! BootForm::hidden('user_id')->value($user->id) !!}
                                                                {!! BootForm::hidden('id')->value($seat->id) !!}
                                                                <button type="submit" class="btn btn-danger"><i class="fa fa-fw fa-close"></i> ja</button>
                                                                <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close">nein</button>
                                                                {!! BootForm::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- MODAL PAY BY CODE -->
                                                <div class="modal fade" id="code-{{ $seat->seatnumber }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Platz #{{ $seat->seatnumber }}</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Du hast einen Gutschein von uns?!</p>
                                                                <p>Dann trage hier den Code ein.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('lanparty.reservation.code')) !!}
                                                                {!! csrf_field() !!}
                                                                {!! BootForm::hidden('user')->value($user->id) !!}
                                                                {!! BootForm::hidden('seat')->value($seat->id) !!}
                                                                {!! BootForm::hidden('lanparty')->value($lanparty->id) !!}
                                                                {!! BootForm::text('Code', 'code')->required() !!}
                                                                <button type="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i> einlösen</button>
                                                                {!! BootForm::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- MODAL PAY BY PAYPAL -->
                                                <div class="modal fade" id="paypal-{{ $seat->seatnumber }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Platz #{{ $seat->seatnumber }}</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Du willst den Platz per PayPal bezahlen?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('paypal.payment')) !!}
                                                                {!! csrf_field() !!}
                                                                {!! BootForm::hidden('user')->value($user->id) !!}
                                                                {!! BootForm::hidden('seat')->value($seat->id) !!}
                                                                {!! BootForm::hidden('lanparty')->value($lanparty->id) !!}
                                                                <button type="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i> jetzt bezahlen</button>
                                                                {!! BootForm::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- MODAL PAY BY COINS -->
                                                <div class="modal fade" id="coins-{{ $seat->seatnumber }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Platz #{{ $seat->seatnumber }}</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Du hast <span class="text-success">{{ $user->coins()->lists('coins')->sum() }} GnB-Coins</span>.</p>
                                                                <p>Willst du für <span class="text-danger">{{ config('lanparty')['paybycoins'] }} GnB-Coins</span> diesen Sitzplatz bezahlen?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('lanparty.reservation.coins')) !!}
                                                                {!! csrf_field() !!}
                                                                {!! BootForm::hidden('user')->value($user->id) !!}
                                                                {!! BootForm::hidden('seat')->value($seat->id) !!}
                                                                {!! BootForm::hidden('lanparty')->value($lanparty->id) !!}
                                                                <button type="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i> ja</button>
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fa fa-fw fa-close"></i> nein</button>
                                                                {!! BootForm::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            @if (config('lanparty.paywithpaypal') && $user->seats()->where('lanparty_id', $lanparty->id)->where('status', '<', 3)->where('status', '>', 0)->get()->count() > 1)
                                                <hr>

                                                <p>Natürlich hast du auch die Möglichkeit direkt alle deine Plätze auf einmal mit <i class="fa fa-paypal"></i> PayPal zu bezahlen.</p>
                                                <button class="btn btn-success" data-container="body" data-toggle="modal" data-target="#paypalall"><i class="fa fa-fw fa-paypal"></i> alle Plätze bezahlen</button>

                                                <!-- MODAL PAY BY PAYPAL -->
                                                <div class="modal fade" id="paypalall" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Alle Plätze</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Du willst alle Plätze per <i class="fa fa-paypal"></i> <strong>PayPal</strong> bezahlen?</p>
                                                                @foreach ($seats = $user->seats()->where('lanparty_id', $lanparty->id)->where('status', '<', 3)->where('status', '>', 0)->get() as $index => $seat)
                                                                    <span class="badge" style="margin-right: 10px;">Platz #{{$seat->seatnumber}}</span>
                                                                @endforeach
                                                            </div>
                                                            <div class="modal-footer">
                                                                {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('paypal.payment')) !!}
                                                                {!! csrf_field() !!}
                                                                {!! BootForm::hidden('user')->value($user->id) !!}
                                                                {!! BootForm::hidden('seats')->value(implode('-', $seats->pluck('id')->toArray())) !!}
                                                                {!! BootForm::hidden('lanparty')->value($lanparty->id) !!}
                                                                <button type="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i> jetzt bezahlen</button>
                                                                {!! BootForm::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h6>Sitzplan</h6>
                            </div>
                            <div class="panel-body">

                                <div class="row">

                                    <!-- STAGE -->
                                    <div class="col-lg-12">
                                        <div class="seatblocks stage panel panel-default">
                                            <div class="panel-body bg-darker text-center">
                                                <h6>Bühne</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">

                                            <div class="seatblocks">
                                                <i class="fa fa-sign-out fa-2x text-success special beergarden" data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Ausgang" data-content="zum Biergarten <i class='fa fa-beer'></i>"></i>
                                                <i class="fa fa-sign-out fa-2x text-danger special emergencyexit emergencyexit--1" data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Notausgang" data-content=""></i>
                                                <i class="fa fa-sign-out fa-2x text-danger special emergencyexit emergencyexit--2" data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Notausgang" data-content=""></i>
                                                <i class="fa fa-sign-out fa-2x text-success special bar" data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Eingang" data-content="und Zugang zur Bar <i class='fa fa-cocktail'></i>"></i>

                                                <div class="fa special sleepshowerwc">
                                                    <i class="fa fa-wheelchair fa-2x text-info" data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Toiletten und Duschen"></i>
                                                    <i class="fa fa-bed fa-2x text-info" data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Schlafbereich"></i>
                                                </div>

                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right">
                                                    @for ($i=249; $i<=260; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>

                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left">
                                                    @for ($i=1; $i<=12; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>
                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right">
                                                    @for ($i=25; $i<=36; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>

                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left">
                                                    @for ($i=49; $i<=60; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>
                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right">
                                                    @for ($i=73; $i<=84; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>

                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left">
                                                    @for ($i=97; $i<=108; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>
                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right">
                                                    @for ($i=121; $i<=132; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>

                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left">
                                                    @for ($i=145; $i<=156; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>
                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right">
                                                    @for ($i=169; $i<=180; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>

                                            </div>

                                            <div class="seatblocks">

                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right">
                                                    @for ($i=261; $i<=272; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>

                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left">
                                                    @for ($i=13; $i<=24; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>
                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right">
                                                    @for ($i=37; $i<=48; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>

                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left">
                                                    @for ($i=61; $i<=72; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>
                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right">
                                                    @for ($i=85; $i<=96; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>

                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left">
                                                    @for ($i=109; $i<=120; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>
                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right">
                                                    @for ($i=133; $i<=144; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>

                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left">
                                                    @for ($i=157; $i<=168; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>
                                                <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right">
                                                    @for ($i=181; $i<=192; $i++)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>

                                            </div>

                                            <div class="seatblocks">

                                                <div class="seatblock seatblock--horizontal row-top">
                                                    @for ($i=206; $i>=193; $i--)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>

                                                <div class="seatblock seatblock--horizontal row-bottom">
                                                    @for ($i=220; $i>=207; $i--)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>

                                                <div class="seatblock seatblock--horizontal row-top">
                                                    @for ($i=234; $i>=221; $i--)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>

                                                <div class="seatblock seatblock--horizontal row-bottom">
                                                    @for ($i=248; $i>=235; $i--)
                                                        <button class="btn btn-sm seat {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                                @if (isset($reservedseats[$i]))
                                                                @if ($reservedseats[$i]->status == -1)
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                                @else
                                                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                @endif
                                                                @else
                                                                @if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('lanpartymanager')))
                                                                data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                @endif
                                                                @endif
                                                        >{{ $i }}</button>
                                                    @endfor
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @for ($i=1; $i<=272; $i++)
                @if (!isset($reservedseats[$i]))
                    <div class="modal fade" id="modal-{{ $i }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Sitzplatz #{{ $i }}</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Diesen Sitzplatz jetzt reservieren?</p>
                                    {!! BootForm::open()->post()->action(route('lanparty.reservation.post')) !!}
                                    {!! csrf_field() !!}
                                    {!! BootForm::hidden('seatnumber')->value($i) !!}
                                    {!! BootForm::hidden('lanparty')->value($lanparty->id) !!}
                                    <p class="text-right">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i> ja</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fa fa-fw fa-close"></i> nein</button>
                                    </p>
                                    {!! BootForm::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endfor

        @elseif ($lanparty->registrationstart > \Carbon\Carbon::now())

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        Die Anmeldung öffnet in ...

                        <div id="countdown" data-timer="{{ $lanparty->registrationstart->format('Y/m/d H:i:s') }}"></div>

                    </div>
                </div>
            </div>

        @elseif ($lanparty->registrationend < \Carbon\Carbon::now() && $lanparty->start > \Carbon\Carbon::now())

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        Gleich gehts los!

                    </div>
                </div>
            </div>

        @elseif ($lanparty->start < \Carbon\Carbon::now() && $lanparty->end > \Carbon\Carbon::now())

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        Jetzt gehts rund!

                    </div>
                </div>
            </div>

        @endif
    @else

        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6>Ooohhh...</h6>
                        </div>
                        <div class="panel-body">
                            Zur Zeit ist leider keine Lanparty geplant.
                        </div>
                    </div>

                </div>
            </div>
        </div>

	@endif
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

        });
    </script>
@endsection