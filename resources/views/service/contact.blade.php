@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Kontakt</h6>
                    </div>
                    <div class="panel-body">

                        {!! BootForm::openHorizontal(['sm'=>[2,10]])->post()->action(route('service.contact.post')) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::email('E-Mail', 'email')->placeholder('me@example.de')->required() !!}
                        {!! BootForm::textarea('Nachricht', 'message')->required() !!}
                        {!! BootForm::submit('<i class="fa fa-fw fa-paper-plane"></i> absenden') !!}
                        {!! BootForm::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection