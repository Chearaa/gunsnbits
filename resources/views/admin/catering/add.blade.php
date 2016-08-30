@extends('layouts.admin')

@section('title', 'Catering')
@section('bodyclass', 'bgpic-5')
@section('contentclass', 'container bg-dark')

@section('content')
    <h1 class="title">Auswahl hinzufügen</h1>

    <div class="row box">
        <div class="col-sm-12">

            {!! BootForm::openHorizontal(['sm'=>[4,8]])
                ->post()
                ->action(route('admin.catering.add.check'))
                ->enctype('multipart/form-data')
            !!}
            {!! csrf_field() !!}
            {!! BootForm::text('Bezeichnung', 'title')->placeholder('Titel der Speise')->required() !!}
            <div class="fileinput fileinput-new col-sm-offset-4 col-sm-8" data-provides="fileinput">
                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 300px; height: 110px;"></div>
                <div>
                    <span class="btn btn-default btn-file"><span class="fileinput-new">Bild auswählen</span><span class="fileinput-exists">Wechseln</span><input type="file" name="image" required></span>
                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Löschen</a>
                </div>
                <span id="helpBlock" class="help-block">JPG und PNG sind erlaubt. Maximal 200kb. 350x220 Pixel sind eine optimale Größe.</span>
            </div>

            @if ($errors->has('image'))
                <div class="col-sm-offset-4 col-sm-8 text-danger">{{ $errors->first('image') }}</div>
            @endif
            {!! BootForm::textarea('Beschreibung', 'description')->required() !!}
            {!! BootForm::text('Preis &euro;', 'costs')->class('form-control costs')->placeholder('0,00')->required() !!}
            {!! BootForm::submit('<i class="fa fa-fw fa-plus"></i> hinzufügen')->class('btn btn-success') !!}
            {!! BootForm::close() !!}
        </div>
    </div>
@endsection