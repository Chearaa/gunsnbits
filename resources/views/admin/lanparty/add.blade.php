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
						{!! BootForm::text('Ende', 'end')->class('form-control dtp-end')->id('end')->required() !!}
						{!! BootForm::text('Anmeldung ab dem', 'registrationstart')->class('form-control dtp-regstart')->id('registrationstart')->required() !!}
						{!! BootForm::text('Anmeldung bis zum', 'registrationend')->class('form-control dtp-regend')->id('registrationend')->required() !!}
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

            $('.dtp-start').datetimepicker({
                locale: 'de',
                useCurrent: false
            });
            $('.dtp-end').datetimepicker({
                locale: 'de'
            });
            $('.dtp-regstart').datetimepicker({
                locale: 'de'
            });
            $('.dtp-regend').datetimepicker({
                locale: 'de'
            });

            $('.dtp-start').on('dp.change', function (e) {
                $('.dtp-end').data('DateTimePicker').minDate(e.date);
                $('.dtp-regstart').data('DateTimePicker').maxDate(e.date);
                $('.dtp-regend').data('DateTimePicker').maxDate(e.date);
            });

            $('.dtp-end').on('dp.change', function (e) {
                $('.dtp-start').data('DateTimePicker').maxDate(e.date);
            });

            $('.dtp-regstart').on('dp.change', function (e) {
                $('.dtp-regend').data('DateTimePicker').minDate(e.date);
            });

        });
    </script>
@endsection