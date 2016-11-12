@extends('layouts.email')

@section('preheader')

@endsection

@section('content')
    <h1>Passwort zurücksetzen</h1>
    <p>
        Hallo,<br/>
        wir haben eine Anfrage zum Zurücksetzen des Passworts erhalten.<br/><br/>
        Wurde diese Anfrage nicht von dir gestellt, so ignoriere diese E-Mail einfach.<br/>
        Ansonsten klicke einfach auf den folgenden Link, damit du dann ein neues Passwort vergeben kannst.
    </p>
    <p>
        <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
    </p>
@endsection

@section('footer')

@endsection

