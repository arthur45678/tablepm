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
                        <span class="caption-subject font-green sbold uppercase page-name">{{ isset($title) ? $title : 'Admin panel' }}</span>
                    </div>

                    <div class="caption pull-right">
                        <a class="btn btn-outline-success m-btn m-btn--custom" href="{{ route('admin.advertiserCompanies.create') }}">Create</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row" style="display: none;">
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
                        <div class="m-section">
                                    <div class="m-section__content">
                                        <table class="table m-table m-table--head-separator-primary">
                                            <?php $user = \App\User::findOrFail(Auth::user()->id); ?>
                                            <thead>
                                                <tr>
                                                    <th>
                                                        ID
                                                    </th>
                                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                    <th>
                                                        {{ $properties['native'] }}
                                                    </th>
                                                    @endforeach
                                                    <th>
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @if($articles)
                                                @foreach($articles as $article)
                                                    <tr>
                                                        <th scope="row">
                                                            {{ $article->id }}
                                                        </th>
                                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <?php $trans = $article->trans($localeCode)->first() ?>
                                                            @if($trans)
                                                                <td>{{ $trans->title }}</td>
                                                            @else
                                                                <td></td>
                                                            @endif
                                                        @endforeach
                                                        <td>
                                                            
                                                            <!-- <a href="{{ route('admin.users.show', ['id' => $user->id]) }}" class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
                                                                <i class="la la-th-list"></i>
                                                            </a> -->
                                                            
                                                            
                                                            <a href="{{ route('admin.advertiserCompanies.edit', ['id' => $article->id]) }}" class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
                                                                <i class="la la-edit"></i>
                                                            </a>
                                                            <form method="post" action="{{ route('admin.advertiserCompanies.destroy', ['id' => $article->id]) }}" class="userDeleteForm">
                                                                <input type="hidden" name="_method" value="delete">
                                                                {{ csrf_field() }}
                                                               <!--  <a  data-toggle="modal" data-target="#{{ $user->id }}" class="deleteAnchor btn btn-danger" href=""><i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="Delete"></i></a> -->
                                                                <a href="" data-toggle="modal" data-target="#{{ $article->id }}" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
                                                                    <i class="la la-trash"></i>
                                                                </a>

                                                            </form>
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
                                                            </div>
                                                        </td>
                                                        @if($user->bookmarkedAdvertComp()->where(['advert_comp_id' => $article->id])->first())
                                                            <td><a class="btn btn-primary" href="{{ route('admin.bookmarked.deleteAdvertiserCompaniesBookmarked', ['id' => $article->id]) }}"><i class="far fa-bookmark" data-toggle="tooltip" data-placement="left" title=""></i></a></td>

                                                        @else
                                                            <td><a class="btn btn-primary" href="{{ route('admin.bookmarked.addAdvertiserCompaniesBookmark', ['id' => $article->id]) }}"><i class="fas fa-bookmark" data-toggle="tooltip" data-placement="left" title=""></i></a></td>

                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @if($articles)
                            {{$articles->links()}}
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')


@endsection