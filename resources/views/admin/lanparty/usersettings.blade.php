@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Benutzer-Einstellungen</h6>
                    </div>
                    <div class="panel-body">

                        <table class="table table-responsive">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Vor- und Nachname</th>
                                <th>E-Mail-Adresse</th>
                                <th class="text-right">kann maximal x Sitzplätze reservieren</th>
                                <th></th>
                            </tr>
                            </tbody>

                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-right">{{ $user->maxseats }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.lanparty.user.settings.edit', [$user->id]) }}" class="btn btn-sm btn-default"><i class="fa fa-fw fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection