@extends('layouts.admin')

@section('styles')

@endsection

@s
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

                    <div class="caption pull-right">
                        <a class="btn btn-primary" href="{{ route('admin.advertiserCompanies.create') }}">Create</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        {{--Search--}}

                        <div class="form-group">
                            <input type="text" class="form-control" name="search" id="search">

                            <div class="loading">
                                <div class="loading-bar"></div>
                                <div class="loading-bar"></div>
                                <div class="loading-bar"></div>
                            </div>
                        </div>

                        {{--end Search--}}
                    </div><!--row-->



                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h1>{{ isset($title) ? $title : 'Admin panel' }}</h1>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <th>{{ $properties['native'] }}</th>
                                    @endforeach
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>{{ $article->id }}</td>

                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <?php $trans = $article->trans($localeCode)->first() ?>
                                            @if($trans)
                                                <td>{{ $trans->title }}</td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endforeach
                                        <td><a class="btn btn-primary" href="{{ route('admin.advertiserCompanies.show', ['id' => $article->id]) }}"><i class="fa fa-file" data-toggle="tooltip" data-placement="left" title="Edit"></i></a></td>
                                        <td><a class="deleteAnchor btn btn-primary" href="{{ route('admin.advertiserCompanies.edit', ['id' => $article->id]) }}"><i class="fas fa-edit" data-toggle="tooltip" data-placement="left" title="Edit"></i></a></td>
                                        <td>

                                            <form method="post" action="{{ route('admin.advertiserCompanies.destroy', ['id' => $article->id]) }}">
                                                <input type="hidden" name="_method" value="delete">
                                                {{ csrf_field() }}
                                                <a  data-toggle="modal" data-target="#{{ $article->id }}" class="deleteAnchor btn btn-danger" href=""><i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="Delete"></i></a>

                                            </form>
                                            <!-- Modal -->
                                            <div class="modal fade" id="{{ $article->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="deleteSubmit btn btn-danger">Delete</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>{{--modal--}}
                                        </td>



                                        @if(Auth::user()->bookmarkedRestaurants()->where(['rest_comp_id' => $article->id])->first())
                                            <td><a class="btn btn-primary" href="{{ route('admin.bookmarked.deleteRestaurantCompaniesBookmarked', ['id' => $article->id]) }}"><i class="far fa-bookmark" data-toggle="tooltip" data-placement="left" title=""></i></a></td>

                                        @else
                                            <td><a class="btn btn-primary" href="{{ route('admin.bookmarked.addRestaurantCompaniesBookmark', ['id' => $article->id]) }}"><i class="fas fa-bookmark" data-toggle="tooltip" data-placement="left" title=""></i></a></td>

                                        @endif

                                    </tr>

                                </tbody>
                            </table>

                          



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')


@endsection