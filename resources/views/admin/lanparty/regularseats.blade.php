@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-lg-12">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h6>Stammplätze verwalten</h6>
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
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--a">
                                            @for ($i=1; $i<=12; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--b">
                                            @for ($i=25; $i<=36; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--c">
                                            @for ($i=49; $i<=60; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--d">
                                            @for ($i=73; $i<=84; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--e">
                                            @for ($i=97; $i<=108; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--f">
                                            @for ($i=121; $i<=132; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--g">
                                            @for ($i=145; $i<=156; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--h">
                                            @for ($i=169; $i<=180; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                    </div>

                                    <div class="seatblocks clearfix">

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--bonus seatblock--v">
                                            @for ($i=261; $i<=272; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--i">
                                            @for ($i=13; $i<=24; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--j">
                                            @for ($i=37; $i<=48; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--k">
                                            @for ($i=61; $i<=72; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--l">
                                            @for ($i=85; $i<=96; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--m">
                                            @for ($i=109; $i<=120; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--n">
                                            @for ($i=133; $i<=144; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--left seatblock--o">
                                            @for ($i=157; $i<=168; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>
                                        <div class="seatblock seatblock--vertical seatblock--2rows seatrow--right seatblock--p">
                                            @for ($i=181; $i<=192; $i++)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                    </div>

                                    <div class="seatblocks clearfix">

                                        <div class="seatblock seatblock--horizontal row-top seatblock--q">
                                            @for ($i=206; $i>=193; $i--)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--horizontal row-bottom seatblock--r">
                                            @for ($i=220; $i>=207; $i--)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--horizontal row-top seatblock--s">
                                            @for ($i=234; $i>=221; $i--)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                        @endif
                                                >{{ $i }}</button>
                                            @endfor
                                        </div>

                                        <div class="seatblock seatblock--horizontal row-bottom seatblock--t">
                                            @for ($i=248; $i>=235; $i--)
                                                <button class="btn btn-sm btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}"
                                                        @if (isset($regularseats[$i]))
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                        @else
                                                        data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
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
	    @if (isset($regularseats[$i]))
	    <div class="modal fade" id="modal-{{ $i }}" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Stammplatz #{{ $i }}</h4>
					</div>
					<div class="modal-body">
						<p>Zur Zeit 
						@if ($regularseats[$i]->status == 3) 
							<span class="text-success">bezahlt</span>
						@elseif ($regularseats[$i]->status == 2) 
							<span class="text-success">reserviert</span>
						@elseif ($regularseats[$i]->status == 1)
							<span class="text-warning">vorgemerkt</span>
						@endif
						von <b>{{ $regularseats[$i]->user->name }}</b> (ID: {{ $regularseats[$i]->user->id }}).</p>
					</div>
					<div class="modal-footer">
						{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.lanparty.regularseats')) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::hidden('id')->value($regularseats[$i]->id) !!}
                        {!! BootForm::hidden('action')->value('delete') !!}
						{!! BootForm::submit('<i class="fa fa-fw fa-close"></i> Stammplatz löschen')->class('btn btn-danger') !!}
                        {!! BootForm::close() !!}
					</div>
				</div>
			</div>
		</div>
		@else
		<div class="modal fade" id="modal-{{ $i }}" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Stammplatz #{{ $i }}</h4>
					</div>
					<div class="modal-body">
						<p>Diesen Stammplatz an</p>
						{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.lanparty.regularseats')) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::hidden('action')->value('reserve') !!}
                        {!! BootForm::hidden('seatnumber')->value($i) !!}
                        {!! BootForm::hidden('user_id') !!}
                        {!! BootForm::text('Benutzer', 'name')->class('form-control autocomplete user')->autocomplete('off') !!}
                        {!! BootForm::select('Status', 'status')->options([2=>'reserviert', 1=>'vorgemerkt', 3=>'bezahlt']) !!}
						{!! BootForm::submit('<i class="fa fa-fw fa-check"></i> vergeben')->class('btn btn-success') !!}
                        {!! BootForm::close() !!}
					</div>
				</div>
			</div>
		</div>
		@endif
	@endfor
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function () {
            /**
             * autocomplete
             */
            $('.autocomplete.user').typeahead({
                onSelect: function (item) {
                    $('input[name="user_id"]').val(item.value);
                },
                ajax: {
                    url: "/ajax/users",
                    timeout: 300,
                    displayField: "name",
                    triggerLength: 1,
                    method: "get"
                }
            });
        });
    </script>
@endsection