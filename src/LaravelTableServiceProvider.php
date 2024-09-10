<?php

namespace Sergeich5\LaravelTable;

use Illuminate\Support\ServiceProvider;
use Sergeich5\LaravelTable\View\Components\TableComponent;

class LaravelTableServiceProvider extends ServiceProvider
{
    function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sergeich5');

        $this->loadViewComponentsAs('sergeich5', [
            TableComponent::class,
        ]);
    }
}