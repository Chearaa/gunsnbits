@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="btn-group pull-right">
                            <a href="{{ route('admin.lanparty.add') }}" class="btn btn-sm btn-success"><i class="fa fa-fw fa-plus"></i></a>
                        </div>
                        <h6>Guns'n Bits - Lanparties</h6>
                    </div>
                    <div class="panel-body">

                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Name</th>
                                <th>Start</th>
                                <th>Ende</th>
                                <th>Anmeldung</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tbody>

                            @foreach ($lanparties as $lanparty)
                                <tr>
                                    <td>{{ $lanparty->title }}</td>
                                    <td>{{ $lanparty->start->format('d.m.Y') }}</td>
                                    <td>{{ $lanparty->end->format('d.m.Y') }}</td>
                                    <td>
                                        @if ($lanparty->registrationstart < $now)
                                            @if ($lanparty->registrationend > $now)
                                                <span class="text-success">offen</span>
                                            @else
                                                <span class="text-danger">geschlossen</span>
                                            @endif
                                        @else
                                            @if ($now->diffInDays($lanparty->registrationstart) > 1)
                                                <span>öffnet in {{ $now->diffInDays($lanparty->registrationstart) }} Tagen</span>
                                            @elseif ($now->diffInDays($lanparty->registrationstart) > 0)
                                                <span>öffnet morgen</span>
                                            @else
                                                <span>öffnet in {{ $now->diffInHours($lanparty->registrationstart) }} Stunden</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.lanparty.edit', [$lanparty->id]) }}" class="btn btn-default"><i class="fa fa-fw fa-edit"></i></a>
                                        <a href="{{ route('admin.lanparty.seatingplan', [$lanparty->id]) }}" class="btn btn-default"><i class="fa fa-fw fa-th-large"></i></a>
                                        <a href="{{ route('admin.lanparty.memberlist', [$lanparty->id]) }}" class="btn btn-default"><i class="fa fa-fw fa-list"></i></a>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger pull-right" data-container="body" data-toggle="modal" data-target="#modal-{{ $lanparty->id }}"><i class="fa fa-fw fa-close"></i></button>
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($lanparties as $lanparty)
        <div class="modal fade" id="modal-{{ $lanparty->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Lanparty löschen?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Soll die Lanparty "{{ $lanparty->title }}" wirklich gelöscht werden?
                    </div>
                    <div class="modal-footer">
                        {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.lanparty.delete.post')) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::hidden('id')->value($lanparty->id) !!}
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