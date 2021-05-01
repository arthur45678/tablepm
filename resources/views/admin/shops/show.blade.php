@extends('layouts.admin')

@section('styles')
	<link rel="stylesheet" href="{{ $assetPath }}/default_assets/demo/default/custom/components/jquery_geocomplete/map.css">

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
	<form class="m-form" method="post" action="{{ route('admin.shops.update', ['id' => $article->id]) }}" enctype="multipart/form-data">
		<input type="hidden" name="_method" value="put">
		{{csrf_field()}}
		<div class="m-portlet__body">
			<div class="m-form__section m-form__section--first">
				<div class="form-group m-form__group row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
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

				<div id="translate">

						@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <div role="{{$localeCode}}" class="tab-pane {{ (App::getLocale() ==  $localeCode) ? 'active' : ''}}" id="tab_{{$localeCode}}">

                                <?php $trans = $article->trans($localeCode)->first() ?>
                                <div class="form-group">
                                    <label class="control-label col-md-3" for="title_{{$localeCode}}">Company Name {{ $properties['native'] }}</label>
                                    <div class="col-md-4">
                                        <input type="text" name="title[{{$localeCode}}]" id="title_{{$localeCode}}" value="{{ isset($trans->title) ? $trans->title : '' }}" class="form-control" placeholder="Company Name {{$localeCode}}" class="form-control" placeholder="Company Name">
                                    </div>
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

						<a href="{{ route('admin.shops.index')}}" class="btn btn-secondary">Cancel</a>

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