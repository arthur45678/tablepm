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
                            <form class="form-horizontal" id="updateForm"  method="post" action="{{ route('admin.customerTypesRestaurants.update', ['id' => $article->id]) }}" enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="put">
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

                                                <?php $trans = $article->trans($localeCode)->first() ?>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="title_{{$localeCode}}">Title</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="title[{{$localeCode}}]" id="title_{{$localeCode}}" value="{{ isset($trans->title) ? $trans->title : '' }}" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div><!--translate-->
                                {{--Transnate Tab End--}}


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