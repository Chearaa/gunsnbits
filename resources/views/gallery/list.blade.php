@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Bilder-Galerien</h6>
                    </div>
                    <div class="panel-body">

                        @if (!empty($galleries))
                            <div class="row grid" style="padding-left: 15px;">
                                @foreach($galleries as $gallery)
                                    @if ($gallery->albums()->first() instanceof \App\Album && $gallery->albums()->first()->images()->first() instanceof \App\Image)
                                        <div class="grid-item" style="margin-bottom: 15px;">
                                            <a href="{{ route('gallery.album.list', [$gallery]) }}">
                                                <figure>
                                                    <img class="img-thumbnail img-responsive" alt="" src="/images/galleries/{{ $gallery->id }}/{{ $gallery->albums()->first()->id }}/small/{{ $gallery->albums()->first()->images()->first()->filename }}">
                                                    <figcaption class="text-center">
                                                        <strong>{{ $gallery->title }}</strong>{!! !empty($gallery->subtitle) ? '<br/><small>' . $gallery->subtitle . '</small>' : '' !!}
                                                    </figcaption>
                                                </figure>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p>Bisher wurden leider noch keine Bilder-Galerien angelegt.</p>
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