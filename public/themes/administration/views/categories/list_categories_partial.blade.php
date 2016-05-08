<tr>
    <td>{{isset($categories[$category_id]['id']) ? $categories[$category_id]['id'] : 'n/a'}}</td>
    <td>
        @if($categories[$category_id]['level'] == 0)
            <h2 class="no-margin text-center">
            @else
            <strong>
                {{isset($categories[$categories[$category_id]['parent_id']]['title']) ? $categories[$categories[$category_id]['parent_id']]['title'] : 'n/a'}}
            </strong>
            &nbsp;<i class="fa fa-forward" style="font-size: 10px" aria-hidden="true"></i> &nbsp;
        @endif
        {{isset($categories[$category_id]['title']) ? $categories[$category_id]['title'] : 'n/a'}}
        @if($categories[$category_id]['level'] == 0) </h2> @endif
    </td>
    <td>{{isset($categories[$category_id]['level']) ? trans('categories.level_'.$categories[$category_id]['level']) : 'n/a'}}</td>
    <td>
        @if(isset($categories[$category_id]['active']))
            @if($categories[$category_id]['active'] == 1)
                {{trans('categories.activated')}}
            @else
                {{trans('categories.not_activated')}}
            @endif
        @endif
    </td>
    <td>
        @if(isset($categories[$category_id]['menu_visibility']))
            @if($categories[$category_id]['menu_visibility'] == 1)
                {{trans('categories.visible')}}
            @else
                {{trans('categories.invisible')}}
            @endif
        @endif
    </td>
    <td class="text-center">
        <a href="/admin/categories/edit/{{isset($categories[$category_id]['id']) ? $categories[$category_id]['id'] : 'n/a'}}"
           class="btn btn-icon-only green"
           title="{{trans('global.edit')}}"
        >
            <i class="fa fa-pencil"></i>
        </a>
        <a href="#"
           class="btn btn-icon-only red remove_category"
           title="{{trans('global.remove')}}"
           data-id="{{isset($categories[$category_id]['id']) ? $categories[$category_id]['id'] : ''}}"
           data-title="{{isset($categories[$category_id]['title']) ? $categories[$category_id]['title'] : ''}}"
        >
            <i class="fa fa-trash"></i>
        </a>
    </td>
</tr>