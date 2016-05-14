@extends('administration::layout')

@section('content')
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box blue-madison">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-archive"></i>{{$pageTitle}}
            </div>
        </div>
        <div class="portlet-body">
            @if(!empty($products) && is_array($products))
                <table class="table table-striped table-bordered table-hover" id="products_list">
                    <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            {{trans('products.image')}}
                        </th>
                        <th>
                            {{trans('products.title')}}
                        </th>
                        <th>
                            {{trans('products.quantity')}}
                        </th>
                        <th>
                            {{trans('products.price')}}
                        </th>
                        <th>
                            {{trans('products.active')}}
                        </th>
                        <th>
                            {{trans('global.actions')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{isset($product['id']) ? $product['id'] : 'n/a'}}</td>
                            <td>
                                @if(!empty($product['image']))
                                    <img src="{{$thumbs_path . $product['id'] . '/' . $icon_size . '/' .  $product['image']}}" alt="{{$product['image']}}" class="img-responsive" style="max-width:150px; margin: auto"/>
                                @endif
                            </td>
                            <td>{{isset($product['title']) ? $product['title'] : 'n/a'}}</td>
                            <td>{{isset($product['quantity']) ? $product['quantity'] : '0'}}</td>
                            <td>{{isset($product['price']) ? $product['price'] : '0'}}</td>
                            <td>
                                @if(isset($product['active']))
                                    @if($product['active'] == 1)
                                        {{trans('products.activated')}}
                                    @else
                                        {{trans('products.not_activated')}}
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="javascript:;"
                                   class="btn btn-icon-only blue copy-product"
                                   title="{{trans('products.duplicate')}}"
                                   data-id="{{$product['id'] or ''}}"
                                >
                                    <i class="fa fa-code-fork" aria-hidden="true"></i>
                                </a>
                                <a href="/admin/products/edit/{{isset($product['id']) ? $product['id'] : 'n/a'}}"
                                   class="btn btn-icon-only green"
                                   title="{{trans('global.edit')}}"
                                >
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="#"
                                   class="btn btn-icon-only red remove_category"
                                   title="{{trans('global.remove')}}"
                                   data-id="{{isset($product['id']) ? $product['id'] : ''}}"
                                   data-title="{{isset($product['title']) ? $product['title'] : ''}}"
                                >
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {

            $('.remove_category').click(function () {
                var product_id = $(this).attr('data-id');
                var product_title = $(this).attr('data-title');
                var parent = $(this).closest('tr');

                if (
                        typeof product_id !== typeof undefined && typeof product_title !== typeof undefined &&
                        product_id.length > 0 && product_title.length > 0
                ) {
                    bootbox.dialog({
                                       message: "<h4>{{trans('products.product_remove')}}</h4> <strong>ID:</strong> " + product_id + " <br /><strong>{{trans('products.title')}}:</strong> " + product_title,
                                       title: "{{trans('global.confirm_action')}}",
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
                                                              url: '/admin/products/destroy/' + product_id,
                                                              headers: {
                                                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                              },
                                                              success: function (response) {
                                                                  if (typeof response == typeof {} && response['status'] && response['message']) {
                                                                      showNotification(response['status'], response['title'], response['message']);
                                                                      if (response['status'] == 'success') {
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

            $('.copy-product').on('click', function () {
                var id = $(this).attr('data-id');

                if (id) {
                    $.ajax({
                               type: 'post',
                               url: '/admin/products/store',
                               data: {
                                   duplicate: true,
                                   product_id: id
                               },
                               headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               },
                               success: function (response) {
                                   if (typeof response == typeof {} && response['status'] && response['message'] && response['new_id']) {
                                       showNotification(response['status'], response['title'], response['message']);

                                       setTimeout(function() {
                                           window.location.href = "/admin/products/edit/" + response['new_id'];
                                       }, 2000);

                                   } else {
                                       showNotification('error', translate('request_not_completed'), translate('contact_support'));
                                   }
                               },
                               error: function () {
                                   showNotification('error', translate('request_not_completed'), translate('contact_support'));
                               }

                           });
                }
            });

            $('#products_list').DataTable({
                                              responsive: true,
                                              order: [[0, 'desc']],
                                              stateSave: false,
                                              adaptiveHeight: true,
                                              language: translateData['dataTable']
                                          });

        });
    </script>
@endsection