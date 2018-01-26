@extends('layouts.gnb')

@section('title', 'Login')
@section('bodyclass', 'bgpic-3')
@section('contentclass', 'container bg-dark')

@section('content')

    <h1>Passwort zurücksetzen</h1>

    <div class="row">
        <div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8 col-xs-12">
            {!! BootForm::openHorizontal(['sm'=>[2,10]])->post()->action(route('user.passwordreset.post')) !!}
            {!! csrf_field() !!}
            {!! BootForm::email('E-Mail', 'email')->placeholder('max@mustermann.de')->helpBlock('Wir schicken Ihnen eine E-Mail zum Zurücksetzen des Passworts.') !!}
            {!! BootForm::submit('<i class="fa fa-fw fa-envelope-o"></i> Passwort zurücksetzen')->class('btn btn-success') !!}
            {!! BootForm::close() !!}

            @if ($errors->first('usernotfound'))
                <div class="alert alert-danger" role="alert"><i class="fa fa-fw fa-exclamation-circle"></i> {{  $errors->first('usernotfound') }}</div>
            @endif

            @if ($errors->first('userfound'))
                <div class="alert alert-success" role="alert"><i class="fa fa-fw fa-check"></i> {{  $errors->first('userfound') }}</div>
            @endif
        </div>
    </div>

@endsection