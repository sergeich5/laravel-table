<?php

use PHPUnit\Framework\TestCase;
use Sergeich5\LaravelTable\Builder\Table;

class ExtractValueFromRowTest extends TestCase
{
    static function dataProvider(): array
    {
        return [
            [
                new Table([], [
                    ['key' => 'value']
                ]),
                'key',
                'value'
            ],
            [
                new Table([], [
                    (function () {
                        $t = new stdClass();
                        $t->key = 'value';
                        return $t;
                    })()
                ]),
                'key',
                'value'
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param Table $table
     * @param string $key
     * @param string $expected
     * @return void
     */
    function test(Table $table, string $key, string $expected): void
    {
        $this->assertSame($table->getValueFromRow(0, $key), $expected);
    }
}