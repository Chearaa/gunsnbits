@extends('layouts.email')

@section('preheader')

@endsection

@section('content')
    <h1>Kontaktanfrage</h1>
    <table>
    	<tr>
    		<th>E-Mail-Adresse</th>
    		<td>{{ $request->email }}
    	</tr>
    	<tr>
    		<th>Nachricht</th>
    		<td>{{ $request->message }}
    	</tr>
    </table>
@endsection

@section('footer')

@endsection