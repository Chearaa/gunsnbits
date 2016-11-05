@extends('layouts.email')

@section('preheader')

@endsection

@section('content')
    <h1>Du hast dein Passwort vergessen?</h1>
    <h3>Kein Problem!</h3>
    <p>Klicke einfach auf den <a href="{{ route('user.passwordreset.hash') }}?hash={{ $hash }}">Link</a>, um dein Passwort neu zu setzen!</p>
    <br/>
    <br/>
    <p>Solltest du dann immer noch nicht einloggen können, melde dich doch bitte bei uns!</p>
    <p>Dein <b>Guns'n'Bits Team</b></p>
@endsection

@section('footer')

@endsection