@extends('layouts.admin')

@section('title', 'Stammplätze')
@section('bodyclass', 'bgpic-1')
@section('contentclass', 'container bg-dark')

@section('content')
	
	<h1>Stammplätze verwalten</h1>

    <!-- STAGE -->
	<div class="row stage">
		<div class="col-sm-12 text-center seatingrow">
			@for ($i=201; $i<=210; $i++)
			<button class="btn btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}" 
				@if (isset($regularseats[$i]))
					data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
				@else
					data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" 
				@endif
			>{{ $i }}</button>
			@endfor
		</div>
		<div class="col-sm-12 text-center seatingrow">
			@for ($i=211; $i<=220; $i++)
			<button class="btn btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}" 
				@if (isset($regularseats[$i]))
					data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
				@else
					data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" 
				@endif
			>{{ $i }}</button>
			@endfor
		</div>
	</div>
                    
	<div class="row hall">
		<!-- ROW 1 -->
		<div class="col-xs-6 col-sm-3 seatingrow">
			<div class="row">
				<div class="col-xs-6 leftrow">
					@for ($i=1; $i<=25; $i++)
					<button class="btn btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }} pull-right" 
						@if (isset($regularseats[$i]))
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
						@else
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" 
						@endif
					>{{ $i }}</button>
					@endfor
				</div>
				<div class="col-xs-6 rightrow">
					@for ($i=26; $i<=50; $i++)
					<button class="btn btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}" 
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
		<!-- ROW 2 -->
		<div class="col-xs-6 col-sm-3 seatingrow">
			<div class="row">
				<div class="col-xs-6 leftrow">
					@for ($i=51; $i<=75; $i++)
					<button class="btn btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }} pull-right" 
						@if (isset($regularseats[$i]))
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
						@else
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" 
						@endif
					>{{ $i }}</button>
					@endfor
				</div>
				<div class="col-xs-6 rightrow">
					@for ($i=76; $i<=100; $i++)
					<button class="btn btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}" 
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
		<!-- ROW 3 -->
		<div class="col-xs-6 col-sm-3 seatingrow">
			<div class="row">
				<div class="col-xs-6 leftrow">
					@for ($i=101; $i<=125; $i++)
					<button class="btn btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }} pull-right" 
						@if (isset($regularseats[$i]))
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
						@else
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" 
						@endif
					>{{ $i }}</button>
					@endfor
				</div>
				<div class="col-xs-6 rightrow">
					@for ($i=126; $i<=150; $i++)
					<button class="btn btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}" 
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
		<!-- ROW 4 -->
		<div class="col-xs-6 col-sm-3 seatingrow">
			<div class="row">
				<div class="col-xs-6 leftrow">
					@for ($i=151; $i<=175; $i++)
					<button class="btn btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }} pull-right" 
						@if (isset($regularseats[$i]))
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
						@else
							data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" 
						@endif
					>{{ $i }}</button>
					@endfor
				</div>
				<div class="col-xs-6 rightrow">
					@for ($i=176; $i<=200; $i++)
					<button class="btn btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }}" 
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
    
    @for ($i=1; $i<=220; $i++)
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
                        {!! BootForm::text('Benutzer', 'name')->class('form-control autocomplete user') !!}
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