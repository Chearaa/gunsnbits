@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Album bearbeiten</h6>
                    </div>
                    <div class="panel-body">

                        {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.gallery.album.edit.post', [$gallery, $album])) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::text('Titel', 'title')->required()->placeholder('Titel des Albums')->value(old('title') ? old('title') : $album->title) !!}
                        {!! BootForm::text('Untertitel', 'subtitle')->placeholder('Untertitel')->value(old('subtitle') ? old('subtitle') : $album->subtitle) !!}
                        {!! BootForm::textarea('Beschreibung', 'description')->value(old('description') ? old('description') : $album->description) !!}
                        {!! BootForm::submit('<i class="fa fa-fw fa-plus"></i> speichern')->class('btn btn-success') !!}
                        {!! BootForm::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection