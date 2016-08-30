@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Berechtigungen</h6>
                    </div>
                    <div class="panel-body">

                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>Nickname</th>
                                    <th>E-Mail</th>
                                    <th></th>
                                    <th><i class="btn fa fa-legal" title="Berechtigungen"></i></th>
                                    <th><i class="btn fa fa-gamepad" title="Lanparty"></i></th>
                                    <th><i class="btn fa fa-picture-o" title="Bilder"></i></th>
                                    <th><i class="btn fa fa-cutlery" title="Catering"></i></th>
                                    <th><i class="btn fa fa-users" title="Guns´n Bits"></i></th>
                                </tr>
                            </tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td></td>
                                <td>
                                    <i class="btn fa fa-{{ ($user->hasRole('permissionmanager')) ? 'check-' : '' }}square-o {{ ($user->hasRole('permissionmanager')) ? 'text-success' : 'text-danger' }} switch" data-url="/admin/user/permissions/ajax/" data-userid="{{ $user->id }}" data-roleid="2"></i>
                                </td>
                                <td>
                                    <i class="btn fa fa-{{ ($user->hasRole('lanpartymanager')) ? 'check-' : '' }}square-o {{ ($user->hasRole('lanpartymanager')) ? 'text-success' : 'text-danger' }} switch" data-url="/admin/user/permissions/ajax/" data-userid="{{ $user->id }}" data-roleid="3"></i>
                                </td>
                                <td>
                                    <i class="btn fa fa-{{ ($user->hasRole('imagemanager')) ? 'check-' : '' }}square-o {{ ($user->hasRole('imagemanager')) ? 'text-success' : 'text-danger' }} switch" data-url="/admin/user/permissions/ajax/" data-userid="{{ $user->id }}" data-roleid="4"></i>
                                </td>
                                <td>
                                    <i class="btn fa fa-{{ ($user->hasRole('cateringmanager')) ? 'check-' : '' }}square-o {{ ($user->hasRole('cateringmanager')) ? 'text-success' : 'text-danger' }} switch" data-url="/admin/user/permissions/ajax/" data-userid="{{ $user->id }}" data-roleid="5"></i>
                                </td>
                                <td>
                                    <i class="btn fa fa-{{ ($user->hasRole('gunsnbits')) ? 'check-' : '' }}square-o {{ ($user->hasRole('gunsnbits')) ? 'text-success' : 'text-danger' }} switch" data-url="/admin/user/permissions/ajax/" data-userid="{{ $user->id }}" data-roleid="1"></i>
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
