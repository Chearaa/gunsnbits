@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Bilder zum Album "{{ $album->title }}" hinzufügen</h6>
                    </div>
                    <div class="panel-body">
                        <script src="/js/dropzone.js"></script>

                        <form action="{{ route('admin.gallery.album.pictures.upload', [$gallery, $album]) }}" class="dropzone" enctype="multipart/form-data" files="true">
                            {{ csrf_field() }}
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection