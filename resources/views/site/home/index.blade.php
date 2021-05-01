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
                    <div class="row">
                        <!-- /.table-responsive -->
                        <div class="col-md-12">
                            <h4><a href="{{ route('searchAdvanced.index') }}">Advanced search</a></h4>

                            <form method="get" action="{{ route('searchByDistrict') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <select class="form-control select2" name="district_id">
                                        <optgroup label="" id="district_id">
                                            @foreach($districtsTrans as $item)

                                                <option value="{{ $item->district_id }}">{{ $item->title }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>{{--col-md-12--}}

                    </div><!--row-->


                    <div class="row">
                        @if(count($articles) > 0)

                            <h3>Restaurant Network</h3>
                            @foreach($articles as $article)


                                <div class="col-xs-6 col-md-6">
                                    <h3><a href="">{{ $article->title }}</a></h3>
                                    @if($article->post->img)
                                        <a href="#" class="thumbnail">
                                            <img style="max-width: 118px" src="{{ $imagePath }}/{{ $article->post->img }}" alt="">
                                        </a>
                                    @else
                                        {{--no-image.jpg--}}
                                        <a href="#" class="thumbnail">
                                            <img style="max-width: 118px" src="{{ $imagesServe }}/page_no_image.jpg" alt="">
                                        </a>

                                        <h6>District: {{ $article->post->district->trans(App::getLocale())->first()->title }}</h6>
                                        <h6>Street: {{ $article->post->street }}</h6>
                                        <h6>Seat numbers: {{ $article->post->seat_number }}</h6>

                                    @endif

                                    @if(Auth::user()->bookmarkedRestaurantShop()->where(['restShop_id' => $article->post->id])->first())
                                        <a class="btn btn-primary" href="{{ route('bookmarked.deleteRestaurantShopBookmarked', ['id' => $article->post->id]) }}"><i class="far fa-bookmark" data-toggle="tooltip" data-placement="left" title=""></i></a>
                                    @else
                                        <a class="btn btn-primary" href="{{ route('bookmarked.addRestaurantShopBookmark', ['id' => $article->post->id]) }}"><i class="fas fa-bookmark" data-toggle="tooltip" data-placement="left" title=""></i></a>
                                    @endif
                                </div>
                            @endforeach
                        @else

                        @endif
                    </div><!--row-->

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