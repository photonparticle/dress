@extends('dressplace::layout')

@section('content')
    <!-- shop-area start -->
    <div class="shop-area">
        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    @if(empty($tag))
                        <h1>{{trans('client.search_for')}}: {{$needable}}</h1>
                    @else
                        <h1>{{trans('client.search_by_tag')}}: {{$needable}}</h1>
                    @endif
                </div>

                <!-- shop-content start -->
                <div class="col-xs-12">
                    <div class="shop-content">
                        <!-- Nav tabs -->
                        <ul class="shop-tab" role="tablist">
                            <li role="presentation" class="active"><a href="#grid" aria-controls="grid" role="tab" data-toggle="tab"><i class="fa fa-th"></i></a></li>
                            <li role="presentation"><a href="#list" aria-controls="list" role="tab" data-toggle="tab"><i class="fa fa-list"></i></a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="grid">
                                <div class="row">
                                    @include('dressplace::partials.render_products', $products_to_render)
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="list">
                                <div class="row shop-list">
                                    @include('dressplace::partials.render_products_list', $products_to_render)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- shop-content end -->
            </div>
        </div>
    </div>
@endsection