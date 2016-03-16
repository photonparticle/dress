@if(!empty($type))

    {{--ORDERS REPORT--}}
    @if($type == 'orders')
        <thead>
        <tr>
            <th>{{trans('reports.date_start')}}</th>
            <th>{{trans('reports.date_end')}}</th>
            <th>{{trans('reports.orders')}}</th>
            <th>{{trans('reports.products')}}</th>
            <th>{{trans('reports.total')}}</th>
            <th>{{trans('reports.profit')}}</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($results) && is_array($results))
            @foreach($results as $result)
                <tr>
                    <td>
                        {{$result['date_start'] or ''}}
                    </td>
                    <td>
                        {{$result['date_end'] or ''}}
                    </td>
                    <td>
                        {{$result['orders'] or 0}}
                    </td>
                    <td>
                        {{$result['products'] or 0}}
                    </td>
                    <td>
                        {{$result['total'] or 0}} {{trans('reports.currency')}}
                    </td>
                    <td>
                        {{$result['profit'] or 0}} {{trans('reports.currency')}}
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    @endif

    {{--USERS REPORTS--}}
    @if($type == 'users')
        <thead>
        <tr>
            <th>{{trans('reports.date_start')}}</th>
            <th>{{trans('reports.date_end')}}</th>
            <th>{{trans('reports.users')}}</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($results) && is_array($results))
            @foreach($results as $result)
                <tr>
                    <td>
                        {{$result['date_start'] or ''}}
                    </td>
                    <td>
                        {{$result['date_end'] or ''}}
                    </td>
                    <td>
                        {{$result['users'] or 0}}
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    @endif
@endif