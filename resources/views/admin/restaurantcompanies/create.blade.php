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
	<form class="m-form" method="post" action="{{ route('admin.RestaurantCompanies.store') }}" enctype="multipart/form-data">
		{{csrf_field()}}
		<div class="m-portlet__body">
			<div class="m-form__section m-form__section--first">


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
							<optgroup label="" id="district_id">
								@if($districts)
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
								@endif
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
					<label class="col-lg-3 col-form-label">
						Contact Name:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Contact Name" name="name" @if(old('name')) value="{{old('name')}}" @endif>
						<span class="m-form__help validation">
							@if($errors->has('name'))
								{{$errors->first('name')}}
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
						Password:
					</label>
					<div class="col-lg-6">
						<input type="password" class="form-control m-input" placeholder="Password" name="password">
						<span class="m-form__help validation">
							@if($errors->has('password'))
								{{$errors->first('password')}}
							@endif
						</span>
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Confirm Password:
					</label>
					<div class="col-lg-6">
						<input type="password" class="form-control m-input" placeholder="Confirm Password" name="password_confirmation">
						<span class="m-form__help validation">
							@if($errors->has('password_confirmation'))
								{{$errors->first('password_confirmation')}}
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
						Restaurant account type:
					</label>
					<div class="col-lg-6">
						<select class="form-control" name="accountType_id" id="accountType_id">
						@if($accountTypes)
                            @foreach($accountTypes as $item)
                            	<?php $str = ''; ?>
                            	@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <?php $trans = $item->trans($localeCode)->first() ?>
                                    @if($trans)
                                        <?php $str .=  $trans->title . '|' ?>
                                    @endif
                                @endforeach
                                <option value="{{ $item->id }}">{{ trim($str, '|') }}</option>
                            @endforeach
                        @endif
	                    </select>

						<span class="m-form__help validation">
							@if($errors->has('accountType_id'))
								{{$errors->first('accountType_id')}}
							@endif
						</span>
					</div>
				</div>

				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Customer Types:
					</label>
					<div class="col-lg-6">
						<select class="form-control select2" name="customerTypes[]" id="m_select2_2" multiple>
							<optgroup label="Industries" id="customerTypesOptGroup">
							@if($customerTypes)
	                            @foreach($customerTypes as $item)
	                                <?php $str = ''; ?>
	                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
	                                    <?php $trans = $item->trans($localeCode)->first() ?>
	                                        @if($trans)
	                                            <?php $str .=  $trans->title . '|' ?>
	                                        @endif
	                                @endforeach
	                                    <option value="{{ $item->id }}">{{ trim($str, '|') }}</option>
	                            @endforeach
	                        @endif
	                        </optgroup>
	                    </select>

						<span class="m-form__help validation">
							@if($errors->has('customerTypes'))
								{{$errors->first('customerTypes')}}
							@endif
						</span>
					</div>
				</div>

				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Restaurant Types:
					</label>
					<div class="col-lg-6">
						<select class="form-control select2" name="restaurantTypes[]" id="m_restaurantType" multiple>
							<optgroup label="Industries" id="restaurantTypeOptGroup">
								@if($restaurantType)
									@foreach($restaurantType as $item)
	                                    <?php $str = ''; ?>
										@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
	                                        <?php $trans = $item->trans($localeCode)->first() ?>
											@if($trans)
	                                            <?php $str .=  $trans->title . '|' ?>
											@endif
										@endforeach
										<option value="{{ $item->id }}">{{ trim($str, '|') }}</option>
									@endforeach
								@endif
							</optgroup>
						</select>

						<span class="m-form__help validation">
							@if($errors->has('restaurantType'))
								{{$errors->first('restaurantType')}}
							@endif
						</span>
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
						@if($countries)
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->title }}</option>
                            @endforeach
                        @endif
	                    </select>

						<span class="m-form__help validation">
							@if($errors->has('country_id'))
								{{$errors->first('country_id')}}
							@endif
						</span>
					</div>
				</div>

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
		<div class="m-portlet__foot m-portlet__foot--fit">
			<div class="m-form__actions m-form__actions">
				<div class="row">
					<div class="col-lg-3"></div>
					<div class="col-lg-6">
						<button type="submit" class="btn btn-success">
							Submit
						</button>

						<a href="{{ route('admin.RestaurantCompanies.index')}}" class="btn btn-secondary">Cancel</a>

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