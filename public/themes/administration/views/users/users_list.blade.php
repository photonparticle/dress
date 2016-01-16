@extends('administration::layout')

@section('content')
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="page-content">
    <div class="portlet box blue-madison">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-user"></i>{{trans('global.users_list')}}
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover" id="users_list">
                <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        {{trans('users.first_name')}}
                    </th>
                    <th>
                        {{trans('users.last_name')}}
                    </th>
                    <th>
                        {{trans('users.created_at')}}
                    </th>
                    <th>
                        {{trans('users.actions')}}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{isset($user['id']) ? $user['id'] : 'n/a'}}</td>
                        <td>{{isset($user['email']) ? $user['email'] : 'n/a'}}</td>
                        <td>{{isset($user['first_name']) ? $user['first_name'] : 'n/a'}}</td>
                        <td>{{isset($user['last_name']) ? $user['last_name'] : 'n/a'}}</td>
                        <td>{{isset($user['created_at']) ? $user['created_at'] : 'n/a'}}</td>
                        <td class="text-center">
                            <a href="/admin/users/show/{{isset($user['id']) ? $user['id'] : 'n/a'}}"
                               class="btn btn-icon-only blue"
                               title="{{trans('users.view_profile')}}"
                            >
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="/admin/users/edit/{{isset($user['id']) ? $user['id'] : 'n/a'}}"
                               class="btn btn-icon-only green"
                               title="{{trans('global.edit')}}"
                            >
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="#"
                               class="btn btn-icon-only red"
                               title="{{trans('global.remove')}}"
                               data-id="{{isset($user['id']) ? $user['id'] : ''}}"
                            >
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            Demo.init(); // init demo features
        });
    </script>
@endsection