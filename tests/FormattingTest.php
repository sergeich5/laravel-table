<?php

use PHPUnit\Framework\TestCase;
use Sergeich5\LaravelTable\Builder\Column;

class FormattingTest extends TestCase
{
    static function dataProvider(): array
    {
        return [
            [
                Column::make('foo', 'key')
                    ->toIntegerFormat(),
                12345,
                '12 345'
            ],
            [
                Column::make('foo', 'key')
                    ->toPercentFormat(),
                0.19,
                '19,00%'
            ],
            [
                Column::make('foo', 'key')
                    ->toDateFormat(),
                '2024-09-01',
                '2024-09-01'
            ],
            [
                Column::make('foo', 'key')
                    ->toDateFormat('F Y'),
                '2024-09-01',
                'September 2024'
            ]
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param Column $column
     * @param $value
     * @param string $expected
     * @return void
     */
    function test(Column $column, $value, string $expected): void
    {
        $this->assertSame($column->format($value), $expected);
    }
}