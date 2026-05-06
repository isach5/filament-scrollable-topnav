<?php

namespace Emuniq\FilamentScrollableTopnav\Tests;

use Emuniq\FilamentScrollableTopnav\ScrollableTopnavServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return array_filter([
            LivewireServiceProvider::class,
            class_exists(SupportServiceProvider::class) ? SupportServiceProvider::class : null,
            class_exists(ActionsServiceProvider::class) ? ActionsServiceProvider::class : null,
            class_exists(FormsServiceProvider::class) ? FormsServiceProvider::class : null,
            class_exists(TablesServiceProvider::class) ? TablesServiceProvider::class : null,
            class_exists(NotificationsServiceProvider::class) ? NotificationsServiceProvider::class : null,
            class_exists(InfolistsServiceProvider::class) ? InfolistsServiceProvider::class : null,
            class_exists(SchemasServiceProvider::class) ? SchemasServiceProvider::class : null,
            class_exists(WidgetsServiceProvider::class) ? WidgetsServiceProvider::class : null,
            FilamentServiceProvider::class,
            ScrollableTopnavServiceProvider::class,
        ]);
    }
}
