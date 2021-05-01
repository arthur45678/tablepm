@extends('layouts.admin')
<?php $assetPath = asset('admin') ?>
@section('styles')
    <link rel="stylesheet" href="{{ $assetPath }}/global/plugins/jquery_geocomplete/map.css">
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
                            <form id="updateForm" class="form-horizontal" method="post" action="{{ route('admin.advertiserCompanies.update', ['id' => $article->id]) }}" enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="put">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-4">
                                        <div class="map_canvas"></div>
                                    </div>
                                </div>

                                {{--Map--}}
                                <div class="form-group">
                                    <label  class="control-label col-md-3" for="find"></label>
                                    <div class="col-md-4">
                                        <input id="geocomplete" type="text" placeholder="Type in an address" value="" />
                                        <input class="btn btn-primary" id="find" type="button" value="find" />
                                    </div>
                                    <input  name="lat" type="hidden" value="">
                                    <input name="lng" type="hidden" value="">
                                </div>

                                {{--Map end--}}

                                <div class="row">
                                    <div class="form-group">
                                        <label class="control-label col-md-3" for="img">Post image</label>
                                        <div class="col-md-4">
                                            <input name="img" id="img" type="file" class="form-control filestyle" data-buttonName="btn-primary">
                                        </div>

                                        <div class="col-md-4">
                                            @if($article->img)
                                                <img style="max-width: 118px" src="{{ $imagePath }}/{{ $article->img }}" alt="">
                                            @else
                                                {{--no-image.jpg--}}
                                                <img style="max-width: 118px" src="{{ $imagesServe }}/page_no_image.jpg" alt="">
                                            @endif
                                        </div>
                                    </div>


                                </div><!--row-->





                                <div class="form-group">
                                    <label class="control-label col-md-3" for="block">Block</label>
                                    <div class="col-md-4">
                                        <input type="text" name="block" class="form-control" value="{{ isset($article->block) ? $article->block : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="block">Floor</label>
                                    <div class="col-md-4">
                                        <input type="text" name="floor" class="form-control" value="{{ isset($article->floor) ? $article->floor : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="flat">Flat</label>
                                    <div class="col-md-4">
                                        <input type="text" name="flat" class="form-control" value="{{ isset($article->flat) ? $article->flat : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="estate_building">Estate Building</label>
                                    <div class="col-md-4">
                                        <input type="text" name="estate_building" class="form-control" value="{{ isset($article->estate_building) ? $article->estate_building : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="street">Street</label>
                                    <div class="col-md-4">
                                        <input type="text" name="street" class="form-control" value="{{ isset($article->street) ? $article->street : '' }}">
                                    </div>
                                </div>


                                @if(isset($industries) && count($industries) > 0)
                                    <div class="form-group">
                                        <label class="control-label col-md-3" for="">Industries</label>
                                        <div class="col-md-4">
                                            <select name="industries[]" id="industries" class="form-control select2" multiple="multiple" data-placeholder="" style="width: 100%;">
                                                @foreach($industries as $item)
                                                    @if($article && $item->checkHasIndustry($item->id, $article->id))
                                                        <option selected value="{{ $item->id }}">{{ $item->getAllTransData($item->slug) }}</option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->getAllTransData($item->slug) }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="district">District</label>
                                    <div class="col-md-4">
                                        <input type="text" name="district" class="form-control" value="{{ isset($article->district) ? $article->district : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="email">Email</label>
                                    <div class="col-md-4">
                                        <input type="email" name="email" class="form-control" value="{{ isset($article->email) ? $article->email : '' }}">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="phone">Phone</label>
                                    <div class="col-md-4">
                                        <input type="tel" name="phone" class="form-control" value="{{ isset($article->phone) ? $article->phone : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="mobile">Mobile</label>
                                    <div class="col-md-4">
                                        <input type="tel" name="mobile" class="form-control" value="{{ isset($article->mobile) ? $article->mobile : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="website_url">Website URL</label>
                                    <div class="col-md-4">
                                        <input type="url" name="website_url" class="form-control" value="{{ isset($article->website_url) ? $article->website_url : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="country_id">Country</label>
                                    <div class="col-md-4">
                                        <select name="country_id" id="country_id" class="form-control">
                                            @foreach($countries as $country)
                                                @if($article->country_id == $country->id)
                                                    <option selected value="{{ $country->id }}">{{ $country->title }}</option>
                                                @else
                                                    <option value="{{ $country->id }}">{{ $country->title }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



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
                                                    <label class="control-label col-md-3" for="title_{{$localeCode}}">Company Name</label>
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


@endsection