<?php

use PHPUnit\Framework\TestCase;
use Sergeich5\LaravelTable\Builder\Column;
use Sergeich5\LaravelTable\Builder\Table;

class ColumnsTest extends TestCase
{
    static function dataProvider(): array
    {
        return [
            [
                new Table([
                    Column::make('foo', 'foo_key'),
                    Column::make('bar', 'bar_key'),
                ], []),
                ['foo', 'bar']
            ]
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param Table $table
     * @param array $expected
     * @return void
     */
    function test(Table $table, array $expected): void
    {
        $this->assertSame(
            $table->getColumns(),
            $expected,
            'TableComponent::getColumns is working as not expected'
        );
    }
}