@extends('layouts.gnb')

@section('title', 'Registrieren')
@section('bodyclass', 'bgpic-3')
@section('contentclass', 'container bg-dark')

@section('content')

    <h1>Neu registrieren</h1>

    <div class="row">
        <div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8 col-xs-12">
            {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('user.register.post')) !!}
            {!! csrf_field() !!}
            {!! BootForm::text('Benutzer-Name', 'name') !!}
            {!! BootForm::email('E-Mail', 'email')->placeholder('max@mustermann.de') !!}
            {!! BootForm::password('Passwort', 'password') !!}
            {!! BootForm::password('Passwort Wdh.', 'password_confirm') !!}
            {!! BootForm::submit('<i class="fa fa-fw fa-user-plus"></i> registrieren')->class('btn btn-success') !!}
            {!! BootForm::close() !!}
        </div>
    </div>

@endsection