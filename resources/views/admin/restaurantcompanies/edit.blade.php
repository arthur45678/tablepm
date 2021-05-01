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
		<form class="m-form" method="post" action="{{ route('admin.RestaurantCompanies.update', ['id' => $article->id]) }}" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="put">
			{{csrf_field()}}

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

			{{--Map end--}}


			<div class="m-portlet__body">
				<div class="m-form__section m-form__section--first">


					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label">
							District:
						</label>
						<div class="col-lg-6">
							@if(isset($districts) && count($districts) > 0)

								<select name="district_id" id="district_id" class="form-control select2" data-placeholder="" style="width: 100%;">
									@if($districts)
										@foreach($districts as $item)
											@if($article->district_id == $item->id)
												<option selected value="{{ $item->id }}">{{ $item->getAllTransData($item->id) }}</option>
											@else
												<option value="{{ $item->id }}">{{ $item->getAllTransData($item->id) }}</option>
											@endif
										@endforeach
									@endif
								</select>
							@endif

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
							<input type="text" class="form-control m-input" placeholder="Contact Name" name="name" value="{{ isset($user->name) ? $user->name : '' }}">
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
							<input type="email" class="form-control m-input" placeholder="Email" name="email" value="{{ $user->email }}">
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
										<option value="{{ $item->id }}" @if($item->id == $article->accountType_id) selected @endif>{{ trim($str, '|') }}</option>
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
							@if(isset($customerTypes) && count($customerTypes) > 0)

								<select name="customerTypes[]" id="customerTypes" class="form-control select2" multiple="multiple" data-placeholder="" style="width: 100%;">
									@foreach($customerTypes as $item)
										@if($article && $item->checkHasCustomerTypeRestaurant($article->id))

											<option selected value="{{ $item->id }}">{{ $item->getAllTransData($item->slug) }}</option>
										@else
											<option value="{{ $item->id }}">{{ $item->getAllTransData($item->slug) }}</option>

										@endif
									@endforeach
								</select>
							@endif


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
							@if(isset($restaurantType) && count($restaurantType) > 0)

								<select name="restaurantTypes[]" id="restaurantTypes" class="form-control select2" multiple="multiple" data-placeholder="" style="width: 100%;">
									@foreach($restaurantType as $item)
										@if($article && $item->checkHasRestaurantType($article->id))

											<option selected value="{{ $item->id }}">{{ $item->getAllTransData($item->id) }}</option>
										@else
											<option value="{{ $item->id }}">{{ $item->getAllTransData($item->id) }}</option>

										@endif
									@endforeach
								</select>
							@endif


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
							<input type="text" class="form-control m-input" placeholder="Block" name="block" value="{{ isset($article->block) ? $article->block : '' }}">
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
							<input type="text" class="form-control m-input" placeholder="Floor" name="floor" value="{{ isset($article->floor) ? $article->floor : '' }}">
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
							<input type="text" class="form-control m-input" placeholder="Flat" name="flat" value="{{ isset($article->flat) ? $article->flat : '' }}">
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
							<input type="text" class="form-control m-input" placeholder="Estate Building" name="estate_building" value="{{ isset($article->estate_building) ? $article->estate_building : '' }}">
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
							<input type="text" class="form-control m-input" placeholder="Street" name="street" value="{{ isset($article->street) ? $article->street : '' }}">
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
							<input type="tel" class="form-control m-input" placeholder="Phone" name="phone" value="{{ isset($article->phone) ? $article->phone : '' }}">
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
							<input type="tel" class="form-control m-input" placeholder="Mobile" name="mobile" value="{{ isset($article->mobile) ? $article->mobile : '' }}">
							<span class="m-form__help validation">
							@if($errors->has('mobile'))
									{{$errors->first('mobile')}}
								@endif
						</span>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label">
							Bank account name:
						</label>
						<div class="col-lg-6">
							<input type="text" class="form-control m-input" placeholder="Bank account name" name="bank_account_name" value="{{ isset($article->bank_account_name) ? $article->bank_account_name : '' }}">
							<span class="m-form__help validation">
							@if($errors->has('bank_account_name'))
									{{$errors->first('bank_account_name')}}
								@endif
						</span>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label">
							Bank account number:
						</label>
						<div class="col-lg-6">
							<input type="text" class="form-control m-input" placeholder="Bank account number" name="bank_account_number" value="{{ isset($article->bank_account_number) ? $article->bank_account_number : '' }}">
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
							<input type="text" class="form-control m-input" placeholder="Bank" name="bank" value="{{ isset($article->bank) ? $article->bank : '' }}">
							<span class="m-form__help validation">
							@if($errors->has('bank'))
									{{$errors->first('bank')}}
								@endif
						</span>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label">
							Website URL:
						</label>
						<div class="col-lg-6">
							<input type="url" class="form-control m-input" placeholder="Website URL" name="website_url" value="{{ isset($article->website_url) ? $article->website_url : '' }}">
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
									<option @if($article->country_id == $country->id) selected @endif value="{{ $country->id }}">{{ $country->title }}</option>
								@endforeach
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
                                <?php $trans = $article->trans($localeCode)->first() ?>
								<input type="text" class="form-control m-input" placeholder="" name="title[{{$localeCode}}]" value="{{ isset($trans->title) ? $trans->title : '' }}">
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