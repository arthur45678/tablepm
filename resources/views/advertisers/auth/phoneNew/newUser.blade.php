@extends('layouts.site')

@section('title')
    Sign Up
@endsection

@section('content')
    <div class="container">
      <h1>We're going to be *BEST* friends</h1>
      <p> Thanks for your interest in signing up! Can you tell us a bit about yourself?</p>

        <form method="post" action="{{ route('user-create') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="" class="form-control">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="" class="form-control">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" value="" class="form-control">
            </div>

            <div class="form-group">
                <label for="country_code">Country code</label>
                <input type="text" name="country_code" id="country_code" value="" class="form-control">
            </div>

            <div class="form-group">
                <label for="phone_number">Phone number</label>
                <input type="text" name="phone_number" id="phone_number" value="" class="form-control">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">sign up</button>
            </div>
        </form>

    </div>
@endsection
