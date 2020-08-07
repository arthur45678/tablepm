@extends('layouts.site')
@section('content')
<div class="row">
	<div class="col-lg-3"></div>
	<div class="col-lg-6">
		<div class="m-portlet" style="margin-top: 100px">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption" style="background-color: #f4516c">
					<div class="m-portlet__head-title" style="margin:0 auto;">
						<span class="m-portlet__head-icon m--hide">
							<i class="la la-gear"></i>
						</span>
						<h3 class="m-portlet__head-text" style="color: white; font-size: 30px; letter-spacing: 1px;">
							Advertiser
						</h3>
					</div>
				</div>
			</div>
			<!--begin::Form-->
			<form class="m-form" method="POST" action="{{ route('advertiser.register.email') }}">
				{{csrf_field()}}
				<div class="m-portlet__body">
					<div class="m-form__section m-form__section--first">
						<div class="form-group m-form__group">
							<input type="email" class="form-control m-input form-control-lg" placeholder="Email" name="email">
							@if ($errors->has('email'))
								<span class="m-form__help">
									{{ $errors->first('email') }}
								</span>
							@endif
						</div>
						<div class="form-group m-form__group">
							<input type="password" class="form-control m-input form-control-lg" placeholder="Password" name="password">
							@if ($errors->has('password'))
								<span class="m-form__help">
									{{ $errors->first('password') }}
								</span>
							@endif
						</div>
						<div class="form-group m-form__group">
							<input type="password" class="form-control m-input form-control-lg" placeholder="Confirm Password" name="password_confirmation">
							@if ($errors->has('password_confirmation'))
								<span class="m-form__help">
									{{ $errors->first('password_confirmation') }}
								</span>
							@endif
						</div>
						<div class="form-group m-form__group">
							<input type="text" class="form-control m-input form-control-lg" placeholder="Contact Name" name="name">
							@if ($errors->has('name'))
								<span class="m-form__help">
									{{ $errors->first('name') }}
								</span>
							@endif
						</div>
						<div class="form-group m-form__group">
							<input type="text" class="form-control m-input form-control-lg" placeholder="Company Name" name="company_name">
							@if ($errors->has('company_name'))
								<span class="m-form__help">
									{{ $errors->first('company_name') }}
								</span>
							@endif
						</div>
						<div class="form-group m-form__group">
							<select class="form-control m-input m-input--square form-control-lg col-md-2" name="phone_code" id="phone_code" style="float: left;">
                                @foreach($countries as $item)
                                    <option value="{{ $item->phone_code }}">{{ $item->phone_code }}</option>
                                @endforeach
                            </select>
							<input type="number" class="form-control m-input form-control-lg col-md-9" placeholder="Phone Number" name="phone_number">
							@if ($errors->has('phone_number'))
								<span class="m-form__help">
									{{ $errors->first('phone_number') }}
								</span>
							@endif
						</div>
					</div>
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions" style="float: right;">
						<button type="submit" class="btn m-btn--square  btn-danger btn-lg">
							Create Account
						</button>
					</div>
				</div>
			</form>
									<!--end::Form-->
		</div>
	</div>
</div>
@endsection