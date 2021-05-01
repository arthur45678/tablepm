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

                    {{ dump($article) }}
                    <div class="row">
                        <!-- /.table-responsive -->
                        <div class="col-md-12">
                            @if(isset($article->img))
                                <div class="thumbnail">
                                    <img src="{{ $imagePath }}/{{ $article->img }}" alt="">
                                </div>
                            @endif

                        </div>{{--col-md-12--}}

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