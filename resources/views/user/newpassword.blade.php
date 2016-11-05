@extends('layouts.gnb')

@section('title', 'Neues Passwort vergeben')
@section('bodyclass', 'bgpic-3')
@section('contentclass', 'container bg-dark')

@section('content')

    <h1>Neu registrieren</h1>

    <div class="row">
        <div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8 col-xs-12">
            @if (!empty($invalidHash))
                <div class="alert alert-danger" role="alert"><i class="fa fa-fw fa-exclamation-circle"></i> {{  $invalidHash }}</div>
            @else
                {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('user.newpassword.post')) !!}
                {!! csrf_field() !!}
                {!! BootForm::hidden('hash')->value($data->token) !!}
                {!! BootForm::email('E-Mail', 'email')->value($data->email)->disabled() !!}
                {!! BootForm::password('Passwort', 'password') !!}
                {!! BootForm::password('Passwort Wdh.', 'password_confirm') !!}
                {!! BootForm::submit('<i class="fa fa-fw fa-check"></i> neues Passwort setzen')->class('btn btn-success') !!}
                {!! BootForm::close() !!}
            @endif
        </div>
    </div>

@endsection