@extends('layouts.gnb')

@section('title', 'Anmeldung')
@section('bodyclass', 'bgpic-1')
@section('contentclass', 'container bg-dark')

@section('content')

	@if ($lanparty != null)

		<h1>Anmeldung zur {{ $lanparty->title }}</h1>

		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				@if (is_null($user))
					<p>Um dich anmelden zu können musst du eingeloggt sein.</p>
					<p><a href="{{ route('user.login') }}" class="btn btn-default"><i class="fa fa-fw fa-sign-in"></i> jetzt einloggen</a></p>
				@else
					<h5>Hallo {{ $user->name }}</h5>
					@if ($usercanreserveseats > 0)
						@if ($usercanreserveseats == 1)
						<p>Du kannst <span class="text-success">einen Platz</span> reservieren.</p>
						@else
						<p>Du kannst noch bis zu <span class="text-success">{{ $usercanreserveseats }} weitere Plätze</span> reservieren.</p>
						@endif
					@else
						<p>Leider kannst du <span class="text-danger">keinen weiteren</span> Sitzplatz reservieren.</p>
						<p>Brauchst du jedoch noch mehr Plätze, melde dich bitte bei unserem <a href="{{ route('service.contact') }}">Support-Team</a>!</p>
					@endif
				@endif
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 reservations">
				@if (!is_null($user) && $user->seats()->where('lanparty_id', $lanparty->id)->get()->count() > 0)
					<h5>{{ ($user->seats()->where('lanparty_id', $lanparty->id)->get()->count() == 1) ? 'Deine Reservierung' : 'Deine Reservierungen'}}</h5>
					@foreach ($user->seats()->where('lanparty_id', $lanparty->id)->get() as $index => $seat)
						@if ($index > 0)
							<hr>
						@endif
						@if ($seat->status == 1)
                            <button class="btn btn-lg btn-warning pull-left">{{ $seat->seatnumber }}</button>
							<p>Platz <span class="text-warning">{{ $seat->seatnumber }}</span> wurde am {{ $seat->marked_at->format('d.m.Y H:i') }} Uhr <span class="text-warning">vorgemerkt</span> aber <span class="text-danger">noch nicht bezahlt</span>.<p>
							<p>Bitte überweise den Teilnehmerbetrag bis zum {{ $seat->marked_at->addDays(14)->format('d.m.Y') }}, damit dir dieser Platz wirklich sicher ist. Andernfalls kann es sein, dass wir den Platz für andere wieder freigeben.</p>
							<p><button class="btn btn-default" data-popover="true" data-trigger="click" data-placement="right" title="Überweisungs-Infos für Platz #{{ $seat->seatnumber }}" data-content="<p>Bitte überweise <span class='text-success'>{{ config('lanparty')['costs'] }}</span> &euro; an</p><p>{{ config('lanparty')['accountholder'] }}<br/>IBAN: {{ config('lanparty')['iban'] }}<br/>BIC: {{ config('lanparty')['bic'] }}</p><p>Verwendungszweck: <span class='text-success'>{{ $lanparty->reasonforpayment }}-{{ $user->id }}-{{ $seat->seatnumber }}</span></p>"><i class="fa fa-fw fa-info-circle"></i> Überweisung-Info</button></p>
							<p>
								@if (config('lanparty')['paywithcode'])
								<button class="btn btn-success" data-container="body" data-toggle="modal" data-target="#code-{{ $seat->seatnumber }}"><i class="fa fa-fw fa-qrcode"></i> Gutschein</button>
								@endif
								@if ($user->coins()->lists('coins')->sum() >= config('lanparty')['paybycoins'])
								<button class="btn btn-success" data-container="body" data-toggle="modal" data-target="#coins-{{ $seat->seatnumber }}"><i class="fa fa-fw fa-gg-circle"></i> mit GnB-Coins bezahlen</button>
								@endif
								<button class="btn btn-danger pull-right" data-container="body" data-toggle="modal" data-target="#modal-{{ $seat->seatnumber }}" ><i class="fa fa-fw fa-close"></i></button>
							</p>
						@elseif ($seat->status == 2)
                            <button class="btn btn-lg btn-success pull-left">{{ $seat->seatnumber }}</button>
							<p>Platz <span class="text-success">{{ $seat->seatnumber }}</span> wurde am {{ $seat->reserved_at->format('d.m.Y H:i') }} Uhr <span class="text-success">reserviert</span> aber <span class="text-danger">noch nicht bezahlt</span>.<p>
							<p>Gerne kannst du den Teilnehmerbetrag schon jetzt überweisen, oder erst vor Ort auf unserer Lan.</p>
							<button class="btn btn-default" data-popover="true" data-trigger="click" data-placement="right" title="Überweisungs-Infos für Platz #{{ $seat->seatnumber }}" data-content="<p>Bitte überweise <span class='text-success'>{{ config('lanparty')['costs'] }}</span> &euro; an</p><p>{{ config('lanparty')['accountholder'] }}<br/>IBAN: {{ config('lanparty')['iban'] }}<br/>BIC: {{ config('lanparty')['bic'] }}</p><p>Verwendungszweck: <span class='text-success'>{{ $lanparty->reasonforpayment }}-{{ $user->id }}-{{ $seat->seatnumber }}</span></p>"><i class="fa fa-fw fa-info-circle"></i> Überweisung-Info</button>
							@if (config('lanparty')['paywithcode'])
								<button class="btn btn-success" data-container="body" data-toggle="modal" data-target="#code-{{ $seat->seatnumber }}"><i class="fa fa-fw fa-qrcode"></i> Gutschein</button>
							@endif
							<button class="btn btn-danger pull-right" data-container="body" data-toggle="modal" data-target="#modal-{{ $seat->seatnumber }}" ><i class="fa fa-fw fa-close"></i> stornieren</button>
						@elseif ($seat->status == 3)
                            <button class="btn btn-lg btn-success pull-left">{{ $seat->seatnumber }}</button>
							<p>Platz <span class="text-success">{{ $seat->seatnumber }}</span> wurde am {{ $seat->payed_at->format('d.m.Y H:i') }} Uhr <span class="text-success">reserviert</span> und <span class="text-success">bezahlt</span>.<p>
							<p>{{ config('lanparty')['coins'] }} GnB-Coins wurden dir gutgeschrieben.</p>
						@endif

						<!-- MODAL RESERVATION DELETE -->
						<div class="modal fade" id="modal-{{ $seat->seatnumber }}" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Platz #{{ $seat->seatnumber }}</h4>
									</div>
									<div class="modal-body">
										<p>Willst du wirklich diese Reservierung stornieren?</p>
									</div>
									<div class="modal-footer">
										{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('lanparty.reservation.delete')) !!}
										{!! csrf_field() !!}
										{!! BootForm::hidden('user_id')->value($user->id) !!}
										{!! BootForm::hidden('id')->value($seat->id) !!}
										<button type="submit" class="btn btn-danger"><i class="fa fa-fw fa-close"></i> ja</button>
										<button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close">nein</button>
										{!! BootForm::close() !!}
									</div>
								</div>
							</div>
						</div>

						<!-- MODAL PAY BY CODE -->
						<div class="modal fade" id="code-{{ $seat->seatnumber }}" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Platz #{{ $seat->seatnumber }}</h4>
									</div>
									<div class="modal-body">
										<p>Du hast einen Gutschein von uns?!</p>
										<p>Dann trage hier den Code ein.</p>
									</div>
									<div class="modal-footer">
										{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('lanparty.reservation.code')) !!}
										{!! csrf_field() !!}
										{!! BootForm::hidden('user')->value($user->id) !!}
										{!! BootForm::hidden('seat')->value($seat->id) !!}
										{!! BootForm::hidden('lanparty')->value($lanparty->id) !!}
										{!! BootForm::text('Code', 'code')->required() !!}
										<button type="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i> einlösen</button>
										{!! BootForm::close() !!}
									</div>
								</div>
							</div>
						</div>

						<!-- MODAL PAY BY COINS -->
						<div class="modal fade" id="coins-{{ $seat->seatnumber }}" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Platz #{{ $seat->seatnumber }}</h4>
									</div>
									<div class="modal-body">
										<p>Du hast <span class="text-success">{{ $user->coins()->lists('coins')->sum() }} GnB-Coins</span>.</p>
										<p>Willst du für <span class="text-danger">{{ config('lanparty')['paybycoins'] }} GnB-Coins</span> diesen Sitzplatz bezahlen?</p>
									</div>
									<div class="modal-footer">
										{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('lanparty.reservation.coins')) !!}
										{!! csrf_field() !!}
										{!! BootForm::hidden('user')->value($user->id) !!}
										{!! BootForm::hidden('seat')->value($seat->id) !!}
										{!! BootForm::hidden('lanparty')->value($lanparty->id) !!}
										<button type="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i> ja</button>
										<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fa fa-fw fa-close"></i> nein</button>
										{!! BootForm::close() !!}
									</div>
								</div>
							</div>
						</div>
					@endforeach
				@endif
			</div>
		</div>

        <h1>Sitzplan</h1>

		{{-- STAGE --}}
		<div class="row stage">
			<h5>Bühne</h5>
			<p>Nur für Guns'n Bits Member</p>
			<div class="col-sm-12 text-center seatingrow">
				@for ($i=201; $i<=210; $i++)
				<button class="btn {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
				@if (isset($reservedseats[$i]))
					@if ($reservedseats[$i]->status == -1)
						data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
					@else
						data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
					@endif
				@else
					@if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin')))
						data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
					@endif
				@endif
				>{{ $i }}</button>
				@endfor
			</div>
			<div class="col-sm-12 text-center seatingrow">
				@for ($i=211; $i<=220; $i++)
				<button class="btn {{ ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin'))) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
				@if (isset($reservedseats[$i]))
					@if ($reservedseats[$i]->status == -1)
						data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
					@else
						data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
					@endif
				@else
					@if ($usercanreserveseats > 0 && Auth::check() && (Auth::user()->hasRole('gnb') || Auth::user()->hasRole('admin')))
						data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
					@endif
				@endif
				>{{ $i }}</button>
				@endfor
			</div>
		</div>

        {{-- HALL --}}
		<div class="row hall">
			<h5>Saal</h5>
			<!-- ROW 1 -->
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 seatingrow">
                <h5 class="visible-sm visible-xs">Reihe 1</h5>
				<div class="row">
					<div class="col-xs-6 leftrow">
						@for ($i=1; $i<=25; $i++)
						<button class="btn {{ ($usercanreserveseats > 0) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }} pull-right"
						@if (isset($reservedseats[$i]))
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							@if ($usercanreserveseats > 0)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
							@endif
						@endif
						>{{ $i }}</button>
						@endfor
					</div>
					<div class="col-xs-6 rightrow">
						@for ($i=26; $i<=50; $i++)
						<button class="btn {{ ($usercanreserveseats > 0) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
						@if (isset($reservedseats[$i]))
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							@if ($usercanreserveseats > 0)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
							@endif
						@endif
						>{{ $i }}</button>
						@endfor
					</div>
				</div>
			</div>
			<!-- ROW 2 -->
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 seatingrow">
                <h5 class="visible-sm visible-xs">Reihe 2</h5>
				<div class="row">
					<div class="col-xs-6 leftrow">
						@for ($i=51; $i<=75; $i++)
						<button class="btn {{ ($usercanreserveseats > 0) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }} pull-right"
						@if (isset($reservedseats[$i]))
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							@if ($usercanreserveseats > 0)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
							@endif
						@endif
						>{{ $i }}</button>
						@endfor
					</div>
					<div class="col-xs-6 rightrow">
						@for ($i=76; $i<=100; $i++)
						<button class="btn {{ ($usercanreserveseats > 0) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
						@if (isset($reservedseats[$i]))
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							@if ($usercanreserveseats > 0)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
							@endif
						@endif
						>{{ $i }}</button>
						@endfor
					</div>
				</div>
			</div>
			<!-- ROW 3 -->
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 seatingrow">
                <h5 class="visible-sm visible-xs">Reihe 3</h5>
				<div class="row">
					<div class="col-xs-6 leftrow">
						@for ($i=101; $i<=125; $i++)
						<button class="btn {{ ($usercanreserveseats > 0) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }} pull-right"
						@if (isset($reservedseats[$i]))
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							@if ($usercanreserveseats > 0)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
							@endif
						@endif
						>{{ $i }}</button>
						@endfor
					</div>
					<div class="col-xs-6 rightrow">
						@for ($i=126; $i<=150; $i++)
						<button class="btn {{ ($usercanreserveseats > 0) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
						@if (isset($reservedseats[$i]))
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							@if ($usercanreserveseats > 0)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
							@endif
						@endif
						>{{ $i }}</button>
						@endfor
					</div>
				</div>
			</div>
			<!-- ROW 4 -->
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 seatingrow">
                <h5 class="visible-sm visible-xs">Reihe 4</h5>
				<div class="row">
					<div class="col-xs-6 leftrow">
						@for ($i=151; $i<=175; $i++)
						<button class="btn {{ ($usercanreserveseats > 0) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }} pull-right"
						@if (isset($reservedseats[$i]))
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							@if ($usercanreserveseats > 0)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
							@endif
						@endif
						>{{ $i }}</button>
						@endfor
					</div>
					<div class="col-xs-6 rightrow">
						@for ($i=176; $i<=200; $i++)
						<button class="btn {{ ($usercanreserveseats > 0) ? 'btn-success' : 'btn-default' }} seat {{ (isset($reservedseats[$i])) ? 'btn-' . $reservedseats[$i]->color() : '' }}"
						@if (isset($reservedseats[$i]))
							@if ($reservedseats[$i]->status == -1)
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="Dieser Sitzplatz ist <span class='text-info'>deaktiviert</span>."
							@else
								data-container="body" data-popover="true" data-trigger="hover" data-placement="top" data-trigger=focus title="Sitzplatz #{{ $i }}" data-content="{{ $reservedseats[$i]->user->name }} (ID: {{ $reservedseats[$i]->user->id }})<br/>{{ ($reservedseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($reservedseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
							@endif
						@else
							@if ($usercanreserveseats > 0)
								data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
							@endif
						@endif
						>{{ $i }}</button>
						@endfor
					</div>
				</div>
			</div>
		</div>

		@for ($i=1; $i<=220; $i++)
			@if (!isset($reservedseats[$i]))
			<div class="modal fade" id="modal-{{ $i }}" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Sitzplatz #{{ $i }}</h4>
						</div>
						<div class="modal-body">
							<p>Diesen Sitzplatz jetzt reservieren?</p>
							{!! BootForm::open()->post()->action(route('lanparty.reservation.post')) !!}
							{!! csrf_field() !!}
							{!! BootForm::hidden('seatnumber')->value($i) !!}
							{!! BootForm::hidden('lanparty')->value($lanparty->id) !!}
							<p class="text-right">
								<button type="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i> ja</button>
								<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fa fa-fw fa-close"></i> nein</button>
							</p>
							{!! BootForm::close() !!}
						</div>
					</div>
				</div>
			</div>
			@endif
		@endfor

    @else

        <h1 class="title">Ohh...</h1>

        <div class="row box">
            <div class="col-sm-6">
                <p>Zur Zeit ist leider keine Lanparty geplant.</p>
            </div>
        </div>

	@endif
@endsection