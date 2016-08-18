@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Registrieren
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-block btn-primary" href="{{ $login_url }}"><i class="fa fa-facebook"></i> Facebook</a>

                        <div class="div-hr-label">
                            <hr class="hr-label">
                            <span class="span-label">oder</span>
                        </div>

                        {!! BootForm::open()->post()->action( route('auth.register') )->role('form') !!}
                        {!! BootForm::text('', 'name')->placeholder('Name')->required() !!}
                        {!! BootForm::email('', 'email')->placeholder('E-Mail-Adresse')->required() !!}
                        {!! BootForm::password('', 'password')->placeholder('Passwort')->required() !!}
                        {!! BootForm::password('', 'password_confirmation')->placeholder('Passwort wiederholen')->required() !!}
                        {!! BootForm::submit('<i class="fa fa-user-plus"></i> registrieren')->class('btn btn-success pull-right') !!}
                        {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
