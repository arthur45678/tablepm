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


                            @foreach($articles as $item)

                             <?php $trans = $item->trans(App::getLocale())->first() ?>

                              @if($trans)
                                <div class="col-xs-6 col-md-6">
                                    <h3>{{ $trans->title }}</h3>
                                    @if($item->img)
                                        <a href="#" class="thumbnail">
                                            <img src="{{ $imagePath }}/{{ $item->img }}" alt="...">
                                        </a>
                                    @else
                                        <a href="#" class="thumbnail">
                                            <img style="max-width: 118px" src="{{ $imagesServe }}/page_no_image.jpg" alt="">
                                        </a>
                                    @endif

                                </div>
                              @else

                              @endif

                            @endforeach




                    </div>{{--col-md-12--}}

                    {{$articles->appends(request()->except('page'))->links()}}

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