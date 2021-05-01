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

                        @foreach($articles as $article)
                            <article>
                                <?php $trans = $article->trans(App::getLocale())->first() ?>
                                @if($trans)
                                    <h3>{{ $trans->title }}</h3>
                                    <a class="pull-right btn btn-primary" href="{{ route('bookmarked.deleteRestaurantShopBookmarked', ['id' => $article->id]) }}"><i class="far fa-bookmark" data-toggle="tooltip" data-placement="left" title=""></i></a>

                                    <p>Street: {{ $article->street }}</p>
                                    <p>Seat number: {{ $article->seat_number }}</p>
                                @else

                                @endif
                            </article>
                        @endforeach

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