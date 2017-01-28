@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Unser Catering</h6>
                    </div>
                    <div class="panel-body">

                        @foreach($caterings as $catering)
                            <div class="row catering" style="margin-bottom: 20px;">
                                <div class="col-sm-6">
                                    <img class="img-thumbnail img-responsive" alt="" src="{!! ($catering->image) ? '/images/catering/' . $catering->image : '/images/catering/default.png' !!}">
                                </div>
                                <div class="col-sm-6">
                                    <h4>{{ $catering->title }}</h4>
                                    <p>{!! nl2br($catering->description) !!}</p>
                                    <h5 class="pull-right">{{ number_format($catering->costs, 2, ',', '.') }} &euro;</h5>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>[GNB]Pati</h6>
                    </div>
                    <div class="panel-body">
                        <img class="img-thumbnail img-responsive center-block" alt="" src="/images/gnbmember/pati.png" width="200"><br/>
                        <p>Unsere Pati ist jede Lan für euch von früh bis spät hinterm Tresen!<br/>Ob Cocktail, Fritten oder Frühstück. Sie ist immer für euch da.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection