@extends('layouts.advertiser')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <h3>Advertiser</h3>

                    <p>Create an account by phone number</p>
                    <form method="POST" action="{{ route('advertiser.register.phone') }}">
                        @csrf




                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"></label>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <select class="form-control" name="phone_code" id="phone_code">
                                            @foreach($countries as $item)
                                                <option value="{{ $item->phone_code }}">{{ $item->phone_code }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-8">
                                        <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" placeholder="Phone number" required autofocus>
                                    </div>
                                </div><!--row-->


                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Create Account
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
