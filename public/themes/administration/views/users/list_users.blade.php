@extends('administration::layout')

@section('content')
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box blue-madison">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-user"></i>{{$pageTitle}}
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
                        {{trans('global.administrator')}}
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
                        <td>
                            @if(isset($user['admin']))
                                @if($user['admin'] == 1)
                                    {{trans('global.yes')}}
                                @else
                                    {{trans('global.no')}}
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            {{--<a href="/admin/users/show/{{isset($user['id']) ? $user['id'] : 'n/a'}}"--}}
                               {{--class="btn btn-icon-only blue"--}}
                               {{--title="{{trans('users.view_profile')}}"--}}
                            {{-->--}}
                                {{--<i class="fa fa-eye"></i>--}}
                            {{--</a>--}}
                            <a href="/admin/users/edit/{{isset($user['id']) ? $user['id'] : 'n/a'}}"
                               class="btn btn-icon-only green"
                               title="{{trans('global.edit')}}"
                            >
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="#"
                               class="btn btn-icon-only red remove_user"
                               title="{{trans('global.remove')}}"
                               data-id="{{isset($user['id']) ? $user['id'] : ''}}"
                               data-email="{{isset($user['email']) ? $user['email'] : ''}}"
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
<!-- END EXAMPLE TABLE PORTLET-->
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {

            $('.remove_user').click( function () {
                var user_id = $(this).attr('data-id');
                var user_email = $(this).attr('data-email');
                var parent = $(this).closest('tr');

                if(
                    typeof user_id !== typeof undefined && typeof user_email !== typeof undefined &&
                    user_id.length > 0 && user_email.length > 0
                ) {
                    bootbox.dialog({
                       message: "<h4>{{trans('user_notifications.user_remove')}}</h4> <strong>ID:</strong> " + user_id + " <br /><strong>Email:</strong> " + user_email,
                            title: "{{trans('user_notifications.confirm_action')}}",
                            buttons: {
                        cancel: {
                            label: "{{trans('global.no')}}",
                            className: "btn-danger"
                        },
                        confirm: {
                            label: "{{trans('global.yes')}}",
                                className: "btn-success",
                                callback: function () {
                                    $.ajax({
                                       type: 'post',
                                       url: '/admin/users/destroy/' + user_id,
                                       headers: {
                                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                       },
                                       success: function (response) {
                                           if(typeof response == typeof {} && response['status'] && response['message']) {
                                               showNotification(response['status'], response['title'], response['message']);
                                               if(response['status'] == 'success') {
                                                   parent.remove();
                                               }
                                           } else {
                                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                                           }
                                       },
                                       error: function () {
                                           showNotification('error', translate('request_not_completed'), translate('contact_support'));
                                       }

                                   });
                            }
                        }
                    }
                });
                }
            });


            $('#users_list').DataTable({
               responsive: true,
               order: [[0, 'asc']],
               stateSave: true,
               adaptiveHeight: true,
               language: translateData['dataTable']
           });



        });
    </script>
@endsection