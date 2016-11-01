@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{!! csrf_token() !!}">

    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="btn-group pull-right">
                            <a href="{{ route('admin.catering.add') }}" class="btn btn-sm btn-success"><i class="fa fa-fw fa-plus"></i></a>
                        </div>
                        <h6>Die Speisekarte</h6>
                    </div>
                    <div class="panel-body">

                        <ul class="list-unstyled sortable-catering">
                            @foreach($caterings as $key=>$catering)
                                <li id="catering-{{ $catering->id }}">
                                    <div class="row catering">
                                        <div class="col-sm-6">
                                            <img class="img-thumbnail img-responsive" alt="" src="{!! ($catering->image) ? '/images/catering/' . $catering->image : '/images/catering/default.png' !!}">
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" data-container="body" data-toggle="modal" data-target="#modal-{{ $catering->id }}" class="btn btn-danger pull-right"><i class="fa fa-fw fa-close"></i></button>
                                            {{-- <a href="{{ route('admin.catering.edit', $catering) }}" class="btn btn-default pull-right"><i class="fa fa-fw fa-edit"></i></a> --}}
                                            {{--<span class="btn btn-default pull-right"><i class="fa fa-fw fa-arrows-v" title="Verschieben um Sortierung zu ändern"></i></span> --}}
                                            <h4>{{ $catering->title }}</h4>
                                            <p>{!! nl2br($catering->description) !!}</p>
                                            <h5 class="pull-right">{{ number_format($catering->costs, 2, ',', '.') }} &euro;</h5>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($caterings as $catering)
        <div class="modal fade" id="modal-{{ $catering->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Die Speise wirklich löschen?</h4>
                    </div>
                    <div class="modal-body">
                        {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.catering.delete.post')) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::hidden('catering_id')->value($catering->id) !!}
                        <button type="submit" class="btn btn-danger"><i class="fa fa-fw fa-check"></i> ja</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close" aria-hidden="true"><i class="fa fa-fw fa-close"></i> nein</button>
                        {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection