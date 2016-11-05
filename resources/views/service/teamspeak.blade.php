@extends('layouts.gnb')

@section('title', 'Teamspeak')
@section('bodyclass', 'bgpic-1')
@section('contentclass', 'container bg-dark')

@section('content')

    <h1>TeamSpeak</h1>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <p>
                Habt ihr nicht nur Bock zu zocken,<br/>sondern wollt auch ein paar Gleichgesinnte kennenlernen?!<br/>
                Dann startet euer <a href="http://www.teamspeak.de" target="_blank">TeamSpeak</a> und kommt auf unseren Server!<br/><br/>
            </p>
            <dl>
                <dd>Server-IP:</dd>
                <dt>85.214.156.40</dt>
                <dd>Port:</dd>
                <dt>10011</dt>
            </dl>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            {!! $ts3_VirtualServer->getViewer(new TeamSpeak3_Viewer_Html("images/viewericons/", "images/countryflags/", "data:image")) !!}
        </div>
    </div>


@endsection