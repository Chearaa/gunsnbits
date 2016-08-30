@extends('layouts.gnb')

@section('title', 'Catering')
@section('bodyclass', 'bgpic-5')
@section('contentclass', 'container bg-dark')

@section('content')

    <h1 class="text-center">Catering</h1>
    
    <div class="row">
        <div class="col-sm-8">
            @foreach($caterings as $catering)
            <div class="row catering">
                <div class="col-sm-6">
                    <img class="img-thumbnail img-responsive" alt="" src="{!! ($catering->image) ? '../images/catering/' . $catering->image : 'images/catering/default.png' !!}">
                </div>
                <div class="col-sm-6">
                    <h4>{{ $catering->title }}</h4>
                    <p>{!! nl2br($catering->description) !!}</p>
                    <h5 class="pull-right">{{ number_format($catering->costs, 2, ',', '.') }} &euro;</h5>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-sm-4">
            <div class="row">
                <div class="col-sm-12 box">
                    <img class="img-thumbnail img-responsive center-block" alt="" src="images/gnbmember/pati.png" width="200">
                    <h4>[GNB]Pati</h4>
                    <p>Unsere Pati ist jede Lan für euch von früh bis spät hinterm Tresen!<br/>Ob Cocktail, Fritten oder Frühstück. Sie ist immer für euch da.</p>
                </div>
            </div>
        </div>
    </div>

@endsection