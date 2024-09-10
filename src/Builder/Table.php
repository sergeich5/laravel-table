<?php

namespace Sergeich5\LaravelTable\Builder;

class Table
{
    public array $columns;
    public array $data;
    public array $classes;

    function __construct(array $columns, array $data, array $classes = [])
    {
        $this->columns = $columns;
        $this->data = $data;
        $this->classes = $classes;
    }

    function getColumns(): array
    {
        return collect($this->columns)->pluck('value')->values()->toArray();
    }

    function getRows(): array
    {
        $rows = [];

        foreach ($this->data as $rowIndex => $dataRow) {
            $row = [];

            /* @var Column $column */
            foreach ($this->columns as $columnIndex => $column) {
                $value = $this->getValueFromRow($rowIndex, $column->key);
                $formattedValue = $column->format($value);

                $shouldGlue = false;
                if ($rowIndex > 0 && $column->rowSpanable) {
                    $minRowIndex = 0;

                    if (!is_null($column->rowSpanToColumnKey)) {
                        $rowspanColumnIndex = $this->getColumnIndexByKey($column->rowSpanToColumnKey);
                        if (!is_null($rowspanColumnIndex))
                            for ($i = $rowIndex; $i >= 0; $i--) {
                                $t = ($i == $rowIndex) ? $row : $rows[$i];

                                if (!is_null($t[$rowspanColumnIndex])) {
                                    $minRowIndex = $i;
                                    break;
                                }
                            }
                    }

                    for ($i = $rowIndex - 1; $i >= $minRowIndex; $i--) {
                        if (is_null($rows[$i][$columnIndex]))
                            continue;

                        if ($rows[$i][$columnIndex]['value'] == $formattedValue) {
                            $shouldGlue = true;
                            $rows[$i][$columnIndex]['rowspan']++;
                        }
                        break;
                    }
                }

                if ($shouldGlue)
                    $row[] = null;
                else {
                    $item = [
                        'value' => $formattedValue,
                    ];

                    if ($column->rowSpanable)
                        $item['rowspan'] = 1;

                    if (count($itemClasses = $column->classes($value)) > 0)
                        $item['class'] = $itemClasses;

                    $row[] = $item;
                }
            }

            $rows[] = $row;
        }

        return $rows;
    }

    function getValueFromRow(int $rowIndex, string $key)
    {
        return (is_array($this->data[$rowIndex]))
            ? $this->data[$rowIndex][$key]
            : $this->data[$rowIndex]->{$key};
    }

    function getColumnIndexByKey(string $key): ?int
    {
        foreach ($this->columns as $columnIndex => $column)
            if ($column->key == $key)
                return $columnIndex;

        return null;
    }
}