@extends('layouts.admin')
<?php $assetPath = asset('admin') ?>

@section('styles')

@endsection

@section('content')

    <!-- BEGIN PAGE HEADER-->

    <!-- END PAGE HEADER-->

    {{--Map test--}}



    {{--end Map test--}}
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered calendar">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">{{ isset($title) ? $title : 'Admin panel' }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div id="map" style="height: 700px; width: 100%;"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')


@endsection