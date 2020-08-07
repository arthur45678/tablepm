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
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                        <div class="m-section">
                                    <div class="m-section__content">
                                        <form method="post" action="{{ route('admin.permissions.store') }}" >
                                            {{ csrf_field() }}
                                            <table class="table m-table m-table--head-separator-primary">
                                                <?php $user = \App\User::findOrFail(Auth::user()->id); ?>
                                                <thead>
                                                    <tr>
                                                        <th>Permissions</th>
                                                        @if(!$roles->isEmpty())

                                                            @foreach($roles as $item)
                                                                <th>{{ $item->name}}</th>
                                                            @endforeach

                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @if(!$permissions->isEmpty())
                                                    @foreach($permissions as $val)
                                                        <tr>
                                                            <td>{{ $val->name }}</td>
                                                            @foreach($roles as $role)
                                                                <td>
                                                                    @if($role->hasPermission($val->name))
                                                                    <label class="m-checkbox">
                                                                        <input checked name="{{ $role->id }}[]"  type="checkbox" value="{{ $val->id }}">
                                                                        <span></span>
                                                                    </label>
                                                                        
                                                                    @else
                                                                    <label class="m-checkbox">
                                                                        <input name=" {{ $role->id }}[]"  type="checkbox" value="{{ $val->id }}">
                                                                        <span></span>
                                                                    </label>
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-success">Save</button>
                                                </div>
                                            </div>
                                        </form>
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