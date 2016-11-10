@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-lg-12">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h6>Stammplätze verwalten</h6>
					</div>
					<div class="panel-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-darker">
                                        <h6>Bühne</h6>

                                        <div class="text-center seatingrow">
                                            @for ($i=209; $i<=220; $i++)
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
                                                            <button class="btn btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }} pull-right"
                                                                    @if (isset($regularseats[$i]))
                                                                    data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                    @else
                                                                    data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                    @endif
                                                            >{{ $i }}</button>
                                                        @endfor

                                                    </div>
                                                    <!-- ROW 2 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=27; $i<=52; $i++)
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

                                            <div class="col-lg-3">
                                                <div class="row">
                                                    <!-- ROW 3 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=53; $i<=78; $i++)
                                                            <button class="btn btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }} pull-right"
                                                                    @if (isset($regularseats[$i]))
                                                                    data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                    @else
                                                                    data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                    @endif
                                                            >{{ $i }}</button>
                                                        @endfor

                                                    </div>
                                                    <!-- ROW 4 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=79; $i<=104; $i++)
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

                                            <div class="col-lg-3">
                                                <div class="row">
                                                    <!-- ROW 5 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=105; $i<=130; $i++)
                                                            <button class="btn btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }} pull-right"
                                                                    @if (isset($regularseats[$i]))
                                                                    data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                    @else
                                                                    data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                    @endif
                                                            >{{ $i }}</button>
                                                        @endfor

                                                    </div>
                                                    <!-- ROW 6 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=131; $i<=156; $i++)
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

                                            <div class="col-lg-3">
                                                <div class="row">
                                                    <!-- ROW 7 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=157; $i<=182; $i++)
                                                            <button class="btn btn-default seat {{ (isset($regularseats[$i])) ? 'btn-danger' : '' }} pull-right"
                                                                    @if (isset($regularseats[$i]))
                                                                    data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}" data-popover="true" data-trigger="hover" data-placement="top" data-trigger="focus" title="Sitzplatz #{{ $i }}" data-content="{{ $regularseats[$i]->user->name }} (ID: {{ $regularseats[$i]->user->id }})<br/>{{ ($regularseats[$i]->status > 1) ? '<span class="text-success">reserviert</span>' : '<span class="text-warning">vorgemerkt</span>'}}{{ ($regularseats[$i]->status == 3) ? '<span> und </span><span class="text-success">bezahlt</span>' : '' }}"
                                                                    @else
                                                                    data-container="body" data-toggle="modal" data-target="#modal-{{ $i }}"
                                                                    @endif
                                                            >{{ $i }}</button>
                                                        @endfor

                                                    </div>
                                                    <!-- ROW 8 -->
                                                    <div class="col-lg-6">

                                                        @for ($i=183; $i<=208; $i++)
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
                        {!! BootForm::text('Benutzer', 'name')->class('form-control autocomplete user')->autocomplete('off') !!}
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