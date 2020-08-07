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

                    <div class="caption pull-right">
                        <a class="btn btn-outline-success m-btn m-btn--custom" href="{{ route('admin.customerTypesRestaurants.create') }}">Create</a>
                    </div>
                </div>
                <div class="portlet-body">
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
                                                        
                                                        
                                                        <a href="{{ route('admin.customerTypesRestaurants.edit', ['id' => $article->id]) }}" class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
                                                            <i class="la la-edit"></i>
                                                        </a>
                                                        <form method="post" action="{{ route('admin.customerTypesRestaurants.destroy', ['id' => $article->id]) }}" class="userDeleteForm">
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
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            {{--Pagination--}}
                            <nav  aria-label="Page navigation">
                                <ul class="pagination">
                                    @if(isset($articles))
                                        @if($articles->lastPage() > 1)

                                            @if($articles->currentPage() !== 1)
                                                <li class="disabled">
                                                    <a aria-label="Previous" href="{{ $articles->url(($articles->currentPage() - 1)) }}">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                            @endif

                                            @for($i = 1; $i <= $articles->lastPage(); $i++)
                                                @if($articles->currentPage() == $i)
                                                    <li class="active">
                                                        <a class="disabled">{{ $i }}</a>

                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="{{ $articles->url($i) }}">{{ $i }}</a>

                                                    </li>
                                                @endif
                                            @endfor

                                            @if($articles->currentPage() !== $articles->lastPage())
                                                <li>
                                                    <a aria-label="Next" href="{{ $articles->url(($articles->currentPage() + 1)) }}">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif

                                    @endif
                                </ul>
                            </nav>{{--Pagination end--}}

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