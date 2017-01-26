@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="btn-group pull-right">
                            <a href="{{ route('admin.gallery.add') }}" class="btn btn-sm btn-success"><i class="fa fa-fw fa-plus"></i></a>
                        </div>
                        <h6>Bilder-Galerien</h6>
                    </div>
                    <div class="panel-body">

                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Titel</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tbody>

                            @foreach ($galleries as $gallery)
                                <tr>
                                    <td>{{ $gallery->title }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.gallery.edit', [$gallery]) }}" class="btn btn-sm btn-default"><i class="fa fa-fw fa-edit"></i></a>
                                        <a href="{{ route('admin.gallery.album.list', [$gallery]) }}" class="btn btn-sm btn-default"><i class="fa fa-fw fa-list"></i></a>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger pull-right" data-container="body" data-toggle="modal" data-target="#modal-{{ $gallery->id }}"><i class="fa fa-fw fa-close"></i></button>
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($galleries as $gallery)
        <div class="modal fade" id="modal-{{ $gallery->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Bilder-Galerie löschen?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Soll die Bilder-Galerie "{{ $gallery->title }}" wirklich gelöscht werden?</p>
                        <p>Beachte dabei auch dass alle Alben und alle Bilder dieser Galerie gelöscht werden!</p>
                    </div>
                    <div class="modal-footer">
                        {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.gallery.delete')) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::hidden('gallery_id')->value($gallery->id) !!}
                        {!! BootForm::hidden('action')->value('delete') !!}
                        <button type="submit" class="btn btn-danger"><i class="fa fa-fw fa-check"></i> ja</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close"><i class="fa fa-fw fa-close"></i> nein</button>
                        {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection