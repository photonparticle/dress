@if(isset($table) && is_array($table) && !empty($table['cols']) && !empty($table['rows']))
    <?php
    $count_cols = 0;
    $count_rows = 1;
    ?>
    <div class="table-responsive">
        <table class="dimensions-table table">
            <tr>
                @if(!empty($table['image']))
                    @foreach($table['rows'] as $row)
                        <?php $count_rows++;?>
                    @endforeach
                    @if(!empty($table['image']) &&
                        !empty($images_dir) &&
                        !empty($public_images_dir) &&
                        file_exists($images_dir . $table['image'])
                        )
                        <th rowspan="{{$count_rows}}" class="image">
                            <img src="{{$public_images_dir. $table['image']}}" alt="{{$table['title']}}"/>
                        </th>
                    @endif
                @endif
                <th>

                </th>
                @foreach($table['cols'] as $col)
                    <th>
                        {{$col}}
                        <?php
                        $count_cols++;
                        ?>
                    </th>
                @endforeach
            </tr>
            @foreach($table['rows'] as $key => $row)
                <tr>
                    <td class="title">
                        {{$row}}
                    </td>
                    @for($i = 0; $i < $count_cols; $i++)
                        <td>

                        </td>
                    @endfor
                </tr>
            @endforeach
        </table>
    </div>
@endif