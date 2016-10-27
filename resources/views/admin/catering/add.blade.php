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
                        <div class="form-group" style="margin-bottom: 50px;">
                            <div class="col-sm-8 col-sm-offset-4">
                                <a class="btn btn-default file-btn">
                                    <span>Bild auswählen</span>
                                    <input type="file" id="upload" class="croppie-upload" value="Choose a file" name="image" accept="image/*" />
                                </a>
                                <div id="upload-image" class="" style="width: 100%; height: 300px;"></div>
                                <textarea id="cropped-image" name="cropped_image" style="display: none;"></textarea>
                            </div>
                        </div>
                        @if($errors->has('image'))
                            @foreach ($errors->get('image') as $error)
                                <div class="form-group"><div class="col-sm-8 col-sm-offset-4 text-danger">{{ $error }}</div></div>
                            @endforeach
                        @endif
                        {!! BootForm::textarea('Beschreibung', 'description')->required() !!}
                        {!! BootForm::text('Preis &euro;', 'costs')->class('form-control costs')->placeholder('0,00')->required() !!}
                        {!! BootForm::submit('<i class="fa fa-fw fa-plus"></i> hinzufügen')->class('btn btn-success')->id('upload-result') !!}
                        {!! BootForm::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(function() {
            'use strict';

            var $uploadCrop;

            function readFile(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.upload-image').addClass('ready');
                        $uploadCrop.croppie('bind', {
                            url: e.target.result
                        }).then(function(){
                            console.log('jQuery bind complete');
                        });

                    }

                    reader.readAsDataURL(input.files[0]);
                }
                else {
                    //swal("Sorry - you're browser doesn't support the FileReader API");
                }
            }

            $uploadCrop = $('#upload-image').croppie({
                viewport: {
                    width: 400,
                    height: 225,
                    type: 'square'
                },
                enableExif: true
            });

            $('#upload').on('change', function () {
                readFile(this);
            });
            $('#upload-result').on('click', function (ev) {
                $uploadCrop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (resp) {
                    console.log('resp erhalten');
                    $('#cropped-image').val(resp);
                });
            });

        });
    </script>

@endsection