@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Bilder des Albums "{{ $album->title }}"</h6>
                    </div>
                    <div class="panel-body">

                        @if (!empty($images))
                            <div class="row grid" style="padding-left: 15px;">
                                @foreach($images as $image)
                                    @if ($image instanceof \App\Image)
                                        <div class="grid-item" style="margin-bottom: 15px;">
                                            <a href="/images/galleries/{{ $gallery->id }}/{{ $album->id }}/{{ $image->filename }}" data-lightbox="images" data-title="{{ $image->caption }}">
                                                <img class="img-thumbnail img-responsive" alt="{{ $image->caption }}" src="/images/galleries/{{ $gallery->id }}/{{ $album->id }}/small/{{ $image->filename }}">
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p>Bisher wurden noch keine Bilder hinzugefügt.</p>
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