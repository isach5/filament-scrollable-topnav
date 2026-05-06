<?php

namespace Emuniq\FilamentScrollableTopnav;

use Emuniq\FilamentScrollableTopnav\Commands\InstallCommand;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;

class ScrollableTopnavServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-scrollable-topnav');

        FilamentAsset::register([
            Css::make('scrollable-topnav', __DIR__ . '/../resources/css/plugin.css'),
            Js::make('scrollable-topnav', __DIR__ . '/../resources/js/plugin.js'),
        ], 'emuniq/filament-scrollable-topnav');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}
