@extends('layouts.admin')

@section('title', 'Sitzplan')
@section('bodyclass', 'bgpic-3')
@section('contentclass', 'container bg-dark')

@section('content')
	
	<h1>Sitzplan - {{ $lanparty->title }}</h1>

    <!-- STAGE -->
	<div class="row stage">
		<h5>Bühne</h5>
		<div class="col-sm-12 text-center seatingrow">
			@for ($i=201; $i<=210; $i++)
			<button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
			@if (isset($reservedseats[$i]))
				@if ($reservedseats[$i]->status == -1)
					data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
				@else
					data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
				@endif
			@else
				data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
			@endif
			>{{ $i }}</button>
			@endfor
		</div>
		<div class="col-sm-12 text-center seatingrow">
			@for ($i=211; $i<=220; $i++)
			<button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
			@if (isset($reservedseats[$i]))
				@if ($reservedseats[$i]->status == -1)
					data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
				@else
					data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
				@endif
			@else
				data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
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
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
						@endif
						>{{ $i }}</button>
					@endfor
				</div>
				<div class="col-xs-6 rightrow">
					@for ($i=26; $i<=50; $i++)
						<button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
						@if (isset($reservedseats[$i]))
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
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
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
						@endif
						>{{ $i }}</button>
					@endfor
				</div>
				<div class="col-xs-6 rightrow">
					@for ($i=76; $i<=100; $i++)
						<button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
						@if (isset($reservedseats[$i]))
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
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
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
						@endif
						>{{ $i }}</button>
					@endfor
				</div>
				<div class="col-xs-6 rightrow">
					@for ($i=126; $i<=150; $i++)
						<button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
						@if (isset($reservedseats[$i]))
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
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
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
						@endif
						>{{ $i }}</button>
					@endfor
				</div>
				<div class="col-xs-6 rightrow">
					@for ($i=176; $i<=200; $i++)
						<button class="btn btn-default seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
						@if (isset($reservedseats[$i]))
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
						@endif
						>{{ $i }}</button>
					@endfor
				</div>
			</div>
		</div>
	</div>
    
    @for ($i=1; $i<=220; $i++)
	    @if (isset($reservedseats[$i]) && $reservedseats[$i]->status > 0)
	    <div class="modal fade" id="modal-{{ $i }}" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Sitzplatz #{{ $i }}</h4>
					</div>
					<div class="modal-body">
						<p>Zur Zeit 
						@if ($reservedseats[$i]->status == 3) 
							<span class="text-success">reserviert</span> und <span class="text-success">bezahlt</span>
						@elseif ($reservedseats[$i]->status == 2) 
							<span class="text-success">reserviert</span>
						@elseif ($reservedseats[$i]->status == 1)
							<span class="text-warning">vorgemerkt</span>
						@endif
						von<br/><b>{{ $reservedseats[$i]->user->name }}</b> (ID: {{ $reservedseats[$i]->user->id }}).</p>
					</div>
					<div class="modal-footer">
						@if ($reservedseats[$i]->status < 3)
						<p>Willst du diesen Platz wieder freigeben?
						{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.lanparty.seatingplan', [$lanparty->id])) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::hidden('id')->value($reservedseats[$i]->id) !!}
                        {!! BootForm::hidden('action')->value('activate') !!}
						{!! BootForm::submit('<i class="fa fa-fw fa-close"></i> ja, freigeben')->class('btn btn-danger') !!}
                        {!! BootForm::close() !!}
                        <hr>
                        @endif
                        <p>Diesem Teilnehmer einen neuen Platz zuweisen?</p>
                        {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.lanparty.seatingplan', [$lanparty->id])) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::hidden('id')->value($reservedseats[$i]->id) !!}
                        {!! BootForm::hidden('action')->value('change') !!}
                        {!! BootForm::select('Sitzplatz', 'seatnumber')->options($freeseats) !!}
						{!! BootForm::submit('<i class="fa fa-fw fa-check"></i> zuweisen')->class('btn btn-success') !!}
                        {!! BootForm::close() !!}
                	</div>
				</div>
			</div>
		</div>
		@elseif (isset($reservedseats[$i]) && $reservedseats[$i]->status == -1)
		<div class="modal fade" id="modal-{{ $i }}" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Sitzplatz #{{ $i }}</h4>
					</div>
					<div class="modal-body">
						<p>Diesen Sitzplatz wieder</p>
						{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.lanparty.seatingplan', [$lanparty->id])) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::hidden('id')->value($reservedseats[$i]->id) !!}
                        {!! BootForm::hidden('action')->value('activate') !!}
						{!! BootForm::submit('<i class="fa fa-fw fa-check"></i> aktivieren')->class('btn btn-success pull-right') !!}
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
						<h4 class="modal-title">Sitzplatz #{{ $i }}</h4>
					</div>
					<div class="modal-body">
						{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.lanparty.seatingplan', [$lanparty->id])) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::hidden('seatnumber')->value($i) !!}
                        {!! BootForm::hidden('action')->value('disable') !!}
						{!! BootForm::submit('<i class="fa fa-fw fa-close"></i> deaktivieren')->class('btn btn-info pull-right') !!}
                        {!! BootForm::close() !!}
                        <hr>
                        <p>Diesen Sitzplatz für</p>
                        {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.lanparty.seatingplan', [$lanparty->id])) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::hidden('seatnumber')->value($i) !!}
                        {!! BootForm::hidden('action')->value('reserve') !!}
                        {!! BootForm::hidden('user_id') !!}
                        {!! BootForm::text('Benutzer', 'name')->class('form-control autocomplete user') !!}
                        {!! BootForm::select('mit Status', 'status')->options([1=>'vorgemerkt', 2=>'reserviert', 3=>'bezahlt']) !!}
						{!! BootForm::submit('<i class="fa fa-fw fa-check"></i> reservieren')->class('btn btn-success') !!}
                        {!! BootForm::close() !!}
					</div>
				</div>
			</div>
		</div>
		@endif
	@endfor
@endsection