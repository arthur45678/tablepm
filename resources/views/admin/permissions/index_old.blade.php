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

                            <form class="form-horizontal" method="post" action="{{ route('admin.permissions.store') }}">
                                {{ csrf_field() }}

                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Привилегии</th>
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
                                                            <input checked name="{{ $role->id }}[]"  type="checkbox" value="{{ $val->id }}">
                                                        @else
                                                            <input name=" {{ $role->id }}[]"  type="checkbox" value="{{ $val->id }}">
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach

                                    @endif
                                    </tbody>
                                </table>


                                <div class="form-group">
                                    <label class="control-label col-md-6" for="website_url"></label>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-default green">Save</button>
                                    </div>
                                </div>
                            </form>
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
        })
    </script>

@endsection