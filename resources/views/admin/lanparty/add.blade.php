@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-offset-2 col-lg-8">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h6>Lanparty anlegen</h6>
					</div>
					<div class="panel-body">
						{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.lanparty.add.post')) !!}
						{!! csrf_field() !!}
						{!! BootForm::text('Titel', 'title')->required()->placeholder('Titel der Lanparty') !!}
						{!! BootForm::text('Untertitel', 'subtitle')->placeholder('Untertitel / Motto') !!}
						{!! BootForm::textarea('Beschreibung', 'description') !!}
						{!! BootForm::text('Start', 'start')->class('form-control dtp-start')->id('start')->required() !!}
						{!! BootForm::text('Ende', 'end')->class('form-control datetimepicker datetime')->id('end')->required() !!}
						{!! BootForm::text('Anmeldung ab dem', 'registrationstart')->class('form-control datetimepicker datetime')->id('registrationstart')->required() !!}
						{!! BootForm::text('Anmeldung bis zum', 'registrationend')->class('form-control datetimepicker datetime')->id('registrationend')->required() !!}
						{!! BootForm::text('Verwendungszweck', 'reasonforpayment')->required()->placeholder('GNBXX') !!}
						{!! BootForm::submit('<i class="fa fa-fw fa-plus"></i> anlegen')->class('btn btn-success') !!}
						{!! BootForm::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function() {
            'use strict';

            $('.dtp-start').datetime
        });
    </script>
@endsection