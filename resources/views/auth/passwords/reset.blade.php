@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Passwort zurücksetzen
                    </div>
                    <div class="panel-body">
                        {!! BootForm::open()->post()->action( route('auth.password.reset') )->role('form') !!}
                        {!! BootForm::hidden('token')->value($token) !!}
                        {!! BootForm::email('', 'email')->placeholder('E-Mail-Adresse')->value($email)->required() !!}
                        {!! BootForm::password('', 'password')->placeholder('Passwort')->required() !!}
                        {!! BootForm::password('', 'password_confirmation')->placeholder('Passwort wiederholen')->required() !!}
                        {!! BootForm::submit('<i class="fa fa-refresh"></i> speichern')->class('btn btn-success pull-right') !!}
                        {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
