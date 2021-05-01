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
                        <!-- <span class="caption-subject font-green sbold uppercase">{{ isset($title) ? $title : 'Admin panel' }}</span> -->
                    </div>

                    <form method="get" action="{{ route('admin.searchRestaurant') }}" enctype="multipart/form-data" class="form-inline">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" name="s" class="form-control" placeholder="Search restaurant" value="{{ isset($s) ? $s : '' }}">
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary">Search</button>
                        </div>

                    </form>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                        <div class="m-section">
                                    <div class="m-section__content">
                                        <table class="table m-table m-table--head-separator-primary">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                             @foreach($articles as $article)
                                                <tr>
                                                    <td><a href="{{ route('admin.RestaurantCompanies.edit', [$article->slug_article])  }}" >{{ $article->title }}</a></td>
                                                    <td><a class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air" href="{{ route('admin.restaurantShopProfile.create', ['slug' => $article->slug_article]) }}"><i class="la la-plus"></i></a></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            {{$articles->links()}}

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection