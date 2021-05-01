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
			<form class="m-form" method="POST" action="{{ route('advertisers.login') }}">
				{{csrf_field()}}

				<div class="m-portlet__body">
					<div class="m-form__section m-form__section--first">
					<h3>Login by email</h3>
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
					</div>
					@if(session('message_login'))
					<p style="color: red; font-size: 16px;">{{session('message_login')}}</p>
					@endif
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions" style="float: right;">
						<button type="submit" class="btn m-btn--square  btn-danger btn-lg">
							Login
						</button>
					</div>
				</div>
			</form>
									<!--end::Form-->
		</div>
	</div>
</div>
@endsection