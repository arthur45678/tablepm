@extends('layouts.site')

@section('styles')

@endsection

@section('content')
    <?php $imagePath = asset('images') ?>
    <?php $imagesServe = asset('imagesServe') ?>
    <!-- BEGIN PAGE HEADER-->

    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered calendar">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">{{ isset($title) ? $title : 'Site' }}</span>
                    </div>

                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h1>Register</h1>


                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#advertiser" aria-controls="advertiser" role="tab" data-toggle="tab">Advertiser</a></li>
                                <li role="presentation"><a href="#restaurant_ower" aria-controls="restaurant_ower" role="tab" data-toggle="tab">Restaurant ower</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="advertiser">
                                    <a href="{{ route('advertiser.register.email') }}">E-mail</a><br>
                                    <a href="{{ route('advertiser.register.phone') }}">Phone</a>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="restaurant_ower">...</div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function()
        {
            $('#clickmewow').click(function()
            {
                $('#radio1003').attr('checked', 'checked');
            });

            $('.deleteSubmit').on('click', function () {
                $(this).closest('td').find('form').submit();
            });
        })
    </script>

@endsection