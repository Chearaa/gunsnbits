@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-lg-offset-2 col-lg-8">

				<div class="panel panel-default">
					<div class="panel-heading">
                        <div class="btn-group pull-right">
                            <a href="{{ route('admin.code.add') }}" class="btn btn-sm btn-success"><i class="fa fa-fw fa-plus"></i></a>
                        </div>
						<h6>Gutschein-Codes</h6>
					</div>
					<div class="panel-body">

                        <table class="table table-striped">
                            <tr>
                                <th>Code</th>
                                <th>Status</th>
                                <th>Gültigkeit</th>
                                <th>Verbraucht am</th>
                                <th></th>
                            </tr>
                            @foreach ($codes as $code)
                                <tr>
                                    <td>{{ $code->code }}</td>
                                    <td>
                                        @if (is_null($code->used_at))
                                            <span class="label label-success"><i class="fa fa-fw fa-check"></i></span>
                                        @else
                                            <span class="label label-danger"><i class="fa fa-fw fa-close"></i></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (is_null($code->lanparty))
                                            immer gültig
                                        @else
                                            {{ $code->lanparty->title }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (!is_null($code->used_at))
                                            {{ $code->used_at->format('d.m.Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (!is_null($code->used_at))
                                            von {{ $code->user->name }} (ID: {{ $code->user->id }}) für die {{ $code->lanparty->title }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection