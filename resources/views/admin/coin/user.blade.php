@extends('layouts.admin')

@section('title', 'GnB Coins')
@section('bodyclass', 'bgpic-5')
@section('contentclass', 'container bg-dark')

@section('content')

	<h1>Coins - Benutzer-Auswahl</h1>
    
    <div class="row">
        <div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-6 col-xs-12">
			{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.coin.user.post')) !!}
			{!! csrf_field() !!}
			{!! BootForm::hidden('user_id') !!}
			{!! BootForm::text('Benutzer', 'name')->class('form-control autocomplete user') !!}
			{!! BootForm::submit('<i class="fa fa-fw fa-check"></i> auswählen')->class('btn btn-success') !!}
			{!! BootForm::close() !!}
    	</div>
    </div>
@endsection