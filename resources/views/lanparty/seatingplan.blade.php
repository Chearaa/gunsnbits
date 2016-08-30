@extends('layouts.gnb')

@section('title', 'Sitzplan')
@section('bodyclass', 'bgpic-2')
@section('contentclass', 'container bg-dark')

@section('content')

	@if (!is_null($lanparty))
        <h1 class="title">Sitzplan der {{ $lanparty->title }}</h1>

        <!-- STAGE -->
        <div class="row stage">
            <h5>Bühne</h5>
            <div class="col-sm-12 text-center seatingrow">
                @for ($i=201; $i<=210; $i++)
                <button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                    @if (isset($reservedseats[$i]))
                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}"
                        @if ($reservedseats[$i]->status == -1)
                        data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                        @elseif ($reservedseats[$i]->status == 1)
                        data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-warning'>vorgemerkt</span>"
                        @elseif ($reservedseats[$i]->status == 2)
                        data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span>"
                        @elseif ($reservedseats[$i]->status == 3)
                        data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span> und <span class='text-success'>bezahlt</span>"
                        @endif
                    @endif
                >{{ $i }}</button>
                @endfor
            </div>
            <div class="col-sm-12 text-center seatingrow">
                @for ($i=211; $i<=220; $i++)
                <button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                    @if (isset($reservedseats[$i]))
                        data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}"
                        @if ($reservedseats[$i]->status == -1)
                        data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                        @elseif ($reservedseats[$i]->status == 1)
                        data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-warning'>vorgemerkt</span>"
                        @elseif ($reservedseats[$i]->status == 2)
                        data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span>"
                        @elseif ($reservedseats[$i]->status == 3)
                        data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span> und <span class='text-success'>bezahlt</span>"
                        @endif
                    @endif
                >{{ $i }}</button>
                @endfor
            </div>
        </div>
        <div class="row hall">
            <h5>Saal</h5>
            <!-- ROW 1 -->
            <div class="col-xs-6 col-sm-3 seatingrow">
                <div class="row">
                    <div class="col-xs-6 leftrow">
                        @for ($i=1; $i<=25; $i++)
                        <button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }} pull-right"
                            @if (isset($reservedseats[$i]))
                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}"
                                @if ($reservedseats[$i]->status == -1)
                                data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                @elseif ($reservedseats[$i]->status == 1)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-warning'>vorgemerkt</span>"
                                @elseif ($reservedseats[$i]->status == 2)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span>"
                                @elseif ($reservedseats[$i]->status == 3)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span> und <span class='text-success'>bezahlt</span>"
                                @endif
                            @endif
                        >{{ $i }}</button>
                        @endfor
                    </div>
                    <div class="col-xs-6 rightrow">
                        @for ($i=26; $i<=50; $i++)
                        <button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                            @if (isset($reservedseats[$i]))
                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}"
                                @if ($reservedseats[$i]->status == -1)
                                data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                @elseif ($reservedseats[$i]->status == 1)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-warning'>vorgemerkt</span>"
                                @elseif ($reservedseats[$i]->status == 2)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span>"
                                @elseif ($reservedseats[$i]->status == 3)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span> und <span class='text-success'>bezahlt</span>"
                                @endif
                            @endif
                        >{{ $i }}</button>
                        @endfor
                    </div>
                </div>
            </div>
            <!-- ROW 2 -->
            <div class="col-xs-6 col-sm-3 seatingrow">
                <div class="row">
                    <div class="col-xs-6 leftrow">
                        @for ($i=51; $i<=75; $i++)
                        <button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }} pull-right"
                            @if (isset($reservedseats[$i]))
                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}"
                                @if ($reservedseats[$i]->status == -1)
                                data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                @elseif ($reservedseats[$i]->status == 1)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-warning'>vorgemerkt</span>"
                                @elseif ($reservedseats[$i]->status == 2)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span>"
                                @elseif ($reservedseats[$i]->status == 3)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span> und <span class='text-success'>bezahlt</span>"
                                @endif
                            @endif
                        >{{ $i }}</button>
                        @endfor
                    </div>
                    <div class="col-xs-6 rightrow">
                        @for ($i=76; $i<=100; $i++)
                        <button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                            @if (isset($reservedseats[$i]))
                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}"
                                @if ($reservedseats[$i]->status == -1)
                                data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                @elseif ($reservedseats[$i]->status == 1)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-warning'>vorgemerkt</span>"
                                @elseif ($reservedseats[$i]->status == 2)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span>"
                                @elseif ($reservedseats[$i]->status == 3)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span> und <span class='text-success'>bezahlt</span>"
                                @endif
                            @endif
                        >{{ $i }}</button>
                        @endfor
                    </div>
                </div>
            </div>
            <!-- ROW 3 -->
            <div class="col-xs-6 col-sm-3 seatingrow">
                <div class="row">
                    <div class="col-xs-6 leftrow">
                        @for ($i=101; $i<=125; $i++)
                        <button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }} pull-right"
                            @if (isset($reservedseats[$i]))
                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}"
                                @if ($reservedseats[$i]->status == -1)
                                data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                @elseif ($reservedseats[$i]->status == 1)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-warning'>vorgemerkt</span>"
                                @elseif ($reservedseats[$i]->status == 2)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span>"
                                @elseif ($reservedseats[$i]->status == 3)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span> und <span class='text-success'>bezahlt</span>"
                                @endif
                            @endif
                        >{{ $i }}</button>
                        @endfor
                    </div>
                    <div class="col-xs-6 rightrow">
                        @for ($i=126; $i<=150; $i++)
                        <button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                            @if (isset($reservedseats[$i]))
                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}"
                                @if ($reservedseats[$i]->status == -1)
                                data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                @elseif ($reservedseats[$i]->status == 1)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-warning'>vorgemerkt</span>"
                                @elseif ($reservedseats[$i]->status == 2)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span>"
                                @elseif ($reservedseats[$i]->status == 3)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span> und <span class='text-success'>bezahlt</span>"
                                @endif
                            @endif
                        >{{ $i }}</button>
                        @endfor
                    </div>
                </div>
            </div>
            <!-- ROW 4 -->
            <div class="col-xs-6 col-sm-3 seatingrow">
                <div class="row">
                    <div class="col-xs-6 leftrow">
                        @for ($i=151; $i<=175; $i++)
                        <button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }} pull-right"
                            @if (isset($reservedseats[$i]))
                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}"
                                @if ($reservedseats[$i]->status == -1)
                                data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                @elseif ($reservedseats[$i]->status == 1)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-warning'>vorgemerkt</span>"
                                @elseif ($reservedseats[$i]->status == 2)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span>"
                                @elseif ($reservedseats[$i]->status == 3)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span> und <span class='text-success'>bezahlt</span>"
                                @endif
                            @endif
                        >{{ $i }}</button>
                        @endfor
                    </div>
                    <div class="col-xs-6 rightrow">
                        @for ($i=176; $i<=200; $i++)
                        <button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
                            @if (isset($reservedseats[$i]))
                                data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}"
                                @if ($reservedseats[$i]->status == -1)
                                data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
                                @elseif ($reservedseats[$i]->status == 1)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-warning'>vorgemerkt</span>"
                                @elseif ($reservedseats[$i]->status == 2)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span>"
                                @elseif ($reservedseats[$i]->status == 3)
                                data-content="{{ $user->name }} (ID: {{ $user->id }})<br/><span class='text-success'>reserviert</span> und <span class='text-success'>bezahlt</span>"
                                @endif
                            @endif
                        >{{ $i }}</button>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection