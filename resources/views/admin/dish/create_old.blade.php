@extends('layouts.admin')

@section('styles')

@endsection

@section('content')

    <!-- BEGIN PAGE HEADER-->

    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered calendar">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">{{ isset($title) ? $title : 'Admin panel' }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <form  class="form-horizontal" method="post" action="{{ route('admin.dish.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                {{--Transnate Tab--}}
                                <div id="translate">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <li role="{{$localeCode}}" class="{{ (App::getLocale() ==  $localeCode) ? 'active' : ''}}"><a href="#tab_{{$localeCode}}" aria-controls="{{$localeCode}}" role="tab" data-toggle="tab">{{ $properties['native'] }}</a></li>
                                        @endforeach
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <div role="{{$localeCode}}" class="tab-pane {{ (App::getLocale() ==  $localeCode) ? 'active' : ''}}" id="tab_{{$localeCode}}">

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="title_{{$localeCode}}">Company Name</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="title[{{$localeCode}}]" id="title_{{$localeCode}}" value="" class="form-control">
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach

                                    </div>
                                </div><!--translate-->
                                {{--Transnate Tab End--}}

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="website_url"></label>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>


                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function()
        {
            $('#clickmewow').click(function()
            {
                $('#radio1003').attr('checked', 'checked');
            });
        })
    </script>

@endsection