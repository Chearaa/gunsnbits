@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Gutschein-Codes generieren</h6>
                    </div>
                    <div class="panel-body">

                        {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.code.add.post')) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::text('Anzahl', 'counter')->type('number')->min(0)->max(100)->required()->helpBlock('Es können maximal 100 Gutschein-Codes auf einmal generiert werden.') !!}
                        {!! BootForm::select('Gültigkeit', 'lanparty')->options($lanparties) !!}
                        {!! BootForm::submit('<i class="fa fa-fw fa-plus"></i> generieren')->class('btn btn-success') !!}
                        {!! BootForm::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection