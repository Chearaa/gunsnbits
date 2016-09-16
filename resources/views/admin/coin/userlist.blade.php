@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-lg-offset-2 col-lg-8">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h6>{{ $user->name }} : {{ $user->coins->sum('coins') }} Coins</h6>
					</div>
					<div class="panel-body">
                        {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.coin.user.add', [$user->id])) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::text('Coins', 'coins')->type('number')->required() !!}
                        {!! BootForm::text('Beschreibung', 'description')->required() !!}
                        {!! BootForm::submit('<i class="fa fa-fw fa-check"></i> eintragen')->class('btn btn-success') !!}
                        {!! BootForm::close() !!}
					</div>

                    <div class="panel-body">
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
			</div>
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