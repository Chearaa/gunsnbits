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
                            <div class="row">
                                @foreach($galleries as $gallery)
                                    @if ($gallery instanceof \App\Gallery)
                                        @if ($gallery->albums()->count() == 1)
                                            <div class="col-sm-3">
                                                <a href="{{ route('gallery.album.images.list', [$gallery, $gallery->albums()->first()]) }}">
                                                    <figure class="text-center">
                                                        <img class="img-thumbnail img-responsive" alt="" src="/images/galleries/{{ $gallery->id }}/{{ $gallery->albums()->first()->id }}/small/{{ $gallery->albums()->first()->images()->first()->filename }}">
                                                        <figcaption>
                                                            <strong>{{ $gallery->albums()->first()->title }}</strong>{!! !empty($gallery->albums()->first()->subtitle) ? '<br/><small>' . $gallery->albums()->first()->subtitle . '</small>' : '' !!}
                                                        </figcaption>
                                                    </figure>
                                                </a>
                                            </div>

                                        @elseif ($gallery->albums()->count() > 1)
                                            @if ($gallery->albums()->first() instanceof \App\Album && $gallery->albums()->first()->images()->first() instanceof \App\Image)
                                                <div class="col-sm-3">
                                                    <a href="{{ route('gallery.album.list', [$gallery]) }}">
                                                        <figure class="text-center">
                                                            <img class="img-thumbnail img-responsive" alt="" src="/images/galleries/{{ $gallery->id }}/{{ $gallery->albums()->first()->id }}/small/{{ $gallery->albums()->first()->images()->first()->filename }}">
                                                            <figcaption>
                                                                <strong>{{ $gallery->title }}</strong>{!! !empty($gallery->subtitle) ? '<br/><small>' . $gallery->subtitle . '</small>' : '' !!}
                                                            </figcaption>
                                                        </figure>
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
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