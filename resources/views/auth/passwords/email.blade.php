@extends('layouts.app')

<!-- Main Content -->
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Passwort zurücksetzen
                    </div>
                    <div class="panel-body">
                        {!! BootForm::open()->post()->action( route('auth.password.email') )->role('form') !!}
                        {!! BootForm::email('', 'email')->placeholder('E-Mail-Adresse')->required()->helpblock('Passwort vergessen? Kein Problem!<br/><br/>Wir senden dir einen Link an deine E-Mail-Adresse.<br/>Klicke diesen einfach an und schon kannst du dein Passwort neu vergeben.') !!}
                        {!! BootForm::submit('<i class="fa fa-envelope"></i> Link zusenden')->class('btn btn-success pull-right') !!}
                        {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
