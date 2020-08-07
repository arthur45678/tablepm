@extends('layouts.admin')

@section('styles')

@endsection

@section('content')

    <!-- BEGIN PAGE HEADER-->

    <!-- END PAGE HEADER-->
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


                            <div id="map" style="height: 600px; width: 100%;"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        var locations = [

            @foreach($restaurants as $item)
               ['{{ $item->title }}', {{ $item->lat }}, {{ $item->lng }}, 4],
            @endforeach

        ];

        console.log(locations);

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            //   center: new google.maps.LatLng(-33.92, 151.25),
            center: new google.maps.LatLng(22.31920109999999, 114.1696121),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;



        for (i = 0; i < locations.length; i++) {
            //  console.log(locations[i][1]);
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    </script>


@endsection