@extends('layouts.site')

@section('content')
<div class="verification-sent">
	@if($status == 'success')
	<div>
		<h3>Your email has been verified.</h3>
		<h3>We will contact you shortly to assist you to activate the account.</h3>
	</div>
	@else
	<div>
		<h3>Whoops, something went wrong.</h3>
	</div>
	@endif
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
	    text-align: center;
	}
</style>
