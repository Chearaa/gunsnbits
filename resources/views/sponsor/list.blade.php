@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Unsere Sponsoren</h6>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            @foreach($sponsors as $sponsor)
                                <div class="col-sm-6" style="margin-bottom: 10px;">
                                    <a href="{{ route('sponsor.show', str_slug($sponsor->name)) }}">
                                        <img class="img-thumbnail img-responsive" alt="" src="{!! ($sponsor->logo) ? '../images/sponsors/' . $sponsor->logo : 'images/sponsors/default.png' !!}">
                                    </a>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection