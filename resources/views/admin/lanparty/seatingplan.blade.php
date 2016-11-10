@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-lg-12">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h6>Sitzplan - {{ $lanparty->title }}</h6>
					</div>
					<div class="panel-body">

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body bg-darker">
                                        <h6>Bühne</h6>

                                        <div class="text-center seatingrow">
                                            @for ($i=209; $i<=220; $i++)
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
						</div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-darker">
                                        <h6>Saal</h6>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="row">
                                                    <!-- ROW 1 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=1; $i<=26; $i++)
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
                                                    <!-- ROW 2 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=27; $i<=52; $i++)
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
                                            <div class="col-lg-3">
                                                <div class="row">
                                                    <!-- ROW 3 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=53; $i<=78; $i++)
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
                                                    <!-- ROW 4 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=79; $i<=104; $i++)
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
                                            <div class="col-lg-3">
                                                <div class="row">
                                                    <!-- ROW 5 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=105; $i<=130; $i++)
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
                                                    <!-- ROW 6 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=131; $i<=156; $i++)
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
                                            <div class="col-lg-3">
                                                <div class="row">
                                                    <!-- ROW 7 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=157; $i<=182; $i++)
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
                                                    <!-- ROW 8 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=183; $i<=208; $i++)
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


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-body text-center bg-darker">
                                        <h6>Catering</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

					</div>
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
                        {!! BootForm::text('Benutzer', 'name')->class('form-control autocomplete user')->autocomplete('off') !!}
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

@section('scripts')
    <script type="text/javascript">
        $(function () {
            /**
             * autocomplete
             */
            $('.autocomplete.user').typeahead({
                onSelect: function (item) {
                    $('input[name="user_id"]').val(item.value);
                },
                ajax: {
                    url: "/ajax/users",
                    timeout: 300,
                    displayField: "name",
                    triggerLength: 1,
                    method: "get"
                }
            });
        });
    </script>
@endsection