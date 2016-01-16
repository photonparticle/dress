@extends('administration::layout')

@section('content')
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="page-content">
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