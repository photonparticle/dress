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