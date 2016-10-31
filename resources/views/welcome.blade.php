@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="margin-bottom: 50px;">
        <div class="col-lg-6 text-center" data-mh="row1">
            <figure>
                <img class="img-responsive" src="images/gnb/logo.svg">
            </figure>
            <h3>Die LAN der Region<br/>Köln-Düren-Aachen</h3>
        </div>
        <div class="col-lg-6" data-mh="row1">
            <div class="panel panel-default" data-mh="row1">
                <div class="panel-heading">Alles auf einen Blick!</div>
                <div class="panel-body">

                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Unsere nächste Lanparty</div>
                <div class="panel-body">

                    <ul class="timeline">
                        @foreach($posts as $post)
                            <li class="">
                                <div class="timeline-badge text-warning">
                                    @if($post->type == 'event')
                                        <i class="fa fa-fw fa-calendar"></i>
                                    @elseif($post->type == 'video')
                                        <i class="fa fa-fw fa-play"></i>
                                    @elseif($post->type == 'status')
                                        <i class="fa fa-fw fa-comment"></i>
                                    @elseif($post->type == 'photo')
                                        <i class="fa fa-fw fa-camera"></i>
                                    @elseif($post->type == 'link')
                                        <i class="fa fa-fw fa-link"></i>
                                    @endif
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-body">
                                        <article class="post-wrap thumbnail">
                                            <div class="post-media">
                                                <div class="post-meta clearfix">
                                                    <span class="pull-left text-warning"><span class="post-date"><i class="fa fa-calendar-o"></i> {{ $post->created_time->format('d.m.Y') }} <i class="fa fa-clock-o"></i> {{ $post->created_time->format('H:i') }} Uhr</span></span>
                                                </div>
                                            </div>
                                            <div class="post-header">
                                                @if ($post->story)
                                                    <p>{{ $post->story }}</p>
                                                @endif
                                            </div>
                                            <div class="post-body">
                                                @if ($post->images()->get()->count() > 0)
                                                    <div class="pull-right" style="margin-bottom: 10px;">
                                                        @if ($post->images()->get()->count() == 1)
                                                            <figure>
                                                                <img class="img-responsive img-thumbnail" src="images/facebook/{{ $post->images()->first()->basename }}" width="200">
                                                            </figure>
                                                        @else

                                                        @endif
                                                    </div>
                                                @endif
                                                <div class="post-excerpt">{!! $post->message !!}</div>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>


    </div>
</div>
@endsection
