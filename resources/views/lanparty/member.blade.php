@extends('layouts.app')

@section('content')

	@if ($lanparty instanceof \App\Lanparty)

		@if ($lanparty->registrationstart < \Carbon\Carbon::now() && $lanparty->registrationend > \Carbon\Carbon::now())

			<div class="container">
				<div class="row">
					<div class="col-lg-12">

						<div class="panel panel-default">
							<div class="panel-heading">
								<h6>Teilnehmer der {{ $lanparty->title }}</h6>
							</div>
							<div class="panel-body">

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
					</div>
				</div>
			</div>

        @elseif ($lanparty->registrationstart > \Carbon\Carbon::now())

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        Die Anmeldung öffnet in ...

                        <div id="countdown" data-timer="{{ $lanparty->registrationstart->format('Y/m/d H:i:s') }}"></div>

                    </div>
                </div>
            </div>

        @elseif ($lanparty->registrationend < \Carbon\Carbon::now() && $lanparty->start > \Carbon\Carbon::now())

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        Gleich gehts los!

                    </div>
                </div>
            </div>

		@endif

    @else
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6>Ooohhh...</h6>
                        </div>
                        <div class="panel-body">
                            Zur Zeit ist leider keine Lanparty geplant.
                        </div>
                    </div>

                </div>
            </div>
        </div>
	@endif

@endsection

@section('scripts')
    <script type="text/javascript" src="/js/jquery.countdownTimer.min.js"></script>
    <script type="text/javascript">
        $(function() {
            'use strict';

            var countdowntime = $('#countdown').data('timer') ? $('#countdown').data('timer') : '2020/01/01 00:00:00';

            $('#countdown').countdowntimer({
                dateAndTime: countdowntime,
                size: 'lg'
            });

        });
    </script>
@endsection