@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Benutzer-Profil bearbeiten</h6>
                    </div>
                    <div class="panel-body">

                        {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('user.editprofile.post'))->enctype('multipart/form-data') !!}
                        {!! BootForm::bind($user) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::email('E-Mail', 'email') !!}
                        {!! BootForm::text('Geburtstag', 'birthday')->class('datepicker form-control date')->placeholder('00.00.0000')->id('birthdate') !!}
                        <div class="form-group" style="margin-bottom: 50px;">
                            <div class="col-sm-offset-4 col-sm-8">
                                <a class="btn btn-default file-btn">
                                    <span>Bild auswählen</span>
                                    <input type="file" id="upload" class="croppie-upload" value="Choose a file" name="avatar" accept="image/*" />
                                </a>
                            </div>
                            <div class="col-sm-offset-4 col-sm-8">
                                <div id="upload-image" class="" style="width: 100%; height: 500px;"></div>
                                <textarea id="cropped-image" name="cropped_image" style="display: none;"></textarea>
                                <input id="org-image-file" type="text" value="{{ $user->avatar }}" style="display: none;">
                            </div>
                        </div>
                        @if($errors->has('avatar'))
                            <div class="form-group"><div class="col-sm-8 col-sm-offset-4 text-danger">{{ $errors->first('avatar') }}</div></div>
                        @endif
                        {!! BootForm::submit('<i class="fa fa-fw fa-check"></i> speichern')->class('btn btn-success pull-right')->id('upload-result') !!}
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
            var $orgFile = $('#org-image-file').val();

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
                    width: 300,
                    height: 400,
                    type: 'square'
                },
                enableExif: true
            });

            $uploadCrop.croppie('bind', {
                url: '../../../images/avatar/' + $orgFile
            }).then(function() {
                $uploadCrop.croppie('setZoom', '1');
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