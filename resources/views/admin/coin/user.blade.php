@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Coins - Benutzer-Auswahl</h6>
                    </div>
                    <div class="panel-body">
                        {!! BootForm::openHorizontal(['sm'=>[4,8]])->post()->action(route('admin.coin.user.post')) !!}
                        {!! csrf_field() !!}
                        {!! BootForm::hidden('user_id') !!}
                        {!! BootForm::text('Benutzer', 'name')->class('form-control autocomplete user')->autocomplete('off') !!}
                        {!! BootForm::submit('<i class="fa fa-fw fa-check"></i> auswählen')->class('btn btn-success') !!}
                        {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(function () {
            /**
             * autocomplete
             */
            $('.autocomplete.user').typeahead({
                onSelect: function (item) {
                    $('input[name="user_id"]').val(item.value);
                },
                ajax: {
                    url: "/ajax/users",
                    timeout: 300,
                    displayField: "name",
                    triggerLength: 1,
                    method: "get"
                }
            });
        });
    </script>
@endsection