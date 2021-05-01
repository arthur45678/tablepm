<div class="row clearfix">
    <br>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        @if(Session::has('fail'))
            <div class="alert alert-danger">
                <strong>{{ Session::get('fail') }}</strong>
            </div>
        @endif

        @if(Session::has('warning'))
            <div class="alert alert-danger">
                <strong>{{ Session::get('warning') }}</strong>
            </div>
        @endif

        @if(Session::has('success'))
            <div class="alert alert-success">
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>{{--row clearfix--}}





