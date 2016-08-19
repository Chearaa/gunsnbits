@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Benutzer-Berechtigungen
                    </div>
                    <div class="panel-body">

                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>Nickname</th>
                                    <th>E-Mail</th>
                                    <th></th>
                                    <th><i class="btn fa fa-users" title="Benutzer"></i></th>
                                    <th><i class="btn fa fa-gamepad" title="Lanparty"></i></th>
                                    <th><i class="btn fa fa-picture-o" title="Bilder"></i></th>
                                    <th><i class="btn fa fa-cutlery" title="Catering"></i></th>
                                </tr>
                            </tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td></td>
                                <td>
                                    <i class="btn fa fa-{{ ($user->hasRole('permissionmanager')) ? 'check-' : '' }}square-o {{ ($user->hasRole('permissionmanager')) ? 'text-success' : 'text-danger' }} switch" data-url="/admin/user/permissions/ajax/" data-userid="{{ $user->id }}"></i>
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
