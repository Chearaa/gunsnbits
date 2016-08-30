@extends('layouts.admin')

@section('title', 'Gutscheine')
@section('bodyclass', 'bgpic-3')
@section('contentclass', 'container bg-dark')

@section('content')

	<h1>Gutschein-Codes</h1>
    
    <div class="row">
    	<div class="col-sm-12">
			<table class="table table-striped">
				<tr>
					<th>Code</th>
					<th>Status</th>
					<th>Gültigkeit</th>
					<th>Verbraucht am</th>
					<th></th>
				</tr>
				@foreach ($codes as $code)
				<tr>
					<td>{{ $code->code }}</td>
					<td>
					@if (is_null($code->used_at))
						<span class="label label-success"><i class="fa fa-fw fa-check"></i></span>
					@else
						<span class="label label-danger"><i class="fa fa-fw fa-close"></i></span>
					@endif
					</td>
					<td>
					@if (is_null($code->lanparty))
						immer gültig
					@else	
						{{ $code->lanparty->title }}
					@endif
					</td>
					<td>
					@if (!is_null($code->used_at))
						{{ $code->used_at->format('d.m.Y') }}
					@endif
					</td>
					<td>
					@if (!is_null($code->used_at))
						von {{ $code->user->name }} (ID: {{ $code->user->id }}) für die {{ $code->lanparty->title }} 
					@endif
					</td>
				</tr>
				@endforeach
			</table>
    	</div>
    </div>
@endsection