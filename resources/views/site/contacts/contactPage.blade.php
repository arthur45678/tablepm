@extends('layouts.site')

@section('styles')

    <link rel="stylesheet" href="{{ $assetPath }}/vendor/select2/select2.min.css">
@endsection

@section('sidebar')
    @if(isset($sidebar))
        {!! $sidebar !!}
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ isset($title) ? $title : '' }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ isset($title) ? $title : '' }}
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form method="post" action="{{ route('contacts.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="" class="form-control">
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <p>Contact number</p>
                                <div class="col-md-3">
                                    <select class="form-control" name="phone_code" id="">
                                        @foreach($countries as $item)
                                            <option value="{{ $item->phone_code }}">{{ $item->phone_code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-9">
                                    <input  class="form-control" type="text" name="contact_number">
                                </div>
                            </div><!--row-->
                        </div>

                        <div class="form-group">
                            <label for="company_name">Company name</label>
                            <input id="company_name" type="text" name="company_name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="text" name="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Text</label>
                            <textarea class="form-control" name="text" id="text" cols="30" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary">submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
@endsection

@section('scripts')
    <script src="{{ $assetPath }}/vendor/select2/select2.full.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".select2").select2();


        });
    </script>
@endsection