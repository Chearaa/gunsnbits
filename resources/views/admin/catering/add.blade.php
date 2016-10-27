@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{!! csrf_token() !!}">

    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Auswahl hinzufügen</h6>
                    </div>
                    <div class="panel-body">

                        {!! BootForm::openHorizontal(['sm'=>[4,8]])
                            ->post()
                            ->action(route('admin.catering.add.check'))
                            ->enctype('multipart/form-data')
                        !!}
                        {!! csrf_field() !!}
                        {!! BootForm::text('Bezeichnung', 'title')->placeholder('Titel der Speise')->required() !!}
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="image">Bild</label>
                            <div class="col-sm-8">
                                <input id="image" type="file" name="image" />
                            </div>
                        </div>
                        {!! BootForm::textarea('Beschreibung', 'description')->required() !!}
                        {!! BootForm::text('Preis &euro;', 'costs')->class('form-control costs')->placeholder('0,00')->required() !!}
                        {!! BootForm::submit('<i class="fa fa-fw fa-plus"></i> hinzufügen')->class('btn btn-success') !!}
                        {!! BootForm::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="/js/dropzone.js"></script>
    <script type="text/javascript">
        $('#image').dropzone({
            url: '/admin/catering/file/upload'
        });
    </script>

@endsection