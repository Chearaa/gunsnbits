@if(isset($alerts))
    @foreach($alerts as $alert)
        <div class="alert alert-{{ $alert['class'] }}" role="alert">
            {!! $alert['msg'] !!}
        </div>
    @endforeach
@endif