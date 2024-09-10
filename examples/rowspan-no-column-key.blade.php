<x-sergeich5-table-component
        :columns="[
            \Sergeich5\LaravelTable\Builder\Column::make('Дата', 'date')
                ->toDateFormat('F Y')
                ->setRowSpanable(true),
            \Sergeich5\LaravelTable\Builder\Column::make('Имя', 'name'),
            \Sergeich5\LaravelTable\Builder\Column::make('Прибыль', 'revenue')
                ->setRowSpanable(true)
                ->toIntegerFormat(),
            \Sergeich5\LaravelTable\Builder\Column::make('Долг', 'debt')
                ->toIntegerFormat()
                ->setClasses(fn($value) => $value > 0 ? 'red' : ''),
        ]"
        :data="[
            [
                'date' => '2024-09-01',
                'name' => 'Joe',
                'revenue' => 0,
                'debt' => 1000,
            ],
            [
                'date' => '2024-09-01',
                'name' => 'David',
                'revenue' => 0,
                'debt' => 0,
            ],
            [
                'date' => '2024-08-01',
                'name' => 'Joe',
                'revenue' => 0,
                'debt' => 1000,
            ],
        ]" />

<style>
    .int {
        text-align: center;
    }
    .red {
        background: pink;
    }
</style>
