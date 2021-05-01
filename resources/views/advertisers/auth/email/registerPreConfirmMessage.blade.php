@extends('layouts.site')

@section('content')
<div class="verification-sent">
	<div>
		<h3>Verification Email has been sent to {{$email}}</h3>
	</div>
	<br />
	<!-- <div>
		<a href="{{action('Site\IndexController@index')}}" class="btn m-btn--square  btn-danger btn-lg">
			Return to Home
		</a>
	</div> -->
	
</div>
@endsection
<style type="text/css">
	.verification-sent{
	    display: flex;
	    justify-content: center;
	    align-items: center;
	    margin-top: 300px;
	}
</style>
