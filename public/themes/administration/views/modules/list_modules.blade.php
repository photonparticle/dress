@extends('administration::layout')

@section('content')
    <div class="portlet box blue-madison">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gears"></i>{{$pageTitle}}
            </div>
        </div>
        <div class="portlet-body">
            <div class="tiles">
                <!-- BEGIN PROFILE CONTENT -->
                @if(!empty($modules) && is_array($modules))
                    @foreach($modules as $name => $module)
                        <a href="/admin/module/{{$name}}" title="{{$module['title'] or ''}}">
                            <div class="tile {{$module['color'] or 'bg-blue-steel'}}">
                                <div class="tile-body">
                                    <i class="fa {{$module['icon'] or 'fa-gears'}}"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        <h4>
                                            {{$module['title'] or ''}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                        @endif
                                <!-- END PROFILE CONTENT -->
            </div>
        </div>
    </div>
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