@extends('layouts.app')

@section('content')

    <div class="container">
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

                                    <div class="seatblocks clearfix">
                                        <i class="fa fa-sign-out fa-2x text-success special beergarden" data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Ausgang" data-content="zum Biergarten <i class='fa fa-beer'></i>"></i>
                                        <i class="fa fa-sign-out fa-2x text-danger special emergencyexit emergencyexit--1" data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Notausgang" data-content=""></i>
                                        <i class="fa fa-sign-out fa-2x text-danger special emergencyexit emergencyexit--2" data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Notausgang" data-content=""></i>
                                        <i class="fa fa-sign-out fa-2x text-success special bar" data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Eingang" data-content="und Zugang zur Bar <i class='fa fa-cocktail'></i>"></i>

                                        <div class="fa special sleepshowerwc">
                                            <i class="fa fa-wheelchair fa-2x text-info" data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Toiletten und Duschen"></i>
                                            <i class="fa fa-bed fa-2x text-info" data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Schlafbereich"></i>
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatrow--bonus seatblock--u">
                                            @for ($i=249; $i<=260; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--a">
                                            @for ($i=1; $i<=12; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--b">
                                            @for ($i=25; $i<=36; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--c">
                                            @for ($i=49; $i<=60; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--d">
                                            @for ($i=73; $i<=84; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--e">
                                            @for ($i=97; $i<=108; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--f">
                                            @for ($i=121; $i<=132; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--g">
                                            @for ($i=145; $i<=156; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--h">
                                            @for ($i=169; $i<=180; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                    </div>

                                    <div class="seatblocks clearfix">

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--bonus seatblock--v">
                                            @for ($i=261; $i<=272; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--i">
                                            @for ($i=13; $i<=24; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--j">
                                            @for ($i=37; $i<=48; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--k">
                                            @for ($i=61; $i<=72; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--l">
                                            @for ($i=85; $i<=96; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--m">
                                            @for ($i=109; $i<=120; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--n">
                                            @for ($i=133; $i<=144; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--o">
                                            @for ($i=157; $i<=168; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--p">
                                            @for ($i=181; $i<=192; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                    </div>

                                    <div class="seatblocks">

                                        <div class="seatblock seatblock--horizontal row-top seatblock--q">
                                            @for ($i=206; $i>=193; $i--)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--horizontal row-bottom seatblock--r">
                                            @for ($i=220; $i>=207; $i--)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--horizontal row-top seatblock--s">
                                            @for ($i=234; $i>=221; $i--)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @endif
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--horizontal row-bottom seatblock--t">
                                            @for ($i=248; $i>=235; $i--)
                                                <button class="btn btn-sm btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                                                        @if (isset($reservedseats[$i]))
                                                        @if ($reservedseats[$i]->status == -1)
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                                        @else
                                                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-success">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3 && Auth::check() && Auth::user()->hasRole('lanpartymanager')) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
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

@endsection