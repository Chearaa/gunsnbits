@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-offset-2 col-lg-8">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h6>Benutzer bearbeiten</h6>
					</div>
					<div class="panel-body">
						{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.lanparty.user.settings.update', [$user->id])) !!}
						{!! BootForm::bind($user) !!}
						{!! csrf_field() !!}
						{!! BootForm::text('max. Sitzplätze', 'maxseats') !!}
						{!! BootForm::submit('<i class="fa fa-fw fa-download"></i> speichern') !!}
						{!! BootForm::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection