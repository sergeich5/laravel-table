<table @class($tableClasses)>
    <thead>
    <tr>
        @foreach($columns as $column)
            <td>
                {{ $column }}
            </td>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($rows as $row)
        <tr>
            @foreach($row as $column)
                @if(!is_null($column))
                    <td @class($column['class'] ?? []) @if(($column['rowspan'] ?? 1) > 1) rowspan="{{ $column['rowspan'] }}" @endif>
                        {{ $column['value'] }}
                    </td>
                @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
