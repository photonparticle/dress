@extends('administration::layout')

@section('content')
<h3 class="page-title">{{$pageTitle}}</h3>
            <div class="tiles">
                <!-- BEGIN PROFILE CONTENT -->
                @if(!empty($modules) && is_array($modules))
                    @foreach($modules as $name => $module)
                        <a href="/admin/module/{{$name}}" title="{{$module['title'] or ''}}">
                            <div class="tile {{$module['color'] or 'bg-blue-steel'}} {{$module['tile-size'] or ''}}">
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
@endsection

