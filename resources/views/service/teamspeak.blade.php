@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Teamspeak</h6>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <p>
                                    Habt ihr nicht nur Bock zu zocken,<br/>sondern wollt auch ein paar Gleichgesinnte kennenlernen?!<br/>
                                    Dann startet euer <a href="http://www.teamspeak.de" target="_blank">TeamSpeak</a> und kommt auf unseren Server!<br/><br/>
                                </p>
                                <dl>
                                    <dt>Server-IP:</dt>
                                    <dd>85.214.156.40</dd>
                                    <dt>Port:</dt>
                                    <dd>10011</dd>
                                </dl>
                            </div>
                            <div class="col-lg-6">
                                <div class="teamspeak-viewer">
                                    {!! $ts3_VirtualServer->getViewer(new TeamSpeak3_Viewer_Html("/images/ts3/", "/images/countryflags/", "data:image")) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection