@extends('layouts.gnb')

@section('title', 'Coins')
@section('bodyclass', 'bgpic-3')
@section('contentclass', 'container bg-dark')

@section('content')

	<h1>Coins</h1>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<table class="table table-striped">
				<tr>
					<th><i class="fa fa-fw fa-gg-circle"></i></th>
					<th>Beschreibung</th>
					<th>Datum</th>
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
				</tr>
				@endforeach
			</table>

    	</div>
    </div>
@endsection