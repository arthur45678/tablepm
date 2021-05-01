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

                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Company name</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <td><img width="70" src="{{ isset($article->img) ? asset('images') . '/'. $article->img : asset('imagesServe') . '/no_image.jpg'}}" alt=""></td>


                                                <?php $trans = $article->trans($localeCode)->first() ?>
                                                @if($trans)
                                                    <tr>
                                                        <td><a href="{{ route('admin.RestaurantCompanies.edit', ['id' => $article->id]) }}">{{ $trans->title }}</a></td>
                                                    </tr>
                                                @endif


                                                </tbody>
                                            </table>



                                        </div>
                                    @endforeach

                                </div>
                            </div><!--translate-->
                            {{--Transnate Tab End--}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')


@endsection