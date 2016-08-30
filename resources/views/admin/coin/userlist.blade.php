@extends('layouts.admin')

@section('title', 'GnB Coins - Benutzerliste')
@section('bodyclass', 'bgpic-4')
@section('contentclass', 'container bg-dark')

@section('content')

	<h1>Coins von {{ $user->name }}</h1>
    
    <div class="row">
    	<div class="col-sm-12">
    	
    		{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.coin.user.add', [$user->id])) !!}
			{!! csrf_field() !!}
			{!! BootForm::text('Coins', 'coins')->type('number')->required() !!}
			{!! BootForm::text('Beschreibung', 'description')->required() !!}
			{!! BootForm::submit('<i class="fa fa-fw fa-check"></i> eintragen')->class('btn btn-success') !!}
			{!! BootForm::close() !!}
    	
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-sm-12">
			<table class="table table-striped">
				<tr>
					<th><i class="fa fa-fw fa-gg-circle"></i></th>
					<th>Beschreibung</th>
					<th>Datum</th>
					<th></th>
				</tr>
				@foreach ($user->coins as $coin)
				<tr>
					<td>
					@if ($coin->coins >= 0) 
						<span class="text-success">+{{ $coin->coins }}</span>
					@else
						<span class="text-danger">{{ $coin->coins }}</span>
					@endif
					</td>
					<td>
						{{ $coin->description }}
					</td>
					<td>
						{{ $coin->created_at->format('d.m.Y H:i') }}
					</td>
					<td>
						<button data-container="body" data-toggle="modal" data-target="#modal-{{ $coin->id }}" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></button>
					</td>
				</tr>
				@endforeach
			</table>
    	</div>
    </div>
    
    @foreach ($user->coins as $coin)
    <div class="modal fade" id="modal-{{ $coin->id }}" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Coins wirklich löschen?</h4>
				</div>
				<div class="modal-body">
					{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.coin.user.delete', [$user->id])) !!}
					{!! csrf_field() !!}
					{!! BootForm::hidden('coin_id')->value($coin->id) !!}
					<button type="submit" class="btn btn-danger"><i class="fa fa-fw fa-check"></i> ja</button>
					<button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close" aria-hidden="true"><i class="fa fa-fw fa-close"></i> nein</button>
					{!! BootForm::close() !!}
				</div>
			</div>
		</div>
	</div>
    @endforeach
@endsection