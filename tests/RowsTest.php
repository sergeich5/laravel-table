<?php

use PHPUnit\Framework\TestCase;
use Sergeich5\LaravelTable\Builder\Column;
use Sergeich5\LaravelTable\Builder\Table;

class RowsTest extends TestCase
{
    static function dataProvider(): array
    {
        return [
            [
                new Table([
                    Column::make('column1', 'key1'),
                    Column::make('column2', 'key2'),
                ], [
                    [
                        'key1' => 'value1',
                        'key2' => 'value2',
                    ]
                ]),
                [
                    [
                        ['value' => 'value1'],
                        ['value' => 'value2'],
                    ]
                ]
            ],
            [
                new Table([
                    Column::make('column1', 'key1')
                        ->setRowSpanable(true),
                    Column::make('column2', 'key2'),
                ], [
                    [
                        'key1' => 'value1',
                        'key2' => 'value2',
                    ],
                    [
                        'key1' => 'value1',
                        'key2' => 'value2',
                    ]
                ]),
                [
                    [
                        ['value' => 'value1', 'rowspan' => 2],
                        ['value' => 'value2'],
                    ],
                    [
                        null,
                        ['value' => 'value2'],
                    ]
                ]
            ],
            [
                new Table([
                    Column::make('column1', 'key1')
                        ->setRowSpanable(true),
                    Column::make('column2', 'key2')
                        ->setRowSpanable(true),
                ], [
                    [
                        'key1' => 'value1',
                        'key2' => 'value2',
                    ],
                    [
                        'key1' => 'value1',
                        'key2' => 'value2',
                    ],
                    [
                        'key1' => 'value2',
                        'key2' => 'value2',
                    ]
                ]),
                [
                    [
                        ['value' => 'value1', 'rowspan' => 2],
                        ['value' => 'value2', 'rowspan' => 3],
                    ],
                    [
                        null,
                        null,
                    ],
                    [
                        ['value' => 'value2', 'rowspan' => 1],
                        null,
                    ]
                ]
            ],
            [
                new Table([
                    Column::make('column1', 'key1')
                        ->setRowSpanable(true),
                    Column::make('column2', 'key2')
                        ->setRowSpanable(true, 'key1'),
                ], [
                    [
                        'key1' => 'value1',
                        'key2' => 'value2',
                    ],
                    [
                        'key1' => 'value1',
                        'key2' => 'value2',
                    ],
                    [
                        'key1' => 'value2',
                        'key2' => 'value2',
                    ]
                ]),
                [
                    [
                        ['value' => 'value1', 'rowspan' => 2],
                        ['value' => 'value2', 'rowspan' => 2],
                    ],
                    [
                        null,
                        null,
                    ],
                    [
                        ['value' => 'value2', 'rowspan' => 1],
                        ['value' => 'value2', 'rowspan' => 1],
                    ]
                ]
            ],
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
            $table->getRows(),
            $expected,
            'TableComponent::getRows is working as not expected'
        );
    }
}