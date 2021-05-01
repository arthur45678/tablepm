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
                        <a class="btn btn-outline-success m-btn m-btn--custom" href="{{ route('admin.users.create') }}">Create</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                        <div class="m-section">
                                    <div class="m-section__content">
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
                                                        Role
                                                    </th>
                                                    <th>
                                                        Action
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
                                                        {{ $user->roles->implode('name', ', ') }}
                                                    </td>
                                                    <td>

                                                        <!-- <a href="{{ route('admin.users.show', ['id' => $user->id]) }}" class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
                                                            <i class="la la-th-list"></i>
                                                        </a> -->


                                                        <a href="{{ route('admin.users.edit', ['id' => $user->id]) }}" class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
                                                            <i class="la la-edit"></i>
                                                        </a>
                                                        <form method="post" action="{{ route('admin.users.destroy', ['id' => $user->id]) }}" class="userDeleteForm">
                                                            <input type="hidden" name="_method" value="delete">
                                                            {{ csrf_field() }}
                                                           <!--  <a  data-toggle="modal" data-target="#{{ $user->id }}" class="deleteAnchor btn btn-danger" href=""><i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="Delete"></i></a> -->
                                                            <a href="" data-toggle="modal" data-target="#{{ $user->id }}" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
                                                                <i class="la la-trash"></i>
                                                            </a>

                                                        </form>
                                                        <div class="modal fade" id="{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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