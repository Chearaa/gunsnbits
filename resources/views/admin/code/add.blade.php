@extends('layouts.admin')

@section('title', 'Gutscheine')
@section('bodyclass', 'bgpic-2')
@section('contentclass', 'container bg-dark')

@section('content')

	<h1>Gutschein-Codes generieren</h1>
    
    <div class="row">
    	<div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-6 col-xs-12">
    		
    		{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.code.add.post')) !!}
            {!! csrf_field() !!}
			{!! BootForm::text('Anzahl', 'counter')->type('number')->min(0)->max(100)->required()->helpBlock('Es können maximal 100 Gutschein-Codes auf einmal generiert werden.') !!}
			{!! BootForm::select('Gültigkeit', 'lanparty')->options($lanparties) !!}
			{!! BootForm::submit('<i class="fa fa-fw fa-plus"></i> generieren')->class('btn btn-success') !!}
			{!! BootForm::close() !!}
    	</div>
    </div>
@endsection