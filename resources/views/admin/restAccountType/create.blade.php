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
	<form class="m-form" method="post" action="{{ route('admin.restAccountType.store') }}">
		{{csrf_field()}}
		<div class="m-portlet__body">
			<div class="m-form__section m-form__section--first">
				<div id="translate">
					<div class="m-portlet__body">
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
		</div>
		<div class="m-portlet__foot m-portlet__foot--fit">
			<div class="m-form__actions m-form__actions">
				<div class="row">
					<div class="col-lg-3"></div>
					<div class="col-lg-6">
						<button type="submit" class="btn btn-success">
							Submit
						</button>

						<a href="{{ route('admin.restAccountType.index') }}" class="btn btn-secondary">Cancel</a>

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

@endsection