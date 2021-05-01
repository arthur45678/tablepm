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
						Create Advertiser Company
					</h3>
				</div>
			</div>
		</div>
		<!--begin::Form-->
		<form class="m-form" method="post" action="{{ route('admin.advertiserCompanies.update', ['id' => $article->id]) }}" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="put">

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

					{{--Map end--}}




					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label">
							Contact Name:
						</label>
						<div class="col-lg-6">
							<input type="text" class="form-control m-input" placeholder="Contact Name" name="name" @if(isset($user)) value="{{ $user->name }}" @endif>
							<span class="m-form__help validation">
							@if($errors->has('name'))
									{{$errors->first('name')}}
								@endif
						</span>
						</div>
					</div>

					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label">
							District:
						</label>
						<div class="col-lg-6">
							@if(isset($districts) && count($districts) > 0)

								<select name="district_id" id="customerTypes" class="form-control select2" data-placeholder="" style="width: 100%;">
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

					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label">
							Email:
						</label>
						<div class="col-lg-6">
							<input type="email" class="form-control m-input" placeholder="Email" name="email" @if($user) value="{{ $user->email }}" @endif>
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
						<div class="col-md-4">
							@if($article->img)
								<img style="max-width: 118px" src="{{ $imagePath }}/{{ $article->img }}" alt="">
							@else
								{{--no-image.jpg--}}
								<img style="max-width: 118px" src="{{ $imagesServe }}/page_no_image.jpg" alt="">
							@endif
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
							District:
						</label>
						<div class="col-lg-6">
							<input type="text" class="form-control m-input" placeholder="District" name="district" value="{{ isset($article->district) ? $article->district : '' }}">
							<span class="m-form__help validation">
							@if($errors->has('district'))
									{{$errors->first('district')}}
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
							<input type="text" class="form-control m-input" placeholder="Mobile" name="mobile" value="{{ isset($article->mobile) ? $article->mobile : '' }}">
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
							Industries:
						</label>
						<div class="col-lg-6">
							<select name="industries[]" id="industries" class="form-control select2" multiple="multiple" data-placeholder="" style="width: 100%;">
								<optgroup label="Industries" id="industriesOptGroup">
									@foreach($industries as $item)
										@if($article && $item->checkHasIndustry($item->id, $article->id))
											<option selected value="{{ $item->id }}">{{ $item->getAllTransData($item->slug) }}</option>
										@else
											<option value="{{ $item->id }}">{{ $item->getAllTransData($item->slug) }}</option>
										@endif
									@endforeach
								</optgroup>
							</select>

							<span class="m-form__help validation">
							@if($errors->has('industries'))
									{{$errors->first('industries')}}
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
									@if($article->country_id == $country->id)
										<option selected value="{{ $country->id }}">{{ $country->title }}</option>
									@else
										<option value="{{ $country->id }}">{{ $country->title }}</option>
									@endif
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
								Company Name {{ $properties['native'] }}:
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