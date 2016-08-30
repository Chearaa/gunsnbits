@extends('layouts.admin')

@section('title', 'Sponsor bearbeiten')
@section('bodyclass', 'welcome bgpic-3')
@section('contentclass', 'container bg-dark')

@section('content')

	<h1 class="title">Sponsor aktualisieren</h1>
    
    <div class="row box">
    	<div class="col-sm-12">
    		
    		{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.sponsor.edit.post', [$sponsor->id]))->enctype('multipart/form-data') !!}
    		{!! BootForm::bind($sponsor) !!}
            {!! csrf_field() !!}
			{!! BootForm::text('Name', 'name')->required() !!}
			<div class="col-sm-offset-4 col-sm-8" style="margin-bottom: 10px;">
				<img class="img-thumbnail img-responsive" alt="" src="{!! ($sponsor->logo) ? '../../../images/sponsors/' . $sponsor->logo : 'images/sponsors/default.png' !!}" width="300">
			</div>
			<div class="fileinput fileinput-new col-sm-offset-4 col-sm-8" data-provides="fileinput">
				<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 300px; height: 110px;"></div>
				<div>
					<span class="btn btn-default btn-file"><span class="fileinput-new">Bild auswählen</span><span class="fileinput-exists">Wechseln</span><input type="file" name="logo"></span>
					<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Löschen</a>
				</div>
			</div>
			@if ($errors->has('logo'))
			<div class="col-sm-offset-4 col-sm-8 text-danger">{{ $errors->first('logo') }}</div>
			@endif
			{!! BootForm::textarea('Beschreibung', 'description') !!}
			{!! BootForm::text('Webseite', 'url')->type('url') !!}
			{!! BootForm::text('Facebook', 'facebook')->type('url') !!}
			{!! BootForm::text('Twitter', 'twitter')->type('url') !!}
			{!! BootForm::submit('<i class="fa fa-fw fa-plus"></i> speichern')->class('btn btn-success') !!}
			{!! BootForm::close() !!}
    	</div>
    </div>
@endsection