@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>{{ $gallery->title }} - {{ $album->title }}</h6>
                    </div>
                    <div class="panel-body">

                        {!! BootForm::open()->post()->action(route('admin.gallery.album.pictures.edit', [$gallery, $album])) !!}
                            <table class="table table-condensed">
                                @foreach($album->images as $image)
                                    <tr>
                                        <td><img class="img-thumbnail" src="{{ '/images/galleries/' . $gallery->id . DIRECTORY_SEPARATOR . $album->id . DIRECTORY_SEPARATOR . 'small' . DIRECTORY_SEPARATOR . $image->filename }}" alt="{{ $image->caption }}"></td>
                                        <td>{!! BootForm::text('', 'title[' . $image->id . ']')->value($image->caption) !!}</td>
                                        <td><a class="btn btn-danger" href="{{ route('admin.gallery.album.pictures.delete', [$gallery, $album, $image]) }}" style="margin-top: 20px;"><i class="fa fa-close"></i></a></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3"><button type="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i> speichern</button></td>
                                </tr>
                            </table>
                        {!! BootForm::close() !!}

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection