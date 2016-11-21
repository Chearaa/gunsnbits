@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-lg-12">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h6>Teilnehmer - {{ $lanparty->title }}</h6>
					</div>
					<div class="panel-body">

						<table class="table table-striped">
							<tr>
								<th>#</th>
								<th>Name</th>
								<th class="text-center">Benutzer-ID</th>
								<th class="text-center">Status</th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							@foreach ($lanparty->seats()->get()->sortBy('seatnumber') as $seat)
								<tr>
									<td>{{ $seat->seatnumber }}</td>
									<td>{{ ($seat->user instanceof App\User) ? $seat->user->name : '' }}</td>
									<td class="text-center">{{ ($seat->user instanceof App\User) ? $seat->user->id : '' }}</td>
									<td class="text-center">
										@if ($seat->status == -1)
											<span class="text-info">deaktiviert</span>
										@elseif ($seat->status == 1)
											<span class="text-warning">vorgemerkt</span>
										@elseif ($seat->status == 2)
											<span class="text-success">reserviert</span>
										@elseif ($seat->status == 3)
											<span class="text-success"><i class="fa fa-fw fa-check"></i> bezahlt</span>
										@endif
									</td>
									<td>
										@if ($seat->status == 1)
											<i class="fa fa-fw fa-clock-o"></i>
											@if ($now > $seat->marked_at->addDays(14))
												<span class="text-danger">-{{ $now->diffInDays($seat->marked_at->addDays(14)) }} {{ ($now->diffInDays($seat->marked_at->addDays(14)) == 1) ? 'Tag' : 'Tage' }}</span>
											@else
												<span class="text-warning">+{{ $now->diffInDays($seat->marked_at->addDays(14)) }} {{ ($now->diffInDays($seat->marked_at->addDays(14)) == 1) ? 'Tag' : 'Tage' }}</span>
											@endif
										@elseif ($seat->status == 2)
											<span class="text-success">am {{ $seat->reserved_at->format('d.m.Y') }}</span>
										@elseif ($seat->status == 3)
											<span class="text-success">am {{ $seat->payed_at->format('d.m.Y') }}</span>
										@endif
									</td>
									<td>
										{!! BootForm::open()->post()->action(route('admin.lanparty.memberlist.post', [$lanparty->id])) !!}
										{!! csrf_field() !!}
										{!! BootForm::hidden('seat')->value($seat->id) !!}
										@if ($seat->status == 1 || $seat->status == 2)
											{!! BootForm::hidden('user')->value($seat->user->id) !!}
											{!! BootForm::hidden('action')->value('free') !!}
											<button class="btn btn-warning" type="submit"><i class="fa fa-fw fa-unlock"></i></button>
										@endif
										@if ($seat->status == 1)
											{!! BootForm::hidden('user')->value($seat->user->id) !!}
											{!! BootForm::hidden('action')->value('reserve') !!}
											<button class="btn btn-success"><i class="fa fa-fw fa-lock"></i></button>
										@endif
										{!! BootForm::close() !!}
									</td>
									<td>
										@if ($seat->status == 1 || $seat->status == 2)
											{!! BootForm::open()->post()->action(route('admin.lanparty.memberlist.post', [$lanparty->id])) !!}
											{!! csrf_field() !!}
											{!! BootForm::hidden('seat')->value($seat->id) !!}
											{!! BootForm::hidden('user')->value($seat->user->id) !!}
											{!! BootForm::hidden('action')->value('pay') !!}
											<button class="btn btn-success"><i class="fa fa-fw fa-money"></i></button>
											{!! BootForm::close() !!}
										@elseif ($seat->status == 3)
											{!! BootForm::open()->post()->action(route('admin.lanparty.memberlist.post', [$lanparty->id])) !!}
											{!! csrf_field() !!}
											{!! BootForm::hidden('seat')->value($seat->id) !!}
											{!! BootForm::hidden('user')->value($seat->user->id) !!}
											{!! BootForm::hidden('action')->value('freepay') !!}
											<button class="btn btn-danger"><i class="fa fa-fw fa-close"></i></button>
											{!! BootForm::close() !!}
										@endif
									</td>
								</tr>
							@endforeach
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>

@endsection