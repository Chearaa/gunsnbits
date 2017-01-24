@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="btn-group pull-right">
                            <a href="{{ route('admin.gallery.album.add', [$gallery]) }}" class="btn btn-sm btn-success"><i class="fa fa-fw fa-plus"></i></a>
                        </div>
                        <h6>Alben</h6>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Titel</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tbody>

                            @foreach ($albums as $album)
                                <tr>
                                    <td>{{ $album->id }}</td>
                                    <td>{{ $album->title }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.gallery.album.pictures.list', [$gallery, $album]) }}" class="btn btn-sm btn-default"><i class="fa fa-fw fa-th-large"></i></a>
                                        <a href="{{ route('admin.gallery.album.pictures.add', [$gallery, $album]) }}" class="btn btn-sm btn-default"><i class="fa fa-fw fa-upload"></i></a>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger pull-right" data-container="body" data-toggle="modal" data-target="#modal-{{ $album->id }}"><i class="fa fa-fw fa-close"></i></button>
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @foreach ($albums as $album)
        <div class="modal fade" id="modal-{{ $album->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Album löschen?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Soll das Album "{{ $album->title }}" wirklich gelöscht werden?</p>
                    </div>
                    <div class="modal-footer">
                        {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.gallery.album.delete', [$gallery])) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::hidden('album_id')->value($album->id) !!}
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