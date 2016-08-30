@extends('layouts.gnb')

@section('title', 'Sponsor - ' . $sponsor->name)
@section('bodyclass', 'bgpic-4')
@section('contentclass', 'container bg-dark')

@section('content')

    <h1 class="title">{{ $sponsor->name }}</h1>
    
    <div class="row">
        <div class="col-sm-8">
            <img class="img-thumbnail img-responsive" alt="" src="{!! ($sponsor->logo) ? '../images/sponsors/' . $sponsor->logo : 'images/sponsors/default.png' !!}">
        </div>
        <div class="col-sm-4">
            @if(!empty($sponsor->url))
                <p><a href="{{ $sponsor->url }}" target="_blank"><i class="fa fa-fw fa-2x fa-globe" style="margin-bottom: 20px;"></i></a> Homepage</p>
            @endif
            @if(!empty($sponsor->facebook))
                <p><a href="{{ $sponsor->facebook }}" target="_blank"><i class="fa fa-fw fa-2x fa-facebook-square" style="margin-bottom: 20px;"></i></a> Facebook</p>
            @endif
            @if(!empty($sponsor->twitter))
                <p><a href="{{ $sponsor->twitter }}" target="_blank"><i class="fa fa-fw fa-2x fa-twitter" style="margin-bottom: 20px;"></i></a> Twitter</p>
            @endif
        </div>
    </div>

    <div class="row box">
        <div class="col-sm-12">
            {!! nl2br($sponsor->description) !!}
        </div>
    </div>

@endsection