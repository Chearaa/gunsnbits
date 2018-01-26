@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-lg-12">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h6>Neuen Sponsor anlegen</h6>
					</div>
					<div class="panel-body">

                        {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.sponsor.add.post'))->enctype('multipart/form-data') !!}
                        {!! csrf_field() !!}
                        {!! BootForm::text('Name', 'name')->required() !!}
                        <div class="form-group" style="margin-bottom: 50px;">
                            <div class="col-sm-offset-4 col-sm-8">
                                <a class="btn btn-default file-btn">
                                    <span>Bild auswählen</span>
                                    <input type="file" id="upload" class="croppie-upload" value="Choose a file" name="logo" accept="image/*" />
                                </a>
                            </div>
                            <div class="col-sm-12">
                                <div id="upload-image" class="" style="width: 100%; height: 300px;"></div>
                                <textarea id="cropped-image" name="cropped_image" style="display: none;"></textarea>
                            </div>
                        </div>
                        @if($errors->has('logo'))
                            <div class="form-group"><div class="col-sm-8 col-sm-offset-4 text-danger">{{ $errors->first('logo') }}</div></div>
                        @endif
                        {!! BootForm::textarea('Beschreibung', 'description') !!}
                        {!! BootForm::text('Webseite', 'url')->type('url') !!}
                        {!! BootForm::text('Facebook', 'facebook')->type('url') !!}
                        {!! BootForm::text('Twitter', 'twitter')->type('url') !!}
                        {!! BootForm::submit('<i class="fa fa-fw fa-plus"></i> anlegen')->class('btn btn-success')->id('upload-result') !!}
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
                    width: 720,
                    height: 250,
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