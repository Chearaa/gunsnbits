@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Sitzplan</h6>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-darker">
                                        <h6>Bühne</h6>

                                        <div class="text-center seatingrow">
                                            @for ($i=209; $i<=220; $i++)
                                                <button class="btn btn-default seat">{{ $i }}</button>
                                            @endfor
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-darker">
                                        <h6>Saal</h6>

                                        <div class="row">
                                            <div class="col-lg-3 col-sm-6 col-xs-12">
                                                <div class="row">
                                                    <!-- ROW 1 -->
                                                    <p class="hidden-lg text-center">Reihe 1</p>
                                                    <div class="col-xs-6 leftside">
                                                        @for ($i=1; $i<=26; $i++)
                                                            <button class="btn btn-default seat pull-right">{{ $i }}</button>
                                                        @endfor
                                                    </div>
                                                    <!-- ROW 2 -->
                                                    <div class="col-xs-6 rightside">
                                                        @for ($i=27; $i<=52; $i++)
                                                            <button class="btn btn-default seat">{{ $i }}</button>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-xs-12">
                                                <div class="row">
                                                    <!-- ROW 3 -->
                                                    <p class="hidden-lg text-center">Reihe 2</p>
                                                    <div class="col-xs-6 leftside">
                                                        @for ($i=53; $i<=78; $i++)
                                                            <button class="btn btn-default seat pull-right">{{ $i }}</button>
                                                        @endfor
                                                    </div>
                                                    <!-- ROW 4 -->
                                                    <div class="col-xs-6 rightside">
                                                        @for ($i=79; $i<=104; $i++)
                                                            <button class="btn btn-default seat">{{ $i }}</button>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-xs-12">
                                                <div class="row">
                                                    <!-- ROW 5 -->
                                                    <p class="hidden-lg text-center">Reihe 3</p>
                                                    <div class="col-xs-6 leftside">
                                                        @for ($i=105; $i<=130; $i++)
                                                            <button class="btn btn-default seat pull-right">{{ $i }}</button>
                                                        @endfor
                                                    </div>
                                                    <!-- ROW 6 -->
                                                    <div class="col-xs-6 rightside">
                                                        @for ($i=131; $i<=156; $i++)
                                                            <button class="btn btn-default seat">{{ $i }}</button>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-xs-12">
                                                <div class="row">
                                                    <!-- ROW 7 -->
                                                    <p class="hidden-lg text-center">Reihe 4</p>
                                                    <div class="col-xs-6 leftside">
                                                        @for ($i=157; $i<=182; $i++)
                                                            <button class="btn btn-default seat pull-right">{{ $i }}</button>
                                                        @endfor
                                                    </div>
                                                    <!-- ROW 8 -->
                                                    <div class="col-xs-6 rightside">
                                                        @for ($i=183; $i<=208; $i++)
                                                            <button class="btn btn-default seat">{{ $i }}</button>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel panel-default">
                                    <div class="panel-body text-center bg-darker">
                                        <h6>Catering</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection