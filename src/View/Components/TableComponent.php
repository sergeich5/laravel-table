<?php

namespace Sergeich5\LaravelTable\View\Components;

use Illuminate\View\Component;
use Sergeich5\LaravelTable\Builder\Table;

class TableComponent extends Component
{
    private Table $table;

    function __construct(Table $builder)
    {
        $this->table = $builder;
    }

    function render()
    {
        return view('sergeich5::components.table', [
            'columns' => $this->table->getColumns(),
            'rows' => $this->table->getRows(),
            'tableClasses' => $this->table->classes,
        ]);
    }
}