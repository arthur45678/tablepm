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
                            <form class="form-horizontal" id="updateForm" method="post" action="{{ route('admin.users.update', ['id' => $user->id]) }}">
                                <input type="hidden" name="_method" value="PUT">
                                {{ csrf_field() }}



                                <div class="form-group">
                                    <label class="control-label col-md-3" for="name">Contact Name</label>
                                    <div class="col-md-4">
                                        <input type="text" name="name" id="name" value="{{ isset($user->name) ? $user->name : '' }}" class="form-control">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-md-3" for="email">E-mail</label>
                                    <div class="col-md-4">
                                        <input disabled type="email" name="email" id="email" value="{{ $user->email }}" class="form-control">
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="control-label col-md-3" for="password">Password</label>
                                    <div class="col-md-4">
                                        <input type="password" name="password" id="password" class="form-control">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-md-3" for="role_id">Role</label>
                                    <div class="col-md-4">
                                        <select class="form-control" name="role_id" id="role_id">
                                            @if(isset($roles) && count($roles) > 0)
                                                @foreach($roles as $item)
                                                    @if( $user->roles->implode('id', ',') == $item->id)
                                                        <option selected value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
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