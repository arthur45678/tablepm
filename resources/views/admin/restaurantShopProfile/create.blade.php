@extends('layouts.admin')

@section('styles')

@endsection

@section('content')

<div class="m-portlet">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<span class="m-portlet__head-icon m--hide">
					<i class="la la-gear"></i>
				</span>
				<h3 class="m-portlet__head-text">
					{{ isset($title) ? $title : 'Admin panel' }}
				</h3>
			</div>
		</div>
	</div>




	<!--begin::Form-->
	<form class="m-form" method="post" action="{{ route('admin.restaurantShopProfile.store') }}" enctype="multipart/form-data">
		{{csrf_field()}}
		<input type="hidden" name="parent_id" value="{{ $parent_id }}">

		<div class="m-portlet__body">
			<h5>Restaurant</h5>

			<div class="form-group m-form__group row ">
				<div class="col-lg-3"></div>
				<div class="col-lg-6">
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
                                <?php $trans = $restaurant->trans($localeCode)->first() ?>
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

		</div>

		<div class="m-portlet__body">
				<div class="m-form__section m-form__section--first">
					<div class="form-group m-form__group row">
					<div class="col-md-3"></div>
					<div class="col-md-4" style="">
						<div class="map_canvas"></div>
					</div>
				</div>


					{{--Map--}}
					<div class="form-group m-form__group row">
						<div class="col-md-3"></div>
						<div class="col-md-6 text-center">
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
					{{--map--}}

                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">
                        District:
                    </label>
                    <div class="col-lg-6">
                        <select class="form-control select2" name="district_id">
                            <optgroup label="district_id" id="district_id">
                                @foreach($districts as $item)
                                    <?php $str = ''; ?>
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <?php $trans = $item->trans($localeCode)->first() ?>
                                        @if($trans)
                                            <?php $str .=  $trans->title . '|' ?>
                                        @endif
                                    @endforeach
                                    <option value="{{ $item->id }}">{{ trim($str, '|') }}</option>
                                @endforeach
                            </optgroup>
                        </select>

                        <span class="m-form__help validation">
                            @if($errors->has('district_id'))
                                {{$errors->first('district_id')}}
                            @endif
                        </span>
                    </div>
                </div>
				<div class="form-group m-form__group row">
					<label for="exampleInputEmail1" class="col-lg-3 col-form-label">
						Image
					</label>
					<div></div>
					<div class="custom-file col-lg-6">
						<input type="file" name="img" class="custom-file-input form-control m-input" id="customFile">
						<label class="custom-file-label" for="customFile">
							Choose file
						</label>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Block:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Block" name="block" @if(old('block')) value="{{old('block')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('block'))
								{{$errors->first('block')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Floor:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Floor" name="floor" @if(old('floor')) value="{{old('floor')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('floor'))
								{{$errors->first('floor')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Flat:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Flat" name="flat" @if(old('flat')) value="{{old('flat')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('flat'))
								{{$errors->first('flat')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Estate Building:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Estate Building" name="estate_building" @if(old('estate_building')) value="{{old('estate_building')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('estate_building'))
								{{$errors->first('estate_building')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Street:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Street" name="street" @if(old('street')) value="{{old('street')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('street'))
								{{$errors->first('street')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Website URL:
					</label>
					<div class="col-lg-6">
						<input type="url" class="form-control m-input" placeholder="Website URL" name="website_url" @if(old('website_url')) value="{{old('website_url')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('website_url'))
								{{$errors->first('website_url')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Country:
					</label>
					<div class="col-lg-6">
						<select class="form-control" name="country_id" id="country_id">

                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->title }}</option>
                            @endforeach
	                    </select>

						<span class="m-form__help validation">
							@if($errors->has('country_id'))
								{{$errors->first('country_id')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Cuisine type
					</label>
					<div class="col-lg-6">
						<div class="form-group m-form__group row">
							<div class="col-lg-4 col-md-9 col-sm-12">
								<select class="form-control m-bootstrap-select m_selectpicker" name="cuisines[]" id="cuisines" multiple>
									@foreach($cuisines as $item)
                                        <option value="{{ $item->id }}">{{ $item->getAllTransData($item->slug) }}</option>
                                    @endforeach
								</select>
							</div>
						</div>

						<span class="m-form__help validation">
							@if($errors->has('cuisines'))
								{{$errors->first('cuisines')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Dish type
					</label>
					<div class="col-lg-6">
						<div class="form-group m-form__group row">
							<div class="col-lg-4 col-md-9 col-sm-12">
								<select class="form-control m-bootstrap-select m_selectpicker" name="dishes[]" id="dishes" multiple>
									@foreach($dishes as $item)
                                        <option value="{{ $item->id }}">{{ $item->getAllTransData($item->slug) }}</option>
                                    @endforeach
								</select>
							</div>
						</div>

						<span class="m-form__help validation">
							@if($errors->has('dishes'))
								{{$errors->first('dishes')}}
							@endif
						</span>
					</div>
				</div>

				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Opening hours:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Opening hours" name="opening_hours" @if(old('opening_hours')) value="{{old('opening_hours')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('opening_hours'))
								{{$errors->first('opening_hours')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Wi-Fi SSID:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Wi-Fi SSID" name="wifi_ssid" @if(old('wifi_ssid')) value="{{old('wifi_ssid')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('wifi_ssid'))
								{{$errors->first('wifi_ssid')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Wi-Fi Password:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Wi-Fi Password" name="wifi_password" @if(old('wifi_password')) value="{{old('wifi_password')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('wifi_password'))
								{{$errors->first('wifi_password')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Seat number:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Seat number" name="seat_number" @if(old('seat_number')) value="{{old('seat_number')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('seat_number'))
								{{$errors->first('seat_number')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Sticker Quantity:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Sticker Quantity" name="sticker_quantity" @if(old('sticker_quantity')) value="{{old('sticker_quantity')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('sticker_quantity'))
								{{$errors->first('sticker_quantity')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Restaurant Status:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Restaurant Status" name="restaurant_status" @if(old('restaurant_status')) value="{{old('restaurant_status')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('restaurant_status'))
								{{$errors->first('restaurant_status')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Email:
					</label>
					<div class="col-lg-6">
						<input type="email" class="form-control m-input" placeholder="Email" name="email" @if(old('email')) value="{{old('email')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('email'))
								{{$errors->first('email')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Phone:
					</label>
					<div class="col-lg-6">
						<input type="tel" class="form-control m-input" placeholder="Phone" name="phone" @if(old('phone')) value="{{old('phone')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('phone'))
								{{$errors->first('phone')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Mobile:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Mobile" name="mobile" @if(old('mobile')) value="{{old('mobile')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('mobile'))
								{{$errors->first('mobile')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Bank Account Name:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Bank Account Name" name="bank_account_name" @if(old('bank_account_name')) value="{{old('bank_account_name')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('bank_account_name'))
								{{$errors->first('bank_account_name')}}
							@endif
						</span>
					</div>
				</div>
				
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Bank Account Number:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Bank Account Number" name="bank_account_number" @if(old('bank_account_number')) value="{{old('bank_account_number')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('bank_account_number'))
								{{$errors->first('bank_account_number')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Bank:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Bank" name="bank" @if(old('bank')) value="{{old('bank')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('bank'))
								{{$errors->first('bank')}}
							@endif
						</span>
					</div>
				</div>

				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Link the Company Profile:
					</label>
					<div class="col-lg-6">
						<input type="url" class="form-control m-input" placeholder="Link the Company Profile" name="link_company_profile" @if(old('link_company_profile')) value="{{old('link_company_profile')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('link_company_profile'))
								{{$errors->first('link_company_profile')}}
							@endif
						</span>
					</div>
				</div>

				<div id="translate">
					@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
						<div class="form-group m-form__group row">
							<label class="col-lg-3 col-form-label">
								Name {{ $properties['native'] }}:
							</label>
							<div class="col-lg-6">
								<input type="text" class="form-control m-input" placeholder="" name="title[{{$localeCode}}]">
								<span class="m-form__help validation">

							</span>
							</div>
						</div>
					@endforeach

                </div>

			</div>
		</div>
		<div class="m-portlet__foot m-portlet__foot--fit">
			<div class="m-form__actions m-form__actions">
				<div class="row">
					<div class="col-lg-3"></div>
					<div class="col-lg-6">
						<button type="submit" class="btn btn-success">
							Submit
						</button>
						<a class="btn btn-secondary"  href="{{ route('admin.advertiserCompanies.index') }}">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!--end::Form-->
</div>


@endsection

@section('scripts')


@endsection