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
                                    <form method="post" action="{{ action('Admin\UsersController@approveNewUsers') }}" >
                                    {{ csrf_field() }}
                                        <table class="table m-table m-table--head-separator-primary">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        ID
                                                    </th>
                                                    <!-- <th>
                                                        Name
                                                    </th> -->
                                                    <th>
                                                        Name
                                                    </th>
                                                    <th>
                                                        Email/Login
                                                    </th>
                                                    <th>
                                                        Approve
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <th scope="row">
                                                        {{ $user->id }}
                                                    </th>
                                                    <!-- <td>
                                                        {{ $user->contact_name }}
                                                    </td> -->
                                                    <td>
                                                        {{ $user->name }}
                                                    </td>
                                                    <td>
                                                        {{ $user->email }}
                                                    </td>
                                                    <td>
                                                        <label class="m-checkbox m-checkbox--state-success">
                                                            <input type="checkbox" name="{{$user->id}}" >
                                                            
                                                            <span></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endforeach
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

                            {{$users->links()}}

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