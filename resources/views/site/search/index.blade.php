@extends('layouts.site')

@section('styles')

    <link rel="stylesheet" href="{{ $assetPath }}/vendor/select2/select2.min.css">
@endsection

@section('sidebar')
    @if(isset($sidebar))
        {!! $sidebar !!}
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Добавить статью</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>


    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Добавить статью
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <!-- /.table-responsive -->
                    <div class="col-md-12">
                        <form method="get" action="{{ route('searchAdvanced.show') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}


                            <div class="panel-group" id="accordion">
                                @foreach($countries as $item)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <a class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#{{ $item->id }}">
                                                <label for="heading-{{ $item->id }}">
                                                    <input  type="radio" value="heading-{{ $item->id }}" id="heading-{{ $item->id }}" name="country[]"> {{ $item->title }}
                                                </label>
                                            </a>
                                        </div>

                                        <div id="{{ $item->id }}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                            @foreach($item->districts()->get() as $district)
                                                <?php $trans = $district->trans(App::getLocale())->first() ?>
                                                @if($trans)
                                                    <label for="{{ $district->id }}">{{ $trans->title }}</label>
                                                    <input id="{{ $district->id }}" type="checkbox" name="district_id[]" value="{{ $district->id }}">
                                                @endif

                                            @endforeach

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <h3>Restaurant requirments (Heto kanem)</h3>

                            <div class="row">
                                <h3>Customer type</h3>
                                @foreach($customerTypes as $item)
                                    <?php $trans = $item->trans(App::getLocale())->first() ?>
                                    @if($trans)
                                        <label for="{{ $item->id }}">{{ $trans->title }}</label>
                                        <input id="{{ $item->id }}" type="checkbox" name="customer_id[]" value="{{ $item->id }}">
                                    @endif

                                @endforeach
                            </div><!--row-->


                            <div class="row">
                                <h3>Cuisine type (Heto kanem)</h3>
                                @foreach($cuisines as $item)
                                    <?php $trans = $item->trans(App::getLocale())->first() ?>
                                    @if($trans)
                                        <label for="{{ $item->id }}">{{ $trans->title }}</label>
                                        <input id="{{ $item->id }}" type="checkbox" name="restcuisines_id[]" value="{{ $item->id }}">
                                    @endif

                                @endforeach
                            </div><!--row-->

                            <div class="row">
                                <h3>Restaurant type (Heto kanem)</h3>
                                @foreach($restaurantType as $item)
                                    <?php $trans = $item->trans(App::getLocale())->first() ?>
                                    @if($trans)
                                        <label for="{{ $item->id }}">{{ $trans->title }}</label>
                                        <input id="{{ $item->id }}" type="checkbox" name="restaurantType_id[]" value="{{ $item->id }}">
                                    @endif

                                @endforeach
                            </div><!--row-->

                            <div class="row">
                                <h3>No of. seat</h3>

                                <div class="radio">
                                    <label>
                                        <input type="radio" name="seat_number" id="0-50" value="0-50" checked>
                                        0-50
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="seat_number" id="51-100" value="51-100">
                                        51-100
                                    </label>
                                </div>
                                <div class="radio disabled">
                                    <label>
                                        <input type="radio" name="seat_number" id="101-200" value="101-200">
                                        101-200
                                    </label>
                                </div>
                                <div class="radio disabled">
                                    <label>
                                        <input type="radio" name="seat_number" id="200<" value="200<">
                                        over-200
                                    </label>
                                </div>


                            </div><!--row-->


                            <div class="row">
                                <h3>Other</h3>

                                <label for="wifi_ssid">WiFi</label>
                                <input type="checkbox" name="wifi_ssid" id="wifi_ssid" value="1">

                                <br>

                                <label for="liquor_license">Liquor License</label>
                                <input type="checkbox" name="liquor_license" id="liquor_license" value="1">
                            </div><!--row-->

                            <div class="form-group">

                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>{{--col-md-12--}}

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
@endsection

@section('scripts')
    <script src="{{ $assetPath }}/vendor/select2/select2.full.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".select2").select2();

            $(".panel-title").click(function() {
                $(this).children().children().prop("checked", true);
            });
        });
    </script>
@endsection