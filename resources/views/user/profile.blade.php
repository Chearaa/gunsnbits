@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Benutzer-Profil</h6>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-4">
                                <figure class="text-center">
                                    <img class="img-thumbnail img-responsive" src="{!! ($user->avatar) ? '/images/avatar/' . $user->avatar : '/images/avatar/default.png' !!}">
                                </figure>
                            </div>

                            <div class="col-sm-8">
                                <div class="well well-sm"><i class="fa fa-fw fa-user"></i> <span class="text-warning">{{ $user->name }}</span></div>
                                <div class="well well-sm"><i class="fa fa-fw fa-envelope-o"></i> <span class="text-warning">{{ $user->email }}</span></div>
                                <div class="well well-sm"><i class="fa fa-fw fa-birthday-cake"></i> <span class="text-warning">{{ $user->birthday->format('d.m.Y') }}</span></div>
                                <div class="well well-sm"><i class="fa fa-fw fa-gg-circle"></i> <span class="text-warning">{{ $user->coins->sum('coins') }}</span> Guns'n Bit Coins</div>
                                <a href="{{ route('user.profile.edit') }}" class="btn btn-default pull-right"><i class="fa fa-fw fa-edit"></i> Benutzerdaten ändern</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection