@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Bilder-Galerie hinzufügen</h6>
                    </div>
                    <div class="panel-body">

                        {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.gallery.add.post')) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::text('Titel', 'title')->required()->placeholder('Titel der Galerie') !!}
                        {!! BootForm::text('Untertitel', 'subtitle')->placeholder('Untertitel') !!}
                        {!! BootForm::textarea('Beschreibung', 'description') !!}
                        {!! BootForm::submit('<i class="fa fa-fw fa-plus"></i> anlegen')->class('btn btn-success') !!}
                        {!! BootForm::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection