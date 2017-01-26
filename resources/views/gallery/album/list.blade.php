@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Alben der Galerie "{{ $gallery->title }}"</h6>
                    </div>
                    <div class="panel-body">

                        @if (!empty($albums))
                            <div class="row grid" style="padding-left: 15px;">
                                @foreach($albums as $album)
                                    @if ($album->images()->first() instanceof \App\Image)
                                        <div class="grid-item" style="margin-bottom: 15px;">
                                            <a href="{{ route('gallery.album.images.list', [$gallery, $album]) }}">
                                                <img class="img-thumbnail img-responsive" alt="" src="/images/galleries/{{ $gallery->id }}/{{ $album->id }}/small/{{ $album->images()->first()->filename }}">
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

@section('scripts')
    <script type="text/javascript">
        $('.grid').masonry({
            // options
            itemSelector: '.grid-item',
            columnWidth: 210,
            gutter: 15
        });

        lightbox.option({
            'albumLabel': "Bild %1 von %2"
        });
    </script>
@endsection