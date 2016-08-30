@extends('layouts.gnb')

@section('title', 'Sponsoren')
@section('bodyclass', 'bgpic-2')
@section('contentclass', 'container bg-dark')

@section('content')

    <h1 class="title">Unsere Sponsoren</h1>
    
    <div class="row box">
        @foreach($sponsors as $sponsor)
            <div class="col-sm-4">
                <a href="{{ route('sponsor.show', str_slug($sponsor->name)) }}">
                    <img class="img-thumbnail img-responsive" alt="" src="{!! ($sponsor->logo) ? '../images/sponsors/' . $sponsor->logo : 'images/sponsors/default.png' !!}">
                </a>
            </div>
        @endforeach
    </div>

@endsection