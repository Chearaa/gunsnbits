@extends('layouts.email')

@section('preheader')

@endsection

@section('content')
    <h1>Die nächste Lan steht an!</h1>
    <p>
        Es ist wieder soweit.<br/>
        Wir haben die Anmeldung zur <strong>{{ $lanparty->title }}</strong> gerade geöffnet.
    </p>
    <p>
        Da du zu unseren Stammgästen gehörst, haben wir dich schon automatisch <a href="{{ route('lanparty.reservation') }}">angemeldet</a>.
    </p>
    @if ($regularseats->count() > 1)
        <p>
            Folgende Sitzplätze haben wir für dich eingeplant:
        </p>

        @foreach($regularseats as $regularseat)
            @if($regularseat->status == 1)
                <p>
                    Sitzplatz <b>#{{ $regularseat->seatnumber }}</b> wurde <b>vorgemerkt</b>.<br/><br/>
                    Bitte überweise den Teilnehmerbetrag von 25,00 &euro; in den nächsten 2 Wochen an
                </p>
                <p>
                    <b>Guns'n Bits e.V.</b></br>
                    IBAN: DE16 8306 5408 0004 9497 65<br/>
                    BIC: GENODEF1SLR
                </p>
                <p>
                    Verwendungszweck: <b>{{ $lanparty->reasonforpayment }}-{{ $user->id }}-{{ $regularseat->seatnumber }}</b>
                </p>
                <p>
                    Sollten wir bis dahin keinen Geldeingang verbuchen können, kann es sein, dass dein Platz für andere Teilnehmer wieder freigegeben wird.
                </p>
            @elseif($regularseat->status == 2)
                <p>
                    Sitzplatz <b>#{{ $regularseat->seatnumber }}</b> wurde <b>reserviert</b>.<br/><br/>
                    Bitte überweise den Teilnehmerbetrag von 25,00 &euro; an
                </p>
                <p>
                    <b>Guns'n Bits e.V.</b></br>
                    IBAN: DE16 8306 5408 0004 9497 65<br/>
                    BIC: GENODEF1SLR
                </p>
                <p>
                    Verwendungszweck: <b>{{ $lanparty->reasonforpayment }}-{{ $user->id }}-{{ $regularseat->seatnumber }}</b>
                </p>
            @elseif($regularseat->status == 3)
                <p>
                    Sitzplatz <b>#{{ $regularseat->seatnumber }}</b> wurde <b>reserviert</b> und <b>bezahlt</b>.<br/><br/>
                    Wir freuen uns auf dich!
                </p>
            @endif
        @endforeach
    @else
            @if($regularseats->first()->status == 1)
                <p>
                    Sitzplatz <b>#{{ $regularseats->first()->seatnumber }}</b> wurde <b>vorgemerkt</b>.<br/><br/>
                    Bitte überweise den Teilnehmerbetrag von 25,00 &euro; in den nächsten 2 Wochen an
                </p>
                <p>
                    <b>Guns'n Bits e.V.</b></br>
                    IBAN: DE16 8306 5408 0004 9497 65<br/>
                    BIC: GENODEF1SLR
                </p>
                <p>
                    Verwendungszweck: <b>{{ $lanparty->reasonforpayment }}-{{ $user->id }}-{{ $regularseats->first()->seatnumber }}</b>
                </p>
                <p>
                    Sollten wir bis dahin keinen Geldeingang verbuchen können, kann es sein, dass dein Platz für andere Teilnehmer wieder freigegeben wird.
                </p>
            @elseif($regularseats->first()->status == 2)
                <p>
                    Sitzplatz <b>#{{ $regularseats->first()->seatnumber }}</b> wurde <b>reserviert</b>.<br/><br/>
                    Bitte überweise den Teilnehmerbetrag von 25,00 &euro; an
                </p>
                <p>
                    <b>Guns'n Bits e.V.</b></br>
                    IBAN: DE16 8306 5408 0004 9497 65<br/>
                    BIC: GENODEF1SLR
                </p>
                <p>
                    Verwendungszweck: <b>{{ $lanparty->reasonforpayment }}-{{ $user->id }}-{{ $regularseats->first()->seatnumber }}</b>
                </p>
            @elseif($regularseats->first()->status == 3)
                <p>
                    Sitzplatz <b>#{{ $regularseats->first()->seatnumber }}</b> wurde <b>reserviert</b> und <b>bezahlt</b>.<br/><br/>
                    Wir freuen uns auf dich!
                </p>
            @endif
    @endif

@endsection

@section('footer')

@endsection