@if(!empty($products_to_render) && is_array($products_to_render))
    <ul>
        @foreach($products_to_render as $product_id)
            <li>
                <a href="/{{$products[$product_id]['slug']}}">
                    {{$product_id}} - {{$products[$product_id]['title']}}
                </a>
            </li>
        @endforeach
    </ul>
@else
    <p>{{trans('client.no_results')}}</p>
@endif