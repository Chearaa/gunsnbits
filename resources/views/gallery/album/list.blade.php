@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6><a href="{{ route('gallery.list') }}">Bilder</a> / {{ $gallery->title }}</h6>
                    </div>
                    <div class="panel-body">

                        @if (!empty($albums))
                            <div class="row">
                                @foreach($albums as $album)
                                    @if ($album->images()->first() instanceof \App\Image)
                                        <div class="col-sm-3">
                                            <a href="{{ route('gallery.album.images.list', [$gallery, $album]) }}">
                                                <figure class="text-center">
                                                    <img class="img-thumbnail img-responsive" alt="{{ $album->title }}" src="/images/galleries/{{ $gallery->id }}/{{ $album->id }}/small/{{ $album->images()->first()->filename }}">
                                                    <figcaption class="text-center">
                                                        <strong>{{ $album->title }}</strong>{!! !empty($album->subtitle) ? '<br/><small>' . $album->subtitle . '</small>' : '' !!}
                                                    </figcaption>
                                                </figure>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p>Bisher wurden leider noch keine Alben für diese Galerie angelegt.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection