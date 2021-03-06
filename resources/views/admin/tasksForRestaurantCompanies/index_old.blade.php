@extends('layouts.admin')

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
                        <span class="caption-subject font-green sbold uppercase">{{ isset($title) ? $title : 'Admin panel' }}</span>
                    </div>

                    <div class="caption pull-right">
                        <a class="btn btn-primary" href="{{ route('admin.tasksForRestaurantCompanies.create') }}">Create</a>
                        <br><br>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">


                            <?php $user = \App\User::findOrFail(Auth::user()->id); ?>
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
                                @foreach($articles as $article)
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
                                        <td>


                                            <a  data-toggle="modal" data-target="#{{ $article->id }}" class="sendAnchor btn btn-primary" href="">Add Task</a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="{{ $article->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="{{ route('admin.tasksForRestaurantCompanies.store') }}">
                                                                <input type="hidden" name="restCompanies_id" value="{{ $article->id }}">
                                                                {{ csrf_field() }}
                                                                <div class="form-group">
                                                                    <label for="title" class="control-label">Title</label>
                                                                    <input name="title" type="text" class="form-control" id="title">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="text" class="control-label">Message:</label>
                                                                    <textarea name="text" class="form-control" id="text"></textarea>
                                                                </div>

                                                            </form>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="sendSubmit btn btn-primary">Delete</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>{{--modal--}}
                                        </td>


                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

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

            $('.sendSubmit').on('click', function () {
                $(this).closest('td').find('form').submit();

            });
        })
    </script>

@endsection