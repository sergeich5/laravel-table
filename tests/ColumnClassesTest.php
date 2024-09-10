<?php

use PHPUnit\Framework\TestCase;
use Sergeich5\LaravelTable\Builder\Column;

class ColumnClassesTest extends TestCase
{
    static function dataProvider(): array
    {
        return [
            [
                Column::make('foo', 'key')
                    ->toIntegerFormat()
                    ->setClasses('my-class'),
                'value',
                ['int', 'my-class']
            ],
            [
                Column::make('foo', 'key')
                    ->setClasses('my-class'),
                'value',
                ['my-class']
            ],
            [
                Column::make('foo', 'key')
                    ->toDateFormat()
                    ->setClasses('my-class'),
                'value',
                ['date', 'my-class']
            ],
            [
                Column::make('foo', 'key')
                    ->toPercentFormat()
                    ->setClasses('my-class'),
                'value',
                ['percent', 'my-class']
            ],
            [
                Column::make('foo', 'key')
                    ->toPercentFormat()
                    ->setClasses(['foo', 'bar']),
                'value',
                ['percent', 'foo', 'bar']
            ],
            [
                Column::make('foo', 'key')
                    ->toPercentFormat()
                    ->setClasses(fn($value) => 'test'),
                'value',
                ['percent', 'test']
            ],
            [
                Column::make('foo', 'key')
                    ->toPercentFormat()
                    ->setClasses(fn($value) => ['test', 'test2']),
                'value',
                ['percent', 'test', 'test2']
            ],
            [
                Column::make('foo', 'key')
                    ->setClasses(fn($value) => 'test'),
                'value',
                ['test']
            ],
            [
                Column::make('foo', 'key')
                    ->setClasses(fn($value) => ['test', 'test2']),
                'value',
                ['test', 'test2']
            ],
            [
                Column::make('foo', 'key')
                    ->setClasses(fn($value) => $value == 'value' ? 'good' : 'bad'),
                'value',
                ['good']
            ],
            [
                Column::make('foo', 'key')
                    ->setClasses(fn($value) => $value == 'value' ? 'good' : 'bad'),
                'bad',
                ['bad']
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param Column $column
     * @param string $value
     * @param array $expected
     * @return void
     */
    function test(Column $column, string $value, array $expected): void
    {
        $classes = $column->classes($value);
        sort($classes);
        sort($expected);
        $this->assertSame($classes, $expected);
    }
}