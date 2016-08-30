@extends('layouts.gnb')

@section('title', 'Kulturhalle Langerwehe')
@section('bodyclass', 'bgpic-4')
@section('contentclass', 'container bg-dark')

@section('content')
	
	<h1>Kulturhalle Langerwehe</h1>

	<div class="row">
		<div class="col-sm-6">
            <h5>Adresse</h5>
            <p>
                Kulturhalle Langerwehe<br/>
                Josef-Schwarz-Straße 14<br/>
                52379 Langerwehe
            </p>
		</div>
        <div class="col-sm-6">
            <h5>Wegbeschreibung</h5>
            <p>
                Die Kulturhalle in Langerwehe (bei Eschweiler) liegt unmittelbar an der Autobahn A4.<br/>
                Von Köln aus Richtung Aachen<br/>
                Ausfahrt 5b Eschweiler-Ost abfahren und in Richtung Eschweiler/Weisweiler<br/>
                Links auf die B264 Richtung Langwerwehe/Düren/Weisweiler<br/>
                Nach ca. 5km die erste Ausfahrt im Kreisverkehr nehmen<br/>
                Im Ort Langerwehe angekommen am Kreisverkehr die zweite Ausfahrt nehmen<br/>
                Nach ca. 400m auf der linken Seite in die Josef Schwarz Straße einfahren.<br/>
                Ihr habt euer Ziel erreicht !
            </p>
        </div>
	</div>

    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5041.614424762044!2d6.363553443467518!3d50.81621050360719!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47bf67400a2bb129%3A0xd4ff77e8db32110a!2sKulturhalle!5e0!3m2!1sde!2sde!4v1467910196173" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

    <h1>Bilder</h1>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
            <p>
                In der großen Halle finden bis zu 220 Zocker und Zockerinnen platz.<br/>
                Und natürlich gibt es auch genügend Platz zum pennen, falls man die 3 Tage halt nicht durchhält <i class="fa fa-smile-o"></i>
            </p>
        </div>

        <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
            @if (!empty($pictures))
                <div id="carousel-location" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        @foreach($pictures as $key=>$picture)
                            <div class="item {{ ($key == 0) ? 'active' : '' }}">
                                <img class="img-responsive" src="images/location/{{ $picture }}">
                            </div>
                        @endforeach
                    </div>

                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Zurück</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Weiter</span>
                    </a>
                </div>
            @endif
        </div>
    </div>


@endsection