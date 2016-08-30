@extends('layouts.admin')

@section('title', 'Lanparty bearbeiten')
@section('bodyclass', 'welcome bgpic-3')
@section('contentclass', 'container bg-dark')

@section('content')

	<h1>Lanparty bearbeiten</h1>
    
    <div class="row">
    	<div class="col-sm-12">
    		{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.lanparty.edit.post',[$lan['id']])) !!}
    		{!! BootForm::bind($lan) !!}
            {!! csrf_field() !!}
            {!! BootForm::hidden('id') !!}
			{!! BootForm::text('Titel', 'title')->required() !!}
			{!! BootForm::text('Untertitel', 'subtitle') !!}
			{!! BootForm::textarea('Beschreibung', 'description') !!}
			{!! BootForm::text('Start', 'start')->class('form-control datetimepicker')->id('start')->required() !!}
			{!! BootForm::text('Ende', 'end')->class('form-control datetimepicker')->id('end')->required() !!}
			{!! BootForm::text('Anmeldung ab dem', 'registrationstart')->class('form-control datetimepicker')->id('registrationstart')->required() !!}
			{!! BootForm::text('Anmeldung bis zum', 'registrationend')->class('form-control datetimepicker')->id('registrationend')->required() !!}
			{!! BootForm::text('Verwendungszweck', 'reasonforpayment')->required() !!}
			{!! BootForm::submit('<i class="fa fa-fw fa-download"></i> speichern') !!}
			{!! BootForm::close() !!}
    	</div>
    </div>
    
@endsection