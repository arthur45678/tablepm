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


    <script>
        $(document).ready(function()
        {
            $('#clickmewow').click(function()
            {
                $('#radio1003').attr('checked', 'checked');
            });


        })
    </script>

	<script>
        // This example adds a search box to a map, using the Google Place Autocomplete
        // feature. People can enter geographical searches. The search box will return a
        // pick list containing a mix of places and predicted search terms.

        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:

        function initAutocomplete() {

            var map = new google.maps.Map(document.getElementById('map'), {
                @if(isset($article->lat) && isset($article->lat ))
					center: new google.maps.LatLng({{ isset($article->lat) ? $article->lat : '' }}, {{ isset($article->lng) ? $article->lng : '' }}),

				@else

                @endif

                zoom: 13,
                mapTypeId: 'roadmap'
            });

            // Create the search box and link it to the UI element.
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());

            });

            var markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function() {

                /*Get latitude and longitude*/
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    "address": input.value
                },function(results){
                    raw = results;
                    for (var i=0; i < results[0].address_components.length; i++) {
                        for (var j=0; j < results[0].address_components[i].types.length; j++) {
                            //find country name
                            if (results[0].address_components[i].types[j] == "country") {
                                var latitude = results[0].geometry.location.lat();
                                var longitude = results[0].geometry.location.lng();
                                var countryCode = results[0].address_components[i].short_name;
                                var countryName = results[0].address_components[i].long_name;

                                $('#lat').val(latitude);
                                $('#lng').val(longitude);

                            }

                            //find city name
                            if(results[0].address_components[i].types[j] == "locality") {
                                var cityName = 	results[0].address_components[i].long_name;

                            }
                        }
                    }

                });/* end Get latitude and longitude*/

                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };

                    // Create a marker for each place.
                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        title: place.name,
                        position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        }

	</script>

			async defer></script>--}}

@endsection