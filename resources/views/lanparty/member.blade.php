@extends('layouts.gnb')

@section('title', 'Teilnehmer')
@section('bodyclass', 'bgpic-3')
@section('contentclass', 'container bg-dark')

@section('content')
	
	<h1>Teilnehmer der {{ $lanparty->title }}</h1>

	<div class="row">
		<div class="col-sm-12">
			<table class="table table-striped">
				<tr>
					<th>Platz</th>
					<th>Benutzer</th>
					<th>Status</th>
				</tr>
				@foreach ($reservedseats as $reservedseat)
				<tr>
					<td>{{ $reservedseat->seatnumber }}</td>
					<td>
					@if ($reservedseat->user instanceof App\User)
						{{ $reservedseat->user->name }}
					@endif
					</td>
					<td>
						@if ($reservedseat->status == -1)
						<span class="text-info"><i class="fa fa-fw fa-close"></i> deaktiviert</span>
						@elseif ($reservedseat->status == 1)
						<span class="text-warning"><i class="fa fa-fw fa-clock-o"></i> vorgemerkt</span>
						@elseif ($reservedseat->status == 2)
						<span class="text-success"><i class="fa fa-fw fa-check"></i> reserviert</span>
						@elseif ($reservedseat->status == 3)
						<span class="text-success"><i class="fa fa-fw fa-check"></i> reserviert</span> und <span class="text-success">bezahlt</span>
						@endif
					</td>
				</tr>
				@endforeach
			</table>
    	</div>
	</div>
@endsection