@extends('layouts.admin')
<?php $assetPath = asset('admin') ?>

@section('styles')


@endsection

@section('content')

    <!-- BEGIN PAGE HEADER-->

    <!-- END PAGE HEADER-->

    {{--Map test--}}



    {{--end Map test--}}
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

                            <div class="form-group">
                                <h5>Restaurant</h5>

                                <div class="col-md-4">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                <th>
                                                    {{ $properties['native'] }}
                                                </th>
                                            @endforeach

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                <?php $trans = $article->trans($localeCode)->first() ?>
                                                @if($trans)
                                                    <td>{{ $trans->title }}</td>
                                                @else
                                                    <td></td>
                                                @endif
                                            @endforeach
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <form id="updateForm" class="form-horizontal" method="post" action="{{ route('admin.restaurantShopProfile.update',  ['id' => $article->id]) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put">

                                {{--
                                {{ isset($article->) ? $article-> : '' }}
                                --}}
                                <input type="hidden" name="parent_id" value="{{ isset($article->parent_id) ? $article->parent_id : ''  }}">

                                {{--Map--}}
                                <div class="form-group">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-4">
                                        <div id="map" style="height: 400px; width: 100%"></div>
                                        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                                    </div>
                                </div>

                                {{--Map--}}
                                <div class="form-group m-form__group row">
                                    <input id="lat"  name="lat" type="hidden" value="{{ isset($article->lat) ? $article->lat : '' }}">
                                    <input id="lng" name="lng" type="hidden" value="{{ isset($article->lng) ? $article->lng : '' }}">
                                    <input name="formatted_address" type="hidden" value="">

                                </div>

                                {{--Map end--}}


                                <div class="row">
                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">
                                            District:
                                        </label>
                                        <div class="col-lg-6">
                                            @if(isset($districts) && count($districts) > 0)

                                                <select name="district_id" id="district_id" class="form-control select2" data-placeholder="" style="width: 100%;">
                                                    @foreach($districts as $item)
                                                        @if($article->district_id == $item->id)
                                                            <option selected value="{{ $item->id }}">{{ $item->getAllTransData($item->id) }}</option>
                                                        @else
                                                            <option value="{{ $item->id }}">{{ $item->getAllTransData($item->id) }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @endif

                                            <span class="m-form__help validation">
							                @if($errors->has('district_id'))
                                                    {{$errors->first('district_id')}}
                                                @endif
						                </span>
                                        </div>
                                    </div>

                                </div><!--row-->



                                @if($article->buisness_registration == '1')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="img">Изображение Категорий</label>
                                                <input name="img" id="img" type="file" class="form-control filestyle" data-buttonName="btn-primary">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                @if($article->img)
                                                    <img style="max-width: 118px" src="{{ $imagePath }}/{{ $article->img }}" alt="">
                                                @else
                                                    {{--no-image.jpg--}}
                                                    <img style="max-width: 118px" src="{{ $imagesServe }}/page_no_image.jpg" alt="">
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="delete_img">Удалить изображение</label>
                                            <input type="checkbox" id="delete_img" name="delete_img">
                                        </div>
                                    </div><!--row-->

                                @endif

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

                                {{--heckHasCuisine--}}
                                @if(isset($cuisines) && count($cuisines) > 0)
                                    <div class="form-group">
                                        <label class="control-label col-md-3" for="cuisines">Cuisine type</label>
                                        <div class="col-md-4">
                                            <select name="cuisines[]" id="cuisines" class="form-control select2" multiple="multiple" data-placeholder="" style="width: 100%;">
                                                @foreach($cuisines as $item)
                                                    @if($article && $item->checkHasCuisine($item->id, $article->id))

                                                        <option selected value="{{ $item->id }}">{{ $item->getAllTransData($item->slug) }}</option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->getAllTransData($item->slug) }}</option>

                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                @endif


                                @if(isset($dishes) && count($dishes) > 0)
                                    <div class="form-group">
                                        <label class="control-label col-md-3" for="">Dish type</label>
                                        <div class="col-md-4">
                                            <select name="dishes[]" id="dishes" class="form-control select2" multiple="multiple" data-placeholder="" style="width: 100%;">
                                                @foreach($dishes as $item)
                                                    @if($article && $item->checkHasDish($item->id, $article->id))

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
                                    <label class="control-label col-md-3" for="wifi_ssid">Wi-Fi SSID</label>
                                    <div class="col-md-4">
                                        <input type="text" name="wifi_ssid" class="form-control" value="{{ isset($article->wifi_ssid) ? $article->wifi_ssid : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="wifi_password">Wi-Fi Password</label>
                                    <div class="col-md-4">
                                        <input type="text" name="wifi_password" class="form-control" value="{{ isset($article->wifi_password) ? $article->wifi_password : '' }}">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-md-3" for="seat_number">Seat number</label>
                                    <div class="col-md-4">
                                        <input type="text" name="seat_number" class="form-control" value="{{ isset($article->seat_number) ? $article->seat_number : '' }}">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="seat_cost">Seat cost</label>
                                    <div class="col-md-4">
                                        <input type="text" name="seat_cost" class="form-control" value="{{ isset($article->seat_cost) ? $article->seat_cost : '' }}">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-md-3" for="sticker_quantity">Sticker quantit</label>
                                    <div class="col-md-4">
                                        <input type="text" name="sticker_quantity" class="form-control" value="{{ isset($article->sticker_quantity) ? $article->sticker_quantity : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="restaurant_status">Restaurant status</label>
                                    <div class="col-md-4">
                                        <input type="text" name="restaurant_status" class="form-control" value="{{ isset($article->restaurant_status) ? $article->restaurant_status : '' }}">
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
                                    <label class="control-label col-md-3" for="bank_account_name">Bank account name</label>
                                    <div class="col-md-4">
                                        <input type="tel" name="bank_account_name" class="form-control" value="{{ isset($article->bank_account_name) ? $article->bank_account_name : '' }}">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="bank_account_number">Bank account number</label>
                                    <div class="col-md-4">
                                        <input type="tel" name="bank_account_number" class="form-control" value="{{ isset($article->bank_account_number) ? $article->bank_account_number : '' }}">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="bank">Bank</label>
                                    <div class="col-md-4">
                                        <input type="tel" name="bank" class="form-control" value="{{ isset($article->bank) ? $article->bank : '' }}">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="link_company_profile">Link the company profile</label>
                                    <div class="col-md-4">
                                        <input type="text" name="link_company_profile" class="form-control" value="{{ isset($article->link_company_profile) ? $article->link_company_profile : '' }}">
                                    </div>
                                </div>

                                {{--Transnate Tab--}}
                                <div id="translate">

                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <div class="form-group m-form__group row">
                                            <label class="col-lg-3 col-form-label">
                                                Name {{ $properties['native'] }}:
                                            </label>
                                            <div class="col-lg-6">
                                                <?php $trans = $article->trans($localeCode)->first() ?>
                                                <input type="text" class="form-control m-input" placeholder="" name="title[{{$localeCode}}]" value="{{ isset($trans->title) ? $trans->title : '' }}">
                                                <span class="m-form__help validation">

							                    </span>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
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