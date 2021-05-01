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
					Edit User
				</h3>
			</div>
		</div>
	</div>

	<!--begin::Form-->
	<form class="m-form" method="post" action="{{ route('admin.users.update', ['id' => $user->id]) }}">
		<input type="hidden" name="_method" value="put">
		{{csrf_field()}}
		<div class="m-portlet__body">
			<div class="m-form__section m-form__section--first">
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">
						Contact Name:
					</label>
					<div class="col-lg-6">
						<input type="text" class="form-control m-input" placeholder="Contact Name" name="name" value="{{ $user->name }}">
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
						<input type="email" class="form-control m-input" placeholder="Email" name="email" value="{{$user->email}}">
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
					<label class="col-lg-3 col-form-label">
						Confirm Password:
					</label>
					<div class="col-lg-6">
						<select class="form-control" name="role_id" id="role_id">
	                        @if(isset($roles) && count($roles) > 0)
	                            @foreach($roles as $item)
	                                <option value="{{ $item->id }}" @if($user->role_id == $item->id) selected @endif>{{ $item->name }}</option>
	                            @endforeach
	                        @endif
	                    </select>
						<span class="m-form__help validation">
							@if($errors->has('role_id'))
								{{$errors->first('role_id')}}
							@endif
						</span>
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
						<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
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
            $('#saveForm').on('click', function () {

                $('#updateForm').submit();
            });

        })
    </script>

@endsection