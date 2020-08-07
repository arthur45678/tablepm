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
	<form class="m-form" method="post" action="{{ route('admin.shops.store') }}" enctype="multipart/form-data">
		{{csrf_field()}}
		<div class="m-portlet__body">
			<div class="m-form__section m-form__section--first">
				<div class="form-group m-form__group row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="map_canvas"></div>
                    </div>
                </div>

                {{--Map--}}
                <div class="form-group m-form__group row">

                    <label  class="col-lg-3 col-form-label">Location</label>
                    <div class="col-md-4">
                        <input class="btn btn-secondary" id="find" type="button" value="Find" style="float: right" />
                        <div style="overflow: hidden; padding-right: .5em;">
                        	<input class="form-control m-input" id="geocomplete" type="text" placeholder="" value="" />
                        </div>

                    </div>

                    <input  name="lat" type="hidden" value="">
                    <input name="lng" type="hidden" value="">
					<input name="formatted_address" type="hidden" value="">

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

	<script src="{{ $assetPath }}/default_assets/demo/default/custom/components/jquery_geocomplete/jquery.geocomplete.js"></script>
    <script>
        $(document).ready(function()
        {
            $('#clickmewow').click(function()
            {
                $('#radio1003').attr('checked', 'checked');
            });


            /*Map*/

            $("#geocomplete").geocomplete({
                map: ".map_canvas",
                details: "form",
                blur: true,
                geocodeAfterResult: true
            }) .geocomplete()
                .bind("geocode:result", function(event, result){
                    findStatus = true;
                    $('#findStatus').val(true);
                    console.log(findStatus);
                })
                .bind("geocode:error", function(event, result){
                    findStatus = false;
                    $('#findStatus').val(false);
                    console.log(findStatus);
                });

            $(".select2").select2();

            $("#find").click(function(){
                $("#geocomplete").trigger("geocode")});

            /*Map end*/

        })
    </script>

@endsection