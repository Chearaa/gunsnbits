@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-offset-2 col-lg-8">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h6>Lanparty bearbeiten</h6>
					</div>
					<div class="panel-body">
						{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.lanparty.edit.post', [$lanparty->id])) !!}
						{!! BootForm::bind($lanparty) !!}
						{!! csrf_field() !!}
						{!! BootForm::text('Titel', 'title')->placeholder('Titel der Lanparty')->required() !!}
						{!! BootForm::text('Untertitel', 'subtitle')->placeholder('Untertitel / Motto') !!}
						{!! BootForm::textarea('Beschreibung', 'description') !!}
						{!! BootForm::text('Start', 'start')->class('form-control dtp dtp-start')->id('start')->value($lanparty->start->format('d.m.Y H:i'))->required() !!}
						{!! BootForm::text('Ende', 'end')->class('form-control dtp dtp-end')->id('end')->value($lanparty->end->format('d.m.Y H:i'))->required() !!}
						{!! BootForm::text('Anmeldung ab dem', 'registrationstart')->class('form-control dtp dtp-regstart')->id('registrationstart')->value($lanparty->registrationstart->format('d.m.Y H:i'))->required() !!}
						{!! BootForm::text('Anmeldung bis zum', 'registrationend')->class('form-control dtp dtp-regend')->id('registrationend')->value($lanparty->registrationend->format('d.m.Y H:i'))->required() !!}
						{!! BootForm::text('Verwendungszweck', 'reasonforpayment')->required()->placeholder('GNBXX') !!}
						{!! BootForm::submit('<i class="fa fa-fw fa-download"></i> speichern') !!}
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

            var $dtpstartvalue = moment($('.dtp-start').val()).format('DD.MM.YYYY HH:mm'),
                $dtpendvalue = moment($('.dtp-end').val()).format('DD.MM.YYYY HH:mm'),
                $dtpregstartvalue = moment($('.dtp-regstart').val()).format('DD.MM.YYYY HH:mm'),
                $dtpregendvalue = moment($('.dtp-regend').val()).format('DD.MM.YYYY HH:mm');

            $('.dtp').datetimepicker({
                locale: 'de',
                format: 'DD.MM.YYYY HH:mm',
                stepping: 30,
                sideBySide: true
            });

			$('.dtp-start').datetimepicker({
                defaultDate: $dtpstartvalue
			});

            $('.dtp-end').datetimepicker({
                defaultDate: $dtpendvalue
            });
            $('.dtp-regstart').datetimepicker({
                defaultDate: $dtpregstartvalue
            });
            $('.dtp-regend').datetimepicker({
                defaultDate: $dtpregendvalue
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