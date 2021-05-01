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

                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <!-- /.table-responsive -->
                    <div class="col-md-12">
                        <div class="row">
                            <div class="row">

                                @if(count($articles) > 0)
                                    @foreach($articles as $article)


                                        <div class="col-xs-6 col-md-6">
                                            <h3><a href="{{ route('restaurantShops.show', ['id' => $article->post->id ]) }}">{{ $article->title }}</a></h3>
                                            @if($article->post->img)
                                                <a href="#" class="thumbnail">
                                                    <img style="max-width: 118px" src="{{ $imagePath }}/{{ $article->post->img }}" alt="">
                                                </a>

                                            @else
                                                {{--no-image.jpg--}}
                                                <a href="#" class="thumbnail">
                                                    <img style="max-width: 118px" src="{{ $imagesServe }}/page_no_image.jpg" alt="">
                                                </a>

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

                            </div>
                        </div><!--row-->
                    </div>{{--col-md-12--}}


                    {{$articles->links()}}

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

            $(".panel-title").click(function() {
                $(this).children().children().prop("checked", true);
            });
        });
    </script>
@endsection