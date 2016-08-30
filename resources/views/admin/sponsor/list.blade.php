@extends('layouts.admin')

@section('title', 'Sponsoren')
@section('bodyclass', 'welcome bgpic-5')
@section('contentclass', 'container bg-dark')

@section('content')

	<h1 class="title">Sponsoren</h1>
    
    <div class="row box">
    	<div class="col-sm-12">
			
			@foreach ($sponsors as $sponsor)
			<div class="media">
				<div class="media-left">
					<a href="">
						<img class="media-object img-thumbnail img-responsive" alt="" src="{!! ($sponsor->logo) ? '../images/sponsors/' . $sponsor->logo : 'images/sponsors/default.png' !!}" width="300">
					</a>
				</div>
				<div class="media-body">
					<h4 class="media-heading">
						{{ $sponsor->name }}
						<button type="button" data-container="body" data-toggle="modal" data-target="#modal-{{ $sponsor->id }}" class="btn btn-danger pull-right"><i class="fa fa-fw fa-close"></i></button>
						<a href="{{ route('admin.sponsor.edit', [$sponsor->id]) }}" class="btn btn-default pull-right" style="margin-right: 5px;"><i class="fa fa-fw fa-edit"></i></a>
						
					</h4>
					
				</div>
			</div>
			@endforeach
			
    	</div>
    </div>
    
    @foreach ($sponsors as $sponsor)
    <div class="modal fade" id="modal-{{ $sponsor->id }}" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Sponsor wirklich löschen?</h4>
				</div>
				<div class="modal-body">
					{!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.sponsor.delete.post')) !!}
					{!! csrf_field() !!}
					{!! BootForm::hidden('sponsor_id')->value($sponsor->id) !!}
					<button type="submit" class="btn btn-danger"><i class="fa fa-fw fa-check"></i> ja</button>
					<button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close" aria-hidden="true"><i class="fa fa-fw fa-close"></i> nein</button>
					{!! BootForm::close() !!}
				</div>
			</div>
		</div>
	</div>
    @endforeach
    
@endsection