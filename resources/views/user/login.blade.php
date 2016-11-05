@extends('layouts.gnb')

@section('title', 'Login')
@section('bodyclass', 'bgpic-3')
@section('contentclass', 'container bg-dark')

@section('content')

    <h1>Login</h1>

    <div class="row">
        <div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8 col-xs-12">
            {!! BootForm::openHorizontal(['sm'=>[2,10]])->post()->action(route('user.login.post')) !!}
            {!! csrf_field() !!}
            {!! BootForm::email('E-Mail', 'email')->placeholder('max@mustermann.de') !!}
            {!! BootForm::password('Passwort', 'password') !!}
            {!! BootForm::submit('<i class="fa fa-fw fa-sign-in"></i> einloggen')->class('btn btn-success') !!}
            {!! BootForm::close() !!}

            <a href="{{ route('user.passwordreset') }}" class="pull-right">Passwort vergessen?</a>
        </div>
    </div>

@endsection